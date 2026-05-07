<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Services\SmsService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;
    public int $timeout = 30;

    public function __construct(
        public SmsLog $smsLog
    ) {}

    public function handle(SmsService $smsService): void
    {
        if ($this->smsLog->status !== 'pending') {
            Log::info("SMS log {$this->smsLog->id} already processed, skipping", [
                'status' => $this->smsLog->status
            ]);
            return;
        }

        $this->smsLog->incrementAttempt();

        try {
            $response = $smsService->sendSingleMessage(
                $this->smsLog->to,
                $this->smsLog->message,
                config('sms.default_device', 0)
            );

            $externalId = $response['ID'] ?? null;

            $this->smsLog->markAsSent($externalId);

            Log::info("SMS sent successfully", [
                'sms_log_id' => $this->smsLog->id,
                'external_id' => $externalId,
                'to' => $this->smsLog->to
            ]);
        } catch (Exception $e) {
            $this->handleFailure($e);
            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        $this->handleFailure($exception);

        Log::error("SMS job failed permanently", [
            'sms_log_id' => $this->smsLog->id,
            'to' => $this->smsLog->to,
            'attempts' => $this->smsLog->attempts,
            'error' => $exception->getMessage()
        ]);
    }

    private function handleFailure(Exception $exception): void
    {
        $this->smsLog->update([
            'error_message' => $exception->getMessage(),
            'status' => $this->smsLog->attempts >= $this->smsLog->max_attempts
                ? 'failed'
                : 'pending'
        ]);
    }
}