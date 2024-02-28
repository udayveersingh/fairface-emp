@extends('layouts.backend')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/chat-style.css') }}">
    <div class="row">
        <div class="col-md-12">
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
                        {{-- @if (empty($messages)) --}}
                        @include('receive', ['message' => "Hey! What's up!  👋"])
                        {{-- @else --}}
                        {{-- @include('receive', [
                'message' => 'Ask a friend to open this link and you can chat with them!',
            ]) --}}

                        {{-- @include('receive', [
                    'message' => $messages,
                ]) --}}
                        {{-- @endif --}}
                    </div>
                    <!-- End Chat -->

                </div>
                <!-- Footer -->
                <div class="bottom">
                    {{-- @dd($from_id); --}}
                    <form style="display:flex; gap:10px;" id="chat-form">
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
        {{-- </body> --}}
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                var userID = $('#to_id').val();
                console.log(userID, "userID ");
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
                                var html =
                                    '<div class="message left"><img src="{{ asset('storage/employees/' . $user->avatar) }}" alt="Avatar"><p>' +
                                    data.message + '</p></div>';
                            };
                            $('.messages').append(html);
                        });

                });


                // Function to handle sending messages
                $('#chat-form').submit(function(event) {
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
                                '<div class="message right"><p><img src="{{ asset('storage/employees/' . Auth::user()->avatar) }}" alt="Profile picture">' +
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
            });
        </script>
    @endsection

    {{-- </html> --}}
