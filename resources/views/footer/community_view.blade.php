@extends('frontend.app')
@section('title', 'Community')
@section('pagetitle', 'Community View')

@php
$table = 'yes';
@endphp

@section('content')
<style>
    .community-hero {
        background: linear-gradient(to right, #a1aecbff, #626872ff);
        padding: 70px 0;

    }

    .community-card {
        background: #f9f5f5ff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e0e3e9ff;
        transition: .3s;
    }

    .community-card:hover {
        box-shadow: 0 8px 24px rgba(5, 5, 5, 0.08);
        transform: translateY(-4px);
        border: 1px solid #ea0a0aff;
    }

    .discussion-box {
        border: 1px solid #e5e7eb;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        transition: .3s;
    }

    .discussion-box:hover {
        background: #e1e5e8ff;
    }

    .circle-avatar {
        width: 90px;
        height: 90px;
        background: #e5e7eb;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>
@if(!$community)
    <div class="container text-center">
        <h3 class="mt-5">No Community Data Found</h3>
    </div>

    @php return; @endphp
@endif
<section class="community-hero">
    <div class="container text-center">
        <h1 class="fw-bold mb-3 display-5"> {{ $community->title ?? 'iUniversity Community' }}</h1>
        <p class="lead text-white mb-0">
            {{ $community->subtitle ?? ' Join thousands of learners — ask questions, share ideas, collaborate and grow together.' }}
        </p>
    </div>
</section>

<div class="container my-5">
    @php
    $featureCategories = json_decode($community->feature_categories, true);
    @endphp

    <div class="mb-5">
        <h2 class="fw-bold mb-4">{{ $community->feature_heading ?? 'Featured Categories' }}</h2>

        <div class="row g-4">
            @foreach($featureCategories as $cat)
            <div class="col-md-4">
                <div class="community-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3 text-center fs-3">🎯</div>
                        <h5 class="fw-semibold text-center mb-0">{{ $cat['title'] }}</h5>
                    </div>
                    <p class="text-muted mb-0">
                        {{ $cat['description'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    @php
    $trending = json_decode($community->trending_discussions, true);
    @endphp
 

    <div class="my-5">
        <h2 class="fw-bold mb-4">{{ $community->trending_heading ?? 'Trending Discussions' }}</h2>

        <div class="vstack gap-3">
            @foreach($trending as $t)
            <div class="discussion-box">
                <h5 class="fw-semibold mb-1">{{ $t['title'] }}</h5>
                <small class="text-muted">
                    {{ $t['replies'] }} replies • {{ $t['views'] }} views
                </small>

            </div>
            @endforeach
        </div>
    </div>


    @php
    $contributors = json_decode($community->contributors, true);
    @endphp

    <div class="my-5">
        <h2 class="fw-bold mb-4">{{ $community->top_contributer_heading ?? 'Top Contributors' }}</h2>

        <div class="row g-4">
            @foreach($contributors as $c)
            <div class="col-md-4">
                <div class="text-center p-4 community-card">
                    <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $c['image'] }}" class="circle-avatar" />

                    <h5 class="fw-semibold mt-3">{{ $c['name'] }}</h5>
                    <p class="text-muted mb-0">{{ $c['posts'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
<section class="community-hero text-center py-5">
    <h2 class="fw-bold mb-2">{{ $community->cta_title }}</h2>

    <p class="mb-4 text-white">{{ $community->cta_subtitle }}</p>

    <a href="#" class="btn btn-light px-4 py-2 fw-semibold">
        {{ $community->cta_button_text }}
    </a>
</section>

@endsection

@push('script')
<script type="text/javascript">

</script>
@endpush