<div id="change_profile_pic" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('employee-profile') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <input type="hidden" name="employee_id"
                                    value="{{ !empty($employee->user_id) ? $employee->user_id : '' }}">
                                <img class="inline-block"
                                    src="{{ !empty($employee->avatar) ? asset('storage/employees/' . $employee->avatar) : asset('assets/img/user.jpg') }}"
                                    alt="user">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input name="avatar" class="upload" type="file">
                                </div>
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
<!-- Employee Profile Modal --> 