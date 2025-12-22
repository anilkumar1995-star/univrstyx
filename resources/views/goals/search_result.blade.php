@extends('frontend.app')
@section('title', 'Search' )


@section('content')

<nav class="navbar bg-white border-bottom sticky-top">
  <div class="container-fluid px-5 py-2 d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-semibold">Find the right course for your goals.</h5>
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

        <!-- 
        <div class="filter-group mb-4">
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
        @forelse ($courses as $course)
        <div class="course-card d-flex flex-wrap justify-content-between align-items-center">
          <div class="d-flex align-items-center gap-3">
            <div class="course-logo">
              <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->university_icon_2 }}"
                class="watermark img-fluid rounded" alt="university_logo">
            </div>
            <div>
              <p class="course-info mb-1">{{ $course->university_name }}</p>
              <p class="course-title mb-1">{{ Str::limit($course->degree_name, 70) }}</p>
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

        @empty
        <div class="text-center py-5">
          <h6 class="text-muted">No record found</h6>
        </div>
        @endforelse

      </div>

      {{-- Laravel pagination links --}}
      <nav class="mt-4 pagination-wrapper">
        {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
      </nav>
    </div>

  </div>
</div>
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