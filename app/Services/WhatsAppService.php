<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $accessToken;
    private string $phoneNumberId;
    private string $businessAccountId;
    private string $apiVersion;
    private bool $debug;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token', env('WHATSAPP_ACCESS_TOKEN'));
        $this->phoneNumberId = config('services.whatsapp.phone_number_id', env('WHATSAPP_PHONE_NUMBER_ID'));
        $this->businessAccountId = config('services.whatsapp.business_account_id', env('WHATSAPP_BUSINESS_ACCOUNT_ID'));
        $this->apiVersion = config('services.whatsapp.api_version', 'v21.0');
        $this->debug = config('services.whatsapp.debug', env('WHATSAPP_DEBUG', false));
    }

    public function sendTextMessage(string $to, string $message): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function sendTemplateMessage(string $to, string $templateName, ?string $languageCode = 'en_US', ?array $components = null): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $languageCode
                ]
            ]
        ];

        if ($components) {
            $payload['template']['components'] = $components;
        }

        return $this->sendRequest($payload);
    }

    public function sendImageMessage(string $to, string $imageUrl, ?string $caption = null, ?string $mimeType = 'image/jpeg', ?string $fileName = null): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'image',
            'image' => [
                'link' => $imageUrl,
                'mime_type' => $mimeType
            ]
        ];

        if ($caption) {
            $payload['image']['caption'] = $caption;
        }

        if ($fileName) {
            $payload['image']['filename'] = $fileName;
        }

        return $this->sendRequest($payload);
    }

    public function sendAudioMessage(string $to, string $audioUrl, ?string $mimeType = 'audio/mp3'): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'audio',
            'audio' => [
                'link' => $audioUrl,
                'mime_type' => $mimeType
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function sendVideoMessage(string $to, string $videoUrl, ?string $caption = null, ?string $mimeType = 'video/mp4'): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'video',
            'video' => [
                'link' => $videoUrl,
                'mime_type' => $mimeType
            ]
        ];

        if ($caption) {
            $payload['video']['caption'] = $caption;
        }

        return $this->sendRequest($payload);
    }

    public function sendDocumentMessage(string $to, string $documentUrl, ?string $caption = null, ?string $fileName = null, ?string $mimeType = 'application/pdf'): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'document',
            'document' => [
                'link' => $documentUrl,
                'mime_type' => $mimeType
            ]
        ];

        if ($caption) {
            $payload['document']['caption'] = $caption;
        }

        if ($fileName) {
            $payload['document']['filename'] = $fileName;
        }

        return $this->sendRequest($payload);
    }

    public function sendStickerMessage(string $to, string $stickerUrl, ?string $mimeType = 'image/webp'): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'sticker',
            'sticker' => [
                'link' => $stickerUrl,
                'mime_type' => $mimeType
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function sendLocationMessage(string $to, float $latitude, float $longitude, ?string $locationTitle = null, ?string $address = null): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'location',
            'location' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        ];

        if ($locationTitle) {
            $payload['location']['name'] = $locationTitle;
        }

        if ($address) {
            $payload['location']['address'] = $address;
        }

        return $this->sendRequest($payload);
    }

    public function sendContactsMessage(string $to, array $contacts): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'contacts',
            'contacts' => $contacts
        ];

        return $this->sendRequest($payload);
    }

    public function createContact(string $fullName, string $phone, ?string $firstName = null, ?string $lastName = null, ?string $phoneId = null): array
    {
        $contact = [
            'addresses' => [],
            'birthday' => '',
            'emails' => [],
            'name' => [
                'first_name' => $firstName ?? $fullName,
                'last_name' => $lastName ?? '',
                'formatted_name' => $fullName
            ],
            'phones' => [
                [
                    'phone' => $phone,
                    'wa_id' => $phoneId ?? ''
                ]
            ],
            'urls' => []
        ];

        return $contact;
    }

    public function sendInteractiveListMessage(string $to, string $title, string $description, string $buttonText, array $sections): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'interactive',
            'interactive' => [
                'type' => 'list',
                'header' => [
                    'type' => 'text',
                    'text' => $title
                ],
                'body' => [
                    'text' => $description
                ],
                'footer' => [
                    'text' => $description
                ],
                'button' => $buttonText,
                'sections' => $sections
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function sendInteractiveButtonsMessage(string $to, string $headerText, string $bodyText, ?string $footerText, array $buttons): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'interactive',
            'interactive' => [
                'type' => 'button',
                'header' => [
                    'type' => 'text',
                    'text' => $headerText
                ],
                'body' => [
                    'text' => $bodyText
                ],
                'footer' => [
                    'text' => $footerText
                ],
                'action' => [
                    'buttons' => $buttons
                ]
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function createButton(string $id, string $title, string $type = 'reply'): array
    {
        return [
            'type' => $type,
            'reply' => [
                'id' => $id,
                'title' => $title
            ]
        ];
    }

    public function createSection(string $title, array $rows): array
    {
        return [
            'title' => $title,
            'rows' => $rows
        ];
    }

    public function createRow(string $id, string $title, ?string $description = null): array
    {
        return [
            'id' => $id,
            'title' => $title,
            'description' => $description
        ];
    }

    public function sendReactionMessage(string $to, string $messageId, string $emoji): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'reaction',
            'reaction' => [
                'message_id' => $messageId,
                'emoji' => $emoji
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function sendReplyToMessage(string $to, string $messageId, string $message): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'text',
            'text' => [
                'body' => $message
            ],
            'context' => [
                'message_id' => $messageId
            ]
        ];

        return $this->sendRequest($payload);
    }

    public function markMessageAsRead(string $messageId): array
    {
        $url = $this->getApiUrl() . '/messages';

        $payload = [
            'messaging_product' => 'whatsapp',
            'status' => 'read',
            'message_id' => $messageId
        ];

        return $this->sendRequest($payload);
    }

    public function getMessageInfo(string $messageId): array
    {
        $url = $this->getApiUrl() . '/messages/' . $messageId;

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->get($url);

        if ($response->failed()) {
            throw new Exception('Failed to get message info: ' . $response->body());
        }

        return $response->json();
    }

    public function getPhoneNumberSettings(): array
    {
        $url = $this->getApiUrl();

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->get($url);

        if ($response->failed()) {
            throw new Exception('Failed to get phone number settings: ' . $response->body());
        }

        return $response->json();
    }

    public function updatePhoneNumberSettings(string $officiallyRegisteredName): array
    {
        $url = $this->getApiUrl();

        $payload = [
            'name' => $officiallyRegisteredName
        ];

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url, $payload);

        if ($response->failed()) {
            throw new Exception('Failed to update phone number settings: ' . $response->body());
        }

        return $response->json();
    }

    public function registerPhoneNumber(string $pin): array
    {
        $url = $this->getApiUrl() . '/register';

        $payload = [
            'pin' => $pin
        ];

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url, $payload);

        if ($response->failed()) {
            throw new Exception('Failed to register phone number: ' . $response->body());
        }

        return $response->json();
    }

    public function deregisterPhoneNumber(): array
    {
        $url = $this->getApiUrl() . '/deregister';

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url);

        if ($response->failed()) {
            throw new Exception('Failed to deregister phone number: ' . $response->body());
        }

        return $response->json();
    }

    public function createTemplate(string $name, string $category, string $language, array $components): array
    {
        $url = $this->getGraphApiUrl() . '/' . $this->businessAccountId . '/message_templates';

        $payload = [
            'name' => $name,
            'category' => $category,
            'language' => $language,
            'components' => $components
        ];

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url, $payload);

        if ($response->failed()) {
            throw new Exception('Failed to create template: ' . $response->body());
        }

        return $response->json();
    }

    public function sendBatchMessages(array $messages): array
    {
        $results = [];

        foreach ($messages as $index => $message) {
            try {
                $results[$index] = $this->sendRequest($message);

                if ($this->debug) {
                    Log::info("WhatsApp batch message sent", ['index' => $index, 'response' => $results[$index]]);
                }
            } catch (Exception $e) {
                $results[$index] = [
                    'error' => true,
                    'message' => $e->getMessage(),
                    'index' => $index
                ];

                Log::error("WhatsApp batch message failed", [
                    'index' => $index,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    private function sendRequest(array $payload): array
    {
        $url = $this->getApiUrl() . '/messages';

        if ($this->debug) {
            Log::info('WhatsApp API Request', ['payload' => $payload]);
        }

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url, $payload);

        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = $error['error']['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('WhatsApp API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        $result = $response->json();

        if ($this->debug) {
            Log::info('WhatsApp API Response', ['response' => $result]);
        }

        return $result;
    }

    private function getApiUrl(): string
    {
        return 'https://graph.facebook.com/' . $this->apiVersion . '/' . $this->phoneNumberId;
    }

    private function getGraphApiUrl(): string
    {
        return 'https://graph.facebook.com/' . $this->apiVersion;
    }

    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        $countryCode = config('services.whatsapp.country_code', env('WHATSAPP_COUNTRY_CODE', '91'));

        if (!str_starts_with($phone, $countryCode)) {
            $phone = $countryCode . $phone;
        }

        return $phone;
    }
}