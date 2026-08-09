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
                  <li class="breadcrumb-item active" aria-current="page">Drug Information</li>
                  <li class="breadcrumb-item active" aria-current="page">Drugs Beginning With The Letter {{ $letter }}</li>
                </ol>
              </nav>
              <h1>Drug Information</h1>
            </div>
          </div>
        </div>
      </div>
</section>
<section class="drug-information-details-wrapper common-gap">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-12 mb-4">
            <div class="common-title">
              <h3>{{ $medicine->name }} </h3>
            </div>
          </div>

          @if (!empty($medicine?->uses))
          <div class="col-12 col-md-6 mb-4">
            <div class="drug-information-listing-wrap">
              <div class="title">
                <div class="info-name">
                  Uses
                </div>
              </div>
             {!! $medicine?->uses !!}
            </div>
          </div>
          @endif

          @if (!empty($medicine?->side_effects))
          <div class="col-12 col-md-6 mb-4">
            <div class="drug-information-listing-wrap">
              <div class="title">
                <div class="info-name">
                  Side effects
                </div>
              </div>
             {!! $medicine?->side_effects !!}

            </div>
          </div>
          @endif

          @if (!empty($medicine?->additional_information))
          <div class="col-12 col-md-6 mb-4">
            <div class="drug-information-listing-wrap">
              <div class="title">
                <div class="info-name">
                  Additional Information
                </div>
              </div>
               {!! $medicine?->additional_information !!}
            </div>
          </div>
          @endif

          @if (!empty($medicine?->interactions))
          <div class="col-12 col-md-6 mb-4">
            <div class="drug-information-listing-wrap">
              <div class="title">
                <div class="info-name">
                  Interactions
                </div>
              </div>
               {!! $medicine?->interactions !!}
              {{-- <ul>
                <li>Your healthcare professionals (e.g., doctor or pharmacist) may already be aware of any possible drug interactions and may be monitoring you for it. Do not start, stop or change the dosage of any medicine before checking with them first.</li>
                <li>Avoid taking MAO inhibitors (e.g., furazolidone, isocarboxazid, linezolid, moclobemide, phenelzine, procarbazine, selegiline, tranylcypromine) for 2 weeks before, during, and 2 weeks after treatment with this medication. In some cases a serious, possibly fatal, drug interaction may occur. Before using this medication tell your doctor or pharmacist of all</li>
                <li>Do not give this medication to a child younger than six years of age unless directed to do so by a doctor. Caution is advised when using this drug in children because they are more sensitive to the effects of antihistamines. This drug can often cause excitement in young children instead of drowsiness.</li>
                <li>This drug passes into breast milk and may have undesirable effects on a nursing infant. Therefore, breast-feeding is not recommended while using this medication. Consult your doctor before breast-feeding.</li>
                <li>This drug should be used only if clearly needed during pregnancy. Tell your doctor if you are pregnant before using this medication.</li>
              </ul> --}}
            </div>
          </div>
          @endif

          @if (!empty($medicine?->interactions))
            <div class="col-12 col-md-6 mb-4">
                <div class="drug-information-listing-wrap">
                <div class="title">
                    <div class="info-name">
                    Precautions
                    </div>
                </div>
               
                {!! $medicine?->precautions !!}

                </div>
            </div>
          @endif
          
        </div>
      </div>
</section>




@endsection

