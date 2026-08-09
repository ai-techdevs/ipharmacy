<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clinical_trials', function (Blueprint $table) {
            $table->string('allergy1')->nullable();
            $table->string('allergy2')->nullable();
            $table->string('allergy3')->nullable();
            $table->string('allergy4')->nullable();
            $table->string('reaction1')->nullable();
            $table->string('reaction2')->nullable();
            $table->string('reaction3')->nullable();
            $table->string('reaction4')->nullable();
            $table->string('medication1')->nullable();
            $table->string('medication2')->nullable();
            $table->string('medication3')->nullable();
            $table->string('medication4')->nullable();
            $table->string('dose1')->nullable();
            $table->string('dose2')->nullable();
            $table->string('dose3')->nullable();
            $table->string('dose4')->nullable();
            $table->string('mother_condition')->nullable();
            $table->string('father_condition')->nullable();
            $table->string('sibling_condition')->nullable();
            $table->string('other_condition')->nullable();
            $table->boolean('mother_living')->nullable();
            $table->boolean('father_living')->nullable();
            $table->boolean('sibling_living')->nullable();
            $table->boolean('other_living')->nullable();
            $table->boolean('mother_deceased_age')->nullable();
            $table->boolean('father_deceased_age')->nullable();
            $table->boolean('sibling_deceased_age')->nullable();
            $table->boolean('other_deceased_age')->nullable();
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->string('description3')->nullable();
            $table->string('description4')->nullable();
            $table->string('doctor1')->nullable();
            $table->string('doctor2')->nullable();
            $table->string('doctor3')->nullable();
            $table->string('doctor4')->nullable();
            $table->string('location1')->nullable();
            $table->string('location2')->nullable();
            $table->string('location3')->nullable();
            $table->string('location4')->nullable();
            $table->string('year1')->nullable();
            $table->string('year2')->nullable();
            $table->string('year3')->nullable();
            $table->string('year4')->nullable();
            $table->text('medical_problem')->nullable();
            $table->text('health_concern')->nullable();
            $table->text('issue_begin')->nullable();
            $table->boolean('cause_pain')->nullable();
            $table->string('pain_position')->nullable();
            $table->string('pain_change_since_it_began')->nullable();
            $table->string('how_quickly_did_you_current_pain_begin')->nullable();
            $table->string('how_often_does_your_pain_occur')->nullable();
            $table->string('when_is_your_pain_at_its_worst')->nullable();
            $table->text('current_symptomps')->nullable();
            $table->text('pain_description')->nullable();
            $table->string('other_health_concern')->nullable();
            $table->boolean('consume_alcohol')->nullable();
            $table->string('drinks_per_week')->nullable();
            $table->boolean('smoke')->nullable();
            $table->string('smoke_type')->nullable();
            $table->string('smoke_per_day')->nullable();
            $table->boolean('take_other_drug')->nullable();
            $table->string('other_drug')->nullable();
            $table->string('how_often')->nullable();
            $table->boolean('caffeine')->nullable();
            $table->string('cups_per_day')->nullable();
            $table->boolean('sexually_active')->nullable();
            $table->boolean('STI')->nullable();
            $table->string('exercise')->nullable();
            $table->boolean('special_diet')->nullable();
            $table->string('diet')->nullable();
            $table->boolean('planning_pregnancy')->nullable();
            $table->boolean('pregnant_now')->nullable();
            $table->string('contraception ')->nullable();
            $table->string('last_menstrual_cycle ')->nullable();
            $table->boolean('asthma')->nullable();
            $table->boolean('atrial_fibrillation')->nullable();
            $table->boolean('bleeding_problems')->nullable();
            $table->boolean('benign_prostatic_hyperplasia')->nullable();
            $table->boolean('coronary_artery_disease')->nullable();
            $table->boolean('cancer')->nullable();
            $table->boolean('cardiac_arrest')->nullable();
            $table->boolean('celiac_disease')->nullable();
            $table->boolean('chest_pain')->nullable();
            $table->boolean('congestive_heart_failure')->nullable();
            $table->boolean('chronic_fatigue_syndrome')->nullable();
            $table->boolean('depression')->nullable();
            $table->boolean('diabetes')->nullable();
            $table->boolean('drug_alcohol_abuse')->nullable();
            $table->boolean('erectile_dysfunction')->nullable();
            $table->boolean('fibromyalgia')->nullable();
            $table->boolean('gerd')->nullable();
            $table->boolean('heart_disease')->nullable();
            $table->boolean('hyperinsulinemia')->nullable();
            $table->boolean('hyperlipidemia')->nullable();
            $table->boolean('hypothyroidism')->nullable();
            $table->boolean('infection_problems')->nullable();
            $table->boolean('insomnia')->nullable();
            $table->boolean('irritable_bowel_syndrome')->nullable();
            $table->boolean('kidney_problems')->nullable();
            $table->boolean('menopause')->nullable();
            $table->boolean('migraines_headaches')->nullable();
            $table->boolean('neuropathy')->nullable();
            $table->boolean('onychomycosis')->nullable();
            $table->boolean('organ_injury')->nullable();
            $table->boolean('osteoporosis')->nullable();
            $table->boolean('pulmonary_embolism')->nullable();
            $table->boolean('seizure_disorders')->nullable();
            $table->boolean('shortness_of_breath')->nullable();
            $table->boolean('sinus_conditions')->nullable();
            $table->boolean('stroke')->nullable();
            $table->boolean('syndrome_x')->nullable();
            $table->boolean('tremors')->nullable();
            $table->boolean('wheat_allergy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_trials', function (Blueprint $table) {
            //
        });
    }
};
