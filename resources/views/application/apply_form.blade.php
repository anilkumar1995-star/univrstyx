@extends('frontend.app')
@section('title', 'Welcome to Application')
@section('content')

<section class="application-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">

        <div class="welcome-box p-5 shadow-sm bg-white rounded-4">
          <div class="mb-4">
            <img src="{{ asset('frontend/images/support/hii.jpg') }}" alt="wave" width="100">
          </div>

          <h3 class="fw-bold mb-2">Hey {{ Auth::user()->name }},</h3>
          <h4>Welcome to <span class="text-danger">i University</span></h4><br>
          <span >You are Applying for: </span>
          <div class="mt-4 course-box border rounded-4 p-4 d-flex align-items-center text-start">
            <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $programme->university_icon_2 }}" 
                 class="me-3 rounded" width="100" height="80" alt="{{ $programme->degree_name }}">
            <div>
              <h5 class="fw-semibold">{{ $programme->degree_name }}</h5>
              <p class="mb-0 text-muted">{{ $programme->university_name }}</p>
              <small class="text-muted">
                {{ $programme->degree_duration ?? 'N/A' }} months |
                Starts at: <strong>{{ \Carbon\Carbon::parse($programme->deadline_date)->format('d M Y') }}</strong>
              </small>
            </div>
          </div>
          <br>

   <h5 class="text-muted mb-2">Admission Process</h5>
    <div class="d-flex justify-content-center align-items-center mb-4">
      <div class="d-flex align-items-center">
        <div class="rounded-circle bg-success text-white px-3 py-2 me-2">1</div>
        <span class="fw-semibold text-success">Screening Round</span> <br>
        
      </div>
    
      <div class="mx-3 border-top border-2 border-success" style="width: 80px;"></div>
      <div class="d-flex align-items-center">
        <div class="rounded-circle border  px-3 py-2 me-2">2</div>
        <span class="fw-semibold">Reserve a Seat</span><br>
      </div>
    </div>

       

          <div class="mt-5">
            <a href="{{ route('application.screening', $programme->id) }}" class="btn btn-danger btn-lg px-5 rounded-pill">
              LET’S GET STARTED →
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
.application-section {
  background-color: #f9fafc;
  min-height: 100vh;
}
.welcome-box {
  background: #fff;
}
.course-box img {
  object-fit: cover;
}
.circle {
  width: 40px;
  height: 40px;
  line-height: 38px;
  border-radius: 50%;
}
.line {
  z-index: 0;
}
.step {
  z-index: 1;
}
</style>
@endpush
