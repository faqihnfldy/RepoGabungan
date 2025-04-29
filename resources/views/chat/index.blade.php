@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('chat.index') }}" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-10">
                                <label for="user_id" class="form-label">Pilih Dokter</label>
                                <select name="user_id" id="user_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Pilih --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ (isset($selectedUserId) && $selectedUserId == $user->id) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->role }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    @if($selectedUserId)
                    <div class="chat-container" style="height: 400px; overflow-y: auto; margin-bottom: 20px;">
                        <div id="messages">
                            @foreach($messages as $message)
                                <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                    <strong>{{ $message->sender->name }}:</strong>
                                    <p>{{ $message->message }}</p>
                                    <small>{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <form id="chat-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" id="message" class="form-control" placeholder="Ketik pesan...">
                            <input type="hidden" name="receiver_id" id="receiver_id" value="{{ $selectedUserId }}">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                    @else
                        <div class="alert alert-info mt-3">Silakan pilih lawan chat terlebih dahulu.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .message {
        padding: 10px;
        margin: 5px;
        border-radius: 10px;
        max-width: 70%;
    }
    .sent {
        background-color: #007bff;
        color: white;
        margin-left: auto;
    }
    .received {
        background-color: #f8f9fa;
        margin-right: auto;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chat-form');
        const messagesContainer = document.getElementById('messages');
        const messageInput = document.getElementById('message');

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(chatForm);
            
            fetch('{{ route("chat.send") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const message = data.message;
                    const messageHtml = `
                        <div class="message sent">
                            <strong>${message.sender.name}:</strong>
                            <p>${message.message}</p>
                            <small>${new Date(message.created_at).toLocaleTimeString()}</small>
                        </div>
                    `;
                    messagesContainer.innerHTML += messageHtml;
                    messageInput.value = '';
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            });
        });

        // Auto-refresh messages every 5 seconds
        setInterval(function() {
            const receiverId = document.getElementById('receiver_id').value;
            fetch(`/chat/messages/${receiverId}`)
                .then(response => response.json())
                .then(messages => {
                    messagesContainer.innerHTML = '';
                    messages.forEach(message => {
                        const messageHtml = `
                            <div class="message ${message.sender_id == {{ auth()->id() }} ? 'sent' : 'received'}">
                                <strong>${message.sender.name}:</strong>
                                <p>${message.message}</p>
                                <small>${new Date(message.created_at).toLocaleTimeString()}</small>
                            </div>
                        `;
                        messagesContainer.innerHTML += messageHtml;
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        }, 5000);
    });
</script>
@endsection 