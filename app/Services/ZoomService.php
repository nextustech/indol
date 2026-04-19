<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    private string $accountId;
    private string $clientId;
    private string $clientSecret;
    private string $baseUrl;
    private string $tokenUrl;
    private bool $debug;

    public function __construct()
    {
        $this->accountId = config('services.zoom.account_id', env('ZOOM_ACCOUNT_ID'));
        $this->clientId = config('services.zoom.client_id', env('ZOOM_CLIENT_ID'));
        $this->clientSecret = config('services.zoom.client_secret', env('ZOOM_CLIENT_SECRET'));
        $this->baseUrl = 'https://api.zoom.us/v2';
        $this->tokenUrl = 'https://zoom.us/oauth/token';
        $this->debug = config('services.zoom.debug', env('ZOOM_DEBUG', false));
    }

    public function createMeeting(
        string $topic,
        ?string $startTime = null,
        ?int $duration = null,
        ?string $timezone = null,
        ?string $agenda = null,
        ?array $settings = null
    ): array {
        $payload = [
            'topic' => $topic,
            'type' => 2
        ];

        if ($startTime) {
            $payload['start_time'] = $startTime;
        }

        if ($duration) {
            $payload['duration'] = $duration;
        }

        if ($timezone) {
            $payload['timezone'] = $timezone;
        }

        if ($agenda) {
            $payload['agenda'] = $agenda;
        }

        $defaultSettings = [
            'host_video' => true,
            'participant_video' => true,
            'join_before_host' => false,
            'mute_upon_entry' => true,
            'watermark' => false,
            'use_pmi' => false,
            'approval_type' => 2,
            'registration_type' => 1,
            'audio' => 'both',
            'auto_recording' => 'none',
            'waiting_room' => true,
            'meeting_authentication' => false
        ];

        $payload['settings'] = $settings ? array_merge($defaultSettings, $settings) : $defaultSettings;

        return $this->post('/users/me/meetings', $payload);
    }

    public function createInstantMeeting(
        string $topic,
        ?int $duration = 60,
        ?string $agenda = null,
        ?array $settings = null
    ): array {
        $payload = [
            'topic' => $topic,
            'type' => 1,
            'duration' => $duration ?? 60
        ];

        if ($agenda) {
            $payload['agenda'] = $agenda;
        }

        $defaultSettings = [
            'host_video' => true,
            'participant_video' => true,
            'join_before_host' => true,
            'mute_upon_entry' => true,
            'auto_recording' => 'none'
        ];

        $payload['settings'] = $settings ? array_merge($defaultSettings, $settings) : $defaultSettings;

        return $this->post('/users/me/meetings', $payload);
    }

    public function createRecurringMeeting(
        string $topic,
        string $recurrenceType,
        ?string $startTime = null,
        ?int $duration = null,
        ?int $repeatInterval = null,
        ?string $endDateTime = null,
        ?int $occurrences = null,
        ?string $timezone = null,
        ?string $agenda = null
    ): array {
        $recurrenceTypes = [
            'daily' => 1,
            'weekly' => 2,
            'monthly' => 3
        ];

        $payload = [
            'topic' => $topic,
            'type' => 8,
            'recurrence' => [
                'type' => $recurrenceTypes[$recurrenceType] ?? 1,
                'repeat_interval' => $repeatInterval ?? 1
            ]
        ];

        if ($startTime) {
            $payload['start_time'] = $startTime;
        }

        if ($duration) {
            $payload['duration'] = $duration;
        }

        if ($timezone) {
            $payload['timezone'] = $timezone;
        }

        if ($agenda) {
            $payload['agenda'] = $agenda;
        }

        if ($endDateTime) {
            $payload['recurrence']['end_date_time'] = $endDateTime;
        }

        if ($occurrences) {
            $payload['recurrence']['occurrences'] = $occurrences;
        }

        return $this->post('/users/me/meetings', $payload);
    }

    public function updateMeeting(
        string $meetingId,
        ?string $topic = null,
        ?string $startTime = null,
        ?int $duration = null,
        ?string $timezone = null,
        ?string $agenda = null,
        ?array $settings = null
    ): array {
        $payload = [];

        if ($topic) {
            $payload['topic'] = $topic;
        }

        if ($startTime) {
            $payload['start_time'] = $startTime;
        }

        if ($duration) {
            $payload['duration'] = $duration;
        }

        if ($timezone) {
            $payload['timezone'] = $timezone;
        }

        if ($agenda) {
            $payload['agenda'] = $agenda;
        }

        if ($settings) {
            $payload['settings'] = $settings;
        }

        return $this->patch('/meetings/' . $meetingId, $payload);
    }

    public function getMeeting(string $meetingId): array
    {
        return $this->get('/meetings/' . $meetingId);
    }

    public function getMeetings(?string $meetingType = 'upcoming', ?int $pageSize = 30, ?int $pageNumber = 1): array
    {
        $params = [
            'meeting_type' => $meetingType ?? 'upcoming',
            'page_size' => $pageSize ?? 30,
            'page_number' => $pageNumber ?? 1
        ];

        return $this->get('/users/me/meetings', $params);
    }

    public function deleteMeeting(string $meetingId, ?bool $notifyParticipants = true): array
    {
        return $this->delete('/meetings/' . $meetingId, [
            'notify' => $notifyParticipants ? 'true' : 'false'
        ]);
    }

    public function endMeeting(string $meetingId): array
    {
        return $this->patch('/meetings/' . $meetingId . '/status', [
            'action' => 'end'
        ]);
    }

    public function getMeetingParticipants(string $meetingId, ?int $pageSize = 30, ?int $pageNumber = 1): array
    {
        $params = [
            'page_size' => $pageSize ?? 30,
            'page_number' => $pageNumber ?? 1
        ];

        return $this->get('/past_meetings/' . $meetingId . '/participants', $params);
    }

    public function getMeetingRecordings(string $meetingId): array
    {
        return $this->get('/meetings/' . $meetingId . '/recordings');
    }

    public function getPastMeetingDetails(string $meetingId): array
    {
        return $this->get('/past_meetings/' . $meetingId);
    }

    public function getPastMeetingFiles(string $meetingId): array
    {
        return $this->get('/past_meetings/' . $meetingId . '/files');
    }

    public function addRegistrant(string $meetingId, string $email, string $firstName, ?string $lastName = null): array
    {
        $payload = [
            'email' => $email,
            'first_name' => $firstName
        ];

        if ($lastName) {
            $payload['last_name'] = $lastName;
        }

        return $this->post('/meetings/' . $meetingId . '/registrants', $payload);
    }

    public function addMultipleRegistrants(string $meetingId, array $registrants): array
    {
        $payload = [
            'registrants' => $registrants
        ];

        return $this->post('/meetings/' . $meetingId . '/registrants', $payload);
    }

    public function approveRegistrant(string $meetingId, string $registrantId): array
    {
        return $this->put('/meetings/' . $meetingId . '/registrants/' . $registrantId . '/status', [
            'action' => 'approve'
        ]);
    }

    public function rejectRegistrant(string $meetingId, string $registrantId): array
    {
        return $this->put('/meetings/' . $meetingId . '/registrants/' . $registrantId . '/status', [
            'action' => 'deny'
        ]);
    }

    public function getRegistrants(string $meetingId, ?string $status = 'approved', ?int $pageSize = 30, ?int $pageNumber = 1): array
    {
        $params = [
            'status' => $status ?? 'approved',
            'page_size' => $pageSize ?? 30,
            'page_number' => $pageNumber ?? 1
        ];

        return $this->get('/meetings/' . $meetingId . '/registrants', $params);
    }

    public function createWebhook(string $url, ?string $eventTypes = null): array
    {
        $payload = [
            'url' => $url,
            'event_types' => $eventTypes ? explode(',', $eventTypes) : [
                'meeting.started',
                'meeting.ended',
                'meeting.participant_joined'
            ]
        ];

        return $this->post('/webhooks', $payload);
    }

    public function getWebhook(string $webhookId): array
    {
        return $this->get('/webhooks/' . $webhookId);
    }

    public function updateWebhook(string $webhookId, ?string $url = null, ?array $eventTypes = null): array
    {
        $payload = [];

        if ($url) {
            $payload['url'] = $url;
        }

        if ($eventTypes) {
            $payload['event_types'] = $eventTypes;
        }

        return $this->patch('/webhooks/' . $webhookId, $payload);
    }

    public function deleteWebhook(string $webhookId): array
    {
        return $this->delete('/webhooks/' . $webhookId);
    }

    public function getUsers(?int $pageSize = 30, ?int $pageNumber = 1): array
    {
        $params = [
            'page_size' => $pageSize ?? 30,
            'page_number' => $pageNumber ?? 1
        ];

        return $this->get('/users', $params);
    }

    public function getUser(string $userId): array
    {
        return $this->get('/users/' . $userId);
    }

    public function getCurrentUser(): array
    {
        return $this->get('/users/me');
    }

    public function getUserSettings(string $userId): array
    {
        return $this->get('/users/' . $userId . '/settings');
    }

    public function getUserRecordings(string $userId, ?string $meetingId = null): array
    {
        $endpoint = $meetingId 
            ? '/users/' . $userId . '/recordings/' . $meetingId 
            : '/users/' . $userId . '/recordings';

        return $this->get($endpoint);
    }

    public function createUser(string $email, string $firstName, string $lastName, ?string $type = 1): array
    {
        $payload = [
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'type' => $type
        ];

        return $this->post('/users', $payload);
    }

    public function deleteUser(string $userId, ?bool $transferRecording = false): array
    {
        return $this->delete('/users/' . $userId, [
            'transfer_recording' => $transferRecording ? 'true' : 'false'
        ]);
    }

    public function getRecordingSettings(string $userId): array
    {
        return $this->get('/users/' . $userId . '/recordings/settings');
    }

    public function updateRecordingSettings(string $userId, ?bool $autoRecording = null, ?bool $hostDeleteRecording = null, ?bool $participantDeleteRecording = null): array
    {
        $payload = [];

        if ($autoRecording !== null) {
            $payload['auto_recording'] = $autoRecording ? 'auto' : 'none';
        }

        if ($hostDeleteRecording !== null) {
            $payload['host_delete_cloud_recording'] = $hostDeleteRecording;
        }

        if ($participantDeleteRecording !== null) {
            $payload['participant_delete_cloud_recording'] = $participantDeleteRecording;
        }

        return $this->patch('/users/' . $userId . '/recordings/settings', $payload);
    }

    public function getMeetingTemplates(): array
    {
        return $this->get('/meeting_templates');
    }

    public function getMeetingTemplate(string $templateId): array
    {
        return $this->get('/meeting_templates/' . $templateId);
    }

    public function createMeetingFromTemplate(string $templateId, string $topic, ?string $startTime = null, ?int $duration = null): array
    {
        $template = $this->getMeetingTemplate($templateId);

        $payload = [
            'topic' => $topic,
            'type' => 2
        ];

        if ($startTime) {
            $payload['start_time'] = $startTime;
        }

        if ($duration) {
            $payload['duration'] = $duration;
        }

        if (isset($template['settings'])) {
            $payload['settings'] = $template['settings'];
        }

        return $this->post('/users/me/meetings', $payload);
    }

    private function getAccessToken(): string
    {
        $cacheKey = 'zoom_access_token';

        return Cache::remember($cacheKey, 3500, function () {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->asForm()
                ->post($this->tokenUrl, [
                    'grant_type' => 'account_credentials',
                    'account_id' => $this->accountId
                ]);

            if ($response->failed()) {
                throw new Exception('Failed to get Zoom access token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    private function get(string $endpoint, array $params = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $token = $this->getAccessToken();

        if ($this->debug) {
            Log::info('Zoom GET Request', ['url' => $url, 'params' => $params]);
        }

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->get($url, $params);

        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = $error['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('Zoom API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        $result = $response->json();

        if ($this->debug) {
            Log::info('Zoom API Response', ['response' => $result]);
        }

        return $result;
    }

    private function post(string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $token = $this->getAccessToken();

        if ($this->debug) {
            Log::info('Zoom POST Request', ['url' => $url, 'data' => $data]);
        }

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($url, $data);

        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = $error['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('Zoom API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        $result = $response->json();

        if ($this->debug) {
            Log::info('Zoom API Response', ['response' => $result]);
        }

        return $result;
    }

    private function patch(string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $token = $this->getAccessToken();

        if ($this->debug) {
            Log::info('Zoom PATCH Request', ['url' => $url, 'data' => $data]);
        }

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->patch($url, $data);

        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = $error['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('Zoom API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        $result = $response->json();

        if ($this->debug) {
            Log::info('Zoom API Response', ['response' => $result]);
        }

        return $result;
    }

    private function put(string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $token = $this->getAccessToken();

        if ($this->debug) {
            Log::info('Zoom PUT Request', ['url' => $url, 'data' => $data]);
        }

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->put($url, $data);

        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = $error['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('Zoom API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        $result = $response->json();

        if ($this->debug) {
            Log::info('Zoom API Response', ['response' => $result]);
        }

        return $result;
    }

    private function delete(string $endpoint, array $params = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $token = $this->getAccessToken();

        if ($this->debug) {
            Log::info('Zoom DELETE Request', ['url' => $url, 'params' => $params]);
        }

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->delete($url, $params);

        if ($response->failed() && $response->status() !== 204) {
            $error = $response->json();
            $errorMessage = $error['message'] ?? $response->body();

            if ($this->debug) {
                Log::error('Zoom API Error', ['response' => $error]);
            }

            throw new Exception($errorMessage);
        }

        if ($this->debug) {
            Log::info('Zoom API Response', ['status' => $response->status()]);
        }

        return ['success' => true, 'status' => $response->status()];
    }
}