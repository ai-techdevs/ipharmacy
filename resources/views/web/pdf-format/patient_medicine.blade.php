{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        h2 { margin-bottom: 5px; border-bottom: 1px solid #000; padding-bottom: 3px; }
        .section { margin-bottom: 25px; }
        .field { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Patient Query</h1>

    <div class="section">
        <h2>Patient Information</h2>
        @foreach($patient as $key => $value)
            <div class="field">
                <span class="label">{{ ucwords(str_replace('_', ' ', $key)) }}:</span>
                {{ $value }}
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Medicine Information</h2>
        <div class="field"><span class="label">Name:</span> {!! $medicine->name !!}</div>
        <div class="field"><span class="label">Uses:</span> {!! $medicine->uses !!}</div>
        <div class="field"><span class="label">Additional Info:</span> {!! $medicine->additional_information !!}</div>
        <div class="field"><span class="label">Precautions:</span> {!! $medicine->precautions !!}</div>
        <div class="field"><span class="label">Side Effects:</span> {!! $medicine->side_effects !!}</div>
        <div class="field"><span class="label">Interactions:</span> {!! $medicine->interactions !!}</div>
    </div>

</body>
</html> --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            line-height: 1.4;
        }
        h1 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: #333;
        }
        h2 { 
            margin-bottom: 10px; 
            margin-top: 20px;
            border-bottom: 2px solid #333; 
            padding-bottom: 5px; 
            font-size: 16px;
        }
        h3 {
            margin-bottom: 8px;
            margin-top: 15px;
            font-size: 14px;
            color: #444;
        }
        .section { 
            margin-bottom: 25px; 
            page-break-inside: avoid;
        }
        .field { 
            margin-bottom: 8px; 
        }
        .label { 
            font-weight: bold; 
            display: inline-block;
            min-width: 200px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .checkbox-list {
            display: flex;
            flex-wrap: wrap;
        }
        .checkbox-item {
            width: 50%;
            margin-bottom: 5px;
        }
        .yes-no {
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <h1>Patient Medical History & Drug Inquiry Report</h1>

    <!-- Patient Information -->
    <div class="section">
        <h2>Patient Information</h2>
        <div class="field">
            <span class="label">First Name:</span> {{ $request->first_name ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Last Name:</span> {{ $request->last_name ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Email:</span> {{ $request->email ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Mobile:</span> {{ $request->mobile ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Age Group:</span> {{ $request->age_group ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Gender:</span> {{ $request->gender ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Address 1:</span> {{ $request->address_1 ?? 'N/A' }}
        </div>
        @if($request->address_2)
        <div class="field">
            <span class="label">Address 2:</span> {{ $request->address_2 }}
        </div>
        @endif
        <div class="field">
            <span class="label">City:</span> {{ $request->city ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">State:</span> {{ $request->state ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Zip:</span> {{ $request->zip ?? 'N/A' }}
        </div>
    </div>

    <!-- Medical Conditions -->
    <div class="section">
        <h2>Medical Conditions</h2>
        <div class="field">
            <span class="label">Existing Medical Conditions:</span> {{ $request->existing_medical_condition ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Currently Taking Medications:</span> {{ $request->current_medications ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Known Allergies:</span> {{ $request->known_allergies ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Previous Surgeries:</span> {{ $request->previous_surgeries ?? 'N/A' }}
        </div>
    </div>

    <!-- Allergies -->
    <div class="section">
        <h2>Allergies</h2>
        <table>
            <thead>
                <tr>
                    <th>Allergy</th>
                    <th>Reaction</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 4; $i++)
                    @if($request->{'allergy'.$i} || $request->{'reaction'.$i})
                    <tr>
                        <td>{{ $request->{'allergy'.$i} ?? '-' }}</td>
                        <td>{{ $request->{'reaction'.$i} ?? '-' }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Current Medications -->
    <div class="section">
        <h2>Current Medications</h2>
        <table>
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Dose</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 4; $i++)
                    @if($request->{'medication'.$i} || $request->{'dose'.$i})
                    <tr>
                        <td>{{ $request->{'medication'.$i} ?? '-' }}</td>
                        <td>{{ $request->{'dose'.$i} ?? '-' }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Family Health History -->
    <div class="section">
        <h2>Family Health History</h2>
        <table>
            <thead>
                <tr>
                    <th>Relative</th>
                    <th>Condition</th>
                    <th>Living</th>
                    <th>If Deceased, Age</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['mother', 'father', 'sibling', 'other'] as $relative)
                    @if($request->{$relative.'_condition'})
                    <tr>
                        <td>{{ ucfirst($relative) }}</td>
                        <td>{{ $request->{$relative.'_condition'} ?? '-' }}</td>
                        <td>{{ $request->{$relative.'_living'} == '1' ? 'Yes' : ($request->{$relative.'_living'} == '0' ? 'No' : '-') }}</td>
                        <td>{{ $request->{$relative.'_deceased_age'} ?? '-' }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Surgical History -->
    <div class="section">
        <h2>Surgical History</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Doctor</th>
                    <th>Location</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 4; $i++)
                    @if($request->{'description'.$i} || $request->{'doctor'.$i} || $request->{'location'.$i} || $request->{'year'.$i})
                    <tr>
                        <td>{{ $request->{'description'.$i} ?? '-' }}</td>
                        <td>{{ $request->{'doctor'.$i} ?? '-' }}</td>
                        <td>{{ $request->{'location'.$i} ?? '-' }}</td>
                        <td>{{ $request->{'year'.$i} ?? '-' }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Medical History -->
    <div class="section">
        <h2>Medical History</h2>
        <h3>Has the patient ever had any of the following:</h3>
        @php
        $conditions = [
            'asthma' => 'Asthma',
            'hypothyroidism' => 'Hypothyroidism',
            'atrial_fibrillation' => 'Atrial Fibrillation',
            'infection_problems' => 'Infection Problems',
            'bleeding_problems' => 'Bleeding Problems',
            'insomnia' => 'Insomnia',
            'benign_prostatic_hyperplasia' => 'Benign Prostatic Hyperplasia',
            'irritable_bowel_syndrome' => 'Irritable Bowel Syndrome',
            'coronary_artery_disease' => 'Coronary Artery Disease',
            'kidney_problems' => 'Kidney Problems',
            'cancer' => 'Cancer',
            'menopause' => 'Menopause',
            'cardiac_arrest' => 'Cardiac Arrest',
            'migraines_headaches' => 'Migraines/Headaches',
            'celiac_disease' => 'Celiac Disease',
            'neuropathy' => 'Neuropathy',
            'chest_pain' => 'Chest Pain',
            'onychomycosis' => 'Onychomycosis',
            'congestive_heart_failure' => 'Congestive Heart Failure',
            'organ_injury' => 'Organ Injury',
            'chronic_fatigue_syndrome' => 'Chronic Fatigue Syndrome',
            'osteoporosis' => 'Osteoporosis',
            'depression' => 'Depression',
            'pulmonary_embolism' => 'Pulmonary Embolism',
            'diabetes' => 'Diabetes',
            'seizure_disorders' => 'Seizure Disorders',
            'drug_alcohol_abuse' => 'Drug/Alcohol Abuse',
            'shortness_of_breath' => 'Shortness of Breath',
            'erectile_dysfunction' => 'Erectile Dysfunction',
            'sinus_conditions' => 'Sinus Conditions',
            'fibromyalgia' => 'Fibromyalgia',
            'stroke' => 'Stroke',
            'gerd' => 'GERD',
            'syndrome_x' => 'Syndrome X',
            'heart_disease' => 'Heart Disease',
            'tremors' => 'Tremors',
            'hyperinsulinemia' => 'Hyperinsulinemia',
            'wheat_allergy' => 'Wheat Allergy',
            'hyperlipidemia' => 'Hyperlipidemia'
        ];
        @endphp

        <table>
            <thead>
                <tr>
                    <th>Condition</th>
                    <th>Response</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conditions as $key => $label)
                    @if($request->$key !== null)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $request->$key == '1' ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @if($request->medical_problem)
        <div class="field">
            <span class="label">Other Medical Problems:</span><br>
            {{ $request->medical_problem }}
        </div>
        @endif
    </div>

    <!-- Health Concerns -->
    <div class="section">
        <h2>Health Concerns</h2>
        
        @if($request->health_concern)
        <div class="field">
            <span class="label">Primary Health Concern:</span> {{ $request->health_concern }}
        </div>
        @endif

        @if($request->issue_begin)
        <div class="field">
            <span class="label">When Issue Began:</span> {{ $request->issue_begin }}
        </div>
        @endif

        @if($request->cause_pain !== null)
        <div class="field">
            <span class="label">Does Issue Cause Pain:</span> {{ $request->cause_pain == '1' ? 'Yes' : 'No' }}
        </div>
        @endif

        @if($request->pain_position)
        <div class="field">
            <span class="label">Pain Location:</span> {{ $request->pain_position }}
        </div>
        @endif

        @if($request->pain_change_since_it_began)
        <div class="field">
            <span class="label">Pain Change Since It Began:</span> {{ ucfirst($request->pain_change_since_it_began) }}
        </div>
        @endif

        @if($request->how_quickly_did_you_current_pain_begin)
        <div class="field">
            <span class="label">How Quickly Pain Began:</span> {{ ucfirst($request->how_quickly_did_you_current_pain_begin) }}
        </div>
        @endif

        @if($request->how_often_does_your_pain_occur)
        <div class="field">
            <span class="label">Pain Frequency:</span> {{ ucfirst($request->how_often_does_your_pain_occur) }}
        </div>
        @endif

        @if($request->when_is_your_pain_at_its_worst)
        <div class="field">
            <span class="label">Pain Worst At:</span> {{ ucfirst($request->when_is_your_pain_at_its_worst) }}
        </div>
        @endif

        @if($request->current_symptomps)
        <div class="field">
            <span class="label">Current Symptoms:</span> {{ $request->current_symptomps }}
        </div>
        @endif

        @if($request->pain_description)
        <div class="field">
            <span class="label">Pain Description:</span><br>
            @php
                $painDesc = is_array($request->pain_description) ? $request->pain_description : json_decode($request->pain_description, true);
            @endphp
            @if($painDesc && is_array($painDesc))
                {{ implode(', ', $painDesc) }}
            @endif
        </div>
        @endif

        @if($request->other_health_concern)
        <div class="field">
            <span class="label">Other Health Concerns:</span><br>
            {{ $request->other_health_concern }}
        </div>
        @endif
    </div>

    <!-- Social History -->
    <div class="section">
        <h2>Social History</h2>

        <h3>Alcohol Consumption</h3>
        @if($request->consume_alcohol !== null)
        <div class="field">
            <span class="label">Consumes Alcohol:</span> {{ $request->consume_alcohol == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->drinks_per_week)
        <div class="field">
            <span class="label">Drinks Per Week:</span> {{ $request->drinks_per_week }}
        </div>
        @endif

        <h3>Smoking</h3>
        @if($request->smoke !== null)
        <div class="field">
            <span class="label">Smokes:</span> {{ $request->smoke == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->smoke_type)
        <div class="field">
            <span class="label">Smoke Type:</span> {{ ucfirst($request->smoke_type) }}
        </div>
        @endif
        @if($request->smoke_per_day)
        <div class="field">
            <span class="label">Cigarettes Per Day:</span> {{ $request->smoke_per_day }}
        </div>
        @endif

        <h3>Drug Use</h3>
        @if($request->take_other_drug !== null)
        <div class="field">
            <span class="label">Uses Other Drugs:</span> {{ $request->take_other_drug == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->other_drug)
        <div class="field">
            <span class="label">Other Drugs:</span> {{ $request->other_drug }}
        </div>
        @endif
        @if($request->how_often)
        <div class="field">
            <span class="label">Frequency:</span> {{ ucfirst($request->how_often) }}
        </div>
        @endif

        <h3>Caffeine</h3>
        @if($request->caffeine !== null)
        <div class="field">
            <span class="label">Drinks Caffeine:</span> {{ $request->caffeine == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->cups_per_day)
        <div class="field">
            <span class="label">Cups Per Day:</span> {{ $request->cups_per_day }}
        </div>
        @endif

        <h3>Sexual Health</h3>
        @if($request->sexually_active !== null)
        <div class="field">
            <span class="label">Sexually Active:</span> {{ $request->sexually_active == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->STI !== null)
        <div class="field">
            <span class="label">Wants STI Check:</span> {{ $request->STI == '1' ? 'Yes' : 'No' }}
        </div>
        @endif

        <h3>Lifestyle</h3>
        @if($request->exercise)
        <div class="field">
            <span class="label">Exercise Frequency:</span> {{ ucfirst($request->exercise) }}
        </div>
        @endif
        @if($request->special_diet !== null)
        <div class="field">
            <span class="label">On Special Diet:</span> {{ $request->special_diet == '1' ? 'Yes' : 'No' }}
        </div>
        @endif
        @if($request->diet)
        <div class="field">
            <span class="label">Diet Type:</span> {{ $request->diet }}
        </div>
        @endif
    </div>

    <!-- Pregnancy Information -->
    @if($request->planning_pregnancy !== null || $request->pregnant_now !== null || $request->contraception || $request->last_menstrual_cycle)
    <div class="section">
        <h2>Pregnancy Information</h2>
        
        @if($request->planning_pregnancy !== null)
        <div class="field">
            <span class="label">Planning Pregnancy:</span> {{ $request->planning_pregnancy == '1' ? 'Yes' : 'No' }}
        </div>
        @endif

        @if($request->pregnant_now !== null)
        <div class="field">
            <span class="label">Currently Pregnant:</span> {{ $request->pregnant_now == '1' ? 'Yes' : 'No' }}
        </div>
        @endif

        @if($request->contraception)
        <div class="field">
            <span class="label">Contraception Type:</span> {{ $request->contraception }}
        </div>
        @endif

        @if($request->last_menstrual_cycle)
        <div class="field">
            <span class="label">Last Menstrual Cycle:</span> {{ $request->last_menstrual_cycle }}
        </div>
        @endif
    </div>
    @endif

    <!-- Medicine Information -->
    <div class="section">
        <h2>Medicine Information</h2>
        <div class="field"><span class="label">Name:</span> {!! $medicine->name !!}</div>
        @if($medicine->uses)
        <div class="field"><span class="label">Uses:</span> {!! $medicine->uses !!}</div>
        @endif
        @if($medicine->additional_information)
        <div class="field"><span class="label">Additional Info:</span> {!! $medicine->additional_information !!}</div>
        @endif
        @if($medicine->precautions)
        <div class="field"><span class="label">Precautions:</span> {!! $medicine->precautions !!}</div>
        @endif
        @if($medicine->side_effects)
        <div class="field"><span class="label">Side Effects:</span> {!! $medicine->side_effects !!}</div>
        @endif
        @if($medicine->interactions)
        <div class="field"><span class="label">Interactions:</span> {!! $medicine->interactions !!}</div>
        @endif
    </div>

</body>
</html>