<?php

namespace App\Services;

use App\Models\SmsLog;
use App\Models\SmsTemplate;
use Exception;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private const SERVER = 'https://sms.cis.bz';
    private const API_KEY = '38a07c18c9fd1b70d0077045d15e9e43cfc8f772';

    private const USE_SPECIFIED = 0;
    private const USE_ALL_DEVICES = 1;
    private const USE_ALL_SIMS = 2;

    public function sendSingleMessage(
        string $number,
        string $message,
        $device = 0,
        ?int $schedule = null,
        bool $isMMS = false,
        ?string $attachments = null,
        bool $prioritize = false
    ): array {
        Log::info("Sending single SMS", [
            'to' => $number,
            'message_length' => strlen($message),
            'device' => $device
        ]);

        $url = self::SERVER . "/services/send.php";
        $postData = [
            'number' => $number,
            'message' => $message,
            'schedule' => $schedule,
            'key' => self::API_KEY,
            'devices' => $device,
            'type' => $isMMS ? "mms" : "sms",
            'attachments' => $attachments,
            'prioritize' => $prioritize ? 1 : 0
        ];

        try {
            $result = $this->sendRequest($url, $postData)["messages"][0];
            Log::info("SMS sent successfully", [
                'to' => $number,
                'message_id' => $result['id'] ?? null,
                'status' => $result['status'] ?? 'unknown'
            ]);
            return $result;
        } catch (Exception $e) {
            Log::error("SMS send failed", [
                'to' => $number,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function sendMessages(
        array $messages,
        int $option = self::USE_SPECIFIED,
        array $devices = [],
        ?int $schedule = null,
        bool $useRandomDevice = false
    ): array {
        Log::info("Sending batch SMS", [
            'count' => count($messages),
            'recipients' => array_map(fn($m) => $m['number'] ?? 'unknown', $messages)
        ]);

        $url = self::SERVER . "/services/send.php";
        $postData = [
            'messages' => json_encode($messages),
            'schedule' => $schedule,
            'key' => self::API_KEY,
            'devices' => json_encode($devices),
            'option' => $option,
            'useRandomDevice' => $useRandomDevice
        ];

        try {
            $result = $this->sendRequest($url, $postData)["messages"];
            Log::info("Batch SMS sent", [
                'count' => count($result),
                'success_count' => count(array_filter($result, fn($r) => ($r['status'] ?? '') === 'success'))
            ]);
            return $result;
        } catch (Exception $e) {
            Log::error("Batch SMS send failed", [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function sendMessageToContactsList(
        int $listID,
        string $message,
        int $option = self::USE_SPECIFIED,
        array $devices = [],
        ?int $schedule = null,
        bool $isMMS = false,
        ?string $attachments = null
    ): array {
        Log::info("Sending SMS to contact list", [
            'list_id' => $listID,
            'message_length' => strlen($message)
        ]);

        $url = self::SERVER . "/services/send.php";
        $postData = [
            'listID' => $listID,
            'message' => $message,
            'schedule' => $schedule,
            'key' => self::API_KEY,
            'devices' => json_encode($devices),
            'option' => $option,
            'type' => $isMMS ? "mms" : "sms",
            'attachments' => $attachments
        ];

        try {
            $result = $this->sendRequest($url, $postData)["messages"];
            Log::info("Contact list SMS sent", [
                'list_id' => $listID,
                'count' => count($result)
            ]);
            return $result;
        } catch (Exception $e) {
            Log::error("Contact list SMS failed", [
                'list_id' => $listID,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getMessageByID(int $id): array
    {
        $url = self::SERVER . "/services/read-messages.php";
        $postData = [
            'key' => self::API_KEY,
            'id' => $id
        ];

        return $this->sendRequest($url, $postData)["messages"][0];
    }

    public function getMessagesByGroupID(string $groupID): array
    {
        $url = self::SERVER . "/services/read-messages.php";
        $postData = [
            'key' => self::API_KEY,
            'groupId' => $groupID
        ];

        return $this->sendRequest($url, $postData)["messages"];
    }

    public function getMessagesByStatus(
        string $status,
        ?int $deviceID = null,
        ?int $simSlot = null,
        ?int $startTimestamp = null,
        ?int $endTimestamp = null
    ): array {
        $url = self::SERVER . "/services/read-messages.php";
        $postData = [
            'key' => self::API_KEY,
            'status' => $status,
            'deviceID' => $deviceID,
            'simSlot' => $simSlot,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp
        ];

        return $this->sendRequest($url, $postData)["messages"];
    }

    public function resendMessageByID(int $id): array
    {
        $url = self::SERVER . "/services/resend.php";
        $postData = [
            'key' => self::API_KEY,
            'id' => $id
        ];

        return $this->sendRequest($url, $postData)["messages"][0];
    }

    public function resendMessagesByGroupID(string $groupID, ?string $status = null): array
    {
        $url = self::SERVER . "/services/resend.php";
        $postData = [
            'key' => self::API_KEY,
            'groupId' => $groupID,
            'status' => $status
        ];

        return $this->sendRequest($url, $postData)["messages"];
    }

    public function resendMessagesByStatus(
        string $status,
        ?int $deviceID = null,
        ?int $simSlot = null,
        ?int $startTimestamp = null,
        ?int $endTimestamp = null
    ): array {
        $url = self::SERVER . "/services/resend.php";
        $postData = [
            'key' => self::API_KEY,
            'status' => $status,
            'deviceID' => $deviceID,
            'simSlot' => $simSlot,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp
        ];

        return $this->sendRequest($url, $postData)["messages"];
    }

    public function addContact(int $listID, string $number, ?string $name = null, bool $resubscribe = false): array
    {
        $url = self::SERVER . "/services/manage-contacts.php";
        $postData = [
            'key' => self::API_KEY,
            'listID' => $listID,
            'number' => $number,
            'name' => $name,
            'resubscribe' => $resubscribe
        ];

        return $this->sendRequest($url, $postData)["contact"];
    }

    public function unsubscribeContact(int $listID, string $number): array
    {
        $url = self::SERVER . "/services/manage-contacts.php";
        $postData = [
            'key' => self::API_KEY,
            'listID' => $listID,
            'number' => $number,
            'unsubscribe' => true
        ];

        return $this->sendRequest($url, $postData)["contact"];
    }

    public function getBalance(): string
    {
        $url = self::SERVER . "/services/send.php";
        $postData = [
            'key' => self::API_KEY
        ];

        $credits = $this->sendRequest($url, $postData)["credits"];
        return is_null($credits) ? "Unlimited" : $credits;
    }

    public function sendUssdRequest(string $request, int $device, ?int $simSlot = null): array
    {
        $url = self::SERVER . "/services/send-ussd-request.php";
        $postData = [
            'key' => self::API_KEY,
            'request' => $request,
            'device' => $device,
            'sim' => $simSlot
        ];

        return $this->sendRequest($url, $postData)["request"];
    }

    public function getUssdRequestByID(int $id): array
    {
        $url = self::SERVER . "/services/read-ussd-requests.php";
        $postData = [
            'key' => self::API_KEY,
            'id' => $id
        ];

        return $this->sendRequest($url, $postData)["requests"][0];
    }

    public function getUssdRequests(
        string $request,
        ?int $deviceID = null,
        ?int $simSlot = null,
        ?int $startTimestamp = null,
        ?int $endTimestamp = null
    ): array {
        $url = self::SERVER . "/services/read-ussd-requests.php";
        $postData = [
            'key' => self::API_KEY,
            'request' => $request,
            'deviceID' => $deviceID,
            'simSlot' => $simSlot,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp
        ];

        return $this->sendRequest($url, $postData)["requests"];
    }

    public function getDevices(): array
    {
        $url = self::SERVER . "/services/get-devices.php";
        $postData = [
            'key' => self::API_KEY
        ];

        return $this->sendRequest($url, $postData)["devices"];
    }

    public function isEnabled(): bool
    {
        $option = \App\Models\Option::where('option_key', 'sms_enabled')->first();
        if (!$option) {
            return true;
        }
        $enabled = $option->option_value == '1';
        if (!$enabled) {
            Log::info("SMS is globally disabled");
        }
        return $enabled;
    }

    public function getRateLimit(): int
    {
        $option = \App\Models\Option::where('option_key', 'sms_rate_limit_per_hour')->first();
        return $option ? (int) $option->option_value : 100;
    }

    public function checkRateLimit(string $to): bool
    {
        $limit = $this->getRateLimit();
        $count = SmsLog::where('to', $to)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($count >= $limit) {
            Log::warning("SMS rate limit hit", [
                'to' => $to,
                'count' => $count,
                'limit' => $limit
            ]);
            return false;
        }

        return true;
    }

    public function checkDuplicate(string $to, string $message, int $minutes = 5): ?SmsLog
    {
        $existing = SmsLog::where('to', $to)
            ->where('message', $message)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->whereIn('status', ['pending', 'sent'])
            ->first();

        if ($existing) {
            Log::info("Duplicate SMS detected, skipping", [
                'to' => $to,
                'existing_id' => $existing->id,
                'window_minutes' => $minutes
            ]);
        }

        return $existing;
    }

    public function getTemplate(string $key): ?SmsTemplate
    {
        return SmsTemplate::where('key', $key)->active()->first();
    }

    public function renderTemplate(string $key, array $data): ?string
    {
        $template = $this->getTemplate($key);

        if (!$template) {
            Log::warning("SMS template not found", [
                'template_key' => $key
            ]);
            return null;
        }

        $content = $template->content;

        foreach ($data as $placeholder => $value) {
            $content = str_replace("{{{$placeholder}}}", $value, $content);
        }

        return $content;
    }

    private function sendRequest(string $url, array $postData): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            Log::error("SMS API cURL error", [
                'url' => $url,
                'error' => $error
            ]);
            throw new Exception($error);
        }

        curl_close($ch);

        if ($httpCode == 200) {
            $json = json_decode($response, true);

            if ($json === false) {
                if (empty($response)) {
                    throw new Exception("Missing data in request. Please provide all the required information to send messages.");
                }
                Log::error("SMS API non-JSON response", [
                    'response' => substr($response, 0, 500)
                ]);
                throw new Exception($response);
            }

            if ($json["success"]) {
                return $json["data"];
            }

            Log::error("SMS API error response", [
                'error' => $json["error"]["message"] ?? 'Unknown error'
            ]);
            throw new Exception($json["error"]["message"]);
        }

        Log::error("SMS API HTTP error", [
            'http_code' => $httpCode
        ]);
        throw new Exception("HTTP Error Code : {$httpCode}");
    }
}