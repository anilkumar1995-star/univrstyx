@extends('frontend.app')
@section('title', 'View Course')
@section('pagetitle', 'View Course')

@php
$table = 'yes';
@endphp

@section('content')
<section class="breadcrumb-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ !empty($course->course_category) ? ucwords(str_replace('_', ' ', $course->course_category)) : 'N/A' }}&nbsp; > {{ $course->course_title }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<section class="p-0">
  <div class="container mb-5">
    <div class="row g-0">
      <div class="col-lg-7">
        <div class="leftProgramme p-4 p-lg-5 d-flex flex-column h-100">
          <div class="d-inline-flex align-items-center gap-2 mb-3">
            <span class="badge rounded-pill px-3 py-2 fs-6 
            {{ strtolower($course->free_certificate) == 'yes' ? 'bg-success' : 'bg-warning' }}">
              {{ strtolower($course->free_certificate) == 'yes' ? 'Free Certificate' : 'Paid Certificate' }}
            </span>
            <a href="#" class="shareBtn text-dark fs-5">
              <i class="fa-solid fa-share-nodes"></i>
            </a>
          </div>

          <h1 class="mb-3">
            <span class="text-primary-main">{{ $course->course_title }}</span>
          </h1>

          <p class="mb-3">{{ $course->course_description }}</p>

          <div class="d-flex align-items-center mb-3">
            <i class="fa-regular fa-clock text-danger me-2"></i>
            <p class="mb-0">{{ $course->course_hours }} hrs of learning</p>
          </div>

          <div class="d-flex align-items-center flex-wrap mb-4">
            <i class="fa-regular fa-address-book text-danger me-2"></i>
            @foreach($topics as $topic)
            <span class="badge rounded-pill px-3 py-2 bg-dark text-light me-2 mb-2">{{ $topic }}</span>
            @endforeach
          </div>

          <button class="applyBtn w-50 mb-4" data-bs-toggle="modal" data-bs-target="#stepmodal">
            Learn For Free
          </button>

          <div class="d-flex align-items-center mt-auto pt-2">
            <i class="fa-solid fa-phone me-2"></i>
            <div>For enquiries call: {{ $course->helpline_number }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-5 d-flex">
        <div class="rightProgramme w-100 h-100">
          <img
            src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->course_icon }}"
            alt="banner image"
            class="w-100 h-100"
            style="object-fit: cover; display: block;">
        </div>
      </div>
    </div>
  </div>
</section>
@if(!empty($coursetopics))
<div class="container mb-5" style="max-width: 90%;">
  <!-- Tabs as Card Buttons -->
  <ul class="nav nav-tabs border-0 justify-content-start rounded text-primary active mb-3" id="cardTabs" role="tablist">
    @foreach($coursetopics as $index => $topic)
    <li class="nav-item mx-1" role="presentation">
      <button class="nav-link card px-4 py-3 shadow-sm @if($index==0) active @endif"
        id="card-tab-{{ $index }}"
        data-bs-toggle="tab"
        data-bs-target="#card-{{ $index }}"
        type="button"
        role="tab"
        aria-controls="card-{{ $index }}"
        aria-selected="{{ $index==0 ? 'true':'false' }}">
        <div class="fw-bold">{{ $topic->topic }}</div>
        <small class="text-muted">{{ $topic->topic_headding }}</small>
      </button>
    </li>
    @endforeach
  </ul>

  <!-- Tab Content -->
  <div class="tab-content p-4 border rounded shadow-sm bg-white" id="cardTabsContent">
    @foreach($coursetopics as $index => $topic)
    <div class="tab-pane fade @if($index==0) show active @endif"
      id="card-{{ $index }}"
      role="tabpanel"
      aria-labelledby="card-tab-{{ $index }}">
      {!! $topic->topic_content !!}
    </div>
    @endforeach
  </div>
</div>
@endif



</div>
@if(!empty($course->keybenefit_content))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">{!! $course->keybenefit_content !!}</div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($course->who_enroll))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">{!! $course->who_enroll !!}</div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($course->why_choose_course))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">{!! $course->why_choose_course !!}</div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

