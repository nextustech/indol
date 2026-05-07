<?php

namespace App\Console\Commands;

use App\Services\SmsService;
use Illuminate\Console\Command;

class TestSms extends Command
{
    protected $signature = 'sms:test {to? : Phone number} {message? : Message}';
    protected $description = 'Send a test SMS';

    public function handle(SmsService $smsService): int
    {
        $to = $this->argument('to') ?: '919368333300';
        $message = $this->argument('message') ?: 'Test SMS from Laravel SMS System';

        try {
            $this->info("Sending SMS to {$to}...");
            $response = $smsService->sendSingleMessage($to, $message, 0);
            $this->info("SMS sent successfully!");
            $this->line(json_encode($response, JSON_PRETTY_PRINT));
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}