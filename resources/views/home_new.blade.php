@extends('layouts.app_new')
@section('title', 'Dasboard')
@section('pagetitle', 'Dasboard')

@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row align-items-center ">
                    <div class="col-md-4">
                        <h3 class="page-title">Dashboard</h3>
                    </div>
                    <div class="col-md-8 float-end ms-auto">
                        <div class="d-flex title-head">
                            <div class="daterange-picker d-flex align-items-center justify-content-center">

                                <div class="head-icons mb-0">
                                    <a href="{{ route('homeNew') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="Refresh">
                                        <i class="ti ti-refresh-dot"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="Collapse" id="collapse-header">
                                        <i class="ti ti-chevrons-up"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="page-wrapper"> --}}
    {{-- <div class="content"> --}}

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
        <div class="mb-3">
            <h1 class="mb-1">Welcome, {{ auth()->user()->name ?? 'Admin' }}</h1>
        </div>
        {{-- <div class="input-icon-start position-relative mb-3">
                        <span class="input-icon-addon fs-16 text-gray-9">
                            <i class="ti ti-calendar"></i>
                        </span>
                        <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
                    </div> --}}
    </div>

    <!-- <div class="alert bg-warning-transparent alert-dismissible fade show mb-4">
                    <div>
                        <span><i class="ti ti-info-circle fs-14 text-orange me-2"></i>Your Product </span> <span
                            class="text-orange fw-semibold"> Apple Iphone 15 is running Low, </span> already below 5 Pcs.,
                        <a href="javascript:void(0);" class="link-orange text-decoration-underline fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#add-stock">Add Stock</a>
                    </div>
                    <button type="button" class="btn-close text-gray-9 fs-14" data-bs-dismiss="alert" aria-label="Close"><i
                            class="ti ti-x"></i></button>
                </div> -->

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center">
                <div class="card-body">
                    <div class="avatar rounded-circle bg-primary bg-opacity-25 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:50px; height:50px;">
                        <i class="ti ti-users fs-2"></i>
                    </div>
                    <h6 class="fw-semibold text-muted mb-1">Total Students</h6>
                    <h3 class="fw-bold text-success mb-2" data-bs-toggle="tooltip" title="Total Students">
                        {{ $totalstudents ?? 0 }}
                    </h3>
                    <a href="{{ route('member', ['type' => 'student']) }}" class="text-primary text-decoration-none fw-medium">
                        View All Details
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center">
                <div class="card-body">
                    <div class="avatar rounded-circle bg-info bg-opacity-25 text-info d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:50px; height:50px;">
                        <i class="ti ti-book fs-2"></i>
                    </div>
                    <h6 class="fw-semibold text-muted mb-1">Total University & Courses</h6>
                    <h3 class="fw-bold text-success mb-2" data-bs-toggle="tooltip" title="Total Courses">
                        {{ $totalcourses ?? 0 }}
                    </h3>
                    <a href="{{ route('degreeView') }}" class="text-primary text-decoration-none fw-medium">
                        View All Details
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center">
                <div class="card-body">
                    <div class="avatar rounded-circle bg-warning bg-opacity-25 text-warning d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:50px; height:50px;">
                        <i class="ti ti-target fs-2"></i>
                    </div>
                    <h6 class="fw-semibold text-muted mb-1">Total Programmes</h6>
                    <h3 class="fw-bold text-success mb-2" data-bs-toggle="tooltip" title="Total Programmes">
                        {{ $totalprogrammes ?? 0 }}
                    </h3>
                    <a href="{{ route('showProgramme') }}" class="text-primary text-decoration-none fw-medium">
                        View All Details
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 d-flex">
            <div class="card flex-fill shadow-sm text-center">
                <div class="card-body">
                    <div class="avatar rounded-circle bg-success bg-opacity-25 text-success d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:50px; height:50px;">
                        <i class="ti ti-currency-rupee fs-2"></i>
                    </div>
                    <h6 class="fw-semibold text-muted mb-1">Total Revenue</h6>
                    <h3 class="fw-bold text-success mb-2" data-bs-toggle="tooltip" title="Total Revenue">
                        ₹{{ number_format($totalRevenue ?? 0 ,2) }}
                    </h3>
                    <a href="{{ route('fees.list') }}" class="text-primary text-decoration-none fw-medium">
                        View All Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6>Students per Programme</h6>
                <canvas id="studentsChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6>Revenue (Last 6 Months)</h6>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="card shadow-sm p-3">
        <h6>Recent Sign Up Students</h6><br>
        <table class="table table-bordered table-striped" id="admissionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No.</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentStudents as $student)
                <tr>
                    <td>{{ $student->agentcode }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->mobile }}</td>
                    <td>
                        @if(!empty($student->status) && $student->status == 'active')
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $student->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No recent signups found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection


@push('script')

<script>
    const getDashboardData = (start, end) => {


        $.ajax({
            url: "{{ route('homeNew') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Wait!',
                    text: 'We are processing your request.',
                    allowOutsideClick: () => !swal.isLoading(),
                    onOpen: () => {
                        swal.showLoading()
                    }
                });
            },
            complete: function() {
                swal.close();
            },
            success: function(resp) {
                emplyeeCountChart(resp);
                attendanceChart(resp);
            }
        });

    }

    $(function() {
        getDashboardData();
    });

    $(document).ready(function() {
        const studentsCtx = document.getElementById('studentsChart').getContext('2d');
       new Chart(studentsCtx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Students',
            data: @json($counts),
            backgroundColor: [
                'rgba(153, 102, 255, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 159, 64, 0.6)',
            ],
            borderColor: [
                'rgba(153, 102, 255, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                ticks: {
                    callback: function(value, index) {
                        let label = this.getLabelForValue(value);
                        return label.split(" "); // 🔥 break on space
                    }
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});

        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [{
                    label: 'Revenue (₹)',
                    data: [50000, 65000, 80000, 72000, 90000, 100000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>
@endpush