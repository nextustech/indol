<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssessmentPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'list-Assessment',
            'create-Assessment',
            'edit-Assessment',
            'delete-Assessment',
            'show-AssessmentProfile',
            'print-Assessment',
            'list-TreatmentPlan',
            'create-TreatmentPlan',
            'edit-TreatmentPlan',
            'delete-TreatmentPlan',
            'view-trash-assessment',
            'restore-assessment',
            'force-delete-assessment',
            'view-trash-treatment-plan',
            'restore-treatment-plan',
            'force-delete-treatment-plan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $this->command->info('Assessment & Treatment Plan permissions seeded successfully.');
    }
}
