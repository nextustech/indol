<?php

namespace App\Listeners;

use App\Events\SmsSendingEvent;
use App\Jobs\SendSmsJob;
use App\Models\SmsLog;
use App\Services\SmsService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSmsListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public function __construct(
        public SmsService $smsService
    ) {}

    public function handle(SmsSendingEvent $event): void
    {
        if (!$this->smsService->isEnabled()) {
            Log::info("SMS is disabled, skipping", ['to' => $event->to]);
            return;
        }

        if (!$this->smsService->checkRateLimit($event->to)) {
            Log::warning("SMS rate limit exceeded", ['to' => $event->to]);
            return;
        }

        $message = $this->smsService->renderTemplate(
            $event->templateKey,
            $event->templateData
        );

        if (!$message) {
            Log::warning("SMS template not found or inactive", [
                'template_key' => $event->templateKey
            ]);
            return;
        }

        $duplicate = $this->smsService->checkDuplicate($event->to, $message);

        if ($duplicate) {
            Log::info("Duplicate SMS skipped", [
                'to' => $event->to,
                'existing_log_id' => $duplicate->id
            ]);
            return;
        }

        $smsLog = SmsLog::create([
            'to' => $event->to,
            'message' => $message,
            'template_key' => $event->templateKey,
            'status' => 'pending',
            'sendable_type' => $event->sendable ? $event->sendable->getMorphClass() : null,
            'sendable_id' => $event->sendable ? $event->sendable->getKey() : null,
            'user_id' => $event->userId,
            'max_attempts' => 3
        ]);

        SendSmsJob::dispatch($smsLog);

        Log::info("SMS queued for sending", [
            'sms_log_id' => $smsLog->id,
            'to' => $event->to,
            'template_key' => $event->templateKey
        ]);
    }

    public function failed(SmsSendingEvent $event, Exception $exception): void
    {
        Log::error("SMS send event failed", [
            'to' => $event->to,
            'template_key' => $event->templateKey,
            'error' => $exception->getMessage()
        ]);
    }
}