<div class="certificate-section py-5 bg-light">
  <div class="container" style="max-width: 80%;">
    <div class="row align-items-center g-4">

      <!-- Left Content -->
      <div class="col-lg-6">
        <small class="text-uppercase text-muted">{{ $course->certificate_intro }}</small>
        <h2 class="my-3">
          <span class="text-danger">Earn and Share</span> Your Certificate
        </h2>

        <div class="d-flex mb-4">
          <img src="{{asset('')}}frontend/images/icons/security.png" alt="File Icon" width="70" height="70">
          <div>
            <h5 class="mb-1">Official & Verifiable</h5>
            <p class="mb-0 text-muted">Receive a signed and verifiable e-certificate from iUniversity upon successfully completing the course.</p>
          </div>
        </div>

        <div class="d-flex mb-4">
          <img src="{{asset('')}}frontend/images/icons/share.png" alt="File Icon" width="70" height="70">
          <div>
            <h5 class="mb-1">Share Your Achievement</h5>
            <p class="mb-0 text-muted">Post your certificate on LinkedIn or add it to your resume! Share it on Instagram or Twitter.</p>
          </div>
        </div>

        <div class="d-flex">
          <img src="{{asset('')}}frontend/images/icons/recuirement.png" alt="File Icon" width="70" height="70">
          <div>
            <h5 class="mb-1">Stand Out to Recruiters</h5>
            <p class="mb-0 text-muted">Use your certificate to enhance your professional credibility and stand out among your peers!</p>
          </div>
        </div>
      </div>

      <!-- Right Image -->
      <div class="col-lg-6 text-center">
        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->certificate_img }}" alt="Certificate" class="img-fluid rounded shadow w-100 h-100 object-fit-cover">
      </div>

    </div>
  </div>
</div>
@if($courseComparison->count())
<section class="comparison-section py-5">
  <div class="container" style="max-width: 80%;">
    <p class="text-muted mb-1">Free Vs. Paid Courses</p>
    <h2><span class="text-danger fw-bold">Maximize</span> Your Learning</h2>

    <table class="table table-bordered text-center mt-3">
      <thead>
        <tr>
          <th>Feature</th>
          <th>Free</th>
          <th>Paid</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courseComparison as $feature)
        <tr>
          <td class="text-start">{{ $feature->feature_name }}</td>
          <td>{!! strtolower($feature->free_course) == 'yes' ? '✅' : '❌' !!}</td>
          <td>{!! strtolower($feature->paid_course) == 'yes' ? '✅' : '❌' !!}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
@endif


<section>
  <div class="container" style="max-width: 80%;">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="heading-Theme">
          <h3><span>Frequently Asked Question </span></h3>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-3">
        <div class="nav flex-column nav-pills me-3 faqtab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">DBA Course Eligibility</button>
          <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Payment</button>
          <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Refund Policy/Financials</button>
          <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">No Cost Credit Card EMI FAQ's</button>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="tab-content faqContent" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Who is the DBA program from ESGCI for?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul>
                      <li> Experienced professionals seeking an accelerated doctoral research journey. </li>
                      <li> Mid-level managers aiming for senior leadership roles and personal development. </li>
                      <li> Enthusiastic learners pursuing leadership-focused doctoral subjects with robust academic support </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    What is the minimum eligibility for this program?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>Master's Degree (or equivalent) or Bachelors Degree with 3+ years of work experience</p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    What is the admission process?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>Following are the key steps in the application process for the <b>Doctorate Degree in Business Administration: </b></p>
                    <p>
                      <span> 1. Submit application </span>
                      Complete your application by providing work experience and educational background. The admissions committee will review your application, including all required documentation.
                      <span>2. Shortlisting update </span>
                      Our admissions committee will review and accept your application. Upon acceptance, an offer letter will be sent to you confirming your admission to the Doctorate of Business Administration Program.
                      <span>3. Block your seat </span>
                      Reserve your program spot by paying the required program deposit (INR 35,000) in full by the date specified in your offer letter to begin your doctoral journey.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
          <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
        </div>
      </div>
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
              <button> <i class="fa-solid fa-phone"></i> {{ $course->helpline_number }}</button>
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

</div>



@endsection