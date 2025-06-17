@extends('layouts.app')

@section('content')
<h1>Chat with {{ $conversation->customer->name }}</h1>

<div style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
    @foreach ($messages as $message)
        <div style="margin-bottom: 10px;">
            <strong>{{ $message->sender->name }}:</strong>
            <p>{{ $message->body }}</p>

            @if(isset($message->meta['order_id']))
                <div style="background-color: #fef3c7; padding: 10px; border-radius: 8px; margin-top: 5px;">
                    <strong>Order Summary:</strong>
                    <br>
                    <a href="{{ route('orders.show', $message->meta['order_id']) }}">View Order #{{ $message->meta['order_id'] }}</a>
                </div>
            @endif
        </div>
    @endforeach
</div>

<form action="{{ route('chat.message.send', $conversation->id) }}" method="POST">
    @csrf
    <textarea name="body" rows="3" placeholder="Type your message..." style="width: 100%;"></textarea>
    <button type="submit" style="margin-top: 10px;">Send</button>
</form>
@endsection
