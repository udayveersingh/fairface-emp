<!DOCTYPE html>
<html lang="en"
    data-layout-mode="{{ !empty(app(App\Settings\ThemeSettings::class)->theme_color) ? app(App\Settings\ThemeSettings::class)->theme_color : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="_token" content="{{ csrf_token() }}" /> -->
    <title>{{ ucfirst(config('app.name')) }} - {{ ucfirst($title) }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ !empty(app(App\Settings\ThemeSettings::class)->favicon) ? asset('storage/settings/theme/' . app(App\Settings\ThemeSettings::class)->favicon) : asset('assets/img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Toastr Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- Toastify css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastify/src/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!--Chat Main -->

    <!-- Theme CSS -->
    <!-- Page Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/chat-style.css') }}"> --}}
    @yield('styles')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
   <script src="assets/js/html5shiv.min.js"></script>
   <script src="assets/js/respond.min.js"></script>
  <![endif]-->
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('includes.backend.header')
        <!-- /Header -->

        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::ADMIN)
        <!-- Sidebar -->
        @include('includes.backend.admin-sidebar')
        <!-- /Sidebar -->
        @else
        @include('includes.backend.sidebar')
        @endif

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            @yield('content_one')
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    @yield('page-header')
                </div>
                <!-- /Page Header -->
                {{--
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>Error!</strong> {{ $error }}.
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success! </strong>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Warning! </strong>{{ session('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif




            <!-- chat notification model -->
            <div class="modal custom-modal fade" id="chat_message_notification" role="dialog">
                <div class="modal-dialog modal-dialog-centered" width="900px">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="form-header">
                            <h3 class="mt-2"> <i class="fa fa-comments m-r-5"></i>Chat Notifications</h3>
                        </div>
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="card-scroll p-1">
                                    <div class="chat-info-box">
                                        {{-- <div class="media align-items-center">
                                                <a href="" class="avatar">
                                                </a>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title"></span>
                                                        <span class="noti-title">tested</span>
                                                    </p>
                                                </div> --}}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Starts -->
            @yield('content')
            <!-- /Content End -->

        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

</body>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Slimscroll JS -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<!--Daterangepicker Js -->
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<!-- Ck Editor -->
<script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- Toastify JS -->
<script src="{{ asset('assets/plugins/toastify/src/toastify.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>

<!--tags input -->
<script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('body').on('click', '.deletebtn', function() {
            $('#deletebtn').modal('show');
            var id = $(this).data('id');
            $('#delete_id').val(id);
        });

        // $('.alert').delay(10000).fadeOut();
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', '') }}";
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;

            case 'danger':
                toastr.error("{{ Session::get('message') }}");
                break;

        }
        @endif
    });
</script>

<!-- delete functionality of employee detail page -->
<script>
    $(document).ready(function() {
        $('.detail_delete').on('click', function() {
            $('#delete_modal').modal('show');
            var id = $(this).data('id');
            var resource_model = $(this).data('resource_data');
            console.log(id, resource_model);
            $('#delete_data').val(id);
            $('#resource_data').val(resource_model);
        })
    });

    $(".mask_phone_number").keyup(function() {
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{4})$/, "$1-$2-$3"));
    });

    $(document).ready(function() {
        $('.select').select2();
    });
    // 	$(window).on("ready", function(e) {
    // 	$.ajax({
    //  		type: 'POST',
    //  		async: false,
    //  		url: '/logout'
    //  	});
    // });
    // });
</script>
{{-- <script src="{{ asset('path/to/logout.js') }}"></script> --}}
<script>
    // $(window).on('unload', (function() {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', '/logout', true);
    //     xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    //     xhr.send();
    // }));


    // $(window).on('mouseout', (function() {
    //     window.onbeforeunload = ConfirmLeave;
    // }));

    // function ConfirmLeave() {
    //     return "";
    // }
    // var prevKey = "";
    // $(window).on("beforeunload", function() {
    //  runBeforeClose();
    // });

    // Function to handle sending messages
    // setInterval(function() {
        setTimeout(function() {
        $.ajax({
            url: "/show-chat-message",
            dataType: 'json',
            success: function(data) {
                $('.countNewMsg').html(data.count);
                if (data.count > 0) {
                    $('.CheckMessage').addClass('bell');
                }
                // console.log(data ,"data message");
                var html = "";
                $.each(data.newmessage, function(index, row) {
                    var UserID = row.from_user.id;
                    var url = "/chat-view/" + UserID;
                    var avatarImg = row.from_user.avatar;
                    $('.message_chat_view').attr('href',url);
                });

                // $('.getChatMessage').html(html);
            }
        });
    }, 3000);
</script>







@yield('scripts')

</html>