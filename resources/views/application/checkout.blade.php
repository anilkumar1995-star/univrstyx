@extends('frontend.app')
@section('title', 'Checkout')

@section('content')
<section class="py-5 bg-light">
  <div class="container">
    <h5 class="fw-semibold mb-4">Welcome <span class="text-danger">{{ auth()->user()->name ?? 'Guest' }}</span></h5>

    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <p class="mb-1 text-muted">Start learning from</p>
        <h4 class="fw-bold mb-0">INR {{ $programme->course_starting_at }}<span class="fs-6 text-muted">/Month</span></h4>
        <small class="text-muted">at 18% interest or INR {{ $programme->course_total_amount }} <span class="fs-6 text-muted">Total</span></small>
      </div>
      <div class="text-center border-start ps-4">
        <p class="mb-1 text-muted">Your Course</p>
        <h6 class="fw-bold mb-0">{{ $programme->degree_name ?? 'Executive Program in Generative AI for Leaders' }}</h6>
        <small class="text-muted">{{ $programme->university_name ?? 'IUNIVERSITY EDUCATION PVT LTD' }}</small><br>
        <small class="text-muted"><b>{{ $programme->degree_duration }} Months </b>  </small>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
          <h6 class="fw-bold mb-3">1. Payment Options</h6>
          <div class="d-flex">
            <div class="me-4" style="width: 180px;">
              <div class="border-start border-3 border-danger ps-3 mb-3">
                <h6 class="text-danger mb-0 fw-semibold">Reserve a Seat</h6>
                <small class="text-muted">Pay the rest later</small>
              </div>
              <div class="ps-3 mb-3">
                <h6 class="fw-semibold text-secondary mb-0">Recommended</h6>
                <small class="text-muted">0% interest onwards</small>
              </div>
              <div class="ps-3 mb-3">
                <h6 class="fw-semibold text-secondary mb-0">Pocket-Friendly</h6>
                <small class="text-muted">Lowest cost / month</small>
              </div>
              <div class="ps-3">
                <h6 class="fw-semibold text-secondary mb-0">Other Options</h6>
                <small class="text-muted">Pay upfront</small>
              </div>
            </div>

            <div class="flex-grow-1">
              <div class="border rounded-3 p-3 mb-3">
                <h6 class="fw-semibold">Pay minimum INR {{ $seat_amount }}</h6>
                <p class="text-muted small mb-3">
                  and the rest within 7 days through full fee payment or an easy financing option.
                </p>

                <div class="row g-3">
                  <div class="col-6 col-md-3">
                    <button class="btn btn-outline-dark w-100">Credit Card</button>
                  </div>
                  <div class="col-6 col-md-3">
                    <button class="btn btn-outline-dark w-100">Debit Card</button>
                  </div>
                  <div class="col-6 col-md-3">
                    <button class="btn btn-outline-dark w-100">Net Banking</button>
                  </div>
                  <div class="col-6 col-md-3">
                    <button class="btn btn-outline-dark w-100">UPI</button>
                  </div>
                </div>

                <div class="text-center mt-4">
                  <img src="{{ asset('images/payment.png') }}" alt="payment" width="80">
                  <p class="text-muted small mt-2">Choose a payment option to begin with</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white p-4 rounded-4 shadow-sm">
          <h6 class="fw-bold mb-0">2. Billing Details</h6>
        </div>
        <p class="text-muted small mt-3">**Exact pricing will depend on your chosen EMI plan & bank T&Cs.</p>
      </div>

      <div class="col-lg-4">
        <div class="bg-white p-4 rounded-4 shadow-sm">
          <h6 class="fw-bold mb-3">SUMMARY</h6>
          <div class="d-flex justify-content-between mb-2">
            <span>Course Fee</span>
            <span>INR {{ $programme->course_starting_at }}</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between fw-semibold">
            <span>Total</span>
            <span>INR {{ $programme->course_total_amount }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
