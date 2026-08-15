<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Investigation;
use App\Models\TreatmentPlan;
use App\Models\ExercisePrescription;
use Illuminate\Database\Seeder;

class DummyAssessmentDataSeeder extends Seeder
{
    public function run(): void
    {
        $patients = \App\Models\Patient::all();
        $branches = \App\Models\Branch::all();
        $users = \App\Models\User::all();

        if ($patients->isEmpty() || $branches->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Need at least 1 patient, 1 branch, and 1 user to seed.');
            return;
        }

        $branch = $branches->first();
        $user = $users->first();

        // ---------- Assessment 1: Mr. Geetesh (based on the actual sample) ----------
        $patient1 = $patients->first();

        $ass1 = Assessment::create([
            'patient_id' => $patient1->id,
            'branch_id' => $branch->id,
            'assessed_by' => $user->id,
            'assessment_date' => now()->subDays(2)->setHour(11)->setMinute(49),
            'type' => 'initial',
            'chief_complaints' => "Lower back pain, increase from 5 months,\naggravates during sitting & laying.",
            'history_of_present_illness' => "Occupation – Mechanical Engineer.\nLBP from 2020.\nDaily walking 4–5 km.",
            'observation' => "Antalgic gait observed.\nMild forward lean posture while standing.",
            'palpation' => "Mild B/L hamstring tightness\nB/L PSIS pain present\nL4/L5 L5/S1 mild pain and tenderness present\nSacrococcygeal joint pain and tenderness present\nSpinal extension pain increase",
            'range_of_motion' => "Lumbar flexion: 40° (pain at end range)\nLumbar extension: 15° (pain increases)\nB/L SLR: 70° with hamstring tightness\nSide flexion: full range B/L",
            'muscle_strength' => "Hip flexors: 5/5 B/L\nKnee extensors: 5/5 B/L\nAnkle plantarflexors: 5/5 B/L\nTrunk extensors: 4/5 (pain inhibited)",
            'special_tests' => "SLR: Negative B/L\nFaber Test: Positive B/L\nCompression Test: Positive at L5-S1\nPosteroanterior glide: Pain at L4/L5 and L5/S1",
            'neurological' => "DTRs: Intact B/L\nSensation: Intact in L2-S2 dermatomes\nMyotomes: No weakness detected",
            'postural_assessment' => "Forward head posture\nRounded shoulders\nIncreased lumbar lordosis\nB/L pes planus",
            'clinical_impression' => "Mechanical low back pain with radicular component likely due to L5-S1 disc pathology with retrolisthesis. Clinical features suggestive of lumbar segmental instability.",
            'status' => 'completed',
        ]);

        Investigation::create([
            'assessment_id' => $ass1->id,
            'type' => 'MRI (L.S. Spine)',
            'investigation_date' => now()->subMonths(6)->subDays(10),
            'findings' => "Disc desiccation at L5-S1 level.\nGrade I retrolisthesis of L5 over S1 with mild diffuse disc bulge and posterior annular fissure.\nAP canal diameter: 8.8 mm.",
            'facility' => 'City Diagnostic Centre',
        ]);

        $plan1 = TreatmentPlan::create([
            'assessment_id' => $ass1->id,
            'patient_id' => $patient1->id,
            'short_term_goals' => "Reduce pain from 7/10 to 3/10 within 2 weeks\nImprove lumbar ROM by 30%\nReduce hamstring tightness",
            'long_term_goals' => "Return to work without restriction in 8 weeks\nMaintain pain-free sitting for 60 minutes\nPrevent recurrence through core stability",
            'precautions' => "Forward bending\nWeight lifting (>5 kg)\nJerky movement\nLong sitting / long standing (>40 min)\nSitting below 17 inches height",
            'advice' => "Change posture after every 40 min.\nUse LS belt while long sitting / travelling.\nUse western toilet only.\nTake rest in supine / side lying with pillows.",
            'follow_up_instructions' => "Review after 1 week.\nAttend physiotherapy 3x per week for 4 weeks.\nContact if pain increases.",
            'status' => 'active',
            'created_by' => $user->id,
        ]);

        ExercisePrescription::create([
            'treatment_plan_id' => $plan1->id,
            'exercise_name' => 'Pelvic Tilt',
            'description' => 'Lie on back with knees bent, feet flat. Gently tilt pelvis posteriorly, flattening lower back against the floor. Hold 5 seconds, release.',
            'category' => 'stabilization',
            'sets' => '3',
            'repetitions' => '10',
            'frequency' => '2 times/day',
            'duration' => '2 weeks',
            'precautions' => 'Avoid if pain increases',
        ]);

        ExercisePrescription::create([
            'treatment_plan_id' => $plan1->id,
            'exercise_name' => 'Cat-Camel Stretch',
            'description' => 'Position on hands and knees. Alternate between arching spine upward (cat) and allowing it to sag (camel).',
            'category' => 'mobilization',
            'sets' => '2',
            'repetitions' => '10',
            'frequency' => '2 times/day',
            'duration' => '2 weeks',
        ]);

        ExercisePrescription::create([
            'treatment_plan_id' => $plan1->id,
            'exercise_name' => 'Hamstring Stretch (Supine)',
            'description' => 'Lie on back, use a towel around the foot to gently pull the straight leg upward until a stretch is felt in the hamstring.',
            'category' => 'stretching',
            'sets' => '3',
            'repetitions' => '15',
            'frequency' => '2 times/day',
            'duration' => '4 weeks',
        ]);

        ExercisePrescription::create([
            'treatment_plan_id' => $plan1->id,
            'exercise_name' => 'Deep Neck Flexor Activation',
            'description' => 'Lie on back, gently nod the chin without lifting the head. Hold for 10 seconds.',
            'category' => 'postural',
            'sets' => '3',
            'repetitions' => '10',
            'frequency' => '1 time/day',
            'duration' => '4 weeks',
        ]);

        // ---------- Assessment 2: second patient (follow-up) ----------
        if ($patients->count() > 1) {
            $patient2 = $patients->get(1);

            $ass2 = Assessment::create([
                'patient_id' => $patient2->id,
                'branch_id' => $branch->id,
                'assessed_by' => $user->id,
                'assessment_date' => now()->subDay()->setHour(10)->setMinute(30),
                'type' => 'follow-up',
                'chief_complaints' => "Right knee pain since 2 months.\nPain increases while climbing stairs and squatting.\nOccasional clicking sensation.",
                'history_of_present_illness' => "IT professional, sitting 8-10 hours/day.\nHistory of patellofemoral pain syndrome (diagnosed 2024).\nPrevious physiotherapy completed.",
                'observation' => "Mild swelling in right knee.\nQuadriceps wasting noted on right side (1 cm difference).\nValgus collapse during squat.",
                'palpation' => "Tenderness over medial facet of patella.\nPatellar tendon tender at insertion.\nJoint line tenderness negative.",
                'range_of_motion' => "Knee flexion: 120° (pain at end range)\nKnee extension: 0° (full)\nShoulder ROM: Full and painless",
                'muscle_strength' => "Quadriceps: 4/5 right, 5/5 left\nHamstrings: 5/5 B/L\nVMO: poor activation on right",
                'special_tests' => "Patellar Grind Test: Positive right\nClarke's Sign: Positive right\nMcMurray: Negative B/L\nLachman: Negative B/L\nPatellar Apprehension: Negative",
                'neurological' => "Sensation intact. DTRs normal.",
                'postural_assessment' => "Genu valgum B/L (right > left)\nPatella alta on right\nPronated feet B/L",
                'clinical_impression' => "Recurrent right patellofemoral pain syndrome with quadriceps weakness and VMO lag. Mechanical symptoms likely due to patellar tracking dysfunction.",
                'status' => 'completed',
            ]);

            $plan2 = TreatmentPlan::create([
                'assessment_id' => $ass2->id,
                'patient_id' => $patient2->id,
                'short_term_goals' => "Reduce pain from 5/10 to 2/10 in 1 week\nImprove quadriceps strength to 5/5 in 3 weeks\nImprove VMO activation",
                'long_term_goals' => "Pain-free stairs and squat in 6 weeks\nReturn to recreational running in 10 weeks\nPrevent recurrence with strengthening program",
                'precautions' => "Avoid deep squatting (< 90°)\nAvoid prolonged sitting with knee bent\nAvoid high impact activities",
                'advice' => "Use patellar strap during activity.\nIce pack 15 min after exercise.\nMaintain activity modification.\nErgonomic chair adjustment at work.",
                'follow_up_instructions' => "Review in 1 week. Physiotherapy 2x per week for 6 weeks.",
                'status' => 'active',
                'created_by' => $user->id,
            ]);

            ExercisePrescription::create([
                'treatment_plan_id' => $plan2->id,
                'exercise_name' => 'Quadriceps Setting (Static)',
                'description' => 'Sit with leg extended. Tighten quadriceps muscle, pushing knee down into the surface. Hold 10 seconds.',
                'category' => 'strengthening',
                'sets' => '3',
                'repetitions' => '15',
                'frequency' => '3 times/day',
                'duration' => '2 weeks',
            ]);

            ExercisePrescription::create([
                'treatment_plan_id' => $plan2->id,
                'exercise_name' => 'Straight Leg Raise (SLR)',
                'description' => 'Lie on back, one knee bent. Keeping the other leg straight, lift to height of opposite knee. Hold 5 seconds.',
                'category' => 'strengthening',
                'sets' => '3',
                'repetitions' => '10',
                'frequency' => '3 times/day',
                'duration' => '4 weeks',
            ]);

            ExercisePrescription::create([
                'treatment_plan_id' => $plan2->id,
                'exercise_name' => 'Step Up (Low Platform)',
                'description' => 'Step up onto a low (4 inch) platform leading with the affected leg. Control the descent.',
                'category' => 'stabilization',
                'sets' => '3',
                'repetitions' => '10',
                'frequency' => '1 time/day',
                'duration' => '4 weeks',
            ]);

            ExercisePrescription::create([
                'treatment_plan_id' => $plan2->id,
                'exercise_name' => 'Hip Adductor Squeeze',
                'description' => 'Lie on back with knees bent, ball between knees. Squeeze ball and hold 5 seconds.',
                'category' => 'strengthening',
                'sets' => '3',
                'repetitions' => '15',
                'frequency' => '1 time/day',
                'duration' => '4 weeks',
            ]);
        }

        // ---------- Assessment 3: first patient again (follow-up, draft) ----------
        $ass3 = Assessment::create([
            'patient_id' => $patient1->id,
            'branch_id' => $branch->id,
            'assessed_by' => $user->id,
            'assessment_date' => now()->setHour(9)->setMinute(15),
            'type' => 'follow-up',
            'chief_complaints' => "Follow-up: Low back pain reduced from 7/10 to 4/10.\nStill some stiffness in morning.\nAble to sit for 25 min now.",
            'history_of_present_illness' => "Completed 2 physiotherapy sessions.\nCompliant with exercises.\nUsing LS belt for travel.",
            'observation' => "Improved posture. Gait appears more symmetrical.",
            'palpation' => "Reduced tenderness over L5-S1.\nHamstring tightness still present B/L but reduced.",
            'range_of_motion' => "Lumbar flexion: 60° (pain-free)\nLumbar extension: 25° (mild discomfort)",
            'muscle_strength' => "Trunk extensors: 4+/5\nHip muscles: 5/5 B/L",
            'special_tests' => "SLR: 80° B/L without pain\nFaber: Negative B/L",
            'neurological' => "Intact.",
            'postural_assessment' => "Improved alignment. Still mild forward head.",
            'clinical_impression' => "Good response to treatment. Continuing with phase 2 of rehabilitation.",
            'status' => 'draft',
        ]);

        TreatmentPlan::create([
            'assessment_id' => $ass3->id,
            'patient_id' => $patient1->id,
            'short_term_goals' => "Reduce pain to 2/10 in 1 week\nIncrease sitting tolerance to 40 min\nImprove core endurance",
            'long_term_goals' => "Full return to work by week 6\nNo recurrence at 3 months\nIndependent home exercise program",
            'precautions' => "Continue avoiding forward bending with straight legs.\nGradual return to lifting (max 10 kg by week 4).",
            'advice' => "Progress sitting time by 5 min every 2 days.\nContinue LS belt for travel.\nAdd walking 10 min/day.",
            'follow_up_instructions' => "Review in 1 week. Advance to phase 2 exercises.",
            'status' => 'active',
            'created_by' => $user->id,
        ]);

        $this->command->info('Dummy assessment data seeded successfully!');
        $this->command->info('Created: 3 assessments, 1 investigation, 3 treatment plans, 8 exercise prescriptions.');
    }
}
