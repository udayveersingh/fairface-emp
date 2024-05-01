@if (!empty($messages))
    @foreach ($messages as $message)
        @if ($message->to_id == Auth::id() && $message->from_id == $user->id)
            <div class="message left">
                <img src="{{ asset('storage/employees/' . $message->from_user->avatar) }}" alt="Avatar">
                <p>{{ $message->body }}</p>
            </div>
        @elseif($message->from_id == Auth::id() && $message->to_id == $user->id)
            <div class="message right">
                @if(!empty($message->from_user->avatar))
                <img src="{{ asset('storage/employees/' . $message->from_user->avatar) }}" alt="Avatar">
                @else
                <img src="{{ asset('assets/img/user.jpg') }}" alt="Avatar">
                @endif
                <p>{{ $message->body }}</p>
            </div>
        @endif
    @endforeach
@endif

<div class="left message">

</div>
