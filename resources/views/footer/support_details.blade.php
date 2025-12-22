@extends('frontend.app')

@section('title', ucfirst($category['category_name']).' Support')

@section('content')
<section class="py-5">
  <div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/ ') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($category['category_name']) }}</li>
      </ol>
    </nav>

    <!-- Centered Content Wrapper -->
    <div class="mx-auto" style="max-width: 800px;">

      <h2 class="fw-bold mb-4">{{ ucfirst($category['category_name']) }}</h2>

      <div class="accordion" id="faqAccordion">
        @foreach($category['questions'] as $i => $question)
        <div class="accordion-item border-0 border-bottom">
          <h2 class="accordion-header" id="heading{{ $i }}">
            <button class="accordion-button collapsed bg-white px-0 py-3 d-flex justify-content-between"
              type="button" data-bs-toggle="collapse"
              data-bs-target="#collapse{{ $i }}" aria-expanded="false"
              aria-controls="collapse{{ $i }}">
              <span class="fw-semibold fs-5 text-dark">
                {{ $i + 1 }}. {{ $question }}
              </span>
            </button>
          </h2>
          <div id="collapse{{ $i }}" class="accordion-collapse collapse"
            aria-labelledby="heading{{ $i }}" data-bs-parent="#faqAccordion">
            <div class="accordion-body px-0 py-3 text-muted" style="line-height: 1.8;">
              {{ $category['answers'][$i] ?? 'Answer not available.' }}
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Back Button -->
      <!-- <div class="mt-5 text-center">
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill px-4">
          ← Back to Support
        </a>
      </div> -->
    </div>

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
<style>
  .accordion-button::after {
    background-image: none !important;
    content: '+';
    font-size: 1.5rem;
    color: #000;
    margin-left: auto;
  }

  .accordion-button:not(.collapsed)::after {
    content: '–';
    color: #d32f2f;
  }

  .accordion-button:focus {
    box-shadow: none;
  }

  .accordion-button {
    font-weight: 600;
  }

  .breadcrumb a {
    text-decoration: none;
    color: #007bff;
  }

  .breadcrumb a:hover {
    text-decoration: underline;
  }
</style>
@endsection