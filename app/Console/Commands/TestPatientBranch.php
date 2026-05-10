<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\Patient;
use App\Services\SmsToggle;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class TestPatientBranch extends Command
{
    protected $signature = 'sms:testbranch';
    protected $description = 'Test patient branch loading in observer';

    public function handle(): int
    {
        $this->info("=== Testing Patient Observer Branch Loading ===\n");

        // Create request mock with SMS settings
        $request = new Request();
        $request->merge([
            'send_sms_patient' => '1',
        ]);
        SmsToggle::setRequest($request);

        // Get a branch to use
        $branch = Branch::first();
        $this->info("Using Branch: {$branch->branchName} (ID: {$branch->id})");

        // Set branch ID in SmsToggle (like OpdController does)
        SmsToggle::setBranchId($branch->id);
        $this->info("Branch ID set in SmsToggle: " . SmsToggle::getBranchId());

        // Prepare patient data
        $patientData = [
            'name' => 'Test Branch Patient ' . time(),
            'mobile' => '9876543210',
            'age' => 25,
            'date' => now(),
            'patientId' => Patient::max('patientId') + 1,
            'created_by' => 1,
        ];

        $this->info("\n--- Creating Patient ---");
        $this->line("SmsToggle BranchId: " . (SmsToggle::getBranchId() ?? 'NULL'));

        // Create patient - this will trigger 'created' observer
        $patient = Patient::create($patientData);

        $this->line("Patient ID: {$patient->id}");

        // Clean up
        $this->info("\n--- Cleaning Up ---");
        $patient->branches()->detach();
        $patient->forceDelete();
        $this->line("Test patient deleted.");

        $this->info("\n=== Check Laravel logs for observer messages ===");
        $this->info("Look for: 'PatientObserver: Branch loaded' with branch name");

        return Command::SUCCESS;
    }
}