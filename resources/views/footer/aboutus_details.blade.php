@extends('frontend.app')
@section('title', $about->title ?? 'About Us' )


@section('content')

<section class="py-5">
  <div class="container" style="max-width: 1000px;">
    {{-- Breadcrumb --}}
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/ ') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $about->title }}</li>
      </ol>
    </nav>


    {{-- Hero Section --}}
    <div class="row align-items-center mb-5">
      <div class="col-lg-7">
        <h2 class="fw-bold mb-3">
          {!! $about->heading !!}
        </h2>
        <p class="text-muted mb-4">{{ $about->description }}</p>

        @if(!empty($about->button_text) && !empty($about->button_number))
        <a href="tel:{{ $about->button_number }}" class="btn rounded btn-danger px-4 py-2 fw-semibold">
          {{ $about->button_text }}
        </a>
        @endif
      </div>

      <div class="col-lg-5 text-center">
        @if(!empty($about->hero_image))
        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $about->hero_image }}"
          alt="About Image" class="img-fluid rounded-4 shadow">
        @else
        <img src="{{ asset('frontend/assets/img/about-default.jpg') }}" alt="About Default" class="img-fluid rounded-4 shadow">
        @endif
      </div>
    </div>

    @if(!empty($about->founders))
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
    @endif
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