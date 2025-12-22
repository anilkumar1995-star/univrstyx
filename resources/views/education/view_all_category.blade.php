@extends('frontend.app')
@section('title', $category->degree_category ?? 'Courses')

@section('content')
<section class="py-4">
    <div class="container">

        <!-- Header -->
        <div class="row mb-4 text-center">
            <div class="col-lg-12">
                <div class="heading-Theme">
                    <p>{{ strtoupper($category->degree_category ?? 'COURSES') }}</p>
                    <h3>Explore Our <span>{{ ucwords(str_replace('_', ' ', $type)) }}</span> Programs</h3>
                </div>
            </div>
        </div>

        @if($data->count() > 0)
        <div class="row g-4">
            @foreach($data as $course)
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="product-card product-item shadow-sm border rounded-3 d-flex flex-column w-100 position-relative">

                    <!-- Bestseller Badge -->
                    @if($course->bestseller == 'yes')
                        <div class="badger">Bestseller</div>
                    @endif

                    <!-- Image Wrapper -->
                    <div class="course-img-wrapper bg-light text-center p-2" style="height: 230px;">
                        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->degree_category_icon }}"
                            alt="{{ $course->degree_name }}"
                            class="img-fluid h-100 w-auto mx-auto d-block" style="object-fit: contain;">
                    </div>

                    <!-- Details -->
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <p class="sellerName text-uppercase text-muted small mb-1">{{ $course->university_name }}</p>
                        <h5 class="fw-semibold mb-2 text-dark">{{ $course->degree_name }}</h5>

                        <!-- Type -->
                        @if(!empty($course->type))
                        <ul class="badge-tag list-inline mb-2">
                            <li class="list-inline-item badge bg-light text-dark border">
                                {{ ucwords(str_replace('_', ' ', $course->type)) }}
                            </li>
                        </ul>
                        @endif

                        <!-- Stats -->
                        <div class="d-flex flex-column small text-muted mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-regular fa-user me-2 text-theme"></i>
                                <p class="mb-0">{{ number_format($course->course_learners / 1000, 1) }}k+ learners</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-regular fa-clock me-2 text-theme"></i>
                                <p class="mb-0">{{ $course->course_hours }} hours</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="fw-semibold text-dark mb-1">Starting at ₹{{ number_format($course->course_starting_at) }}</p>
                            <small class="text-muted">Total: ₹{{ number_format($course->course_total_amount) }}</small>
                        </div>

                        <div class="mt-auto d-flex">
                            <a href="{{ url('programme/'.$course->id) }}" class="me-2 flex-grow-1">
                                <button class="btn btn-dark w-100 py-2 rounded-3">View Program</button>
                            </a>
                            <button class="btn btn-outline-primary py-2 rounded-3">
                                Syllabus <i class="fa-solid fa-download ms-2"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <h5 class="text-muted mb-3">No courses available in this category yet.</h5>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Back to Home</a>
        </div>
        @endif

    </div>
</section>
@endsection
