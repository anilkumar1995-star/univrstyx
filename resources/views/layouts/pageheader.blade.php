@if (
    !Request::is('dashboard-new') &&
        !Request::is('dashboard') &&
        !Request::is('chat') &&
        !Request::is('profile/*') &&
        !Request::is('profile') &&
        !Request::is('profile/*'))

    <form id="searchForm">
        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

            <div class="d-flex align-items-center flex-wrap row-gap-2">

                <div class="d-flex gap-1 align-items-center dataTables_filter" id="user_list_datatable_info">

                    @if (isset($mystatus))
                        <input type="hidden" name="status" value="{{ $mystatus }}">
                    @endif
                    <div class="row">
                            {{-- @if (Myhelper::hasRole('admin'))
                        <div class="form-group col-md-2">
                            <input class="form-control mydate mt-1" name="from_date" type="text" autocomplete="off"
                                placeholder="From Date" />
                        </div>

                        <div class="form-group col-md-2">
                            <input class="form-control mydate mt-1" name="to_date" type="text" autocomplete="off"
                                placeholder="To Date" />
                        </div>
                        @else --}}
                        <div class="form-group col-md-3">
                            <input class="form-control mydate mt-1" name="from_date" type="text" autocomplete="off"
                                placeholder="From Date" />
                        </div>

                        <div class="form-group col-md-3">
                            <input class="form-control mydate mt-1" name="to_date" type="text" autocomplete="off"
                                placeholder="To Date" />
                        </div>
                        {{-- @endif --}}
                       @if (Request::is('tickets*'))
                               @if (Myhelper::hasRole('admin'))
                            <div class="form-group col-md-2">
                       @php
                            $selectedDepartment = $_GET['department'] ?? '';
                            if ($selectedDepartment === 'Help ') {
                                $selectedDepartment = 'Help & Support';
                            }
                        @endphp

                        <select class="form-control mydate mt-1" name="department_id" id="department_id">
                            <option value="">--Select Department--</option>
                            @foreach ($department as $dep)
                                <option value="{{ $dep->department_name }}"
                                    data-department-id="{{ $dep->id }}"
                                    data-department-name="{{ $dep->department_name }}"
                                    data-id="{{ $dep->id }}"
                                    {{ $dep->department_name == $selectedDepartment ? 'selected' : '' }}>
                                    {{ $dep->department_name }}
                                </option>
                            @endforeach
                        </select>
                            </div>

                            <div class="form-group col-md-2">
                                <select class="form-control mydate mt-1" name="status" id="status">
                                    <option value="">--Select Status--</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Open">Open</option>
                                    <option value="Accept">Accept</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                           @endif 
                            {{-- Hidden search field when on tickets* route --}}
                          <div class="col-sm-3">
                                <div class="icon-form mb-3 mb-sm-0">
                                    <span class="form-icon"><i class="ti ti-search me-2"></i></span>
                                    <input type="text" name="searchtext" class="form-control mt-1" placeholder="Search Value">
                                </div>
                            </div>
                        @else
                            {{-- Visible search field on other routes --}}
                            <div class="col-sm-3">
                                <div class="icon-form mb-3 mb-sm-0">
                                    <span class="form-icon"><i class="ti ti-search me-2"></i></span>
                                    <input type="text" name="searchtext" class="form-control mt-1" placeholder="Search Value">
                                </div>
                            </div>
                        @endif
                        @if (isset($status))
                            <div class="form-group col-md-3">
                                <label for="exampleInputdate5">Status</label>

                                <select name="status" class="form-select mt-1" aria-label="Status">
                                    <option value="">Select status
                                    </option>
                                    @if (isset($status['data']) && sizeOf($status['data']) > 0)
                                        @foreach ($status['data'] as $key => $value)
                                            <option value="{{ $key }}" >
                                                {{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
            <div class="d-flex align-items-center flex-wrap row-gap-2">
                <div class="form-sorts dropdown me-2">
                    <div class="user-list-files d-flex search-button">
                        <button type="submit" class="btn btn-success">
                            Filter &nbsp;
                            <i class="ti ti-filter-share"></i></button>
                        <button type="button" class="btn btn-primary ms-3" id="formReset">Refresh
                            &nbsp;<i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>

                </div>

            </div>
        </div>
    </form>


    <div id="helpModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-slate">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <h6 class="modal-title">Help Desk</h6>
                </div>
                <div class="modal-body no-padding">
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <th>Support Number</th>
                                <td>{{ $mydata['supportnumber'] }}</td>
                            </tr>
                            <tr>
                                <th>Support Email</th>
                                <td>{{ $mydata['supportemail'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endif
