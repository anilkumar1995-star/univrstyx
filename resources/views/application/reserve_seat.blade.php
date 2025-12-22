@extends('frontend.app')
@section('title', 'Reserve a Seat')

@section('content')

{{-- Success banner (place this at top of the content section) --}}
<section class="py-5 text-center bg-white">
  <div class="container" style="max-width: 650px;">

    <div class="position-relative d-inline-flex justify-content-center align-items-center mb-4">
      <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
        style="width: 100px; height: 100px;"><span class="text-success" style="font-size: 50px;">✔</span>
        <i class="bi bi-check2 text-success" style="font-size: 48px;"></i>
      </div>
    </div>
    <h5 class="fw-semibold text-dark mb-2">Your Profile is a <span class="text-success">100% match</span> for</h5>

    <div class="border rounded-3 py-3 px-4 d-inline-block mb-5 shadow-sm">
      <h4 class="fw-bold text-uppercase mb-0">{{ $programme->university_name ?? 'iUniversity' }}</h4>
    </div>
  </div>
</section>

<div class="container text-center">
  <h5 class="fw-semibold text-dark mb-2">Your application has been <span class="text-success">Submitted </span> Successfully</h5>
</div>



<section class="py-5 text-center bg-light">
  <div class="container">
    <h5 class="text-muted mb-4">Admission Process :</h5>

    <div class="position-relative d-flex justify-content-center align-items-start mb-5" style="min-height: 100px;">
      <div class="position-absolute start-50 translate-middle-x border-top border-2 border-success"
        style="width: 250px; top: 22px; z-index: 1;"></div>

      <div class="text-center position-relative" style="z-index: 2; margin-right: 80px;">
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2"
          style="width: 40px; height: 40px;">✔

        </div>
        <p class="fw-semibold text-success mb-1">Screening Round</p>
        <small class="text-muted"><i class="bi bi-clock me-1"></i>5 mins</small>
      </div>

      <div class="text-center position-relative" style="z-index: 2; margin-left: 90px;">
        <div class="rounded-circle border border-success text-success d-flex align-items-center justify-content-center mx-auto mb-2"
          style="width: 40px; height: 40px;">
          <span>2</span>
        </div>
        <p class="fw-semibold text-success mb-1">Reserve a Seat</p>
        <small class="text-muted"><i class="bi bi-clock me-1"></i>5 mins</small>
      </div>
    </div>

    <div class="py-4 bg-white shadow-sm rounded-4 mx-auto" style="max-width: 500px;">
      <p class="text-muted small mb-1"><i class="bi bi-hourglass-split me-1"></i>Filling up fast</p>
      <h5 class="fw-bold mb-1">Only few seats available.</h5>
      <p class="text-muted mb-4">Easy financing options available</p>
      <button onclick="window.location.href='{{ route('checkout', $programme->id) }}'"
        class="btn btn-danger px-5 py-2 rounded-pill fw-semibold">
        RESERVE A SEAT →
      </button>

    </div>
  </div>
</section>
<style>
  .app-success-banner {
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1080;
    background: linear-gradient(90deg, #198754 0%, #2fb86f 100%);
    color: white;
    transform: translateY(-120%);
    transition: transform 320ms ease;
    box-shadow: 0 6px 18px rgba(18, 84, 52, 0.15);
  }

  .app-success-banner.show {
    transform: translateY(0);
  }

  .app-success-banner .inner-container {
    max-width: 1140px;
    margin: 0 auto;
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .app-success-banner .banner-icon {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.12);
    color: #fff;
    font-size: 18px;
  }

  .btn-close-white {
    filter: invert(1) brightness(1.2);
    opacity: 0.9;
  }
</style>
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('appSuccessBanner');
    if (!banner) return;

    setTimeout(() => banner.classList.add('show'), 50);

    const hide = () => {
      banner.classList.remove('show');
      setTimeout(() => banner.remove(), 400);
    };

    const timer = setTimeout(hide, 6000);

    document.getElementById('closeBannerBtn')?.addEventListener('click', () => {
      clearTimeout(timer);
      hide();
    });
  });
</script>