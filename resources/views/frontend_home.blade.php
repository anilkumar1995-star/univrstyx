@extends('frontend.app')
@section('title', 'iUniversity ® India’s Leading Online Learning Platform')
@section('pagetitle', 'Dashboard')

@section('content')
<style>
    .brandEmployee .owl-stage {
        display: flex;
        animation: scrollLoop 30s linear infinite;
    }

    @keyframes scrollLoop {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .brandEmployee .owl-stage {
        will-change: transform;
    }
</style>

<div class="mainBody">
    <section class="py-0">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="slider-caption">

                        <h5 class="mb-1">{{ $slider->title ?? "Master tomorrow's skills today." }}</h5>
                        <p class="mb-5">{{ $slider->subtitle ?? "Excel with India’s top upskilling platform." }}</p>

                        <div class="search-slider position-relative">
                            <input type="search" class="search-input form-control" placeholder="Tell Us what you're looking to learn.">
                            <button type="button" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        <div class="slider-rating mt-3">
                            <p><b>Or Select your Goals 🎯</b></p>
                            <ul>
                                @forelse($goals as $goal)
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#promotion_{{ $goal->id }}">
                                        {{ $goal->goals_name }}
                                    </a>
                                </li>

                                <!-- Modal for each goal -->
                                <div class="modal fade promotionBox" id="promotion_{{ $goal->id }}" tabindex="-1"
                                    aria-labelledby="promotionLabel_{{ $goal->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="promotionLabel_{{ $goal->id }}">
                                                    Select your Area of interest for "{{ $goal->goals_name }}"
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="AreaInterest">
                                                    <div class="d-flex flex-wrap justify-content-center gap-3">
                                                        @foreach($degreeCategories as $category)
                                                        <div class="text-center p-2 rounded-3 shadow-sm"
                                                            style="width: 110px; transition: all 0.3s;">
                                                            <a href="{{ url('programmes/'.$category->id) }}"
                                                                class="d-flex flex-column align-items-center text-decoration-none text-dark">
                                                                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $category->degree_category_icon }}"
                                                                    alt="{{ $category->degree_category }}"
                                                                    class="img-fluid mb-2"
                                                                    style="width: 40px; height: 40px; object-fit: contain;">
                                                                <span class="fw-semibold small text-center">{{ $category->degree_category }}</span>
                                                            </a>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <li><span class="text-muted">No goals found</span></li>
                                @endforelse
                            </ul>

                            @php
                            $text = $slider->join_community ?? "Join the community of 4325346366 learners.";

                            if (preg_match('/\d+/', $text)) {
                            // Number ko <span> me wrap karo
                                $text = preg_replace('/(\d+)/', '<span>$1</span>', $text);
                                }
                                @endphp

                                <p class="mt-4">{!! $text !!}</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="tel:{{ $disclaimer->helpline ?? '1800243876' }}" class="btn btn-primary">
                                <i class="fa-solid fa-phone"></i> Talk To Our Career Expert
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="slider-mentor">
                        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $slider->back_img }}" class="watermark">
                        <div id="carouselExampleDark" class="carousel carousel-dark slide slider-front"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if(!empty($slider->front_img))
                                @php
                                $frontImages = json_decode($slider->front_img, true);
                                @endphp

                                @if(is_array($frontImages) && count($frontImages))
                                @foreach($frontImages as $key => $img)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="5000">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $img }}" class="d-block w-100" alt="Slide {{ $key + 1 }}">
                                </div>
                                @endforeach
                                @endif
                                @endif

                                <!-- <div class="carousel-item active" data-bs-interval="10000">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $slider->front_img }}" class="d-block w-100" alt="...">
                                </div> -->
                                <!-- <div class="carousel-item" data-bs-interval="2000">
                                    <img src="{{ asset('') }}frontend/images/slider/2.webp" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('') }}frontend/images/slider/3.webp" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('') }}frontend/images/slider/4.webp" class="d-block w-100" alt="...">
                                </div> -->
                            </div>
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
                    <div class="brandsList">
                        <h5>{{ $homepage->partner_heading_1 ?? 'Trusted by 100+ Academic & Employment Partners' }}</h5>

                        <ul class="brandEmployee owl-carousel">
                            @foreach($brands as $brand)
                            <li>
                                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $brand->company_image }}" style="height:24px;width:110px;margin:25px;" alt="{{ $brand->name }}">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($trending->count() > 0)
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p> {{ $homepage->trending_title ?? 'TRENDING COURSES' }}</p>
                        @php
                        $default = 'Choose from our best-selling courses';
                        $text = $homepage->trending_subtitle ?? $default;

                        $words = explode(' ', trim($text));

                        if (count($words) > 2) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = implode(' ', $words);
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="trending-course theme-carusel owl-carousel">
                        @foreach($trending as $course)
                        <div class="product-card product-item">

                            <div class="badger">Bestseller</div>

                            <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->degree_category_icon }}"
                                alt="{{ $course->degree_name }}" />

                            <div class="d-flex flex-column mt-3">
                                <p class="sellerName">{{ $course->university_name }}</p>
                                <h3>{{ $course->degree_name }}</h3>

                                @if(!empty($course->type))
                                <ul class="badge-tag">
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
                                        <p class="font-450">{{ $course->course_hours }} hours</p>
                                    </div>
                                </div>

                                <div class="d-flex w-100 footer-btn">
                                    <a href="{{ url('programme/'.$course->id) }}"
                                        class="text-black w-100 me-2">
                                        <button>View Program</button>
                                    </a>
                                    <button class="enroll-btn">
                                        Syllabus <i class="fa-solid fa-download ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(!empty($freeCourse))
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p>{{ $homepage->free_courses_title ?? 'Free Courses' }}</p>
                        @php
                        $default = 'Get started with a free course';
                        $text = $homepage->free_courses_subtitle ?? $default;

                        $words = explode(' ', trim($text));

                        if (count($words) > 2) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = implode(' ', $words);
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="courses-tab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($coursesByCategory as $key => $cat)
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link @if($loop->first) active @endif"
                                    id="{{ $key }}-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $key }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="{{ $key }}"
                                    aria-selected="{{ $loop->first ? 'true':'false' }}">
                                    {{ $cat['label'] }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="course-content">
                        <div class="tab-content" id="myTabContent">

                            @foreach($coursesByCategory as $key => $cat)
                            <div
                                class="tab-pane fade @if($loop->first) show active @endif"
                                id="{{ $key }}"
                                role="tabpanel"
                                aria-labelledby="{{ $key }}-tab">

                                <div class="chatgpt-course theme-carusel owl-carousel">
                                    @forelse($cat['courses'] as $course)
                                    <div class="product-card product-item">
                                        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->course_icon }}"
                                            alt="{{ $course->course_title }}" />

                                        <div class="d-flex flex-column mt-3">
                                            <h3>{{ $course->course_title }}</h3>

                                            <div class="d-flex flex-column my-3">
                                                <div class="d-flex align-items-center info-data">
                                                    <i class="fa-regular fa-user"></i>
                                                    <p class="font-450">{{ number_format($course->course_learners/100 , 1) }}k Learners</p>
                                                </div>
                                                <div class="d-flex align-items-center info-data">
                                                    <i class="fa-regular fa-clock"></i>
                                                    <p class="font-450 ">{{ $course->course_hours }} hrs of learning</p>
                                                </div>
                                            </div>

                                            <div class="d-flex w-100 footer-btn">
                                                <a href="{{ route('course.viewcourse', $course->id) }}" class="text-black w-100 me-2">
                                                    <button>View Program</button>
                                                </a>
                                                <button class="enroll-btn">Enroll Now</button>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-muted">No courses available in this category.</p>
                                    @endforelse
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p>{{ $homepage->verticals_title ?? 'VERTICALS' }}</p>
                        @php
                        $default = 'Choose your area of interest';
                        $text = $homepage->verticals_subtitle ?? $default;

                        $words = explode(' ', trim($text));

                        if (count($words) > 2) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = implode(' ', $words);
                        }
                        @endphp

                        <h6>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h6>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($degreeCategories as $category)
                <div class="col-lg-3">
                    <a href="{{ url('programmes/'.$category->id) }}" class="verticalInterest">
                        <h6>{{ $category->degree_category }}</h6>
                        <p>{{ $category->universities_count }} Courses</p>
                        <img style="height:50%;width:40%" src="https://images.incomeowl.in/incomeowl/crm/images/{{ $category->degree_category_icon_2 }}"
                            alt="{{ $category->degree_category }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p> FREE MASTERCLASSES </p>
                        <h3>Attend <span>free masterclasses</span> by industry experts</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 masterClass">
                    <div class="product-card p-0 overflow-hidden">

                        <img src="{{ asset('') }}frontend/images/masterClasses/19nov20banner.webp" class="img-fluid" />
                        <div class="caption-product">
                            <div class="d-flex flex-column mt-3">
                                <ul class="d-flex align-items-center text-timer">
                                    <li><span>Tuesday,</span> <span class="pl-2">Nov 19</span></li>
                                    <li><span class="text-uppercase">07:00 PM</span>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="">SOP Writing Tips for Top 100 B-Schools</h3>
                            <ul class="badge-tag">
                                <li> Specialisation in Generative AI </li>
                            </ul>
                            <div class="d-flex flex-column my-3">
                                <div class="d-flex align-items-center info-data">
                                    <i class="fa-regular fa-user"></i>
                                    <p class="font-450">40.6k+ learners</p>
                                </div>
                                <div class="d-flex align-items-center info-data">
                                    <i class="fa-regular fa-clock"></i>
                                    <p class="font-450 ">19 hrs of learning</p>
                                </div>
                            </div>
                            <div class="d-flex w-100 footer-btn">
                                <a href="#" class="text-black w-100 me-2"><button>View Program</button></a>
                                <button class="enroll-btn">Syllabus <i class="fa-solid fa-download ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#" class="explore-bottom"> View All Masterclasses <i
                        class="fa-solid fa-chevron-right"></i></a>
            </div>
        </div>
    </section> -->
    @if(!empty($testimonials) && count($testimonials) > 0)
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p>{{ $homepage->testimonials_title ?? 'LEARNER TESTIMONIALS' }}</p>
                        @php
                        $default = 'Hear from our graduates first-hand';
                        $text = $homepage->testimonials_subtitle ?? $default;

                        $words = explode(' ', trim($text));
                        if (count($words) > 2) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = implode(' ', $words);
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="testimonials-theme theme-carusel owl-carousel">
                @foreach($testimonials as $testimonial)
                <div class="product-card p-0 overflow-hidden m-0">
                    <div class="position-relative">
                        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $testimonial->video_image }}"
                            class="img-fluid" />

                        <button type="button" class="btn-video"
                            data-bs-toggle="modal"
                            data-bs-target="#videoModal"
                            data-video="{{ $testimonial->video_url }}"
                            data-title="{{ $testimonial->name }}'s Story">
                            <i class="fa-regular fa-circle-play"></i> Watch my Story
                        </button>
                    </div>
                    <div class="caption-product">
                        <h3 class="mb-4">{{ $testimonial->message }}</h3>
                        <div class="author">
                            <h5>{{ $testimonial->name }} <span>{{ $testimonial->designation }}</span></h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!--video-Modal -->
            <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel">Video Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="ratio ratio-16x9">
                                <iframe id="videoPlayer" src="" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--video-Modal -->


    </section>
    @endif
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brandsList">
                        <h5>{{ $homepage->partner_heading_2 ?? 'Associated with 1400+ hiring partners' }}</h5>
                        <ul class="brandEmployee owl-carousel">
                            @foreach($brands as $brand)
                            <li>
                                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $brand->company_image }}" style="height:24px;width:110px;margin:25px;" alt="{{ $brand->name }}">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0">
        <div class="container">
            <div class="row">
                @php
                // Decode JSON fields
                $numbers = !empty($learner->number) ? json_decode($learner->number, true) : [];
                $titles = !empty($learner->title) ? json_decode($learner->title, true) : [];
                $descriptions = !empty($learner->description) ? json_decode($learner->description, true) : [];
                $images = !empty($learner->image) ? json_decode($learner->image, true) : [];
                @endphp

                <div class="col-lg-4">
                    <div class="position-sticky top-0 leftStickywork">
                        <div class="heading-Theme">
                            <p>{{ $learner->learner_support_heading ?? "LEARNER SUPPORT & SUCCESS" }}</p>
                            <h3>{{ $learner->learner_support_content ?? "What gives us an edge?" }}</h3>
                            <a href="tel:{{ $disclaimer->helpline ?? '1800243876' }}" class="explore-bottom mt-3 d-inline-block">
                                <i class="fa-solid fa-phone-volume me-2 ms-0"></i>
                                {{ $learner->get_started ?? "Get started with iUniversity" }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="listscroll">
                        <ul>
                            @foreach($titles as $index => $title)
                            <li>
                                <span>
                                    <h3>{{ $numbers[$index] ?? '' }}</h3>
                                    <h4>{{ $title }}</h4>
                                    <p>{{ $descriptions[$index] ?? '' }}</p>
                                </span>

                                @if(!empty($images[$index]))
                                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $images[$index] }}" alt="{{ $title }}">
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($inst))
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        <p> {{ $homepage->instructor_heading_1 ?? 'INSTRUCTORS' }} </p>
                        @php
                        $defaultText = 'Master your craft with renowned faculty';
                        $text = $homepage->instructor_subtitle ?? $defaultText;

                        $words = explode(' ', trim($text));

                        if (count($words) > 2) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = implode(' ', $words);
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="courses-tab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="instructor-tab" data-bs-toggle="tab"
                                    data-bs-target="#instructor" type="button" role="tab"
                                    aria-controls="instructor" aria-selected="true">{{ $homepage->instructor_heading_2 ?? 'INSTRUCTORS' }}</button>
                            </li>
                        </ul>
                    </div>
                    <div class="course-content">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="instructor" role="tabpanel"
                                aria-labelledby="PopularCourse-tab">
                                <div class="InstructorSlider theme-carusel owl-carousel">
                                    @foreach($instructors as $instructor)
                                    <div class="product-card product-item">
                                        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $instructor->profile_image }}" class="img-fluid" />
                                        <div class="d-flex flex-column mt-3">
                                            <h3 class="">{{ $instructor->name }} <span>{{ $instructor->designation }}</span>
                                            </h3>
                                            <div class="d-flex align-items-center logo-working mt-1 mb-3">
                                                <span class="text-uppercase font-normal">Working at </span>&nbsp;
                                                <div class="d-flex">
                                                    <img alt="image"
                                                        src="https://images.incomeowl.in/incomeowl/crm/images/{{ $instructor->working_logo }}"
                                                        style="color: transparent; object-fit: contain;">
                                                </div>
                                            </div>
                                            <p class="description">
                                                {{ Str::limit($instructor->description, 120) }}
                                                @if (strlen($instructor->description) > 120)

                                                <span class="more-text d-none">{{ substr($instructor->description, 120) }}</span>
                                                <span class="text-underline font-medium text-primary read-more"
                                                    data-name="{{ $instructor->name }}"
                                                    data-designation="{{ $instructor->designation }}"
                                                    data-company="https://images.incomeowl.in/incomeowl/crm/images/{{ $instructor->working_logo }}"
                                                    data-description="{{ e($instructor->description) }}"
                                                    data-image="https://images.incomeowl.in/incomeowl/crm/images/{{ $instructor->profile_image }}"
                                                    data-linkedin="{{ $instructor->linkedin_url }}"
                                                    style="cursor:pointer;">Read More</span>
                                                @endif
                                            </p>


                                            <a href="{{ $instructor->linkedin_url }}" target="_blank"
                                                class="d-flex align-items-end text-linkedin mt-2">
                                                <span class="text-underline">LinkedIn Profile</span>
                                                <img alt="Linkedin" src="{{ asset('') }}frontend/images/instructor/Linkedin.svg"></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Instructor Detail Modal -->
    <div class="modal fade" id="instructorModal" tabindex="-1" aria-labelledby="instructorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold mb-0">Instructors</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-center">

                                <div class="col-md-3 text-center">
                                    <img id="modalImage" src="" class="rounded" style="width:120px;height:160px;object-fit:cover;">
                                </div>

                                <div class="col-md-9">
                                    <h5 id="modalName" class="fw-semibold mb-1"></h5> Working At :&emsp;
                                    <img id="modalCompany" src="" alt="Company Logo" style="height:20px;object-fit:contain;">
                                    <p id="modalDesignation" class="text-dark semibold mt-2 mb-2">
                                        <i class="bi bi-person-badge"></i>
                                        <span></span>
                                    </p>
                                    <p id="modalDescription" style="font-size: small;" class="text-muted mb-3"></p>

                                    <a id="modalLinkedin" href="#" target="_blank" class="text-linkedin fw-medium">
                                        LinkedIn Profile <img src="{{ asset('frontend/images/instructor/Linkedin.svg') }}" style="height:18px;margin-left:4px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <div class="heading-Theme">
                        @php
                        $defaultAwards = 'Awards & Accomplishments';
                        $title = $homepage->awards_title ?? $defaultAwards;

                        $words = explode(' ', trim($title));

                        if (count($words) > 1) {
                        $lastOne = array_pop($words);
                        $firstPart = implode(' ', $words);
                        } else {
                        $firstPart = '';
                        $lastOne = $title;
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastOne }}</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="awards-container">
                <div class="awards-slider m-5">
                    <div class="awards-scroll-wrapper">
                        @foreach($awards as $award)
                        <div class="award-card">
                            <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $award->award_image }}"
                                alt="{{ $award->award_title }}">
                            <h6 class="text-primary">{{ $award->award_title }}</h6>
                            <p class="text-black">{{ $award->award_heading }}</p>
                            <p>{{ $award->award_description }}</p>
                        </div>
                        @endforeach

                        @foreach($awards as $award)
                        <div class="award-card">
                            <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $award->award_image }}"
                                alt="{{ $award->award_title }}">
                            <h6 class="text-primary">{{ $award->award_title }}</h6>
                            <p class="text-black">{{ $award->award_heading }}</p>
                            <p>{{ $award->award_description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <!-- Heading -->
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                 @php
                    $heading = $homepage->media_heading ?? 'Our Presence in the Media';
                @endphp
                    <div class="heading-Theme">
                        @php
                        // Split heading for color styling
                        $words = explode(' ', $heading);
                        $firstPart = implode(' ', array_slice($words, 0, -1));
                        $lastWord = end($words);
                        @endphp
                        <h3>{{ $firstPart }} <span>{{ $lastWord }}</span></h3>
                    </div>
                </div>
            </div>

            <!-- Media Cards Carousel -->
            <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($mediaItems->chunk(3) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row justify-content-center">
                            @foreach($mediaChunk as $media)
                            <div class="col-md-4 mb-4">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4 text-start">
                                        <div class="mb-3 text-center bg-primary bg-opacity-10 p-5 rounded-3">
                                            <h5 class="m-0 fw-bold text-uppercase" style="font-family: 'Times New Roman';">
                                                {{ $media->media_name }}
                                            </h5>
                                        </div>
                                        <p class="fw-semibold">{{ $media->media_description }}</p>
                                        <p class="text-muted small mb-0">
                                            {{ \Carbon\Carbon::parse($media->media_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-Theme">
                        @php
                        $defaultTitle = 'iUniversity Learner Support';
                        $title = $homepage->support_title ?? $defaultTitle;

                        $words = explode(' ', trim($title));

                        if (count($words) > 1) {
                        $lastTwo = implode(' ', array_slice($words, -2));
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        } else {
                        $firstPart = '';
                        $lastTwo = $title;
                        }
                        @endphp

                        <h3>
                            {{ $firstPart }}
                            <span>{{ $lastTwo }}</span>
                        </h3>

                        <p class="learnerSupport">{{ $homepage->support_subtitle ?? 'Talk to our experts. We’re available 24/7.' }}</p>
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
                                <button> <i class="fa-solid fa-phone"></i> {{ $disclaimer->helpline ?? "1800243876" }}</button>
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


<!--Updates Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="universityUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <div class="modal-header text-white" style="background: linear-gradient(135deg, #003366, #0055a4);">
                <h5 class="modal-title fw-bold" id="universityUpdateLabel">
                    🎓 iUniversity Announcement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light text-center p-5">
                <img src="{{ asset('') }}frontend/images/I-University_logo_11.png" alt="University Update" class="img-fluid rounded-3 mb-4 shadow-sm" style="max-height: 100px; object-fit: cover;">

                <h4 class="fw-semibold text-primary mb-2">📢 Admissions for 2026 Are Now Open!</h4>
                <p class="text-muted mb-4">
                    Explore our new degree programs in Computer Science, AI, and Digital Marketing.
                    Apply now to be part of our vibrant campus community.
                </p>
                @php
                $allowedIds = [1, 4, 6, 7, 19, 21, 22,25];
                $randomId = $allowedIds[array_rand($allowedIds)];
                @endphp

                <a href="{{ url('programmes/'.$randomId) }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                    Apply Now
                </a>
            </div>

            <div class="modal-footer bg-white justify-content-center">
                <small class="text-secondary">
                    Stay tuned for more updates — Scholarships & Events coming soon 🎉
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).on('click', '.read-more', function() {
        let $this = $(this);

        $('#modalImage').attr('src', $this.data('image'));
        $('#modalCompany').attr('src', $this.data('company'));
        $('#modalName').text($this.data('name'));
        $('#modalDesignation span').text($this.data('designation'));
        $('#modalDescription').html($this.data('description'));
        $('#modalLinkedin').attr('href', $this.data('linkedin'));

        $('#instructorModal').modal('show');
    });
</script>


@endpush