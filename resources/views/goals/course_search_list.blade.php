<div class="course-results">
  @forelse ($courses as $course)
  <div class="course-card d-flex m-2 flex-wrap justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
      <div class="course-logo">
        <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $course->university_icon_2 }}"
          class="watermark img-fluid rounded" alt="university_logo">
      </div>
      <div>
        <p class="course-info mb-1">{{ $course->university_name }}</p>
        <p class="course-title mb-1">{{ Str::limit($course->degree_name, 70) }}</p>
        <p class="course-info mb-1">
          {{ ucwords(str_replace('_', ' ', $course->type)) }} • {{ $course->degree_duration }} Months
        </p>
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

@if ($courses->hasPages())
      <nav class="mt-4 pagination-wrapper">
        {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
      </nav>
@endif