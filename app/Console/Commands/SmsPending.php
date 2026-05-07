<?php

namespace App\Console\Commands;

use App\Models\SmsLog;
use Illuminate\Console\Command;

class SmsPending extends Command
{
    protected $signature = 'sms:pending';
    protected $description = 'View pending/failed SMS logs';

    public function handle(): int
    {
        $pending = SmsLog::where('status', 'pending')->count();
        $sent = SmsLog::where('status', 'sent')->count();
        $failed = SmsLog::where('status', 'failed')->count();

        $this->info("Pending: {$pending}");
        $this->info("Sent: {$sent}");
        $this->info("Failed: {$failed}");

        return Command::SUCCESS;
    }
}