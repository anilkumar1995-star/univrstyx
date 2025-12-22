@extends('frontend.app')
@section('title', 'Screening Round')

@section('content')
<section class="screening-section py-5" style="background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 bg-white rounded-4 shadow-lg p-5 position-relative">

        <div class="text-center mb-4">
          <h5 class="text-primary mb-1 fw-semibold">🎯 Screening Round</h5>
          <h6 class="fw-semibold text-dark">
            {{ $programme->degree_name ?? 'Programme Name' }} from
            <span class="text-danger">{{ $programme->university_name ?? 'University' }}</span>
          </h6>
          <hr class="mt-3 border-3 border-danger opacity-75" style="width: 60px; margin: auto;">
        </div>

        <!-- Laravel Validation Errors -->
        @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form id="screeningForm" method="POST" action="{{ route('screening.store') }}">
          @csrf
          <input type="hidden" name="course_id" value="{{ $programme->id }}">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Name Prefix <span class="text-danger">*</span></label>
              <select name="prefix" required class="form-select border-primary">
                <option value="">Select Prefix</option>
                <option>Mr.</option>
                <option>Ms.</option>
                <option>Mrs.</option>
                <option>Dr.</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control bg-secondary text-white border-primary" value="{{ Auth::user()->name }}" readonly>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Father’s Name <span class="text-danger">*</span></label>
              <input type="text" name="father_name" class="form-control border-warning" required placeholder="Enter Father’s Name">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Guardian’s Name</label>
              <input type="text" name="guardian_name" class="form-control border-warning" placeholder="Enter Guardian’s Name">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary d-block mb-2">Gender <span class="text-danger">*</span></label>
            <div class="btn-group" role="group">
              <input type="radio" class="btn-check" name="gender" id="male" value="male">
              <label class="btn btn-outline-primary rounded-2 me-2 px-4 py-2" for="male">👨 Male</label>

              <input type="radio" class="btn-check" name="gender" id="female" value="female">
              <label class="btn btn-outline-warning rounded-2 px-4 py-2" for="female">👩 Female</label>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Date of Birth <span class="text-danger">*</span></label>
              <input type="date" required name="dob" class="form-control border-info">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">City <span class="text-danger">*</span></label>
              <input type="text" required name="city" class="form-control border-info" placeholder="Enter City">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Phone Number <span class="text-danger">*</span></label>
              <input type="text" name="phone" class="form-control bg-secondary text-white border-success" value="{{ Auth::user()->mobile ?? '' }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control bg-secondary text-white border-success" value="{{ Auth::user()->email ?? '' }}" readonly>
            </div>
          </div>

          <div class="mb-4 p-3 bg-light rounded-3">
            <label class="form-label fw-semibold text-dark d-block mb-2">🎓 Do you have a Bachelor's Degree?</label>
            <div class="btn-group" role="group">
              <input type="radio" class="btn-check" name="bachelor" id="bachelorYes" value="Yes">
              <label class="btn btn-outline-success rounded-2 me-2 px-4 py-2" for="bachelorYes">Yes</label>

              <input type="radio" class="btn-check" name="bachelor" id="bachelorNo" value="No">
              <label class="btn btn-outline-danger rounded-2 px-4 py-2" for="bachelorNo">No</label>
            </div>

            <div class="mt-3 bachelor-percent d-none">
              <input type="number" class="form-control border-success" name="bachelor_percentage"
                placeholder="Enter your Bachelor's percentage (%)" min="0" max="100" step="0.01">
            </div>
          </div>

          <div class="mb-4 p-3 bg-light rounded-3">
            <label class="form-label fw-semibold text-dark d-block mb-2">🎓 Do you have a Master's Degree?</label>
            <div class="btn-group" role="group">
              <input type="radio" class="btn-check" name="masters" id="mastersYes" value="Yes">
              <label class="btn btn-outline-success rounded-2 me-2 px-4 py-2" for="mastersYes">Yes</label>

              <input type="radio" class="btn-check" name="masters" id="mastersNo" value="No">
              <label class="btn btn-outline-danger rounded-2 px-4 py-2" for="mastersNo">No</label>
            </div>

            <div class="mt-3 masters-percent d-none">
              <input type="number" class="form-control border-success" name="masters_percentage"
                placeholder="Enter your Master's percentage (%)" min="0" max="100" step="0.01">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Work Experience</label>
              <select name="experience" class="form-select border-info">
                <option value="">Select total experience</option>
                <option>0-1 years</option>
                <option>2-5 years</option>
                <option>5-10 years</option>
                <option>10+ years</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Industry</label>
              <input type="text" name="industry" class="form-control border-info" placeholder="Enter Industry">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Current Organisation</label>
              <input type="text" name="organisation" class="form-control border-warning" placeholder="Enter Organisation Name">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-secondary">Designation</label>
              <input type="text" name="designation" class="form-control border-warning" placeholder="Enter Designation">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Referral Code (Optional)</label>
            <input type="text" name="referral_code" class="form-control border-secondary" placeholder="Enter Referral Code">
          </div>

          <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" id="agree" required>
            <label class="form-check-label" for="agree">
              <strong>Disclaimer:</strong> I confirm that the above information is correct.
            </label>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-gradient px-5 py-2 rounded-pill fw-semibold">
              🚀 Submit Application
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  .screening-section {
    background: #f8f9fa;
    min-height: 100vh;
  }

  label.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 4px;
  }

  .btn-gradient {
    background: linear-gradient(45deg, #ff4e50, #f9d423);
    color: #fff;
    border: none;
    transition: all 0.3s ease-in-out;
  }

  .btn-gradient:hover {
    background: linear-gradient(45deg, #f9d423, #ff4e50);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
  }

  .btn-outline-pink {
    color: #e83e8c;
    border-color: #e83e8c;
  }

  .btn-outline-pink:hover {
    background-color: #e83e8c;
    color: #fff;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>

<script>
  $(function() {

    $('input[name="bachelor"]').on('change', function() {
      if ($('#bachelorYes').is(':checked')) {
        $('.bachelor-percent').removeClass('d-none');
      } else {
        $('.bachelor-percent').addClass('d-none').find('input').val('');
      }
    });


    $('input[name="masters"]').on('change', function() {
      if ($('#mastersYes').is(':checked')) {
        $('.masters-percent').removeClass('d-none');
      } else {
        $('.masters-percent').addClass('d-none').find('input').val('');
      }
    });


  });
  $("#screeningForm").validate({
    submitHandler: function() {
      var form = $('form#screeningForm');
      form.ajaxSubmit({
        dataType: 'json',
        beforeSubmit: function() {
          form.find('button:submit').html('Please wait...').attr(
            'disabled', true).addClass('btn-secondary');
        },
        success: function(data) {
          form.find('button:submit').html('Submit Details').attr(
            'disabled', false).removeClass('btn-secondary');
          if (data.status === "success") {
            form[0].reset();
            notify(data.message, 'success');
            $('#datatable').dataTable().api().ajax.reload();

          } else {
            notify(data.message, 'error');
          }
        },
        error: function(errors) {
          form.find('button:submit').html('Submit Details').attr(
            'disabled',
            false).removeClass('btn-secondary');
          notify(errors?.responseJSON?.message ||
            "Something went wrong",
            'error');
        }
      });
    }
  });
</script>
@endpush