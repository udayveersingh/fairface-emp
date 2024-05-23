<div class="row mt-3">
    <div class="col-md-12">
        <form id="documentform" method="POST" action="{{route('rlmt-document-update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
            <input type="hidden" id="edit_id" value="{{!empty($document->id) ? $document->id:'' }}" name="id">
            <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-form-label">Document Name<span class="text-danger">*</span></label>
                            <select name="document_name" id="edit_document" class="form-control select" required>
                                <option value="">Select document Name</option>
                                <option value="advert1">Advert1</option>
                                <option value="advert2">Advert 2</option>
                                <option value="interview notes1:">Interview notes 1:</option>
                                <option value="interview notes2:">Interview notes 2:</option>
                                <option value="shortlisted candidates:">Shortlisted candidates:</option>
                            </select>
                        </div>
                    </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-form-label">Attachment</label>
                        <input class="form-control" name="attachment" type="file">
                        <span class="text-danger">Please upload a valid document. Document size should be less than 2MB.</span>
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
<hr/> 
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0">
            <thead>
                <tr>
                    <thead>
                        <tr>
                            <th style="width: 30px;">Sr No.</th>
                            <th>Document Name</th>
                            <th>Created</th>
                            <th>Attachment</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                </tr>
            </thead>
            <tbody>
                @foreach ($rlmt_documents as $index=>$document)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$document->name}}</td>
                    <td>{{!empty($document->created_at) ? date("d-m-Y", strtotime($document->created_at)):''}}</td>
                    @php
                    $extension = pathinfo(storage_path('storage/rlmt/document/employee/'.$document->employee_id.'/'.$document->attachment), PATHINFO_EXTENSION);
                    @endphp
                    <td>
                        <a href="{{asset('storage/rlmt/document/employee/'.$document->employee_id.'/'.$document->attachment)}}" target="_blank"><img src="{{ asset('assets/img/profiles/download-file-icon-small.png')}}" width="35px" height="35px"></a>
                    </td>
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