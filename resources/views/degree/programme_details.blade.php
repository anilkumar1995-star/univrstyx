@extends('frontend.app')
@section('title', $data->degree_title ?? 'Dashboard' )
@section('pagetitle', 'Dashboard')

@section('content')
@if(!empty($data))
<section class="breadcrumb-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              {{ !empty($data->degree_category_slug) ? ucwords(str_replace('_', ' ', $data->degree_category_slug)) : 'N/A' }} > {{ $data->degree_title ?? 'N/A' }}
            </li>
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
          <!-- <a href="#" class="shareBtn"> <i class="fa-solid fa-share-nodes"></i> </a> -->

          <h1><span class="text-primary-main">{{ $data->degree_title ?? '' }}</span></h1>

          <p>{{ $data->degree_description ?? 'No description available.' }}</p>

          <div class="d-flex justify-content-start align-items-start describeData">

            <ul class="keyHighlights">
              @foreach(json_decode($data->degree_inclusions, true) ?? [] as $item)
              <li><i class="fa-regular fa-circle-check"></i> {{ ucfirst(str_replace('_',' ', $item)) }}</li>
              @endforeach
            </ul>
          </div>

          <div class="d-lg-flex d-md-block d-block justify-content-start align-items-start">
            @if(Auth::check())
            <button class="downloadBtn mb-lg-0 mb-md-0 mb-3" data-bs-toggle="modal" data-bs-target="#">Talk To Career Expert</button>
            </button>
            @else
            <button class="downloadBtn mb-lg-0 mb-md-0 mb-3" data-bs-toggle="modal" data-bs-target="#stepmodal">Talk To Career Expert</button>
            </button>
            @endif
            @if(Auth::check())
            <button class="applyBtn" data-bs-toggle="modal" data-bs-target="#">Get Free Career Counsilling</button>
            @else
            <button class="applyBtn" data-bs-toggle="modal" data-bs-target="#stepmodal">Get Free Career Counsilling</button>
            @endif
          </div>

          <div class="d-flex enquiryData">
            <i class="fa-solid fa-phone"></i>
            <div>For enquiries call: {{ $data->helpline_number ?? '1800 210 2020' }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="rightProgramme">
          <img alt="banner image" class="w-100 h-100"
            src="https://images.incomeowl.in/incomeowl/crm/images/{{ $data->programme_icon }}">
        </div>
      </div>
    </div>
  </div>
</section>
@else
<section class="noData my-5">
  <div class="container text-center">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="text-muted">No data available for this programme</h3>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Back Home</a>
      </div>
    </div>
  </div>
</section>
@endif
<!-- @if(!empty($data->degree_overview))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail" id="Overview">
          {!! $data->degree_overview !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($data->key_highlight))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">
          {!! $data->key_highlight !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($data->career_outcome))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">
          {!! $data->career_outcome !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($data->free_copilot))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">
          {!! $data->free_copilot !!}
        </div>
        <a href="javascript:void(0);" class="toggle-btn text-primary" style="display:none;">Read More</a>
      </div>
    </div>
  </div>
</div>
@endif

@if(!empty($data->compare_degree))
<div class="container mb-5" style="max-width: 80%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="leftProgramme">
        <div class="paradetail">
          {!! $data->compare_degree !!}
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
          <h3>Need to know more?</h3>
          <h6>Get to know {{ $data->degree_title ?? "" }} advanced course in-depth by downloading the program syllabus</h6>
          <a href="#" class="btn btn-primary mt-3">Download Syllabus</a>
        </div>
      </div>
    </div>
  </div>
</section> -->

@if($datas->count() > 0)
<section class="py-5">
  <div class="container">
    <!-- Header -->
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-Theme">
          <p>{{ strtoupper(optional($datas->first())->degree_category_name ?? 'COURSES') }}</p>
          <h3>
            Explore our <span>{{ !empty($data->degree_category_slug) ? ucwords(str_replace('_', ' ', $data->degree_category_slug)) : 'Courses' }}</span> Programs
          </h3>
        </div>
      </div>
    </div>

    <!-- Course Grid -->
    <div class="row gy-4">
      @foreach($datas as $course)
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="product-card product-item h-90 position-relative">


          @if($course->bestseller == 'yes' || $course->newcourse_2 == 'Best Seller')
          <div class="badger bg-warning text-dark">Bestseller</div>
          @else
          <div class="badger bg-primary" style="top:40px;">New Course</div>
          @endif


          <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->degree_category_icon }}"
            alt="{{ $course->degree_name }}" class="w-100"
            style="height:180px;object-fit:contain;background:#fff;border-radius:10px;">

          <div class="d-flex flex-column mt-3">
            <p class="sellerName">{{ $course->university_name }}</p>
            <h6 class="">{{ ($course->degree_name) }}</h6>

            @if(!empty($course->type))
            <ul class="badge-tag mb-2">
              <li>{{ ucwords(str_replace('_', ' ', $course->type)) }}</li>
            </ul>
            @endif

            <div class="d-flex flex-column my-3">
              <div class="d-flex align-items-center info-data">
                <i class="fa-regular fa-user"></i>
                <p class="font-450">{{ number_format($course->course_learners / 1000, 1) }}k+ learners</p>
              </div>
              <div class="d-flex align-items-center info-data">
                <i class="fa-regular fa-clock"></i>
                <p class="font-450">{{ $course->course_hours ?? 0 }} hours</p>
              </div>
            </div>

            <div class="d-flex w-100 footer-btn mt-auto">
              <a href="{{ url('programme/'.$course->id) }}" class="text-black w-100 me-2">
                <button>View Program</button>
              </a>
              <button class="enroll-btn">
                Syllabus <i class="fa-solid fa-download ms-2"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@else
<section class="py-5">
  <div class="container text-center">
    <h5 class="text-muted">No courses found in this category.</h5>
  </div>
</section>
@endif

<nav class="navbar bg-white border-bottom sticky-top">
  <div class="container-fluid px-5 py-2 d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-semibold"> Explore our Other <span>{{ ucwords(str_replace('_',' ',optional($alldata->first())->degree_category_name ?? 'Courses')) }}</span> Programs</h5>
    <div class="text-muted">Sort by: <strong>Relevance</strong></div>
  </div>
</nav>

<div class="container-fluid my-4 px-5">
  <div class="row g-4">


    <div class="col-lg-3">
      <div class="sidebar">

        <div class="filter-group mb-4">
          <h6>Degree Category</h6>
          @foreach ($degreeCategories as $category)
          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              name="degree_category[]"
              value="{{ $category->id }}"
              id="degree_category_{{ $category->id }}">
            <label class="form-check-label" for="degree_category_{{ $category->id }}">
              {{ $category->degree_category }}
            </label>
          </div>
          @endforeach
        </div>


        <!-- <div class="filter-group mb-4">
          <h6>University</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">IIIT Bangalore</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Microsoft</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Liverpool John Moores University</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">O.P. Jindal Global University</label></div>
        </div> -->

        <div class="filter-group mb-4">
          <h6>Program Type</h6>
          @foreach ($programTypes as $type)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="program_type[]" value="{{ $type }}">
            <label class="form-check-label">
              {{ ucfirst(str_replace('_', ' ', $type)) }}
            </label>
          </div>
          @endforeach
        </div>


        <div class="filter-group">
          <h6>Duration</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" name="duration[]" value="1-3"><label class="form-check-label">1 to 3 months</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" name="duration[]" value="3-6"><label class="form-check-label">3 to 6 months</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" name="duration[]" value="6-12"><label class="form-check-label">6 to 12 months</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" name="duration[]" value="12-18"><label class="form-check-label">12 to 18 months</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" name="duration[]" value="18+"><label class="form-check-label">More than 18 months</label></div>
        </div>
      </div>
    </div>


    <div class="col-lg-9">
      <div class="d-flex flex-column gap-3">
        @foreach ($courses as $course)
        <div class="course-card d-flex flex-wrap justify-content-between align-items-center">
          <div class="d-flex align-items-center gap-3">
            <div class="course-logo">
              <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->university_icon_2 }}"
                class="watermark img-fluid rounded" alt="university_logo">
            </div>
            <div>
              <p class="course-info mb-1">{{ $course->university_name }}</p>
              <p class="course-title mb-1">{{ $course->degree_name }}</p>
              <p class="course-info mb-1">{{ ucwords(str_replace('_', ' ', $course->type)) }} • {{ $course->degree_duration }} Months</p>
              <span class="tag bg-warning bg-opacity-25">{{ $course->category->degree_category ?? 'N/A' }}</span>
            </div>
          </div>
          <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ url('programme/'.$course->id) }}">
              <button class="btn btn-outline-dark btn-sm">View Program</button>
            </a>
            <button class="btn btn-danger btn-sm">Syllabus</button>
          </div>
        </div>
        @endforeach
      </div>

      {{-- Laravel pagination links --}}
       <nav class="mt-4 pagination-wrapper">
        {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
      </nav>
    </div>

  </div>
</div>







{{-- OTHER COURSES SECTION 
@if($alldata->count() > 0)
<section class="py-5">
  <div class="container">
    <!-- Header -->
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-Theme">
          <p>{{ strtoupper(optional($alldata->first())->degree_category_name ?? 'COURSES') }}</p>
<h3>
  Explore our Other <span>{{ ucwords(str_replace('_',' ',optional($alldata->first())->degree_category_name ?? 'Courses')) }}</span> Programs
</h3>
</div>
</div>
</div>

<!-- Course Grid -->
<div class="row gy-4">
  @foreach($alldata as $course)
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
    <div class="product-card product-item h-90 position-relative">

      @if($course->bestseller == 'yes' || $course->newcourse_2 == 'Best Seller')
      <div class="badger bg-primary ">Bestseller</div>
      @else
      <div class="badger bg-warning ">New Course</div>
      @endif


      <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->degree_category_icon }}"
        alt="{{ $course->degree_name }}" class="w-100"
        style="height:180px;object-fit:contain;background:#fff;border-radius:10px;">

      <div class="d-flex flex-column mt-3">
        <p class="sellerName">{{ $course->university_name }}</p>
        <h6 class="">{{ ($course->degree_name) }}</h6>

        @if(!empty($course->type))
        <ul class="badge-tag mb-2">
          <li>{{ ucwords(str_replace('_', ' ', $course->type)) }}</li>
        </ul>
        @endif

        <div class="d-flex flex-column my-3">
          <div class="d-flex align-items-center info-data">
            <i class="fa-regular fa-user"></i>
            <p class="font-450">{{ number_format($course->course_learners / 1000, 1) }}k+ learners</p>
          </div>
          <div class="d-flex align-items-center info-data">
            <i class="fa-regular fa-clock"></i>
            <p class="font-450">{{ $course->course_hours ?? 0 }} hours</p>
          </div>
        </div>

        <div class="d-flex w-100 footer-btn mt-auto">
          <a href="{{ url('programme/'.$course->id) }}" class="text-black w-100 me-2">
            <button>View Program</button>
          </a>
          <button class="enroll-btn">
            Syllabus <i class="fa-solid fa-download ms-2"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
</div>
</section>
@else
<section class="py-5">
  <div class="container text-center">
    <h5 class="text-muted">No courses found in this category.</h5>
  </div>
</section>
@endif --}}

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
              <button> <i class="fa-solid fa-phone"></i> {{ $data->helpline_number ?? '1800 210 2020' }}</button>
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

