@extends('layouts.backend')


@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection


@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Users</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add
                User</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="javascript:void(0)" class="avatar"><img
                                                src="{{ !empty(auth()->user()->avatar) ? asset('storage/users/' . $user->avatar) : asset('assets/img/user.jpg') }}"
                                                alt="user"></a>
                                        {{ $user->name }}
                                    </h2>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                @php
                                    $role = $query = DB::table('roles')
                                        ->where('id', '=', $user->role_id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                                @endphp
                                <td>{{ $role->name }}</td>
                                <td>{{ date_format(date_create($user->created_at), 'd M, Y') }}</td>
                                @php
                                    $employee = App\Models\Employee::where('user_id', '=', $user->id)->first();
                                @endphp
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="javascript:void(0)" class="action-icon dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false"><i
                                                class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}" data-emp_id="{{!empty($employee->id) ? $employee->id:''}}" data-firstname="{{!empty($employee->firstname) ? $employee->firstname:'' }}" data-lastname="{{!empty($employee->lastname) ? $employee->lastname:''}}" data-employee_id="{{!empty($employee->employee_id) ? $employee->employee_id:'' }}" data-marital_status="{{!empty($employee->marital_status) ? $employee->marital_status:''}}" data-record_status="{{!empty($employee->record_status) ? $employee->record_status:'' }}" data-nationality="{{!empty($employee->country_id)? $employee->country_id:'' }}" data-email="{{ $user->email }}" data-role="{{$role->name}}" class="dropdown-item editbtn" href="javascript:void(0)"
                                                data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-id="{{ $user->id }}" class="dropdown-item deletebtn"
                                                href="javascript:void(0)" data-toggle="modal"><i
                                                    class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="{{ route('users') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="firstname" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="lastname" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <input class="form-control" name="avatar" type="file">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input class="form-control" name="username" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" name="email" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role<span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control">
                                        <option value="">Select to</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input class="form-control" name="employee_id" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <select name="marital_status" class="form-control">
                                        <option value="">Select Marital Status</option>
                                        <option value="married">Married</option>
                                        <option value="unmarried">Unmarried</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Record Status <span class="text-danger">*</span></label>
                                    <select name="record_status" class="form-control">
                                        <option value="">Select Record Status</option>
                                        <option value="active">Active</option>
                                        <option value="archieve">Archieve</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <select name="nationality" class="form-control">
                                        <option value="">Select Nationality</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" type="password">
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add User Modal -->

    <!-- Edit User Modal -->
    <div id="edit_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('users') }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="id" id="edit_id">
                            <input type="hidden" name="emp_id" id="emp_id">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input class="form-control edit_firstname" name="firstname" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control edit_lastname" name="lastname" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <input class="form-control edit_avatar" name="avatar" type="file">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input class="form-control edit_username" name="username" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control edit_email" name="email" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role<span class="text-danger">*</span></label>
                                    <select name="role_id" selected="selected" id="role_id" class="form-control">
                                        <option value="">Select to</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input class="form-control employee_id" name="employee_id" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <select name="marital_status" class="form-control marital_status">
                                        <option value="">Select Marital Status</option>
                                        <option value="married">Married</option>
                                        <option value="unmarried">Unmarried</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Record Status <span class="text-danger">*</span></label>
                                    <select name="record_status" class="form-control record_status">
                                        <option value="">Select Record Status</option>
                                        <option value="active">Active</option>
                                        <option value="archieve">Archieve</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <select name="nationality" class="form-control nationality">
                                        <option value="">Select Nationality</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control edit_password" name="password" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control edit_password" name="password_confirmation"
                                        type="password">
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit User Modal -->
    <x-modals.delete :route="'users'" :title="'User'" />
@endsection


@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', function() {
                $('#edit_user').modal('show');
                var id = $(this).data('id');
                var emp_id = $(this).data('emp_id');
                console.log(emp_id , 'emp_id');
                var name = $(this).data('name');
                var firstname = $(this).data('firstname');
                var lastname = $(this).data('lastname');
                var username = $(this).data('username');
                var email = $(this).data('email');
                var role_id = $(this).data('role');
                console.log(role_id,"role_id");
                var employee = $(this).data('employee_id');
                var marital_status = $(this).data('marital_status');
                var record_status = $(this).data('record_status');
                var nationality_id = $(this).data('nationality');
                $('#edit_id').val(id);
                $('#emp_id').val(emp_id);
                $('.edit_name').val(name);
                $('.edit_firstname').val(firstname);
                $('.edit_lastname').val(lastname);
                $('.edit_username').val(username);
                $('.edit_email').val(email);
                $('#role_id').val(role_id);
                $('.employee_id').val(employee);
                $('.marital_status').val(marital_status);
                $('.record_status').val(record_status);
                $('.nationality').val(nationality_id);
            });
        });
    </script>
@endsection
