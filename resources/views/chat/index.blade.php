@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #ffd6a0, #fbc2eb);
        margin: 0;
        font-family: Arial, sans-serif;
        height: 100vh;
    }

    .container {
        display: flex;
        height: 100%;
    }

    .chat-list {
        width: 35%;
        background-color: #fff;
        border-radius: 15px;
        padding: 20px;
        margin: 10px;
        overflow-y: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h2 {
        margin: 0;
        font-size: 20px;
    }

    .chat-header small a {
        color: #007bff;
        text-decoration: none;
    }

    .chat-header .back-button {
        background-color: #731c2b;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
    }

    .chat-card {
        background-color: #731c2b;
        color: white;
        padding: 10px 15px;
        margin-top: 15px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
    }

    .chat-card .name {
        font-weight: bold;
        text-transform: uppercase;
    }

    .chat-card .message {
        font-size: 14px;
        color: #f8c9c9;
    }

    .chat-empty {
        margin-top: 20px;
        text-align: center;
        padding: 20px;
        background-color: #fbe6eb;
        color: #999;
        border-radius: 10px;
    }

    .chat-window {
        width: 65%;
        background-color: white;
        border-radius: 15px;
        margin: 10px 10px 10px 0;
        display: flex;
        flex-direction: column;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .chat-top {
        padding: 20px;
        background-color: #731c2b;
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-top img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .date {
        text-align: center;
        background-color: #731c2b;
        color: white;
        border-radius: 10px;
        padding: 6px 12px;
        margin: 10px auto;
        display: inline-block;
    }

    .message-left, .message-right {
        max-width: 70%;
        padding: 10px 15px;
        margin: 10px 0;
        border-radius: 15px;
        display: inline-block;
    }

    .message-left {
        background-color: #fff;
        border: 1px solid #ddd;
        align-self: flex-start;
    }

    .message-right {
        background-color: #fdd9d9;
        align-self: flex-end;
    }

    .message-input {
        display: flex;
        padding: 15px;
        border-top: 1px solid #ddd;
    }

    .message-input input {
        flex: 1;
        padding: 10px;
        border-radius: 20px;
        border: 1px solid #ccc;
    }

    .message-input button {
        background-color: #731c2b;
        border: none;
        padding: 10px 20px;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        margin-left: 10px;
    }
</style>

<div class="container">
    <!-- Left Chat List -->
    <div class="chat-list">
        <div class="chat-header">
            <div>
                <h2>Chat</h2>
                <small>Sort by <a href="#">Recently</a></small>
            </div>
            <a href="{{ route('home') }}" class="back-button">← Back</a>
        </div>

        @forelse ($conversations as $conversation)
            <a href="{{ route('chat.show', $conversation->id) }}" class="chat-card">
                <div>
                    <div class="name">{{ $conversation->customer->name }}</div>
                    <div class="message">{{ $conversation->messages->last()->message ?? 'No messages' }}</div>
                </div>
                <img src="{{ $conversation->customer->profile_picture_url ?? asset('default-avatar.png') }}"
                     alt="Profile" width="40" height="40" style="border-radius: 50%;">
            </a>
        @empty
            <div class="chat-empty">No chat available</div>
        @endforelse
    </div>

    <!-- Right Chat Window -->
    @if (isset($activeConversation))
    <div class="chat-window">
        <div class="chat-top">
            <img src="{{ $activeConversation->customer->profile_picture_url ?? asset('default-avatar.png') }}">
            <div>{{ $activeConversation->customer->name }}</div>
        </div>

        <div class="chat-messages">
            @if ($activeConversation->messages->isNotEmpty())
                <div class="date">{{ $activeConversation->messages->first()->created_at->format('d M Y') }}</div>
            @endif

            @foreach ($activeConversation->messages as $message)
                @if ($message->sender_type === 'customer')
                    <div class="message-left">{{ $message->message }}</div>
                @else
                    <div class="message-right">{{ $message->message }}</div>
                @endif
            @endforeach
        </div>

        <!-- Send Message -->
        <form class="message-input" method="POST" action="{{ route('chat.send', $activeConversation->id) }}">
            @csrf
            <input type="text" name="message" placeholder="Type message..." required>
            <button type="submit">➤</button>
        </form>
    </div>
    @else
    <div class="chat-window">
        <div class="chat-top">
            <div style="padding: 20px;">No chat selected</div>
        </div>
    </div>
    @endif
@endsection