@push('script')
<script>
  $(document).ready(function() {
   function fetchCourses(page = 1) {
      let data = {
        degree_category: [],
        university: [],
        program_type: [],
        duration: [],
        page: page
      };

      $('input[name="degree_category[]"]:checked').each(function() {
        data.degree_category.push($(this).val());
      });
      $('input[name="university[]"]:checked').each(function() {
        data.university.push($(this).val());
      });
      $('input[name="program_type[]"]:checked').each(function() {
        data.program_type.push($(this).val());
      });
      $('input[name="duration[]"]:checked').each(function() {
        data.duration.push($(this).val());
      });

      $.ajax({
        url: "{{ route('programmes.filter') }}?page=" + page,
        method: "POST",
        data: data,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        beforeSend: function() {
          $('.d-flex.flex-column.gap-3').html('<p>Loading...</p>');
        },
        success: function(response) {
          let temp = $('<div>').html(response);

          $('.d-flex.flex-column.gap-3').html(temp.find('.course-results').html());

          $('.pagination-wrapper').html(temp.find('nav').html());
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    }

    $('input[type="checkbox"]').on('change', function() {
      fetchCourses();
    });

    $(document).on('click', '.pagination a', function(e) {
      e.preventDefault();
      let page = $(this).attr('href').split('page=')[1];
      fetchCourses(page);
    });

  });
</script>
@endpush