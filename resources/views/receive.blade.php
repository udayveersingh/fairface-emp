
@if(!empty($messages))

@foreach ($messages as $message)
    @if ($message->to_id == Auth::id() && $message->from_id == $user->id)
        <div class="message left">
            <img src="{{ asset('storage/employees/' . $message->from_user->avatar) }}" alt="Avatar">
            <p>{{ $message->body }}</p>
        </div>
    @elseif($message->from_id == Auth::id() && $message->to_id == $user->id)
        <div class="message right">
            <img src="{{ asset('storage/employees/' . $message->from_user->avatar) }}" alt="Avatar">
            <p>{{ $message->body }}</p>
        </div>
    @endif
@endforeach
@endif


<div class="left message">
    {{-- <img src="{{asset('storage/employees/'.$user->avatar)}}" alt="Avatar"> --}}
    {{-- <p>{{$message}}</p> --}}
  </div>

