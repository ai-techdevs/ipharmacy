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
                  <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                </ol>
              </nav>
              <h1>FAQs</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="faq-wrapper common-gap">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-4">
            <div class="common-title">
              <h3>Frequently Asked Questions</h3>
              {{-- <p>Aenean posuere justo vel finibus vulputate. Donec pellentesque rhoncus neque sed bibendum. Curabitur efficitur pellentesque rhoncus neque  mauris vel nibh faucibus dictum. Proin finibus pellentesqu Aenean posuere justo</p> --}}
            </div>
          </div>
          <div class="col-12">

            <div class="faq-wrap">
              <div class="accordion row" id="FAQaccordion">
                @foreach($faqs as $key => $faq)
                <div class="col-12 col-md-6">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ ($key + 1) }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ($key + 1) }}" aria-expanded="true" aria-controls="collapse{{ ($key + 1) }}">
                            {{$faq->question}}
                        </button>
                        </h2>
                        <div id="collapse{{ ($key + 1) }}" class="accordion-collapse collapse" aria-labelledby="heading{{ ($key + 1) }}" data-bs-parent="#FAQaccordion">
                        <div class="accordion-body">
                            <p>{!!$faq->answer  !!}</p>
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading2">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        How do I qualify for drug coupons?
                      </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>To qualify for drug coupons, you must be a registered user of this site.  If you are not a registered user and would like to join, please click the Register link at the top of the page.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading3">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading4">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading5">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading6">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading7">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading8">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading9">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading10">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading11">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                        How can I participate in the IP Forum?
                      </button>
                    </h2>
                    <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#FAQaccordion">
                      <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo suscipit ullam assumenda vel voluptas quibusdam, dolor sequi laborum tempore placeat sunt accusamus temporibus inventore laudantium tenetur, necessitatibus commodi sapiente nam?</p>
                      </div>
                    </div>
                  </div>
                </div> --}}

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
@endsection
