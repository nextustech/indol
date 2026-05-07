<?php

namespace App\Console\Commands;

use App\Events\SmsSendingEvent;
use App\Models\Patient;
use Illuminate\Console\Command;

class TriggerTestSms extends Command
{
    protected $signature = 'sms:testtrigger {phone}';
    protected $description = 'Test SMS trigger flow';

    public function handle(): int
    {
        $phone = $this->argument('phone');

        $this->info("Triggering SMS for {$phone}...");

        event(new SmsSendingEvent(
            '+91' . ltrim($phone, '+'),
            'patient_registration',
            [
                'patient_name' => 'Test Patient',
                'patient_id' => 'TEST001',
                'clinic_name' => 'Test Clinic',
                'clinic_phone' => '1234567890'
            ]
        ));

        $this->info("SMS event dispatched! Check queue/logs.");
        return Command::SUCCESS;
    }
}