<?php

namespace App\Console\Commands;

use App\Models\SmsLog;
use Illuminate\Console\Command;

class SmsLogs extends Command
{
    protected $signature = 'sms:logs {--status= : Filter by status}';
    protected $description = 'View SMS logs';

    public function handle(): int
    {
        $query = SmsLog::orderBy('id', 'desc');

        if ($status = $this->option('status')) {
            $query->where('status', $status);
        }

        $logs = $query->limit(10)->get();

        if ($logs->isEmpty()) {
            $this->info("No SMS logs found.");
            return Command::SUCCESS;
        }

        foreach ($logs as $log) {
            $this->line("ID: {$log->id} | To: {$log->to} | Status: {$log->status}");
            $this->line("  Message: " . substr($log->message, 0, 60) . (strlen($log->message) > 60 ? '...' : ''));
            $this->line("  Attempts: {$log->attempts}/{$log->max_attempts}");
            if ($log->error_message) {
                $this->line("  Error: {$log->error_message}");
            }
            $this->line("");
        }

        return Command::SUCCESS;
    }
}