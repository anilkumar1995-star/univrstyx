@extends('frontend.app')
@section('title',  $contact->heading ?? 'Contact Us')


@section('content')

<section class="py-5">
    <div class="container" style="max-width: 1000px;">
        {{-- Breadcrumb --}}
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/ ') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $contact->heading }}</li>
            </ol>
        </nav>


        {{-- Hero Section --}}
        <div class="row align-items-center mb-5">
            <div class="col-lg-7">
                <h2 class="fw-bold mb-3">
                    {!! $contact->heading !!}
                </h2>
                <p class="text-muted mb-4">{{ $contact->description }}</p>

                @if(!empty($contact->button_text) && !empty($contact->button_number))
                <a href="tel:{{ $contact->button_number }}" class="btn btn-danger rounded px-4 py-2 fw-semibold">
                    {{ $contact->button_text }}
                </a>
                @endif
            </div>

            <div class="col-lg-5 text-center">
                @if(!empty($contact->contact_image))
                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $contact->contact_image }}"
                    alt="Contact Image" class="img-fluid rounded-4 shadow">
                @else
                <img src="{{ asset('frontend/assets/img/about-default.jpg') }}" alt="About Default" class="img-fluid rounded-4 shadow">
                @endif
            </div>
        </div>

        <div class="container my-5">
            <div class="row g-4">
                <h3 class="mt-3">Call Or Email Us</h3>

                @foreach($programs as $prog)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm p-4 text-center" style="border-radius: 15px;">
                        <div class="mx-auto mb-3"
                            style="width:40px; height:40px; background:#fdecef; border-radius:50%; 
                     display:flex; align-items:center; justify-content:center;">
                            <i class="fa fa-phone fa-1x text-danger"></i>
                        </div>
                        <h6 class="">{{ $prog['text'] ?? '' }}</h6>

                        @if(!empty($prog['phone']))
                        <p class="mt-1 mb-1"
                            style="color:#d80027; font-weight:600;">
                            {{ $prog['phone'] }}
                        </p>
                        @endif
                        <hr>
                        <p class="mt-1" style="color:#d80027; font-weight:600;">
                            {{ $prog['email'] ?? '' }}
                        </p>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <div class="container py-5">
            <h2 class="mb-4 fw-bold">Our <span class="text-primary">Offices</span></h2>

            <div class="row g-4">

                @foreach ($offices as $office)
                <div class="col-md-4">
                    <div class="position-relative rounded-4 overflow-hidden shadow-lg" style="height: 360px;">

                        <div class="w-100 h-100"
                            style="background-image: url('https://images.incomeowl.in/incomeowl/crm/images/{{ $office['image'] }}');
                        background-size: cover;
                        background-position: center;">
                        </div>
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.15), transparent);">
                        </div>

                        <div class="position-absolute bottom-0 start-0 end-0 text-center text-white p-3">

                            <div class="mx-auto mb-2"
                                style="width:45px;height:45px;background:rgba(255,0,0,0.85);backdrop-filter:blur(4px);
                                 border-radius:50%;display:flex;align-items:center;justify-content:center;">

                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    fill="white" viewBox="0 0 24 24">
                                    <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 
                                     2.5 2.5 0 0 1 0 5z" />
                                </svg>

                            </div>


                            <h4 class="fw-bold mt-3 mb-1">{{ ucfirst($office['city']) }}</h4>

                            <p class="mb-0 mt-3 text-white" style="font-size:13px; line-height: 1.4;">
                                {{ $office['address'] }}
                            </p>

                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>









        <!-- @if(!empty($about->founders))
    <div class="mt-5">
      @php
      $words = explode(' ', $about->main_heading);
      $lastWord = array_pop($words);
      @endphp

      <h2 class="fw-bold mb-4">
        {{ implode(' ', $words) }} <span class="text-danger">{{ $lastWord }}</span>
      </h2>


      <div class="row">
        @foreach($about->founders as $founder)
        <div class="col-md-4 mb-4">
          <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
            @if(!empty($founder['image']))
            <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $founder['image'] }}"
              alt="{{ $founder['name'] }}" class="card-img-top" style="object-fit: cover; height: 250px;">
            @else
            <img src="{{ asset('frontend/assets/img/founder-placeholder.jpg') }}" alt="Founder" class="card-img-top" style="object-fit: cover; height: 250px;">
            @endif

            <div class="card-body">
              <p class="small text-muted mb-1">
                {{ $founder['award'] ?? '' }}
              </p>
              <h5 class="fw-semibold mb-0">{{ $founder['name'] ?? '' }}</h5>
              <small class="text-muted">{{ $founder['role'] ?? '' }}</small>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif -->
    </div>
</section>






<section class="">
    <div class="container overflow-hidden">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-Theme">
                    <h3> iUniversity<span> Learner Support </span> </h3>
                    <p class="learnerSupport">Talk to our experts. We’re available 24/7.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="supportCountry">
                    <ul>
                        <li>
                            <div class="d-flex">
                                <img src="{{ asset('') }}frontend/images/support/india.webp">
                                <p> Indian Nationals </p>
                            </div>
                            <button> <i class="fa-solid fa-phone"></i> {{ $programme->helpline_number ?? '1800 210 2020' }}</button>
                        </li>
                        <li>
                            <div class="d-flex">
                                <img src="{{ asset('') }}frontend/images/support/gmail.webp">
                                <p> Email Id </p>
                            </div>
                            <button> <i class="fa-solid fa-envelope"></i> {{ $disclaimer->email ?? "support@iuniversity.com" }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="disclaimer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-Theme">
                    <h3 class="mb-4">Disclaimer</h3>

                    <div class="para">
                        <p>
                            {{ $disclaimer->disclaimer ?? "iUniversity facilitates program delivery and is not a college/university in itself. Credits and credentials are awarded by the university. Please refer relevant terms and conditions before applying. Past record is no guarantee of future job prospects. The success of job placement depends on various factors including but not limited to the individual's qualifications, experience, and efforts in seeking employment. Our organization makes no guarantees or representations regarding the level or timing of job placement." }}
                        </p>
                    </div>
                    <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection