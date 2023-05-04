@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Emergency Contact</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_emergency_contact"><i class="fa fa-plus"></i> Add Employee Emergency Contact</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div>
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Relationship</th>
                        <th>Overseas Name</th>
                        <th>Overseas Phone Number</th>
                        <th>Overseas Relationship</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($emergency_contacts->count()))
                    @foreach ($emergency_contacts as $emergency)
                    <tr>
                        <td>{{$emergency->id}}</td>
                        <td>{{$emergency->full_name}}</td>
                        <td>{{$emergency->phone_number_1}}</td>
                        <td>{{$emergency->relationship}}</td>
                        <td>{{$emergency->overseas_full_name}}</td>
                        <td>{{$emergency->overseas_phone_number_1}}</td>
                        <td>{{$emergency->overseas_relationship}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$emergency->id}}" data-fullname="{{$emergency->full_name}}" data-address="{{$emergency->address}}" data-phone_num_1="{{$emergency->phone_number_1}}" data-phone_num_2="{{$emergency->phone_number_2}}" data-relationship="{{$emergency->relationship}}" data-overseas_name="{{$emergency->overseas_full_name}}" data-overseas_address="{{$emergency->overseas_address}}" data-overseas_num_1="{{$emergency->overseas_phone_number_1}}" data-overseas_phone_num_2="{{$emergency->overseas_phone_number_2}}" data-overseas_relationship="{{$emergency->overseas_relationship}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$emergency->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'emergency-contact.destroy'" :title="'Emergency Contact'"/>
                    <!-- Edit Emergency contact Modal -->
                    <div id="edit_emergency_contact" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Emergency Contact</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('emergency-contact.update')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Full Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="name" id="edit_name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number 1</label>
                                                    <input class="form-control" name="phone_number_1" id="edit_phone_number_1" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number 2</label>
                                                    <input class="form-control" name="phone_number_2" id="edit_phone_number_2" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Relationship</label>
                                                    <input class="form-control" name="relationship" id="relationship" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Address<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_address" name="address" rows="4" cols="50"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Overseas Full Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="overseas_name" id="edit_overseas_name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Overseas Phone Number 1</label>
                                                    <input class="form-control" name="overseas_phone_number_1" id="edit_overseas_phone_number_1" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Overseas Phone Number 2</label>
                                                    <input class="form-control" name="overseas_phone_number_2" id="edit_overseas_phone_number_2" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Overseas Relationship</label>
                                                    <input class="form-control" name="overseas_relationship" id="overseas_relationship" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Overseas Address<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_overseas_address" name="overseas_address" rows="4" cols="50"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Edit Emergency Contact Modal -->
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Emergency Contact Modal -->
<div id="add_emergency_contact" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Emergency Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('emergency-contact.store')}}" method="POST">
                    @csrf
                    <div class="row">
                    <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Full Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="name" id="edit_name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number 1</label>
                                <input class="form-control" name="phone_number_1" id="edit_phone_number_1" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number 2</label>
                                <input class="form-control" name="phone_number_2" id="edit_phone_number_2" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Relationship</label>
                                <input class="form-control" name="relationship" id="relationship" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_address" name="address" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Overseas Full Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="overseas_name" id="edit_overseas_name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Overseas Phone Number 1</label>
                                <input class="form-control" name="overseas_phone_number_1" id="edit_overseas_phone_number_1" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Overseas Phone Number 2</label>
                                <input class="form-control" name="overseas_phone_number_2" id="edit_overseas_phone_number_2" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Overseas Relationship</label>
                                <input class="form-control" name="overseas_relationship" id="overseas_relationship" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Overseas Address<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_overseas_address" name="overseas_address" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  Add Emergency Contact Modal -->
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.table').on('click', '.editbtn', function() {
            $('#edit_emergency_contact').modal('show');
            var id = $(this).data('id');
            var edit_full_name = $(this).data('fullname');
            var edit_phone_number_1 = $(this).data('phone_num_1');
            var edit_phone_number_2 = $(this).data('phone_num_2');
            var edit_relationship = $(this).data('relationship');
            var edit_address = $(this).data('address');
            var edit_overseas_name = $(this).data('overseas_name');
            var edit_overseas_num_1 = $(this).data('overseas_num_1');
            var edit_overseas_num_2 = $(this).data('overseas_phone_num_2');
            var edit_overseas_relationship = $(this).data('overseas_relationship');
            var edit_overseas_address = $(this).data('overseas_address');
            $('#edit_id').val(id);
            $('#edit_name').val(edit_full_name);
            $('#edit_phone_number_1').val(edit_phone_number_1);
            $('#edit_phone_number_2').val(edit_phone_number_2);
            $('#relationship').val(edit_relationship);
            $('#edit_address').val(edit_address);
            $('#edit_overseas_name').val(edit_overseas_name);
            $('#edit_overseas_phone_number_1').val(edit_overseas_num_1);
            $('#edit_overseas_phone_number_2').val(edit_overseas_num_2);
            $('#overseas_relationship').val(edit_overseas_relationship);
            $('#edit_overseas_address').val(edit_overseas_address);
        });
    });
</script>
@endsection