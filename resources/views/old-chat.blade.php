@extends('layouts.backend')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/chat-style.css') }}">
    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
        <div class="row">
            <div class="col-md-3">
                <div class="card flex-fill" style="height: 35rem;">
                    <div class="card-body">
                        <h4 class="card-title">Online Users<span class="badge bg-inverse-danger ml-2"></span></h4>
                        <div class="card-scroll p-1 chat-card-scroll">
                            @foreach ($today_logs as $log)
                                @php
                                    $login_date = '';
                                    $current_date = date('Y-m-d');
                                    $login_date = date('Y-m-d', strtotime($log->date_time));
                                @endphp
                                <div class="d-flex gap-3 align-items-center justify-content-between mb-3">


                                    <div class="user-chat-info-box user-chat-btn px-3 m-0 flex-auto w-100"
                                        data-from_id="{{ Auth::user()->id }}" data-to_id="{{ $log->user_id }}">
                                        <div class="media align-items-center">
                                            <a href="#">
                                                {{-- <img
                                                src="{{ !empty($log->avatar) ? asset('storage/employees/' . $log->avatar) : asset('assets/img/user.jpg') }}"> --}}
                                                {{-- <div class="media-body"> --}}
                                                <div class="online-dot-icon">
                                                    @if (!empty($log->status == '1') && !empty($login_date) && $login_date == $current_date)
                                                        <div class="noti-dot text-success"></div>
                                                    @else
                                                        <div class="noti-dot text-danger"></div>
                                                    @endif
                                                </div>
                                                <p class="noti-details"><span class="noti-title">{{ $log->username }}</span>
                                                </p>
                                                {{-- </div> --}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ml-2 flex-0 d-flex">

                                        <i class="fa fa-comments"></i>
                                        <sup class="text-danger" id="counter_{{ $log->user_id }}"></sup>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="welcome-box p-1" style="margin:0px;">
                    <div class="welcome-image pr-2">
                        <img src="{{ !empty(auth()->user()->avatar) ? asset('storage/employees/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"
                            alt="user">
                    </div>
                    <div class="welcome-det">
                        <h4>Welcome,{{ Auth::user()->name }}</h4>
                        @php
                            $date = Carbon\Carbon::now();
                            $formatedDate = $date->format('l' . ',' . 'd M Y');
                        @endphp
                        <p>{{ $formatedDate }}</p>
                    </div>
                </div>
                <div class="chat">

                    <div class="chat-section">
                        <!-- Header -->
                        <div class="top">
                            <img src="{{ asset('storage/employees/' . $user->avatar) }}" width="50px;" height="50px;"
                                alt="Avatar">
                            <div>
                                <p>{{ ucFirst($user->name) }}</p>
                                <small>Online</small>
                            </div>
                        </div>
                        <!-- End Header -->
                        <div class="card-scroll p-1">

                            <!-- Chat -->
                            <div class="messages">
                                @include('receive', ['message' => "Hey! What's up!  👋"])
                            </div>
                            <!-- End Chat -->

                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="bottom">
                        {{-- @dd($from_id); --}}
                        <form style="display:flex; gap:10px;" class="chat-form">
                            <input type="text" id="message" name="message" placeholder="Enter message..."
                                autocomplete="off">
                            <input type="hidden" id="from_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" id="to_id" value="{{ $user->id }}">
                            {{-- <input type="hidden" id="receiver_user"
                    value="{{ !empty($from_id->from_id) ? $from_id->from_id : '' }}"> --}}
                            <button id="send-message" class="btn btn-sm btn-primary" type="submit"><i
                                    class="fa fa-paper-plane mt-2"></i></button>
                        </form>
                    </div>
                    <!-- End Footer -->

                </div>
            </div>
        @else
            <div class="row">
            <div class="col-md-3">
                <div class="card flex-fill" style="height: 35rem;">
                    <div class="card-body">
                        <h4 class="card-title">Online Users<span class="badge bg-inverse-danger ml-2"></span></h4>
                        <div class="card-scroll p-1 chat-card-scroll">
                            @foreach ($today_logs as $log)
                                @php
                                    $login_date = '';
                                    $current_date = date('Y-m-d');
                                    $login_date = date('Y-m-d', strtotime($log->date_time));
                                @endphp
                                <div class="d-flex gap-3 align-items-center justify-content-between mb-3">


                                    <div class="user-chat-info-box user-chat-btn px-3 m-0 flex-auto w-100"
                                        data-from_id="{{ Auth::user()->id }}" data-to_id="{{ $log->user_id }}">
                                        <div class="media align-items-center">
                                            <a href="#">
                                                {{-- <img
                                                src="{{ !empty($log->avatar) ? asset('storage/employees/' . $log->avatar) : asset('assets/img/user.jpg') }}"> --}}
                                                {{-- <div class="media-body"> --}}
                                                <div class="online-dot-icon">
                                                    @if (!empty($log->status == '1') && !empty($login_date) && $login_date == $current_date)
                                                        <div class="noti-dot text-success"></div>
                                                    @else
                                                        <div class="noti-dot text-danger"></div>
                                                    @endif
                                                </div>
                                                <p class="noti-details"><span class="noti-title">{{ $log->username }}</span>
                                                </p>
                                                {{-- </div> --}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ml-2 flex-0 d-flex">

                                        <i class="fa fa-comments"></i>
                                        <sup class="text-danger" id="counter_{{ $log->user_id }}"></sup>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
                <div class="col-md-9">
                    <div class="welcome-box" style="margin:0px;">
                        <div class="welcome-img">
                            <img src="{{ !empty(auth()->user()->avatar) ? asset('storage/employees/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"
                                alt="user">
                        </div>
                        <div class="welcome-det">
                            <h3>Welcome,{{ Auth::user()->name }}</h3>
                            @php
                                $date = Carbon\Carbon::now();
                                $formatedDate = $date->format('l' . ',' . 'd M Y');
                            @endphp
                            <p>{{ $formatedDate }}</p>
                        </div>
                    </div>
                    <div class="chat">
                        <!-- Header -->
                        <div class="top">
                            @if(!empty($user->avatar))
                            <img src="{{ asset('storage/employees/' . $user->avatar) }}" width="50px;" height="50px;"
                                alt="Avatar">
                                @else
                                <img src="{{ asset('assets/img/placeholder_image.jpg') }}" width="50px;" height="50px;"
                                alt="Avatar">
                                @endif
                            <div>
                                <p>{{ ucFirst($user->name) }}</p>
                                <small>Online</small>
                            </div>
                        </div>
                        <!-- End Header -->
                        <div class="card-scroll p-1">

                            <!-- Chat -->
                            <div class="messages">
                                @include('receive', ['message' => "Hey! What's up!  👋"])
                            </div>
                            <!-- End Chat -->

                        </div>
                        <!-- Footer -->
                        <div class="bottom">
                            {{-- @dd($from_id); --}}
                            <form style="display:flex; gap:10px;" class="chat-form">
                                <input type="text" id="message" name="message" placeholder="Enter message..."
                                    autocomplete="off">
                                <input type="hidden" id="from_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" id="to_id" value="{{ $user->id }}">
                                {{-- <input type="hidden" id="receiver_user"
                        value="{{ !empty($from_id->from_id) ? $from_id->from_id : '' }}"> --}}
                                <button id="send-message" class="btn btn-sm btn-primary" type="submit"><i
                                        class="fa fa-paper-plane mt-2"></i></button>
                            </form>
                        </div>
                        <!-- End Footer -->

                    </div>
                </div>
    @endif
    {{-- </body> --}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var userID = $('#to_id').val();
            // const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            //     cluster: 'ap2'
            // });

            Pusher.logToConsole = true;

            var PUSHER_APP_KEY = '{{ env('PUSHER_APP_KEY') }}';
            var pusher = new Pusher(PUSHER_APP_KEY, {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });


            const channel = pusher.subscribe('public');
            // Function to handle receiving messages
            channel.bind('chat', function(data) {
                console.log(data, "data");
                $.post("/receive", {
                        _token: '{{ csrf_token() }}',
                        message: data.message,
                        userID: userID,
                    })
                    .done(function(res) {
                        var ToID = userID;
                        var LoginUser = '{{ Auth::user()->id }}';
                        if (LoginUser == data.to_id && userID == data.from_id) {
                            var html ='<div class="message left">@if (file_exists(public_path().'storage/employees/'. $user->avatar))'+
                            '<img src="{{ asset('storage/employees/'. $user->avatar) }}" alt="Avatar">'+
                            '@else<img src="{{ asset('assets/img/user.jpg')}}" alt="Avatar">@endif<p>' +
                                data.message + '</p></div>';
                        };
                        MessageCounter();
                        $('.messages').append(html);
                    });

            });


            // Function to handle sending messages
            $('.chat-form').submit(function(event) {
                event.preventDefault();
                let message = $('#message').val();

                if (message == '') {
                    alert('Please enter message')
                    return false;
                }
                $.ajax({
                    url: "/broadcast",
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: message,
                        from_id: $('#from_id').val(),
                        to_id: $('#to_id').val(),
                    },
                    success: function(res) {
                        // Append the sent message to the chat interface
                        $('.messages').append(
                            '<div class="message right"><p>@if (file_exists(public_path().'storage/employees/'. Auth::user()->avatar))'+
                            '<img src="{{ asset('storage/employees/'. Auth::user()->avatar) }}" alt="Avatar">'+
                            '@else<img src="{{ asset('assets/img/user.jpg')}}" alt="Avatar">@endif' +
                            $('#message')
                            .val() +
                            '</p></div>'
                        );
                        $('#message').val(''); // Clear the message input field after sending
                        $(document).scrollTop($(document)
                            .height()); // Scroll to the bottom of the chat
                        // setTimeout(function() {

                        // }, 500);
                    }
                });
            });


            $(".user-chat-btn").on("click", function() {
                var from_id = $(this).data('from_id');
                var to_id = $(this).data('to_id');
                $('#from_id').val(from_id);
                $('#to_id').val(to_id);
                console.log(from_id, to_id, "from_id", "to_id");
                $.ajax({
                    url: '/chat/' + to_id,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.user.avatar);
                        let avatarIMG = data.user.avatar;
                        let username = data.user.name;
                        let messages = data.messages;
                        console.log(messages, "message");
                        var chatHtml =
                            `<div class="chat"><div class="top"><img src="{{ asset('storage/employees/${avatarIMG}') }}" width="50px;" height="50px;"
                            alt="Avatar"><div><p>${username}</p><small>Online</small></div></div><div class="card-scroll p-1">`;
                        chatHtml += `<div class="messages">`;
                        $.each(data.messages, function(index, row) {
                            if (row.to_id == data.loginUser && row.from_id == data.user
                                .id) {
                                chatHtml +=
                                    `<div class="message left"><img src="{{ asset('storage/employees/${row.from_user.avatar}') }}" alt="Avatar"><p>${row.body}</p></div>`;
                            } else if (row.from_id == data.loginUser && row.to_id ==
                                data.user.id) {
                                chatHtml +=
                                    `<div class="message right"><img src="{{ asset('storage/employees/${row.from_user.avatar}') }}" alt="Avatar"><p>${row.body}</p></div>`
                            }
                        });
                        chatHtml += `<div class="left message"></div></div></div></div>`;
                        $('.chat-section').html(chatHtml);
                    },
                });
                MessageCounter();
            });



            // var array = [];
            // $(".user-chat-btn").each(function() {
            //     array.push($(this).data("to_id"));
            // });

            // console.log(array, "array");





            // $("#result").append("Results "+array.join(","))



            //   setInterval(function() {
            // setTimeout(function() {

            function MessageCounter() {
                $(".user-chat-btn").each(function() {
                    $.ajax({
                        url: "/chat-message-counter",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            to_id: $(this).data("to_id"),
                        },
                        success: function(data) {
                            console.log(data, "data data")
                            console.log(data.message_counter);
                            $('#counter_' + data.to_id).html(data.message_counter);
                        }
                    });
                    // }, 3000);
                });
            };
        });
    </script>
@endsection

{{-- </html> --}}
