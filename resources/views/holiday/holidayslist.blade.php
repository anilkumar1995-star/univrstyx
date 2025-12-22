@extends('layouts.app_new')
@section('title', 'Syllabus List')
@section('pagetitle', 'Syllabus List')

@php
    $table = 'yes';
@endphp

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h4 class="page-title">@yield('pagetitle')<span class="count-title">All</span></h4>
                        </div>
                        <div class="col-8 text-end">
                            <div class="head-icons">
                                <a href="{{ route('holidayView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Refresh">
                                    <i class="ti ti-refresh-dot"></i>
                                </a>
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Collapse" id="collapse-header" class="">
                                    <i class="ti ti-chevrons-up"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                                class="ti ti-package-export me-2"></i>Export</a>
                                        <div class="dropdown-menu  dropdown-menu-end">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export
                                                        as PDF</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                                            class="ti ti-file-type-xls text-green me-1"></i>Export
                                                        as Excel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    @if (\Myhelper::hasRole('admin'))
                                        <a href="javascript:void(0)" type="button" class="btn btn-primary ms-2"
                                            data-bs-toggle="modal" data-bs-target="#addSyllabusModal">
                                            <i class="ti ti-square-rounded-plus ti-sm"></i> Add Syllabus</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search and Filter -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search courses...">
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary active" data-filter="all">All</button>
                                    <button type="button" class="btn btn-outline-primary" data-filter="programming">Programming</button>
                                    <button type="button" class="btn btn-outline-primary" data-filter="business">Business</button>
                                    <button type="button" class="btn btn-outline-primary" data-filter="design">Design</button>
                                </div>
                            </div>
                        </div>

                        <!-- Syllabus Cards Grid -->
                        <div class="row" id="syllabusCards">
                            <!-- Cards will be dynamically loaded here -->
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="text-center py-4" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Syllabus Modal -->
    <div class="modal" id="addSyllabusModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Syllabus Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>

                <form id="syllabusForm" action="{{ route('festDetStore') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Course Name</label>
                                <input type="text" name="festival_name" class="form-control" required
                                    placeholder="Enter Course Name">
                            </div>
                            <div class="col-md-6">
                                <label>Subject/Category</label>
                                <select name="festival_date" class="form-control" required>
                                    <option value="">Select Subject</option>
                                    <option value="Programming">Programming</option>
                                    <option value="Business">Business</option>
                                    <option value="Design">Design</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Data Science">Data Science</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Duration (in months)</label>
                                <input type="number" name="duration" class="form-control"
                                    placeholder="Enter Duration">
                            </div>
                            <div class="col-md-6">
                                <label>Learning Hours</label>
                                <input type="number" name="learning_hours" class="form-control"
                                    placeholder="Enter Learning Hours">
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Enter Syllabus Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"
                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSyllabusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Syllabus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this syllabus? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
<style>
.syllabus-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}

.syllabus-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card-header-bg {
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.card-header-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="8" fill="rgba(255,255,255,0.1)">JavaScript</text><text y="70" font-size="8" fill="rgba(255,255,255,0.1)">Hello</text></svg>');
    background-size: cover;
}

.card-body-content {
    padding: 20px;
}

.course-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.3;
}

.course-stats {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
    color: #666;
}

.stat-item i {
    color: #667eea;
}

.course-actions {
    display: flex;
    gap: 10px;
}

.btn-view {
    background: #fff;
    color: #333;
    border: 1px solid #ddd;
    flex: 1;
}

.btn-enroll {
    background: #dc3545;
    color: #fff;
    border: none;
    flex: 1;
}

.btn-view:hover {
    background: #f8f9fa;
    color: #333;
}

.btn-enroll:hover {
    background: #c82333;
    color: #fff;
}

