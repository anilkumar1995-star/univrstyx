@extends('layouts.app_new')
@section('title', 'Community')
@section('pagetitle', 'Community List')

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
                            <a href="{{ route('community.list') }}"><i class="ti ti-refresh-dot"></i></a>
                            <a href="javascript:void(0);" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="d-flex align-items-center justify-content-sm-end">
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
                                @if (\Myhelper::hasRole('admin') && !$communityExists)
                                <a href="javascript:void(0)" id="addAboutUsBtn" type="button"
                                    class="btn btn-primary ms-2"
                                    data-bs-toggle="modal" data-bs-target="#communityModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Community
                                </a>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.pageheader')
                    <div class="table-responsive custom-table">
                        <table class="table" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Feature Heading</th>
                                    <th>Trending Heading</th>
                                    <th>Top Contributer Heading</th>
                                    <th>CTA Title</th>
                                    <th>CTA Subtitle</th>
                                    <th>CTA Button Text</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Community Add/Edit Modal -->
    <div class="modal fade" id="communityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="communityForm" action="{{ route('community.save') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">

                <div class="modal-header">
                    <h5 class="modal-title">Manage Community Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">

                    <h5 class="mt-3"> Section</h5>
                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" id="title" placeholder="iUniversity Community" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle" placeholder="Join thousands of learners — ask questions, share ideas, collaborate and grow together." class="form-control">
                    </div>

                    <hr>
                    <h4 class="mb-3">Feature Categories</h4>
                    <div class="col-md-6">
                        <label>Feature Categories</label>
                        <input type="text" name="feature_heading" placeholder="Feature Categories" id="feature_heading" class="form-control">
                    </div>
                    <div id="featureWrapper">
                        <div class="feature-item border rounded p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label>Title</label>
                                    <input type="text" name="feature_categories[0][title]" class="form-control" placeholder="Announcements">
                                </div>
                                <div class="col-md-5">
                                    <label>Description</label>
                                    <input type="text" name="feature_categories[0][description]" placeholder="Updates, events, offers & important platform news." class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addFeature" class="btn btn-outline-primary btn-sm mb-4">+ Add Feature</button>

                    <hr>

                    <h4 class="mb-3">Trending Discussions</h4>
                    <div class="col-md-6">
                        <label>Trending Discussions</label>
                        <input type="text" name="discussion_heading" id="discussion_heading" placeholder="Trending Discussions" class="form-control">
                    </div>
                    <div id="trendWrapper">
                        <div class="trend-item border rounded p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Title</label>
                                    <input type="text" name="trending_discussions[0][title]" placeholder="How to start AI career without coding background?" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Replies</label>
                                    <input type="number" name="trending_discussions[0][replies]" placeholder="28" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Views</label>
                                    <input type="number" name="trending_discussions[0][views]" placeholder="147" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addTrend" class="btn btn-outline-primary btn-sm mb-4">+ Add Trend</button>

                    <hr>

                    <h4 class="mb-3">Top Contributors</h4>
                    <div class="col-md-6">
                        <label>Top Contributers</label>
                        <input type="text" name="contributer_heading" id="contributer_heading" placeholder="Top Contributors" class="form-control">
                    </div>
                    <div id="contribWrapper">
                        <div class="contrib-item border rounded p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" name="contributors[0][name]" placeholder="Enter Name" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Image</label>
                                    <input type="file" name="contributors[0][image]" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" name="contributors[0][posts]" placeholder="Description" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addContrib" class="btn btn-outline-primary btn-sm mb-4">+ Add Contributor</button>


                    <hr>
                    <h5>CTA Section</h5>
                    <div class="col-md-4">
                        <label>CTA Title</label>
                        <input type="text" name="cta_title" id="cta_title" placeholder="Join Our Growing Community" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>CTA Subtitle</label>
                        <input type="text" name="cta_subtitle" id="cta_subtitle" placeholder="Ask questions, get help, share knowledge & grow together." class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Button Text</label>
                        <input type="text" name="cta_button_text" id="cta_button_text" placeholder="Join Now" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>


</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {


        $("#communityForm").validate({
            submitHandler: function() {
                var form = $('#communityForm');

                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit')
                            .html('Please wait...')
                            .attr('disabled', true)
                            .addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit')
                            .html('Submit')
                            .attr('disabled', false)
                            .removeClass('btn-secondary');

                        if (data.status) {
                            $('#datatable').DataTable().ajax.reload();
                            notify("Community details saved successfully", "success");
                            $('#communityModal').modal('hide');
                            form[0].reset();
                        } else {
                            notify(data.message, "error");
                        }
                    },
                    error: function(xhr) {
                        form.find('button:submit')
                            .html('Submit')
                            .attr('disabled', false);

                        notify("Something went wrong", "error");
                    }
                });
            }
        });


        let featureIndex = 1;
        let trendIndex = 1;
        let contribIndex = 1;

        $("#addFeature").click(function() {
            $("#featureWrapper").append(`
            <div class="feature-item border rounded p-3 mb-3">
                <button type="button" class="btn btn-danger mt-4 btn-sm float-end removeItem">X</button>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label>Title</label>
                        <input type="text" name="feature_categories[${featureIndex}][title]" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label>Description</label>
                        <input type="text" name="feature_categories[${featureIndex}][description]" class="form-control">
                    </div>
                </div>
            </div>
        `);
            featureIndex++;
        });

        $("#addTrend").click(function() {
            $("#trendWrapper").append(`
            <div class="trend-item border rounded p-3 mb-3">
                <button type="button" class="btn btn-danger btn-sm mt-4 float-end removeItem">X</button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="trending_discussions[${trendIndex}][title]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Replies</label>
                        <input type="number" name="trending_discussions[${trendIndex}][replies]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Views</label>
                        <input type="number" name="trending_discussions[${trendIndex}][views]" class="form-control">
                    </div>
                </div>
            </div>
        `);
            trendIndex++;
        });

        $("#addContrib").click(function() {
            $("#contribWrapper").append(`
            <div class="contrib-item border rounded p-3 mb-3">
                <button type="button" class="btn btn-danger btn-sm mt-4 float-end removeItem">X</button>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" name="contributors[${contribIndex}][name]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Image</label>
                        <input type="file" name="contributors[${contribIndex}][image]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Description</label>
                        <input type="text" name="contributors[${contribIndex}][posts]" class="form-control">
                    </div>
                </div>
            </div>
        `);
            contribIndex++;
        });

        $(document).on("click", ".removeItem", function() {
            $(this).closest('.feature-item, .trend-item, .contrib-item').remove();
        });


        var url = "{{ url('statement/fetch') }}/communities/0";
        var onDraw = function() {

        };
        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "title"
            },
            {
                "data": "subtitle"
            },
            {
                "data": "feature_heading"
            },
            {
                "data": "trending_heading"
            },
            {
                "data": "top_contributer_heading"
            },
            {
                "data": "cta_title"
            },
            {
                "data": "cta_subtitle"
            },
            {
                "data": "cta_button_text"
            },

            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == 'inactive') {
                        return `<span class="badge badge-danger">Inactive</span>`;
                    } else {
                        return `<span class="badge badge-success">Active</span>`;
                    }

                }
            },
            {
                "data": "id",
                render: function(data, type, full) {
                    return `<button class="btn btn-primary" onclick='editCommunity(${(full.id)})'>Edit</button>`;
                }
            }
        ];

        datatableSetup(url, options, onDraw);
    });


    function editCommunity(id) {

        $.ajax({
            url: `/community/edit/${id}`,
            type: "GET",
            success: function(res) {
                if (res.status) {

                    let d = res.data;

                    $("#id").val(d.id);
                    $("#title").val(d.title);
                    $("#subtitle").val(d.subtitle);
                    $("#feature_heading").val(d.feature_heading);
                    $("#discussion_heading").val(d.trending_heading);
                    $("#contributer_heading").val(d.top_contributer_heading);

                    $("#cta_title").val(d.cta_title);
                    $("#cta_subtitle").val(d.cta_subtitle);
                    $("#cta_button_text").val(d.cta_button_text);

                    $("#featureWrapper").html("");
                    let features = JSON.parse(d.feature_categories);

                    features.forEach((item, index) => {
                        $("#featureWrapper").append(`
                        <div class="feature-item border rounded p-3 mb-3">
                          <button type="button" class="btn btn-danger mt-4 btn-sm float-end removeItem">X</button>
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label>Title</label>
                                    <input type="text" name="feature_categories[${index}][title]" value="${item.title}" class="form-control">
                                </div>
                                <div class="col-md-5">
                                    <label>Description</label>
                                    <input type="text" name="feature_categories[${index}][description]" value="${item.description}" class="form-control">
                                </div>
                            </div>
                        </div>
                    `);
                    });

                    $("#trendWrapper").html("");
                    let trends = JSON.parse(d.trending_discussions);

                    trends.forEach((item, index) => {
                        $("#trendWrapper").append(`
                        <div class="trend-item border rounded p-3 mb-3">
                            <button type="button" class="btn btn-danger mt-4 btn-sm float-end removeItem">X</button>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Title</label>
                                    <input type="text" name="trending_discussions[${index}][title]" value="${item.title}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Replies</label>
                                    <input type="number" name="trending_discussions[${index}][replies]" value="${item.replies}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Views</label>
                                    <input type="number" name="trending_discussions[${index}][views]" value="${item.views}" class="form-control">
                                </div>
                            </div>
                        </div>
                    `);
                    });



                    $("#contribWrapper").html("");
                    let contributors = JSON.parse(d.contributors);

                    contributors.forEach((item, index) => {
                        $("#contribWrapper").append(`
                        <div class="contrib-item border rounded p-3 mb-3">
                         <button type="button" class="btn btn-danger mt-4 btn-sm float-end removeItem">X</button>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" name="contributors[${index}][name]" value="${item.name}" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Image</label>
                                    <input type="file" name="contributors[${index}][image]" class="form-control">

                                    <input type="hidden" name="contributors[${index}][old_image]" value="${item.image}">

                                    ${item.image ? `<img src="https://images.incomeowl.in/incomeowl/crm/images/${item.image}" class="mt-2 rounded" width="80">` : ""}
                                </div>

                                <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" name="contributors[${index}][posts]" value="${item.posts}" class="form-control">
                                </div>

                            </div>
                        </div>
                    `);
                    });


                    $("#communityModal").modal("show");
                }
            }
        });
    }
</script>
@endpush