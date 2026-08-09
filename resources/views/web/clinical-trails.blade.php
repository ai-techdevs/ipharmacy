@extends('web/layouts/master')

@section('content')
<section class="inner-banner-wrapper">
    <div class="inner-banner-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sign up for Clinical Trials</li>
                        </ol>
                    </nav>
                    <h1>Sign up for Clinical Trials</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="signup-clinical-trials-wrapper common-gap">
    <div class="container">
        @if (Session::has('success'))
        <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
        <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}</div>
        @endif

        <form action="{{ route('save.trial') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="signup-clinical-form-wrap">
                        {{-- <div class="row">
                            <div class="col-12 col-md-5 mb-4 mb-md-0">
                                <div class="title">
                                    <h3>Sign Up For Clinical Trials</h3>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 left">
                                <div class="row">
                                    <!-- Top Fields -->
                                    <div class="col-12 col-md-12 mb-3">
                                        <div class="form-group">
                                            <h5> Please update your medical conditions and medical history, before you submit the iPhamarcy.com-generated form for your doctor (“Ask My Doctor if this drug is right for me”), OR before you authorize iPharmacy.com to submit your sign-up to pharmaceutical companies to consider you as a candidate for a clinical trial of a new drug.mmmmmmmmmmmmm</h5>

                                        </div>
                                    </div>
                                </div>
                             
                            </div>
                        </div> --}}

                        <section class="py-5">
                            <div class="container">
                                <div class="p-4 p-md-5 rounded-4 shadow-sm border bg-white">
                                    <div class="row align-items-center">

                                        <!-- Left Title -->
                                        <div class="col-md-5 mb-4 mb-md-0">
                                            <h3 class="fw-bold mb-2">Sign Up For Clinical Trials</h3>

                                        </div>

                                        <!-- Right Text -->
                                        <div class="col-md-7">
                                            <div class="bg-light p-4 rounded-3 border">
                                                <h5 class="fw-normal">
                                                    Please update your medical conditions and medical history, before you submit the iPhamarcy.com-generated form for your doctor (“Ask My Doctor if this drug is right for me”), OR before you authorize iPharmacy.com to submit your sign-up to pharmaceutical companies to consider you as a candidate for a clinical trial of a new drug.
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="newSec">
                            <div class="row">
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>Condition or disease<sup>*</sup></label>
                                        <input class="form-control" name="condition" type="text" value="{{ old('condition') }}" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Other items<sup>*</sup></label>
                                        <input class="form-control" name="other_items" type="text" value="{{ old('other_items') }}" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Treatment<sup>*</sup></label>
                                        <input class="form-control" name="treatment" type="text" value="{{ old('treatment') }}" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Location<sup>*</sup></label>
                                        <input class="form-control" name="location" type="text" value="{{ old('location') }}" required />
                                    </div>
                                </div>

                                <!-- ALLERGIES Section -->
                                <section class="tableFormSec py-4">
                                    <div class="container-xxl">
                                        <h3>ALLERGIES</h3>
                                        <h6>List your allergies and describe the reactions to your body:</h6>
                                        <hr />

                                        @for($i = 1; $i <= 4; $i++) <div class="row align-items-center mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Allergy</label>
                                                <input type="text" name="allergy{{ $i }}" class="form-control" value="{{ old('allergy'.$i) }}" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Reaction</label>
                                                <input type="text" name="reaction{{ $i }}" class="form-control" value="{{ old('reaction'.$i) }}" />
                                            </div>
                                    </div>
                                    @endfor

                                    <!-- MEDICATION Section -->
                                    <h3>MEDICATIONS</h3>
                                    <h6>List the medications you are currently taking including the dosage:</h6>
                                    <hr />

                                    @for($i = 1; $i <= 4; $i++) <div class="row align-items-center mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><input type="text" name="medication{{ $i }}" class="form-control" value="{{ old('medication'.$i) }}" />Medication</label>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><input type="text" name="dose{{ $i }}" class="form-control" value="{{ old('dose'.$i) }}" />Dose:</label>

                                        </div>
                            </div>
                            @endfor

                            <!-- FAMILY HEALTH HISTORY -->
                            <h3>FAMILY HEALTH HISTORY</h3>
                            <h6>List any major conditions/illnesses that your immediate family members have had:</h6>
                            <hr />

                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Relative</th>
                                        <th scope="col">Condition</th>
                                        <th scope="col">Living?</th>
                                        <th scope="col">If deceased, at what age?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['mother', 'father', 'sibling', 'other'] as $relative)
                                    <tr>
                                        <th scope="row">{{ ucfirst($relative) }}</th>
                                        <td>
                                            <input type="text" class="form-control" name="{{ $relative }}_condition" value="{{ old($relative.'_condition') }}" placeholder="Enter condition" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">

                                                <label class="form-check-label"> <input class="form-check-input" type="radio" name="{{ $relative }}_living" value="1" {{ old($relative.'_living') == '1' ? 'checked' : '' }} />Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">

                                                <label class="form-check-label"> <input class="form-check-input" type="radio" name="{{ $relative }}_living" value="0" {{ old($relative.'_living') == '0' ? 'checked' : '' }} />No</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="{{ $relative }}_deceased_age" value="{{ old($relative.'_deceased_age') }}" placeholder="Enter age" />
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- SURGICAL HISTORY -->
                            <h3>SURGICAL HISTORY</h3>
                            <h6>List any surgeries, fractures, major illnesses, or hospitalizations that you have had:</h6>
                            <hr />

                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Description</th>
                                        <th scope="col">Doctor</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 4; $i++) <tr>
                                        <td>
                                            <input type="text" name="description{{ $i }}" class="form-control" value="{{ old('description'.$i) }}" placeholder="Description" />
                                        </td>
                                        <td>
                                            <input type="text" name="doctor{{ $i }}" class="form-control" value="{{ old('doctor'.$i) }}" placeholder="Doctor" />
                                        </td>
                                        <td>
                                            <input type="text" name="location{{ $i }}" class="form-control" value="{{ old('location'.$i) }}" placeholder="Location" />
                                        </td>
                                        <td>
                                            <input type="text" name="year{{ $i }}" class="form-control" value="{{ old('year'.$i) }}" placeholder="Year" />
                                        </td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>

                            <!-- MEDICAL HISTORY -->
                            <hr />
                            <h3>MEDICAL HISTORY</h3>
                            <h6>Have you ever had any of the following?</h6>
                            <hr />

                            <div class="container mt-4">
                                <div class="row">
                                    @php
                                    $conditions = [
                                    'Anemia',
                                    'Arthritis Conditions',
                                    'Asthma',
                                    'Atrial Fibrillation',
                                    'Benign Prostatic Hyperplasia',
                                    'Bleeding Problems',
                                    'Cancer',
                                    'Cardiac Arrest',
                                    'Celiac Disease',
                                    'Chest Pain',
                                    'Chronic Fatigue Syndrome',
                                    'Congestive Heart Failure',
                                    'Coronary Artery Disease',
                                    'Depression',
                                    'Diabetes',
                                    'Drug/Alcohol Abuse',
                                    'Erectile Dysfunction',
                                    'Fibromyalgia',
                                    'Gerd',
                                    'Heart Disease',
                                    'Hyperinsulinemia',
                                    'Hyperlipidemia',
                                    'Hypertension',
                                    'Hypothyroidism',
                                    'Infection Problems',
                                    'Insomnia',
                                    'Irritable Bowel Syndrome',
                                    'Kidney Problems',
                                    'Male Hypogonadism',
                                    'Menopause',
                                    'Migraines/Headaches',
                                    'Neuropathy',
                                    'Onychomycosis',
                                    'Organ Injury',
                                    'Osteoporosis',
                                    'Pulmonary Embolism',
                                    'Seizure Disorders',
                                    'Shortness of Breath',
                                    'Sinus Conditions',
                                    'Stroke',
                                    'Syndrome X',
                                    'Tremors',
                                    'Wheat Allergy'
                                    ];
                                    @endphp

                                    @foreach ($conditions as $condition)
                                    @php
                                    $field = Str::slug($condition, '_');
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ $condition }}" readonly />
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check form-check-inline">

                                                    <label class="form-check-label"><input class="form-check-input" type="radio" name="{{ $field }}" value="1" {{ old($field) == '1' ? 'checked' : '' }}>Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">

                                                    <label class="form-check-label"> <input class="form-check-input" type="radio" name="{{ $field }}" value="0" {{ old($field) == '0' ? 'checked' : '' }}>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">List any other medical problems that you have had:</label>
                                        <textarea class="form-control" rows="3" name="medical_problem">{{ old('medical_problem') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- HEALTH CONCERNS -->
                            <div class="mt-4">
                                <h3>HEALTH CONCERNS</h3>
                                <div class="mb-3">
                                    <label class="form-label">What's your primary health concern?</label>
                                    <input type="text" name="health_concern" class="form-control" value="{{ old('health_concern') }}" placeholder="Description" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Approximately when did this issue begin?</label>
                                    <input type="text" name="issue_begin" class="form-control" value="{{ old('issue_begin') }}" placeholder="Description" />
                                </div>

                                <div class="row align-items-center">
                                    <label>Does the issue cause you pain?</label>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">

                                            <label class="form-check-label"> <input class="form-check-input" type="radio" name="cause_pain" value="1" {{ old('cause_pain') == '1' ? 'checked' : '' }} />Yes</label>
                                        </div>
                                        <div class="form-check ">

                                            <label class="form-check-label"> <input class="form-check-input" type="radio" name="cause_pain" value="0" {{ old('cause_pain') == '0' ? 'checked' : '' }} />No</label>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-3">
                                            <label>If so, where?</label>
                                            <input type="text" class="form-control" name="pain_position" value="{{ old('pain_position') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>How has the pain changed since it began?</strong></label>
                                    <div class="form-check ">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="pain_change_since_it_began" value="increased" {{ old('pain_change_since_it_began') == 'increased' ? 'checked' : '' }} />Increased</label>
                                    </div>
                                    <div class="form-check">

                                        <label class="form-check-label"><input class="form-check-input" type="radio" name="pain_change_since_it_began" value="decreased" {{ old('pain_change_since_it_began') == 'decreased' ? 'checked' : '' }} />Decreased</label>
                                    </div>
                                    <div class="form-check ">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="pain_change_since_it_began" value="unchanged" {{ old('pain_change_since_it_began') == 'unchanged' ? 'checked' : '' }} />Unchanged</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>How quickly did your current pain begin?</strong></label>
                                    <div class="form-check ">

                                        <label class="form-check-label"><input class="form-check-input" type="radio" name="how_quickly_did_you_current_pain_begin" value="gradually" {{ old('how_quickly_did_you_current_pain_begin') == 'gradually' ? 'checked' : '' }} />Gradually</label>
                                    </div>
                                    <div class="form-check ">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="how_quickly_did_you_current_pain_begin" value="suddenly" {{ old('how_quickly_did_you_current_pain_begin') == 'suddenly' ? 'checked' : '' }} />Suddenly</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>How often does your pain occur?</strong></label>
                                    <div class="form-check ">

                                        <label class="form-check-label"><input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="constantly" {{ old('how_often_does_your_pain_occur') == 'constantly' ? 'checked' : '' }} />Constantly</label>
                                    </div>
                                    <div class="form-check ">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="occasionally" {{ old('how_often_does_your_pain_occur') == 'occasionally' ? 'checked' : '' }} />Occasionally</label>
                                    </div>
                                    <div class="form-check ">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="rarely" {{ old('how_often_does_your_pain_occur') == 'rarely' ? 'checked' : '' }} />Rarely</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>When is your pain at its worst?</strong></label>
                                    @foreach(['morning', 'afternoon', 'evening', 'night'] as $time)
                                    <div class="form-check ">

                                        <label class="form-check-label"><input class="form-check-input" type="radio" name="when_is_your_pain_at_its_worst" value="{{ $time }}" {{ old('when_is_your_pain_at_its_worst') == $time ? 'checked' : '' }} />{{ ucfirst($time) }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">What are your current symptoms?</label>
                                    <input type="text" name="current_symptomps" class="form-control" value="{{ old('current_symptomps') }}" />
                                </div>
                            </div>

                            <!-- Pain Description Checkboxes -->
                            <div class="mt-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Check any of the following that describe your pain:</strong></label>
                                    @php
                                    $painTypes = [
                                    'Aching',
                                    'Cramping',
                                    'Dull',
                                    'Hot/Burning',
                                    'Numbness',
                                    'Shock-like',
                                    'Shooting',
                                    'Spasming',
                                    'Squeezing',
                                    'Stabbing/Sharp',
                                    'Throbbing',
                                    'Tingling',
                                    'Tiring/Exhausting'
                                    ];
                                    $oldPainDesc = old('pain_description', []);
                                    @endphp

                                    @foreach($painTypes as $type)
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"><input class="form-check-input" type="checkbox" name="pain_description[]" value="{{ $type }}" {{ in_array($type, $oldPainDesc) ? 'checked' : '' }}>{{ $type }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">List any other health concerns that you would like us to know about</label>
                                            <textarea class="form-control" rows="3" name="other_health_concern">{{ old('other_health_concern') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SOCIAL HISTORY -->
                            <hr>
                            <h3>SOCIAL HISTORY</h3>

                            <div class="row align-items-center">
                                <label>Do you currently consume alcohol?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="consume_alcohol" value="1" {{ old('consume_alcohol') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="consume_alcohol" value="0" {{ old('consume_alcohol') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-3">
                                        <label>How many drinks per week?</label>
                                        <input type="text" name="drinks_per_week" class="form-control" value="{{ old('drinks_per_week') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label>Do you currently smoke?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="smoke" value="1" {{ old('smoke') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="smoke" value="0" {{ old('smoke') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label>What do you smoke?</label>
                                <div class="col-md-12">
                                    @foreach(['tobacco', 'marijuana', 'other'] as $smokeType)
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="smoke_type" value="{{ $smokeType }}" {{ old('smoke_type') == $smokeType ? 'checked' : '' }}>{{ ucfirst($smokeType) }}</label>
                                    </div>
                                    @endforeach

                                    <div class="col-md-12 mt-2 mb-3">
                                        <label>How many cigarettes do you smoke per day?</label>
                                        <input type="text" name="smoke_per_day" class="form-control" value="{{ old('smoke_per_day') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label>Do you currently use any other drugs?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="take_other_drug" value="1" {{ old('take_other_drug') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="take_other_drug" value="0" {{ old('take_other_drug') == '0' ? 'checked' : '' }}>No</label>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-3">
                                        <label>What other drugs do you take?</label>
                                        <input type="text" name="other_drug" class="form-control" value="{{ old('other_drug') }}">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>How often?</label>
                                    <div class="col-md-12">
                                        @foreach(['daily', 'weekly', 'occasionally', 'rarely'] as $freq)
                                        <div class="form-check form-check-inline">

                                            <label class="form-check-label"> <input class="form-check-input" type="radio" name="how_often" value="{{ $freq }}" {{ old('how_often') == $freq ? 'checked' : '' }}>{{ ucfirst($freq) }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label>Do you drink caffeine?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="caffeine" value="1" {{ old('caffeine') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="caffeine" value="0" {{ old('caffeine') == '0' ? 'checked' : '' }}>No</label>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-3">
                                        <label>How many cups per day?</label>
                                        <input type="text" name="cups_per_day" class="form-control" value="{{ old('cups_per_day') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>Are you sexually active?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="sexually_active" value="1" {{ old('sexually_active') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="sexually_active" value="0" {{ old('sexually_active') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>Would you like to be checked for STIs?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="STI" value="1" {{ old('STI') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"><input class="form-check-input" type="radio" name="STI" value="0" {{ old('STI') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>How frequently do you exercise?</label>
                                <div class="col-md-12">
                                    @foreach(['daily', 'weekly', 'occasionally', 'rarely'] as $exercise)
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="exercise" value="{{ $exercise }}" {{ old('exercise') == $exercise ? 'checked' : '' }}>{{ ucfirst($exercise) }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>Are you on a special diet?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="special_diet" value="1" {{ old('special_diet') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="special_diet" value="0" {{ old('special_diet') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-2 mb-3">
                                    <label>What diet?</label>
                                    <input type="text" name="diet" class="form-control" value="{{ old('diet') }}">
                                </div>
                            </div>

                            <hr>
                            <h3>Complete the following if applicable:</h3>

                            <div class="row align-items-center mb-3">
                                <label>Are you planning a pregnancy?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="planning_pregnancy" value="1" {{ old('planning_pregnancy') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="planning_pregnancy" value="0" {{ old('planning_pregnancy') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>Are you pregnant now?</label>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="pregnant_now" value="1" {{ old('pregnant_now') == '1' ? 'checked' : '' }}>Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label"> <input class="form-check-input" type="radio" name="pregnant_now" value="0" {{ old('pregnant_now') == '0' ? 'checked' : '' }}>No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>What type of contraception do you currently use?</label>
                                <div class="col-md-12">
                                    <input type="text" name="contraception" class="form-control" value="{{ old('contraception') }}">
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <label>When was your last menstrual cycle?</label>
                                <div class="col-md-12">
                                    <input type="text" name="last_menstrual_cycle" class="form-control" value="{{ old('last_menstrual_cycle') }}">
                                </div>
                            </div>
                        </div>
</section>

<!-- HIPAA Compliance Section -->
<section class="our-cdc-media-wrapper">
    <div class="our-cdc-media-inner-wrap">
        <div class="container">
            <h4>HIPAA Compliance Patient Consent Form</h4>
            <hr>
            <p>Our Notice of Privacy Practices provides information about how we may use or disclose protected health information.</p>
            <p>The notice contains a patient's rights section describing your rights under the law. You ascertain that by your submission of this update form you have reviewed our notice before signing this consent.</p>
            <p>The terms of the notice may change, if so, you will be notified at your next update of your medical conditions and medical history at iPharmacy.com</p>

            <p>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck5" name="question1" {{ old('question1') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="exampleCheck5">By saving and submitting this form, you consent willingly to iPharmacy.com's and its parent company's use and disclosure of your protected healthcare information for submitting to your designated doctor and for submitting to pharmaceutical companies and/or their employees, or their agents and their employees, for considering your candidacy for a clinical trial. You have the right to revoke this consent in writing, signed by you. However, such a revocation will not be retroactive.</label>
                </div>
            </p>

            <p>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck6" name="question2" {{ old('question2') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="exampleCheck6">I hereby authorize iPhamarcy.com to generate a form for me to submit to my doctor for the purpose of "Ask My Doctor if this drug is right for me".</label>
                </div>
            </p>

            <p>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck7" name="question3" {{ old('question3') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="exampleCheck7">I hereby authorize iPharmacy.com to submit my sign-up to pharmaceutical companies (or their employees or their agents and employees) to consider me as a candidate for a clinical trial of a new drug.</label>
                </div>
            </p>
        </div>
    </div>
</section>

<!-- reCAPTCHA -->
<div class="col-12 mb-5">
    <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
    @error('g-recaptcha-response')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Submit Button -->
<div class="col-12 col-md-12 mb-3">
    <div class="form-group">
        <button class="btn common-btn1">Submit <span><i class="fa-solid fa-arrow-right"></i></span></button>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form {{-- {!! NoCaptcha::renderJs() !!} --}} </div>
</section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
