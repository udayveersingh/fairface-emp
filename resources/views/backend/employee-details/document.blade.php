<div class="row mt-3">
    <div class="col-md-12">
        <form id="documentform" method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" id="edit_id" value="{{!empty($document->id) ? $document->id:'' }}" name="id">
            <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-form-label">Document Name</label>
                        <input class="form-control edit_name" name="name" type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-form-label">Attachment</label>
                        <input class="form-control" name="attachment" type="file">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="submit-section">
                        <button type="submit" id="submit" class="btn w-100 btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>Document Name</th>
                            <th>Created</th>
                            <th>Attachment</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee_documents as $document)
                <tr>
                    <td>{{$document->id}}</td>
                    <td>{{$document->name}}</td>
                    <td>{{!empty(date("Y-m-d", strtotime($document->created_at) ))? date("Y-m-d", strtotime($document->created_at)):''}}</td>
                    <td><a href="{{asset('storage/documents/employee/'.$document->employee_id.'/'.$document->attachment)}}" target="_blank"><img src="{{asset('storage/documents/employee/'.$document->employee_id.'/'.$document->attachment)}}" width="100px"></a></td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$document->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-target="#deletebtn" data-resource_data="Employee Document" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <x-modals.delete :route="'employee-document.destroy'" :title="'Employee document'" />
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#documentform').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('employee-document-update') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(dataResult) {
                    location.reload();
                }
            });
        });
    });
</script>