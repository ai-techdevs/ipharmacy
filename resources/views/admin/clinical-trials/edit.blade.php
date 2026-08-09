@extends('admin.layouts.app')

@section('title', 'Patient Record')

@section('content')

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Patient Medical Record</h4>
            <a href="{{ route('admin.clinical-trials.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>


    <div class="card-body">
        {{-- Medical Condition --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Medical Condition</h5>
            <p><strong>Condition:</strong> {{ $trail->condition ?? '-' }}</p>
            <p><strong>Other Items:</strong> {{ $trail->other_items ?? '-' }}</p>
            <p><strong>Treatment:</strong> {{ $trail->treatment ?? '-' }}</p>
            <p><strong>Location:</strong> {{ $trail->location ?? '-' }}</p>
        </section>

        {{-- Allergies --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Allergies</h5>
            @for ($i = 1; $i <= 4; $i++)
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Allergy {{ $i }}:</strong> {{ $trail->{'allergy'.$i} ?? '-' }}</div>
                    <div class="col-md-6"><strong>Reaction {{ $i }}:</strong> {{ $trail->{'reaction'.$i} ?? '-' }}</div>
                </div>
            @endfor
        </section>

        {{-- Medications --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Medications</h5>
            @for ($i = 1; $i <= 4; $i++)
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Medication {{ $i }}:</strong> {{ $trail->{'medication'.$i} ?? '-' }}</div>
                    <div class="col-md-4"><strong>Dose:</strong> {{ $trail->{'dose'.$i} ?? '-' }}</div>
                    <div class="col-md-4"><strong>Description:</strong> {{ $trail->{'description'.$i} ?? '-' }}</div>
                </div>
            @endfor
        </section>

        {{-- Family History --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Family History</h5>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Mother Condition:</strong> {{ $trail->mother_condition ?? '-' }}</div>
                <div class="col-md-6"><strong>Father Condition:</strong> {{ $trail->father_condition ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Sibling Condition:</strong> {{ $trail->sibling_condition ?? '-' }}</div>
                <div class="col-md-6"><strong>Other Condition:</strong> {{ $trail->other_condition ?? '-' }}</div>
            </div>
        </section>

        {{-- Health & Lifestyle --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Health & Lifestyle</h5>
            <div class="row mb-2">
                <div class="col-md-4"><strong>Consume Alcohol:</strong> {{ $trail->consume_alcohol ? 'Yes' : 'No' }}</div>
                <div class="col-md-4"><strong>Smoke:</strong> {{ $trail->smoke ? 'Yes' : 'No' }}</div>
                <div class="col-md-4"><strong>Exercise:</strong> {{ ucfirst($trail->exercise ?? '-') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><strong>Special Diet:</strong> {{ $trail->special_diet ? 'Yes' : 'No' }}</div>
                <div class="col-md-4"><strong>Caffeine:</strong> {{ $trail->caffeine ? 'Yes' : 'No' }}</div>
                <div class="col-md-4"><strong>Sexually Active:</strong> {{ $trail->sexually_active ? 'Yes' : 'No' }}</div>
            </div>
        </section>

        {{-- Medical Problems --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Medical Problems</h5>
            <div class="row">
                @foreach($trail->getAttributes() as $key => $value)
                    @if(is_bool($value))
                        <div class="col-md-3 mb-2">
                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                            <span class="badge bg-{{ $value ? 'success' : 'danger' }}">{{ $value ? 'Yes' : 'No' }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Other Info --}}
        <section class="mb-4">
            <h5 class="text-secondary border-bottom pb-2 mb-3">Other Information</h5>
            <p><strong>Health Concern:</strong> {{ $trail->health_concern ?? '-' }}</p>
            <p><strong>Issue Begin:</strong> {{ $trail->issue_begin ?? '-' }}</p>
            <p><strong>Current Symptoms:</strong> {{ $trail->current_symptomps ?? '-' }}</p>
            <p><strong>Other Health Concern:</strong> {{ $trail->other_health_concern ?? '-' }}</p>
        </section>

        <div class="text-end mt-4">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>
</div>


</div>

<style>
    h5 { font-weight: 600; color: #495057; }
    .card-header { border-radius: 12px 12px 0 0 !important; }
    .card { border-radius: 12px; }
    .badge { font-size: 0.9em; }
    @media print {
        .btn, .card-header a { display: none !important; }
        .card { border: none; box-shadow: none; }
        body { background: #fff; }
    }
</style>

@endsection
