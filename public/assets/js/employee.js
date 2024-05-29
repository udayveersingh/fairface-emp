$(document).ready(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(this).attr('href'));
        test = $(this).attr('href');
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('[href="' + activeTab + '"]').tab('show');
    }
    if (activeTab == 'job') {
        console.log('job active');
    }

    // $(document).ready(function() {
    //     $('#documentform').on('submit', function(e) {
    //         e.preventDefault();
    //         alert(test);
    //         $.ajax({
    //             url: "{{ route('employee-document-update') }}",
    //             method: "POST",
    //             data: new FormData(this),
    //             dataType: 'JSON',
    //             contentType: false,
    //             cache: false,
    //             processData: false,
    //             success: function(dataResult) {
    //                 // location.reload();
    //             }
    //         });
    //     });
    // });

    $(document).on('click', '#employee_edit_btn', function () {
        console.log('edit clicked');
        $('#edit_employee_detail').modal("show");
    });

    console.log("Element ", $(document).find(".edit_btn").length);
    $(document).on('click', '#edit_btn', function () {
        console.log('edit clicked');
        $('#employee_job').modal("show");
        var id = $(this).data('id');
        var emp_id = $(this).data('employee_id');
        var job_title = $(this).data('job_title');
        var supervisor = $(this).data('supervisor');
        console.log(edit_supervisor, "edit_supervisor");
        var edit_timesheet_approval_inch = $(this).data('timesheet_approval_inch');
        var edit_department = $(this).data('department');
        var edit_work_email = $(this).data('work_email');
        var edit_work_phone_number = $(this).data('work_phone_number');
        var edit_start_date = $(this).data('start_date');
        var edit_end_date = $(this).data('end_date');
        var edit_job_type = $(this).data('job_type');
        var cont_weekly_hours = $(this).data('cont_weekly_hours');
        $('#edit_job_id').val(id);
        $('#employee_id').val(emp_id);
        $('#edit_job_title').val(job_title);
        $('#edit_supervisor').val(supervisor);
        $('#timesheet_approval_inch').val(edit_timesheet_approval_inch);
        $('#edit_department').val(edit_department);
        $('#edit_work_email').val(edit_work_email);
        $('#edit_phone_number').val(edit_work_phone_number);
        $('#edit_start_date').val(edit_start_date);
        $('#edit_end_date').val(edit_end_date);
        $('#edit_job_type').val(edit_job_type);
        $('#contracted_weekly_hours').val(cont_weekly_hours);
        $('.select').select2('destroy').select2();
    });


    // // payslip Form Submit action
    // $('#payslipform').on('submit', function(e) {
    //     e.preventDefault();
    //     var formData =  new FormData(this);
    //     $.ajax({
    //         url: "{{ route('employee-payslip-update') }}",
    //         method: "POST",
    //         data: new FormData(this),
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function(dataResult) {
    //             location.reload();
    //         }
    //     });
    // });


    //Edit Form of Visa
    $(document).on('click', '#edit_btn_visa', function () {
        $('#edit_employee_visa').modal('show');
        var id = $(this).data('id');
        var emp_id = $(this).data('employee_id');
        var visa_type = $(this).data('visa_type');
        var cos_number = $(this).data('cos_number');
        var cos_issue_date = $(this).data('cos_issue_date');
        var cos_expiry_date = $(this).data('cos_expiry_date');
        var visa_issue_date = $(this).data('visa_issue_date');
        var visa_expiry_date = $(this).data('visa_expiry_date');
        $('#edit_visa_id').val(id);
        $('#visa_employee_id').val(emp_id);
        $('#edit_visa_type').val(visa_type);
        $('#edit_cos_number').val(cos_number);
        $('#edit_cos_issue_date').val(cos_issue_date);
        $('#edit_cos_expiry_date').val(cos_expiry_date);
        $('#edit_visa_issue_date').val(visa_issue_date);
        $('#edit_visa_expiry_date').val(visa_expiry_date);
        $('.select').select2('destroy').select2();
    });

    //Edit form of Project
    $(document).on('click', '.edit_btn', function () {
        $('#edit_employee_project').modal('show');
        var id = $(this).data('id');
        var emp_id = $(this).data('employee_id');
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        var project = $(this).data('project');
        $('#edit_project_id').val(id);
        $('#project_employee_id').val(emp_id);
        $('#pro_edit_start_date').val(start_date);
        $('#pro_edit_end_date').val(end_date);
        $('#edit_project').val(project);
        $('.select').select2('destroy').select2();
    });

    //Edit Emergency contact form
    $(document).on('click', '#employee_contact_btn', function () {
        $('#edit_contact_detail').modal("show");
    });

    //Edit Employee Address form
    $(document).on('click', '#edit_btn_employee_address', function () {
        $('#edit_employee_address').modal("show");
        var id = $(this).data('id');
        var emp_id = $(this).data('employee_id');
        var address_line_1 = $(this).data('home_address_line_1');
        var address_line_2 = $(this).data('home_address_line_2');
        var post_code = $(this).data('post_code');
        var from_date = $(this).data('from_date');
        console.log(from_date, 'from_date');
        var to_date = $(this).data('to_date');
        $('#edit_emp_address_id').val(id);
        $('#address_employee_id').val(emp_id);
        $('.edit_address_line_1').text(address_line_1);
        $('.edit_address_line_2').val(address_line_2);
        $('.edit_post_code').val(post_code);
        $('.edit_from_date').val(from_date);
        $('.edit_to_date').val(to_date);
        $('.select').select2('destroy').select2();

    });

    //Edit Employee Bank Detail form
    $(document).on('click', '#employee_bank_btn', function () {
        $('#edit_bank_detail').modal("show");
    });


    $(".mask_phone_number").keyup(function () {
        // $(this).val($(this).val().replace(/^(\d{3})(\d{4})(\d{4})$/, "$1-$2-$3"));
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{4})$/, "(+) $1-$2-$3"));
    });

    // $(document).ready(function() {
    //     $('.select').select2();
    // });


    // $(".newDocument").hide();
    $(".selectDocument").on('change', function () {
        var selectedDocument = $(this).val();
        if (selectedDocument == "add new") {
            $(".newDocument").html(`<input type="text" name="new_document" value="" id="newDocument" required="" class="form-control">`)
        } else {
            $(".newDocument").html('');
        }
    });
});