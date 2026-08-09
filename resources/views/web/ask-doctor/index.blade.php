@extends('web/layouts/master')

@section('content')
<section class="inner-banner-wrapper">
    <div class="inner-banner-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ask My Doctor if This Drug is Right For Me</li>
                        </ol>
                    </nav>
                    <h1>Ask My Doctor If This Drug is Right For Me</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="drug-information-form-wrapper common-gap">


    <div class="container">
        <form action="{{ route('ask.doctor', $medicine->slug) }}" id="queryForm" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">

                    @if (Session::has('success'))
                    <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
                    @endif

                    @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <div class="drug-information-form-wrap">

                        <div class="title-wrap">
                            <div class="title">
                                <div class="icon">
                                    <img class="img-fluid" src="{{asset('assets/images/pdf-icon.svg') }}" alt="">
                                </div>
                                Drug Information
                            </div>

                            <div class="email-print-btn-wrap">
                                <ul>
                                    <li>
                                        <button type="submit" class="btn btn-default" title="Email">
                                            <img class="img-fluid" src="{{ asset('assets/images/email-icon.svg')}}" alt="">
                                        </button>
                                        {{-- <a href="#" >

                      </a> --}}
                                    </li>
                                    <li>
                                        <a href="#" onclick="window.print()" title="Print">
                                            <img class="img-fluid" src="{{ asset('assets/images/print-icon.svg') }}" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="drug-name-about-wrap">
                            <div class="drug-name-wrap">
                                Drug Name: <strong>{{ $medicine->name }} </strong>
                            </div>
                            {{-- <div class="drug-about-content">
                  <div class="drug-about">
                    About:
                  </div>
                  <div class="content">

                  </div>
                </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>First Name<sup>*</sup></label>
                                    <input class="form-control" name="first_name" value="{{ $user->name ?? '' }}" required>

                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input class="form-control" name="last_name" value="{{ $user->last_name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Email<sup>*</sup></label>
                                    <input class="form-control" name="email" value="{{ $user->email ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Mobile<sup>*</sup></label>
                                    <input class="form-control" name="mobile" value="{{ $user->mobile ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Age Group<sup>*</sup></label>
                                    <input class="form-control" name="age_group" value="{{ $user->age_group ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Gender<sup>*</sup></label>
                                    <input class="form-control" name="gender" value="{{ $user->gender ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Address 1<sup>*</sup></label>
                                    <textarea class="form-control" name="address_1" rows="4" required>{{ $user->address1 ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <textarea class="form-control" name="address_2" rows="4">{{ $user->address2 ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>City<sup>*</sup></label>
                                    <input class="form-control" name="city" value="{{ $user->city ?? '' }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>State<sup>*</sup></label>
                                    <input class="form-control" name="state" value="{{ $user->state ?? '' }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Zip<sup>*</sup></label>
                                    <input class="form-control" name="zip" value="{{ $user->zip ?? '' }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="heading">
                                    <h4>Medical Conditions*</h4>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Existing medical conditions?</label>
                                    <input class="form-control" name="existing_medical_condition" value="" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Currently taking medications?<sup>*</sup></label>
                                    <input class="form-control" value="" name="current_medications" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Known allergies?<sup>*</sup></label>
                                    <input class="form-control" value="" name="known_allergies" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label>Any previous surgeries?<sup>*</sup></label>
                                    <input class="form-control" value="" name="previous_surgeries" required>
                                </div>
                            </div>

                        </div>




                        <section class="tableFormSec py-4">
                            <div class="container-xxl">
                                <h3>ALLERGIES</h3>
                                <h6>List your allergies and describe the reactions to your body:</h6>
                                <hr />

                                @for($i = 1; $i <= 4; $i++) <div class="row align-items-center mb-3">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Allergy</label>
                                        <input type="text" name="allergy{{ $i }}" class="form-control" value="{{ old('allergy'.$i) }}" />
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Reaction</label>
                                        <input type="text" name="reaction{{ $i }}" class="form-control" value="{{ old('reaction'.$i) }}" />
                                    </div>
                            </div>
                            @endfor

                            <!-- MEDICATION Section -->
                            <h3>MEDICATION</h3>
                            <h6>List the medications you are currently taking including the dosage:</h6>
                            <hr />

                            @for($i = 1; $i <= 4; $i++) <div class="row align-items-center mb-3">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Medication</label>
                                    <input type="text" name="medication{{ $i }}" class="form-control" value="{{ old('medication'.$i) }}" />
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Dose:</label>
                                    <input type="text" name="dose{{ $i }}" class="form-control" value="{{ old('dose'.$i) }}" />
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
                                        <input class="form-check-input" type="radio" name="{{ $relative }}_living" value="1" {{ old($relative.'_living') == '1' ? 'checked' : '' }} />
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="{{ $relative }}_living" value="0" {{ old($relative.'_living') == '0' ? 'checked' : '' }} />
                                        <label class="form-check-label">No</label>
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
                            'Asthma', 'Hypothyroidism', 'Atrial Fibrillation', 'Infection Problems',
                            'Bleeding Problems', 'Insomnia', 'Benign Prostatic Hyperplasia',
                            'Irritable Bowel Syndrome', 'Coronary Artery Disease', 'Kidney Problems',
                            'Cancer', 'Menopause', 'Cardiac Arrest', 'Migraines/Headaches',
                            'Celiac Disease', 'Neuropathy', 'Chest Pain', 'Onychomycosis',
                            'Congestive Heart Failure', 'Organ Injury', 'Chronic Fatigue Syndrome',
                            'Osteoporosis', 'Depression', 'Pulmonary Embolism', 'Diabetes',
                            'Seizure Disorders', 'Drug/Alcohol Abuse', 'Shortness of Breath',
                            'Erectile Dysfunction', 'Sinus Conditions', 'Fibromyalgia', 'Stroke',
                            'Gerd', 'Syndrome X', 'Heart Disease', 'Tremors', 'Hyperinsulinemia',
                            'Wheat Allergy', 'Hyperlipidemia'
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
                                            <input class="form-check-input" type="radio" name="{{ $field }}" value="1" {{ old($field) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="{{ $field }}" value="0" {{ old($field) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label">No</label>
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
                                    <input class="form-check-input" type="radio" name="cause_pain" value="1" {{ old('cause_pain') == '1' ? 'checked' : '' }} />
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="cause_pain" value="0" {{ old('cause_pain') == '0' ? 'checked' : '' }} />
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="col-md-12 mt-2 mb-3">
                                    <label>If so, where?</label>
                                    <input type="text" class="form-control" name="pain_position" value="{{ old('pain_position') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>How has the pain changed since it began?</strong></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pain_change_since_it_began" value="increased" {{ old('pain_change_since_it_began') == 'increased' ? 'checked' : '' }} />
                                <label class="form-check-label">Increased</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pain_change_since_it_began" value="decreased" {{ old('pain_change_since_it_began') == 'decreased' ? 'checked' : '' }} />
                                <label class="form-check-label">Decreased</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pain_change_since_it_began" value="unchanged" {{ old('pain_change_since_it_began') == 'unchanged' ? 'checked' : '' }} />
                                <label class="form-check-label">Unchanged</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>How quickly did your current pain begin?</strong></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="how_quickly_did_you_current_pain_begin" value="gradually" {{ old('how_quickly_did_you_current_pain_begin') == 'gradually' ? 'checked' : '' }} />
                                <label class="form-check-label">Gradually</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="how_quickly_did_you_current_pain_begin" value="suddenly" {{ old('how_quickly_did_you_current_pain_begin') == 'suddenly' ? 'checked' : '' }} />
                                <label class="form-check-label">Suddenly</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>How often does your pain occur?</strong></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="constantly" {{ old('how_often_does_your_pain_occur') == 'constantly' ? 'checked' : '' }} />
                                <label class="form-check-label">Constantly</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="occasionally" {{ old('how_often_does_your_pain_occur') == 'occasionally' ? 'checked' : '' }} />
                                <label class="form-check-label">Occasionally</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="how_often_does_your_pain_occur" value="rarely" {{ old('how_often_does_your_pain_occur') == 'rarely' ? 'checked' : '' }} />
                                <label class="form-check-label">Rarely</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>When is your pain at its worst?</strong></label>
                            @foreach(['morning', 'afternoon', 'evening', 'night'] as $time)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="when_is_your_pain_at_its_worst" value="{{ $time }}" {{ old('when_is_your_pain_at_its_worst') == $time ? 'checked' : '' }} />
                                <label class="form-check-label">{{ ucfirst($time) }}</label>
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
                            $painTypes = ['Aching', 'Numbness', 'Spasming', 'Throbbing', 'Cramping',
                            'Shock-like', 'Squeezing', 'Tingling', 'Dull', 'Shooting',
                            'Stabbing/Sharp', 'Tiring/Exhausting', 'Hot/Burning'];
                            $oldPainDesc = old('pain_description', []);
                            @endphp

                            @foreach($painTypes as $type)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="pain_description[]" value="{{ $type }}" {{ in_array($type, $oldPainDesc) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $type }}</label>
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
                                <input class="form-check-input" type="radio" name="consume_alcohol" value="1" {{ old('consume_alcohol') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="consume_alcohol" value="0" {{ old('consume_alcohol') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
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
                                <input class="form-check-input" type="radio" name="smoke" value="1" {{ old('smoke') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="smoke" value="0" {{ old('smoke') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <label>What do you smoke?</label>
                        <div class="col-md-12">
                            @foreach(['tobacco', 'marijuana', 'other'] as $smokeType)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="smoke_type" value="{{ $smokeType }}" {{ old('smoke_type') == $smokeType ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($smokeType) }}</label>
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
                                <input class="form-check-input" type="radio" name="take_other_drug" value="1" {{ old('take_other_drug') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="take_other_drug" value="0" {{ old('take_other_drug') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
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
                                    <input class="form-check-input" type="radio" name="how_often" value="{{ $freq }}" {{ old('how_often') == $freq ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($freq) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <label>Do you drink caffeine?</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="caffeine" value="1" {{ old('caffeine') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="caffeine" value="0" {{ old('caffeine') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
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
                                <input class="form-check-input" type="radio" name="sexually_active" value="1" {{ old('sexually_active') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sexually_active" value="0" {{ old('sexually_active') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label>Would you like to be checked for STIs?</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="STI" value="1" {{ old('STI') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="STI" value="0" {{ old('STI') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label>How frequently do you exercise?</label>
                        <div class="col-md-12">
                            @foreach(['daily', 'weekly', 'occasionally', 'rarely'] as $exercise)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="exercise" value="{{ $exercise }}" {{ old('exercise') == $exercise ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($exercise) }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label>Are you on a special diet?</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="special_diet" value="1" {{ old('special_diet') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="special_diet" value="0" {{ old('special_diet') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
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
                                <input class="form-check-input" type="radio" name="planning_pregnancy" value="1" {{ old('planning_pregnancy') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="planning_pregnancy" value="0" {{ old('planning_pregnancy') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label>Are you pregnant now?</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregnant_now" value="1" {{ old('pregnant_now') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregnant_now" value="0" {{ old('pregnant_now') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">No</label>
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
                    <label class="form-check-label" for="exampleCheck6">I hereby authorize iPhamarcy.com to generate a form for me to submit to my doctor for the purpose of "Ask My Doctor is this drug is right for me".</label>
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
    
           <div class="title-wrap">
                            <div class="title">
                                <div class="icon">
                                    <img class="img-fluid" src="{{asset('assets/images/pdf-icon.svg') }}" alt="">
                                </div>
                                Drug Information
                            </div>

                            <div class="email-print-btn-wrap">
                                <ul>
                                    <li>
                                        <button type="submit" class="btn btn-default" title="Email">
                                            <img class="img-fluid" src="{{ asset('assets/images/email-icon.svg')}}" alt="">
                                        </button>
                                        {{-- <a href="#" >

                      </a> --}}
                                    </li>
                                    <li>
                                        <a href="#" onclick="window.print()" title="Print">
                                            <img class="img-fluid" src="{{ asset('assets/images/print-icon.svg') }}" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
</section>


</form>
</div>
</div>
</div>
</div>
</section>

<div class="modal fade" id="SendMailModal" tabindex="-1" role="dialog" aria-labelledby="SendMailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SendMailModalLabel">Send to Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="doctorForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Doctor Name<sup>*</sup></label>
                        <input type="text" class="form-control" name="doctor_name" required>
                    </div>
                    <div class="form-group">
                        <label>Doctor Email<sup>*</sup></label>
                        <input type="email" class="form-control" name="doctor_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelModalBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#queryForm').on('submit', function(e) {
            e.preventDefault();
            $('#SendMailModal').modal('show');
        });

        $('#doctorForm').on('submit', function(e) {
            e.preventDefault();

            // Take all inputs from doctorForm
            var doctorFormData = $(this).serializeArray();

            // Append them as hidden fields inside queryForm
            $.each(doctorFormData, function(_, field) {
                // avoid duplicates if field already exists in queryForm
                if ($('#queryForm').find('[name="' + field.name + '"]').length === 0) {
                    $('<input>').attr({
                        type: 'hidden'
                        , name: field.name
                        , value: field.value
                    }).appendTo('#queryForm');
                } else {
                    // update existing value
                    $('#queryForm').find('[name="' + field.name + '"]').val(field.value);
                }
            });

            // console.log($('#queryForm').serialize()) ;

            // Submit queryForm with merged data
            $('#queryForm')[0].submit();

        });
    })

</script>


{{-- <script>
$(document).ready(function() {

    const form = $('#queryForm');
    const fields = form.find('input, textarea');

  
    const validators = {
        first_name: value => value.trim() !== '' ? '' : 'First Name is required',
        last_name: value => value.trim() !== '' ? '' : 'Last Name is required',
        email: value => {
            if(value.trim() === '') return 'Email is required';
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(value) ? '' : 'Enter a valid email';
        },
        mobile: value => value.trim() !== '' ? '' : 'Mobile number is required',
        age_group: value => value.trim() !== '' ? '' : 'Age Group is required',
        gender: value => value.trim() !== '' ? '' : 'Gender is required',
        address_1: value => value.trim() !== '' ? '' : 'Address 1 is required',
        city: value => value.trim() !== '' ? '' : 'City is required',
        state: value => value.trim() !== '' ? '' : 'State is required',
        zip: value => value.trim() !== '' ? '' : 'Zip is required',
        existing_medical_condition: value => value.trim() !== '' ? '' : 'This field is required',
        current_medications: value => value.trim() !== '' ? '' : 'This field is required',
        known_allergies: value => value.trim() !== '' ? '' : 'This field is required',
        previous_surgeries: value => value.trim() !== '' ? '' : 'This field is required'
    };


    function showError(field, message) {
        removeError(field);
        if (!message) return;
        const errorDiv = $('<div class="field-error-message"></div>').text(message).css({
            'color': '#dc3545',
            'font-size': '12px',
            'margin-top': '4px'
        });
        field.closest('.form-group').append(errorDiv);
        field.css('border-color', '#dc3545');
    }


    function removeError(field) {
        field.closest('.form-group').find('.field-error-message').remove();
        field.css('border-color', '');
    }

   
    function validateField(field) {
        const name = field.attr('name');
        if (!validators[name]) return true;
        const message = validators[name](field.val());
        showError(field, message);
        return message === '';
    }

   
    fields.on('focusout', function() {
        validateField($(this));
    });

  
    form.on('submit', function(e) {
        let isValid = true;
        fields.each(function() {
            if (!validateField($(this))) isValid = false;
        });

        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.field-error-message:first').offset().top - 100
            }, 500);
        }
    });

});
</script> --}}

<script>
    $(document).ready(function() {
        // Handle queryForm submission - show modal
        $('#queryForm').on('submit', function(e) {
            e.preventDefault();

            // Validate form first
            let isValid = true;
            const fields = $(this).find('input[required], textarea[required]');

            fields.each(function() {
                if (!$(this).val().trim()) {
                    isValid = false;
                    $(this).css('border-color', '#dc3545');
                } else {
                    $(this).css('border-color', '');
                }
            });

            // Check HIPAA checkboxes
            if (!$('#exampleCheck5').is(':checked') || !$('#exampleCheck6').is(':checked') || !$('#exampleCheck7').is(':checked')) {
                isValid = false;
                alert('Please accept all HIPAA consent forms');
            }

            if (isValid) {
                $('#SendMailModal').modal('show');
            } else {
                alert('Please fill all required fields');
            }
        });


        $('#cancelModalBtn, button[data-dismiss="modal"]').on('click', function(e) {
            e.preventDefault();
            $('#SendMailModal').modal('hide');

            $('#doctorForm')[0].reset();
        });


        $('#doctorForm').on('submit', function(e) {
            e.preventDefault();


            const doctorName = $('input[name="doctor_name"]').val().trim();
            const doctorEmail = $('input[name="doctor_email"]').val().trim();

            if (!doctorName || !doctorEmail) {
                alert('Please enter doctor name and email');
                return false;
            }


            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(doctorEmail)) {
                alert('Please enter a valid email address');
                return false;
            }


            var doctorFormData = $(this).serializeArray();


            $.each(doctorFormData, function(_, field) {

                $('#queryForm').find('input[name="' + field.name + '"]').remove();


                $('<input>').attr({
                    type: 'hidden'
                    , name: field.name
                    , value: field.value
                }).appendTo('#queryForm');
            });


            $('#SendMailModal').modal('hide');


            $('button[type="submit"]').prop('disabled', true).html('<span>Sending...</span>');


            $('#queryForm')[0].submit();
        });


        $('#SendMailModal').on('hidden.bs.modal', function() {
            $('#doctorForm')[0].reset();
        });
    });

</script>

{{-- <script>
$(document).ready(function() {
    const form = $('#queryForm');
    const fields = form.find('input, textarea');

    const validators = {
        first_name: value => value.trim() !== '' ? '' : 'First Name is required',
        last_name: value => value.trim() !== '' ? '' : 'Last Name is required',
        email: value => {
            if(value.trim() === '') return 'Email is required';
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(value) ? '' : 'Enter a valid email';
        },
        mobile: value => value.trim() !== '' ? '' : 'Mobile number is required',
        age_group: value => value.trim() !== '' ? '' : 'Age Group is required',
        gender: value => value.trim() !== '' ? '' : 'Gender is required',
        address_1: value => value.trim() !== '' ? '' : 'Address 1 is required',
        city: value => value.trim() !== '' ? '' : 'City is required',
        state: value => value.trim() !== '' ? '' : 'State is required',
        zip: value => value.trim() !== '' ? '' : 'Zip is required',
        existing_medical_condition: value => value.trim() !== '' ? '' : 'This field is required',
        current_medications: value => value.trim() !== '' ? '' : 'This field is required',
        known_allergies: value => value.trim() !== '' ? '' : 'This field is required',
        previous_surgeries: value => value.trim() !== '' ? '' : 'This field is required',
        question1: value => value.trim() !== '' ? '' :'This field is required',
        question2: value => value.trim() !== '' ? '' :'This field is required',
        question3: value => value.trim() !== '' ? '' :'This field is required',
    };

    function showError(field, message) {
        removeError(field);
        if (!message) return;
        const errorDiv = $('<div class="field-error-message"></div>').text(message).css({
            'color': '#dc3545',
            'font-size': '12px',
            'margin-top': '4px'
        });
        field.closest('.form-group').append(errorDiv);
        field.css('border-color', '#dc3545');
    }

    function removeError(field) {
        field.closest('.form-group').find('.field-error-message').remove();
        field.css('border-color', '');
    }

    function validateField(field) {
        const name = field.attr('name');
        if (!validators[name]) return true;
        const message = validators[name](field.val());
        showError(field, message);
        return message === '';
    }

    fields.on('focusout', function() {
        validateField($(this));
    });
});
</script> --}}


<script>
    $(document).ready(function() {
        const form = $('#queryForm');
        const fields = form.find('input, textarea, select');

        const validators = {
            first_name: value => value.trim() !== '' ? '' : 'First Name is required'
            , last_name: value => value.trim() !== '' ? '' : 'Last Name is required'
            , email: value => {
                if (value.trim() === '') return 'Email is required';
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(value) ? '' : 'Enter a valid email';
            }
            , mobile: value => value.trim() !== '' ? '' : 'Mobile number is required'
            , age_group: value => value.trim() !== '' ? '' : 'Age Group is required'
            , gender: value => value.trim() !== '' ? '' : 'Gender is required'
            , address_1: value => value.trim() !== '' ? '' : 'Address 1 is required'
            , city: value => value.trim() !== '' ? '' : 'City is required'
            , state: value => value.trim() !== '' ? '' : 'State is required'
            , zip: value => value.trim() !== '' ? '' : 'Zip is required'
            , existing_medical_condition: value => value.trim() !== '' ? '' : 'This field is required'
            , current_medications: value => value.trim() !== '' ? '' : 'This field is required'
            , known_allergies: value => value.trim() !== '' ? '' : 'This field is required'
            , previous_surgeries: value => value.trim() !== '' ? '' : 'This field is required',


            question1: (value, field) => field.is(':checked') ? '' : 'This field is required'
            , question2: (value, field) => field.is(':checked') ? '' : 'This field is required'
            , question3: (value, field) => field.is(':checked') ? '' : 'This field is required'
        , };

        function showError(field, message) {
            removeError(field);
            if (!message) return;
            const errorDiv = $('<div class="field-error-message"></div>')
                .text(message)
                .css({
                    color: '#dc3545'
                    , 'font-size': '12px'
                    , 'margin-top': '4px'
                });
            field.closest('.form-group, .form-check').append(errorDiv);
            field.css('outline', '1px solid #dc3545');
        }

        function removeError(field) {
            field.closest('.form-group, .form-check').find('.field-error-message').remove();
            field.css('outline', '');
        }

        function validateField(field) {
            const name = field.attr('name');
            if (!validators[name]) return true;
            const message = validators[name](field.val(), field);
            showError(field, message);
            return message === '';
        }

        fields.on('focusout change', function() {
            validateField($(this));
        });


        form.on('submit', function(e) {
            let valid = true;
            fields.each(function() {
                if (!validateField($(this))) valid = false;
            });
            if (!valid) e.preventDefault();
        });
    });

</script>


@endpush
