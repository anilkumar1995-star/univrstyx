@extends('frontend.app')
@section('title', $programme->degree_name ?? 'Dashboard' )
@section('pagetitle', 'Dashboard')

@section('content')
<section class="breadcrumb-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/ ') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $degree->degree_category ?? 'N/A'  }}>{{ $programme->degree_name ?? 'N/A'}}</li>
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
        <div class="leftProgramme">
          <div class="d-flex align-items-center">
            @if(!empty($programme->newcourse_1))
            <span class="badge rounded-pill px-3 py-2 fs-6 bg-primary bg-opacity-25 text-black me-2">
              {{ $programme->newcourse_1 }}
            </span>
            @endif
            @if(!empty($programme->newcourse_2))
            <span class="badge rounded-pill px-3 py-2 fs-6 bg-warning bg-opacity-25 text-black me-2">
              {{ $programme->newcourse_2 }}
            </span>
            @endif

            <a href="#" class="shareBtn d-flex align-items-center">
              <i class="fa-solid fa-share-nodes fs-5"></i>
            </a>
          </div>


          <h1 class="">
            <span class="text-primary-main">{{ $programme->degree_name ?? '' }}</span>
          </h1>

          <p>
            {{ $programme->degree_description ?? 'No description available.' }}
          </p>
          <div class="d-flex justify-content-start align-items-start describeData">
            <div>
              <p>Type <span>{{ !empty($programme->type) ? ucwords(str_replace('_', ' ', $programme->type)) : 'N/A' }}</span></p>
            </div>
            <div>
              <p>Deadline Date <span>
                  {{ $programme->deadline_date ? \Carbon\Carbon::parse($programme->deadline_date)->format('M d, Y') : 'TBA' }}
                </span></p>
            </div>
            <div>
              <p>Duration <span>{{ $programme->degree_duration ?? 'N/A' }} Months</span></p>
            </div>
          </div>

          <div class="d-lg-flex d-md-block d-block justify-content-start align-items-start">
            <button class="downloadBtn mb-lg-0 mb-md-0 mb-3" data-bs-toggle="modal" data-bs-target="#">
              Download Brochure
            </button>
            @if(Auth::check())
            @if($hasPendingApplication)
            <button class="applyBtn btn btn-warning"
              onclick="window.location.href='{{ route('checkout', $programme->id) }}'">
              Continue to Payment
            </button>
            @else
            <button class="applyBtn btn btn-primary"
              onclick="window.location.href='{{ route('programme.apply', $programme->id) }}'">
              Start Application
            </button>
            @endif
            @else
            <button class="applyBtn btn btn-primary" data-bs-toggle="modal" data-bs-target="#stepmodal">
              Apply Now
            </button>
            @endif


          </div>

          <div class="d-flex enquiryData">
            <i class="fa-solid fa-phone"></i>
            <div>For enquiries call: {{ $programme->helpline_number ?? '1800 210 2020' }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="rightProgramme">
          <img alt="banner image" class="w-100 h-100"
            src="https://images.incomeowl.in/incomeowl/crm/images/{{ $programme->university_icon_2 }}">
        </div>
      </div>
    </div>
  </div>
</section>

@if(!empty($programme->degree_overview))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail overview-text" id="Overview">
          {!! $programme->degree_overview !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($programme->key_highlight))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail highlight-text">
          {!! $programme->key_highlight !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($programme->career_outcome))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail career-text">
          {!! $programme->career_outcome !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($programme->free_copilot))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail copilot-text">
          {!! $programme->free_copilot !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($programme->compare_degree))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail compare-text">
          {!! $programme->compare_degree !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif




<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="needMore">
          <h3> Need to know more? </h3>
          <h6> Get to know {{ $degree->degree_category ?? "" }} advanced course in-depth by downloading the program syllabus </h6>
          <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="#" class="btn btn-primary">Download Syllabus</a>
            <a href="tel:+919876543210" class="btn btn-primary">Talk To Our Career Expert</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="heading-Theme">
          <p class="text-capitalize">{{ $programme->degree_name ?? '' }}, {{ $programme->university_name ?? '' }}</p>
          <h3>
            <span>Transform Your Leadership Career </span>
            with This {{ $programme->degree_name ?? '' }} from {{ $programme->university_name ?? '' }}
          </h3>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      @php
      $careerItems = json_decode($programme->transform_career, true) ?? [];
      @endphp

      @if(!empty($careerItems))
      @foreach($careerItems as $item)
      <div class="col-lg-4 col-md-4 col-6">
        <div class="TransformGrid">
          <div class="icon">
            <i class="fa-solid fa-award"></i>
          </div>
          <h4>{{ ucfirst(str_replace('_',' ', $item)) }}</h4>
        </div>
      </div>
      @endforeach
      @else
      <div class="col-12 text-center">
        <p class="text-muted">🚀 No transformation points available at the moment.</p>
      </div>
      @endif
    </div>
  </div>
</section>

<!-- 
  <section class="empowerExpertise pb-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme text-center">
            <h3> From <span>Senior Leader to Respected Doctor </span> </h3>
            <h6>Empower Your Expertise. Earn the Coveted Dr.’s Title² That Elevates Your Authority and Influence.</h6>
          </div>
        </div>
      </div>


      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="expertiseStudent beforeStudent">
          <p> Before </p>
          <h4> Neha Patel</h4>
        </div>
        <div class="beforeStudent d-flex align-items-center">
          <div class="">
            <img src="images/programme/doctorate/arrow-with-circle.svg">
          </div>
          <div class="centerProfile">
            <img src="images/i-university-logo-01.png" class="profileLogo">
            <img src="images/programme/doctorate/ESGCINehaPatel.webp">
            <p class="otherBottom"></p>
          </div>
          <div class="">
            <img src="images/programme/doctorate/arrow-right.svg">
          </div>
        </div>
        <div class="expertiseStudent afterStudent">
          <p> After </p>
          <h4> Dr. Neha Patel</h4>
        </div>
      </div>
      <div class="text-center mt-5">
        <a href="#" class="btn btn-primary mt-3">Talk to a Program Expert </a>
      </div>

    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">DBA Program-The Credential That Combines Expertise, Research, and Leadership </p>
            <h3>Why should you choose a <span>DBA over a PhD? </span> </h3>
          </div>
        </div>
      </div>
      <div class="row g-0 mt-4 align-items-end">
        <div class="col-lg-4">
          <div class="whyChooseTable">
            <h4> </h4>
            <ul class="firstColChoose">
              <li><i class="fa-regular fa-pen-to-square"></i> Program Focus </li>
              <li><i class="fa-solid fa-chart-line"></i> Career Enhancement </li>
              <li><i class="fa-regular fa-clock"></i> Time Commitment </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="whyChooseTable centerColumn">
            <h4> DBA </h4>
            <ul>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Scholar-practitioner approach toward solving real-world business challenges </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Ideal for career progression in business management, executive leadership, or consulting </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Finish in as little as 3 years¹ </p>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="whyChooseTable">
            <h4><span>PhD </span></h4>
            <ul>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Ideal for those pursuing an academic or high-level research career </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Best suited for individuals seeking to contribute to academic theory and research </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Longer and More intensive </p>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="d-lg-flex d-md-block d-block justify-content-start align-items-start mt-4 w-50 m-auto ">
        <button class="downloadBtn mb-lg-0 mb-md-0 mb-3" data-bs-toggle="modal" data-bs-target="#signup">Download Brochure</button>
        <button class="applyBtn" data-bs-toggle="modal" data-bs-target="#signup">Talk to Program Expert</button>
      </div>


    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="heading-Theme">
            <h3 class="mb-4"><span>ESGCI,</span> Established 1986 </h3>
            <p class="paradetail">ESGCI International School of Management, Paris, is a renowned institution specializing in management
              studies with a strong international focus. Recognized by the French Ministry of Higher Education, ESGCI
              has over 20% international students from 65 nationalities. It holds QUALIOPI certification for
              high-quality training and is a member of ACBSP. As part of Galileo Global Education, ESGCI benefits from a
              vast network across 91 campuses in 13 countries.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="establishVideo">
            <img src="images/programme/doctorate/ESGIVideo.webp" class="img-fluid">
            <div class="overlay">
              <a href="#"><img src="images/programme/doctorate/play-button.svg"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize"> Quality Assured </p>
            <h3>Internationally Recognised and Accredited </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="Quality-theme theme-carusel owl-carousel">
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Qualiopi.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">QUALIOPI</h5>
                <p> Holds QUALIOPI certification: A quality mark for training organizations registered with the National
                  Institute of Industrial Property (INPI). </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/AccreditationsMinistryHigher.jpg" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">French Ministry of Higher Education</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Accreditations.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">ACBSP</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Accreditationsiacb.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">IACBE</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme w-75">
            <p class="text-capitalize"> Doctorate Degree in Business Administration </p>
            <h3>Earn the Prestigious DBA Degree from ESGCI, Paris </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="listingEarn">
            <ul>
              <li>
                <div class="icon"> <i class="fa-solid fa-award"></i> </div>
                <div class="captionList">
                  <h4> Same Doctorate as On-Campus </h4>
                  <p> Receive the same world-class education and global recognition without needing to relocate.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-certificate"></i> </div>
                <div class="captionList">
                  <h4> Nationally Accredited European Degree </h4>
                  <p> ESGCI holds QUALIOPI certification and awards RNCP qualifications, levels 6 (Bac+3) and 7 (Bac+5),
                    recognized by the State</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-user"></i> </div>
                <div class="captionList">
                  <h4> Lifetime Alumni Status </h4>
                  <p> Join a global network of professionals, many in key leadership roles worldwide.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>
        <div class="col-lg-5">
          <img src="images/programme/doctorate/490x360.webp" class="img-fluid">
        </div>
      </div>
    </div>
  </section> -->

<!-- 
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme w-75">
            <p class="text-capitalize"> Connect. Collaborate. Grow. </p>
            <h3>Leaders from these Top Companies Have Enrolled </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="listingEarn">
            <ul>
              <li>
                <div class="icon"> <i class="fa-solid fa-award"></i> </div>
                <div class="captionList">
                  <h4> Seasoned Professionals </h4>
                  <p> Collaborate with seasoned industry leaders with over 12 years of business experience.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-star"></i> </div>
                <div class="captionList">
                  <h4> Executive-Level Participants</h4>
                  <p> Over 65% of our students are C-suite/senior executives, offering unparalleled networking and
                    mentorship opportunities.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-user"></i> </div>
                <div class="captionList">
                  <h4> Cross-Industry Collaboration</h4>
                  <p> Expand your network with leaders from 10+ industries. </p>
                </div>
              </li>
            </ul>
          </div>

        </div>
        <div class="col-lg-5">
          <img src="images/programme/doctorate/ESG20.webp" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">Leaders driving change </p>
            <h3>A Snapshot of <span>Our Learners in Leading Companies </span> </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="programuser">
            <ul>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 5 </h5>
                  <p> Learner Profiles </p>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="courses-tab mt-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="learner-tab" data-bs-toggle="tab" data-bs-target="#learner"
                  type="button" role="tab" aria-controls="learner" aria-selected="true">Learner Profiles
                </button>
              </li>
            </ul>
          </div>
          <div class="course-content">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="learner" role="tabpanel" aria-labelledby="PopularCourse-tab">
                <div class="LearnerSlider theme-carusel owl-carousel">
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>
                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
  </section>

  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">ESGCI International School of Management,Paris </p>
            <h3>Who will you <span>learn from? </span> </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="programuser">
            <ul>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 3 </h5>
                  <p> Instructors </p>
                </div>
              </li>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 4 </h5>
                  <p> Thesis Supervisors </p>
                </div>
              </li>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 3 </h5>
                  <p> Leadership Experts </p>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="courses-tab mt-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor"
                  type="button" role="tab" aria-controls="instructor" aria-selected="true">Instructors
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="thesis-tab" data-bs-toggle="tab" data-bs-target="#thesis" type="button"
                  role="tab" aria-controls="thesis" aria-selected="true">Thesis Supervisors
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="leadershipexpert-tab" data-bs-toggle="tab"
                  data-bs-target="#leadershipexpert" type="button" role="tab" aria-controls="leadershipexpert"
                  aria-selected="true">Leadership Experts
                </button>
              </li>
            </ul>
          </div>
          <div class="course-content">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                <div class="LearnerSlider theme-carusel owl-carousel">
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>
                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="thesis" role="tabpanel" aria-labelledby="thesis-tab">
                ff
              </div>
              <div class="tab-pane fade" id="leadershipexpert" role="tabpanel" aria-labelledby="leadershipexpert-tab">
                ffg
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">DBA Course Syllabus, ESGCI Paris </p>
            <h3>Detailed Curriculum </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="nav nav-tabs curriculumtab theme-carusel owl-carousel" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">
                <span> Course 1</span>
                Introduction to Doctoral Research</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">
                <span> Course 2</span>
                Formulating a Research Topic</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 3</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 4</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 5</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 6</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 7</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 8</span>
                Data Collection (Optional) </button>
            </li>
          </ul>
          <div class="tab-content curriculumContent" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <h6> Introduction to Doctoral Research </h6>
              <p>Develop research skills to conduct and present doctoral-level research effectively. </p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Foundational Concepts in Academic Research </li>
                <li><i class="fa-regular fa-circle-check"></i> The Nature and Types of Academic Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Key Terminologies in Doctoral Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Features of Business and Management Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Steps in the Doctoral Research Process </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <h6> Formulating a Research Topic and Reviewing Literature </h6>
              <p> Articulate a well-defined research topic, identify relevant sources, evaluate their credibility, and
                conduct a comprehensive literature review.</p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Formulating a Research Question </li>
                <li><i class="fa-regular fa-circle-check"></i> Writing a Research Proposal </li>
                <li><i class="fa-regular fa-circle-check"></i> Developing a Strong Research Design </li>
                <li><i class="fa-regular fa-circle-check"></i> Literature Review: relevance, types, approaches, and
                  methods </li>
                <li><i class="fa-regular fa-circle-check"></i> Drafting the Literature Review </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <h6> Introduction to Doctoral Research </h6>
              <p>Develop research skills to conduct and present doctoral-level research effectively. </p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Fundamentals of Quantitative Data Collection </li>
                <li><i class="fa-regular fa-circle-check"></i> Secondary Data Sources </li>
                <li><i class="fa-regular fa-circle-check"></i> Collecting and Evaluating Primary Data </li>
                <li><i class="fa-regular fa-circle-check"></i> Qualitative Data Collection Methods </li>
                <li><i class="fa-regular fa-circle-check"></i> Data Validity and Reliability, Quality of Data </li>
              </ul>
            </div>
          </div>
          <div class="text-center mt-5">
            <a href="#" class="btn btn-primary">Download Syllabus <i class="fa-solid fa-download"></i> </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme text-center">
            <p class="text-capitalize">DBA Degree Learning Journey </p>
            <h3>Your Transformative<br> Journey to the Doctorate <br> Degree</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="timeline">
            <ul>
              <li>
                <div class="content">
                  <h3>Start Your DBA Journey</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Begin your transformative leadership path.</li>
                  </ul>
                </div>

              </li>
              <li>
                <div class="content">
                  <h3>Foundation-Focused Coursework</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Introduction to Doctoral Research </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Formulating Research Topic and Literature Review
                    </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Quantitative and Qualitative Methods </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Access and Collect Data </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Specialization and CliftonStrengths Assessment</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Business Strategy and Innovation in the Digital Age
                    </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Leadership Skills: Leading People and Change </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Attempt CliftonStrengths, Leverage Strengths for
                      Leadership </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Work on Your Dissertation</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Select a Real-World Business Problem </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Conduct a Literature Review, Identify Gaps </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Develop Research Design and Analyze Data </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Write, Revise, and Refine Dissertation </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Defend the Dissertation and Collect the Degree</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Present and Defend Your Dissertation </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Attain Your DBA and Impact Globally </li>
                  </ul>
                </div>

              </li>

              <div style="clear:both;"></div>
            </ul>
          </div>
          <div class="text-center mt-3">
            <a href="#" class="btn btn-primary">Talk to a Program Expert </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="heading-Theme ">
            <p class="text-capitalize">Enhance Your DBA Program </p>
            <h3 class="mb-4">Paris Leadership Immersion </h3>
            <p class="paradetail">Immerse yourself in the business hub of Europe by networking with top faculty, industry leaders, and
              peers. Engage in intensive workshops, seminars, and collaborative projects to enhance your DBA journey.
              Experience the rich culture of Paris, exploring its iconic landmarks and diverse neighborhoods. Visit key
              industrial sites to gain real-world insights. Enrich your learning with the optional on-campus immersion,
              offering a truly transformative experience.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="establishVideo">
            <img src="images/programme/doctorate/ESGCI2020.webp" class="img-fluid">
            <div class="overlay">
              <a href="#"><img src="images/programme/doctorate/play-button.svg"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section> -->

<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-Theme">
          <p class="text-capitalize">{{ $programme->university_name }} {{ $programme->degree_name }} Course Fees</p>
          <h3>Invest In <span>Your Success</span></h3>
        </div>
      </div>
    </div>

    <div class="row align-items-center mt-4">
      <div class="col-lg-4 offset-lg-1">
        <div class="card courseFeeimmension">
          <div class="card-body">
            <span class="badge bg-light text-dark border rounded-pill d-inline-block px-3">
              {{ $programme->degree_duration }} Months
            </span>

            <div class="heading-Course my-3">
              <h3>
                Starting at
                <span class="d-block">INR {{ number_format($programme->course_starting_at ?? 0) }}/month</span>
              </h3>
              <p>
                Totally <b>INR {{ number_format($programme->course_total_amount) }}</b>
                <span class="text-muted"> No taxes applicable </span>
              </p>
            </div>

            <p class="text-muted mb-1"><b>Inclusions</b></p>
            <ul class="keyHighlights">
              @foreach(json_decode($programme->course_inclusions, true) ?? [] as $item)
              <li><i class="fa-regular fa-circle-check"></i> {{ ucfirst(str_replace('_',' ', $item)) }}</li>
              @endforeach
            </ul>

            <div class="d-flex flex-column justify-content-center text-center mt-4">
              @if(Auth::check())
              @if($hasPendingApplication)
              <button class="applyBtn btn btn-warning"
                onclick="window.location.href='{{ route('checkout', $programme->id) }}'">
                Continue to Payment
              </button>
              @else
              <button class="applyBtn btn btn-primary"
                onclick="window.location.href='{{ route('programme.apply', $programme->id) }}'">
                Start Application
              </button>
              @endif
              @else
              <button class="applyBtn btn btn-primary" data-bs-toggle="modal" data-bs-target="#stepmodal">
                Apply Now
              </button>
              @endif
              <a href="#" class="fs-6 mt-2 text-decoration-underline" data-bs-toggle="modal" data-bs-target="#loanModal">
                View Plan Details
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5 offset-lg-1">
        <img src="{{ asset('frontend/images/programme/doctorate/person_laptop.svg') }}" class="img-fluid">
      </div>
    </div>
  </div>
</section>

<!-- Loan Details Modal -->
<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 rounded-4 shadow-md">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="loanModalLabel">EMI Options / Plans</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 border-end">
            <ul class="nav flex-column nav-pills" id="emiTypeTabs" role="tablist">
              <li class="nav-item mb-2">
                <button class="nav-link active text-start" id="nocost-tab" data-bs-toggle="pill"
                  data-bs-target="#nocost" type="button" role="tab">
                  No Cost EMI
                </button>
              </li>
              <li class="nav-item mb-2">
                <button class="nav-link text-start" id="standard-tab" data-bs-toggle="pill"
                  data-bs-target="#standard" type="button" role="tab">
                  Standard EMI
                </button>
              </li>
            </ul>
          </div>

          <div class="col-md-8">
            <div class="tab-content" id="emiTypeContent">

              <div class="tab-pane fade show active" id="nocost" role="tabpanel" aria-labelledby="nocost-tab">
                <h6 class="fw-bold mb-3">Third Party Credit Facilitators</h6>

                <div class="accordion" id="noCostAccordion">
                  <div class="accordion-item border-0 mb-2 shadow-sm rounded-3">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#fibePanel">
                        Fibe
                      </button>
                    </h2>
                    <div id="fibePanel" class="accordion-collapse collapse" data-bs-parent="#noCostAccordion">
                      <div class="accordion-body">
                        <table class="table table-bordered align-middle">
                          <thead class="table-light">
                            <tr>
                              <th>Tenure (Months)</th>
                              <th>EMI</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>3</td>
                              <td>INR 1,53,334</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>INR 76,667</td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>INR 51,112</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item border-0 mb-2 shadow-sm rounded-3">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#propelldPanel">
                        Propelld
                      </button>
                    </h2>
                    <div id="propelldPanel" class="accordion-collapse collapse" data-bs-parent="#noCostAccordion">
                      <div class="accordion-body">
                        <table class="table table-bordered align-middle">
                          <thead class="table-light">
                            <tr>
                              <th>Tenure (Months)</th>
                              <th>EMI</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>3</td>
                              <td>INR 1,50,000</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>INR 75,000</td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>INR 50,000</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item border-0 mb-2 shadow-sm rounded-3">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#grayquestPanel">
                        GrayQuest
                      </button>
                    </h2>
                    <div id="grayquestPanel" class="accordion-collapse collapse show" data-bs-parent="#noCostAccordion">
                      <div class="accordion-body">
                        <table class="table table-bordered align-middle">
                          <thead class="table-light">
                            <tr>
                              <th>Tenure (Months)</th>
                              <th>EMI</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>3</td>
                              <td>INR 1,53,334</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>INR 76,667</td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>INR 51,112</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="tab-pane fade" id="standard" role="tabpanel" aria-labelledby="standard-tab">
                <h6 class="fw-bold mb-3">Standard EMI Options</h6>
                <table class="table table-bordered align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Tenure (Months)</th>
                      <th>Interest Rate</th>
                      <th>Approx EMI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>6</td>
                      <td>10%</td>
                      <td>INR 78,000</td>
                    </tr>
                    <tr>
                      <td>12</td>
                      <td>11%</td>
                      <td>INR 40,500</td>
                    </tr>
                    <tr>
                      <td>18</td>
                      <td>12%</td>
                      <td>INR 28,200</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 small text-muted">
          <ul class="mb-0">
            <li>Amount of INR 25,000 to reserve your seat before loan processing.</li>
            <li>Credit facility is provided by a third-party credit provider outside our purview.</li>
            <li>Processing fees may apply based on the selected payment method.</li>
            <li>Standard EMI interest rates are based on reducing balance rates per annum.</li>
          </ul>
        </div>

        <div class="text-center mt-4">
          <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" data-bs-toggle="modal"
            data-bs-target="#stepmodal">
            Apply for Loan
          </button>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- <section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="heading-Theme">
          <h3><span>FAQs </span>on {{ $programme->degree_name ?? '' }} </h3>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-3">
        <div class="nav flex-column nav-pills me-3 faqtab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ $programme->degree_name ?? '' }} Course Eligibility</button>
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
                    Who is the {{ $programme->degree_name ?? '' }} program from {{ $programme->university_name ?? '' }} for?
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
</section> -->
@php
$faqs = json_decode($programme->faqs, true);
@endphp

@if(!empty($faqs))
<section class="py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="heading-Theme mb-4">
          <h3><span>FAQs</span> on {{ $programme->degree_name ?? '' }}</h3>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-3">
        <div class="nav flex-column nav-pills me-3 faqtab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          @foreach($faqs as $catIndex => $category)
          <button
            class="nav-link {{ $loop->first ? 'active' : '' }}"
            id="v-pills-{{ $catIndex }}-tab"
            data-bs-toggle="pill"
            data-bs-target="#v-pills-{{ $catIndex }}"
            type="button"
            role="tab"
            aria-controls="v-pills-{{ $catIndex }}"
            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ $category['category_name'] ?? 'No Category' }}
          </button>
          @endforeach
        </div>
      </div>

      <div class="col-lg-7">
        <div class="tab-content faqContent" id="v-pills-tabContent">
          @foreach($faqs as $catIndex => $category)
          <div
            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
            id="v-pills-{{ $catIndex }}"
            role="tabpanel"
            aria-labelledby="v-pills-{{ $catIndex }}-tab">

            <div class="accordion" id="accordion-{{ $catIndex }}">
              @foreach($category['questions'] as $qIndex => $question)
              @php
              $collapseId = 'collapse'.$catIndex.$qIndex;
              $headingId = 'heading'.$catIndex.$qIndex;
              @endphp

              <div class="accordion-item">
                <h2 class="accordion-header" id="{{ $headingId }}">
                  <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ $collapseId }}"
                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="{{ $collapseId }}">
                    {{ $question ?? 'Untitled Question' }}
                  </button>
                </h2>
                <div id="{{ $collapseId }}"
                  class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                  aria-labelledby="{{ $headingId }}"
                  data-bs-parent="#accordion-{{ $catIndex }}">
                  <div class="accordion-body">
                    {!! $category['answers'][$qIndex] ?? '' !!}
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif






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