@extends('layouts.backend')
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Company Document</h3>
        </div>
    </div>
@endsection
@section('content')
    <form action="{{ route('company-document') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Document Name<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="document_name" value="">
                    @if ($errors->has('document_name'))
                        <span class="text-danger">
                            {{ $errors->first('document_name') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Attachment</label>
                    <input class="form-control" name="attachment" type="file">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="submit-section">
                    <button type="submit" class="btn w-100 btn-primary" style="margin-top:-9px">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <!-- /Create Project Modal -->

    <div class="row">
        <div class="col-auto float-left mb-2">
            <h3>List</h3>
        </div>
        <div class="col-md-12">
            <div>
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Attachment</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($company_documents->count()))
                            @foreach ($company_documents as $document)
                                <tr>
                                    <td>{{ $document->name }}</td>
                                    @php
                                        $extension = pathinfo(
                                            storage_path(
                                                'storage/company/document/' .
                                                    $document->name .
                                                    '/' .
                                                    $document->attachment,
                                            ),
                                            PATHINFO_EXTENSION,
                                        );
                                    @endphp
                                    @if(!empty($document->attachment))
                                    <td>
                                        <a href="{{ asset('storage/company/document/' . $document->name . '/' . $document->attachment) }}"
                                            target="_blank">
                                            <img src="{{ asset('assets/img/profiles/download-file-icon-small.png') }}"
                                                width="35px" height="35px"></a>
                                    </td>
                                    @else
                                    <td>
                                      No Document
                                    </td>
                                    @endif
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a data-id="{{ $document->id }}" data-name="{{ $document->name }}"
                                                    data-attachment="{{ $document->attachment }}"
                                                    class="dropdown-item editbtn" href="javascript:void(0);"
                                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a data-id="{{ $document->id }}" class="dropdown-item deletebtn"
                                                    href="javascript:void(0);" data-toggle="modal"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <x-modals.delete :route="'company-document.destroy'" :title="'Company document'" />

                            <!-- Edit Company Document Modal -->
                            <div id="edit_company_document" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Company Document</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('company-document') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="edit_id" name="id">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Document Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control edit_name" name="document_name"
                                                                id="document_name" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Attachment</label>
                                                            <input class="form-control" name="attachment" type="file">
                                                        </div>
                                                        <div class="attachment"></div>
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
                            <!-- / Edit  Modal -->
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.editbtn').on('click', function() {
                $('#edit_company_document').modal('show');
                var id = $(this).data('id');
                var name = $(this).data('name');
                var attachment = $(this).data('attachment');
                $('#edit_id').val(id);
                $('#document_name').val(name);
                if (attachment) {
                    $('.attachment').html(
                        `<img src="{{ asset('storage/company/document/${name}/${attachment}') }}" width="50px" height="50px">`);
                } else {
                    $('.attachment').html('');
                }
            });
        });
    </script>
@endsection
