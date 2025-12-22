@extends('layouts.app_new')
@section('title', 'Student Dashboard')
@section('pagetitle', 'Dashboard')

@section('content')
<div class="content">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-1">Welcome, {{ auth()->user()->name ?? 'Student' }} 👋</h2>
                    <p class="text-muted mb-0">Here's a quick overview of your learning progress.</p>
                </div>

            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center p-3">
                <div class="d-flex justify-content-center mb-2">
                    <div class="avatar rounded-circle bg-primary bg-opacity-25 text-primary d-inline-flex align-items-center justify-content-center"
                        style="width:50px; height:50px;">
                        <i class="ti ti-book fs-3"></i>
                    </div>
                </div>
                <h6 class="fw-semibold text-muted mb-1">Courses Enrolled</h6>
                <h3 class="fw-bold text-success mb-2">{{ $recentCourses->count() ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center p-3">
                <div class="d-flex justify-content-center mb-2">
                    <div class="avatar rounded-circle bg-success bg-opacity-25 text-success d-inline-flex align-items-center justify-content-center"
                        style="width:50px; height:50px;">
                        <i class="ti ti-progress-check fs-3"></i>
                    </div>
                </div>
                <h6 class="fw-semibold text-muted mb-1">Overall Progress</h6>
                <h3 class="fw-bold text-success mb-2">{{ $progress ?? 0 }}%</h3>
            </div>
        </div>
        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center p-3 d-flex flex-column align-items-center justify-content-center">
                <div class="avatar rounded-circle bg-warning bg-opacity-25 text-warning d-inline-flex align-items-center justify-content-center mb-2"
                    style="width:50px; height:50px;">
                    <i class="ti ti-calendar-event fs-3"></i>
                </div>
                <h6 class="fw-semibold text-muted mb-1">Upcoming Classes</h6>
                <h3 class="fw-bold text-success mb-2">{{ $upcomingClasses ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center p-3">
                <div class="d-flex justify-content-center mb-2">
                    <div class="avatar rounded-circle bg-danger bg-opacity-25 text-danger d-inline-flex align-items-center justify-content-center"
                        style="width:50px; height:50px;">
                        <i class="ti ti-currency-rupee fs-3"></i>
                    </div>
                </div>
                <h6 class="fw-semibold text-muted mb-1">Pending Fees</h6>
                <h3 class="fw-bold text-success mb-2">₹{{ number_format($pendingFees ?? 0, 2) }}</h3>
            </div>
        </div>
    </div>

    {{-- PROGRESS CHART --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold mb-3">Your Course Progress</h6>
                <canvas id="courseProgressChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold mb-3">Monthly Study Hours</h6>
                <canvas id="studyHoursChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- RECENT COURSES --}}
    <div class="card shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold">Recently Enrolled Courses</h6>
            <a href="{{ route('application.list') }}" class="text-primary text-decoration-none">View All</a>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Course Name</th>
                    <th>University</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentCourses ?? [] as $course)
                <tr>
                    <td>{{ $course->degree_name }}</td>
                    <td>{{ $course->university_name }}</td>
                    <td>{{ $course->degree_duration }} Months</td>
                    <td>
                        @if($course->status == 'active')
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-secondary">Completed</span>
                        @endif
                    </td>
                    <td>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $course->progress ?? 0 }}%"
                                aria-valuenow="{{ $course->progress ?? 0 }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No recent courses found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection


@push('script')
<script>
    // Course Progress Chart
    const ctx1 = document.getElementById('courseProgressChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['AI', 'Data Science', 'MBA', 'Marketing', 'Finance'],
            datasets: [{
                label: 'Progress (%)',
                data: [85, 60, 70, 90, 50],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Study Hours Chart
    const ctx2 = document.getElementById('studyHoursChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
            datasets: [{
                label: 'Study Hours',
                data: [15, 22, 18, 30, 25, 28],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush