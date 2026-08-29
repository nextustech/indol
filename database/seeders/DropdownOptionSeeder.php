<?php

namespace Database\Seeders;

use App\Models\DropdownOption;
use Illuminate\Database\Seeder;

class DropdownOptionSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'investigation_type' => ['MRI', 'X-ray', 'CT Scan', 'Blood Work', 'USG', 'ECG', 'EMG', 'NCV'],
            'exercise_category' => ['stretching', 'strengthening', 'mobilization', 'stabilization', 'balance', 'gait', 'postural', 'breathing', 'other'],
            'complaint' => ['Pain', 'Swelling', 'Stiffness', 'Numbness', 'Tingling', 'Weakness', 'Deformity', 'Loss of function'],
            'special_test' => ['SLR', 'Faber', 'Compression', 'Distraction', 'McMurray', 'Anterior Drawer Test', 'Posterior Drawer Test', 'Lachman Test', 'Patellar Apprehension Test', 'Drop Arm Test', 'Empty Can Test', 'Hawkins-Kennedy Test'],
            'clinical_impression' => ['Lumbar Disc Bulge', 'Lumbar Canal Stenosis', 'Spondylolisthesis', 'Sciatica', 'Rotator Cuff Injury', 'Frozen Shoulder', 'Osteoarthritis', 'Cervical Spondylosis', 'Plantar Fasciitis', 'Meniscal Injury'],
            'precaution' => ['No forward bending', 'No lifting > 5 kg', 'Avoid prolonged sitting', 'Avoid twisting movements', 'No running/jumping', 'Avoid cross-legged sitting', 'No weight bearing on affected side', 'Avoid cold exposure'],
            'advice' => ['Use lumbar belt', 'Use western toilet', 'Change pillow position', 'Take hot water fermentation', 'Maintain posture', 'Avoid prolonged static posture', 'Use ergonomic chair', 'Sleep on firm surface', 'Apply ice after exercise', 'Stay hydrated'],
        ];

        foreach ($groups as $type => $names) {
            foreach ($names as $name) {
                DropdownOption::firstOrCreate(['type' => $type, 'name' => $name]);
            }
        }

        $this->command->info('Dropdown options seeded successfully.');
    }
}