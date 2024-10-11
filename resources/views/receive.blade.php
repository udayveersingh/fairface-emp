@if (!empty($messages) && !empty($user))
    @foreach ($messages as $message)
        @if ($message->to_id == Auth::id() && $message->from_id == $user->id)
            <div class="message left">
                @if (file_exists(public_path().'storage/employees/'. $message->from_user->avatar))
                    <img src="{{ asset('storage/employees/'. $message->from_user->avatar) }}" alt="Avatar">
                @else
                    <img src="{{ asset('assets/img/user.jpg')}}" alt="Avatar">
                @endif
                <p>{{ $message->body }}</p><br>
                <p><span class="date">{{$message->created_at->diffForHumans();}}</span><p>
            </div>
        @elseif($message->from_id == Auth::id() && $message->to_id == $user->id)
            <div class="message right">
                @if (file_exists(public_path().'storage/employees/'. $message->from_user->avatar))
                <img src="{{ asset('storage/employees/'. $message->from_user->avatar) }}" alt="Avatar">
            @else
                <img src="{{ asset('assets/img/user.jpg')}}" alt="Avatar">
            @endif
                {{-- @if(!empty($message->from_user->avatar))
                <img src="{{ asset('storage/employees/' . $message->from_user->avatar) }}" alt="Avatar">
                @else
                <img src="{{ asset('assets/img/user.jpg') }}" alt="Avatar">
                @endif --}}
                <p>{{ $message->body }}</p><br>
                <p><span class="date">{{$message->created_at->diffForHumans();}}</span><p>
            </div>
        @endif
    @endforeach
@endif

<div class="left message">

</div>