.filter-btn.active {
    background-color: #667eea;
    color: white;
    border-color: #667eea;
}
</style>
@endpush

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            loadSyllabusCards();

            // Search functionality
            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.syllabus-card').each(function() {
                    var courseName = $(this).find('.course-title').text().toLowerCase();
                    if (courseName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Filter functionality
            $('[data-filter]').on('click', function() {
                $('[data-filter]').removeClass('active');
                $(this).addClass('active');
                
                var filter = $(this).data('filter');
                if (filter === 'all') {
                    $('.syllabus-card').show();
                } else {
                    $('.syllabus-card').each(function() {
                        var category = $(this).data('category');
                        if (category === filter) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

            function loadSyllabusCards() {
                $('#loadingSpinner').show();
                $('#syllabusCards').empty();

                $.ajax({
                    url: "{{ url('statement/fetch') }}/festivaldetails/0",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#loadingSpinner').hide();
                        console.log('Syllabus data received:', data);
                        if (data.data && data.data.length > 0) {
                            data.data.forEach(function(item) {
                                var card = createSyllabusCard(item);
                                if (card) {
                                    $('#syllabusCards').append(card);
                                }
                            });
                        } else {
                            $('#syllabusCards').html('<div class="col-12 text-center"><p>No syllabus found</p></div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingSpinner').hide();
                        console.error('Error loading syllabus:', error);
                        $('#syllabusCards').html('<div class="col-12 text-center"><p>Error loading syllabus</p></div>');
                    }
                });
            }

            function createSyllabusCard(item) {
                try {
                    var category = (item.festival_date || 'General').toString();
                    var duration = (item.duration || 'N/A').toString();
                    var learners = Math.floor(Math.random() * 50000) + 1000;
                    var hours = Math.floor(Math.random() * 20) + 10;
                    
                    // Escape special characters to prevent JavaScript errors
                    var courseName = (item.festival_name || 'Untitled Course').toString().replace(/'/g, "\\'").replace(/"/g, '\\"');
                    var description = (item.desc || '').toString().replace(/'/g, "\\'").replace(/"/g, '\\"');

                    return `
                        <div class="col-lg-4 col-md-6 syllabus-card" data-category="${category.toLowerCase()}">
                            <div class="card syllabus-card">
                                <div class="card-header-bg"></div>
                                <div class="card-body-content">
                                    <h5 class="course-title">${courseName}</h5>
                                    <div class="course-stats">
                                        <div class="stat-item">
                                            <i class="ti ti-users"></i>
                                            <span>${learners.toLocaleString()}+ learners</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="ti ti-clock"></i>
                                            <span>${hours} hrs of learning</span>
                                        </div>
                                    </div>
                                    <div class="course-actions">
                                        @if (\Myhelper::hasRole('admin'))
                                            <button class="btn btn-view" onclick="editDetails('${item.id}', '${courseName}', '${category}', '${description}', '${duration}')">
                                                <i class="ti ti-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-enroll" onclick="deleteSyllabus('${item.id}')">
                                                <i class="ti ti-trash"></i> Delete
                                            </button>
                                        @else
                                            <button class="btn btn-view">
                                                <i class="ti ti-eye"></i> View Program
                                            </button>
                                            <button class="btn btn-enroll">
                                                <i class="ti ti-user-plus"></i> Enroll Now
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } catch (error) {
                    console.error('Error creating syllabus card:', error);
                    return '';
                }
            }

            $("#syllabusForm").validate({
                submitHandler: function() {
                    var form = $('form#syllabusForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('button:submit').html('Submit Details').attr(
                                'disabled',
                                false).removeClass('btn-secondary');
                            if (data.status == "success") {
                                form[0].reset();
                                loadSyllabusCards();
                                notify("Syllabus details submitted successfully",
                                    'success');
                                $('#addSyllabusModal').modal('hide');
                            } else {
                                notify(data.status, 'error');
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
        });

        function editDetails(id, courseName, subject, desc, duration) {
            try {
                $('#syllabusForm').find('[name="id"]').val(id);
                $('#syllabusForm').find('[name="festival_name"]').val(courseName);
                $('#syllabusForm').find('[name="festival_date"]').val(subject);
                $('#syllabusForm').find('[name="description"]').val(desc);
                $('#syllabusForm').find('[name="duration"]').val(duration);

                $('#addSyllabusModal').modal('show');
            } catch (error) {
                console.error('Error in editDetails:', error);
                notify('Error opening edit form', 'error');
            }
        }

        function deleteSyllabus(id) {
            $('#deleteSyllabusModal').modal('show');
            $('#confirmDelete').off('click').on('click', function() {
                $.ajax({
                    url: "{{ route('syllabusDelete') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            notify('Syllabus deleted successfully', 'success');
                            loadSyllabusCards();
                        } else {
                            notify(response.message || 'Failed to delete syllabus', 'error');
                        }
                        $('#deleteSyllabusModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting syllabus:', error);
                        notify('Something went wrong', 'error');
                        $('#deleteSyllabusModal').modal('hide');
                    }
                });
            });
        }
    </script>
@endpush
