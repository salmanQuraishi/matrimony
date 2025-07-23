<x-app-layout>
    @include('chat.style')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <section class="msger">
                        <header class="msger-header">
                            <div class="msger-header-title">
                                <i class="fas fa-comment-alt"></i> {{$userData->name}}
                            </div>
                        </header>

                        <main class="msger-chat" id='chatSection'></main>
 
                        <div class="msger-inputarea">
                            <input type="text" hidden id='receiver_id' value="{{$userData->id}}">
                            <input type="text" class="msger-input" placeholder="Enter your message..." id='message'>
                            <button class="msger-send-btn" onclick="broadcastMethod()">Send</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/bootstrap.js')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let receiverId = $('#receiver_id').val();
        
        $.get(`/chat/messages/${receiverId}`, function (messages) {

            messages.forEach(msg => {
                let isSender = msg.sender_id == {{ auth()->id() }};
                let userImg = isSender
                    ? 'https://cdn-icons-png.flaticon.com/128/149/149071.png'
                    : 'https://cdn-icons-png.flaticon.com/128/3135/3135715.png';

                let newMessage = `
                <div class="msg ${isSender ? 'right-msg' : 'left-msg'}">
                    <div class="msg-img" style="background-image: url(${userImg})"></div>
                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">${isSender ? 'You' : msg.sender.name || msg.sender.name}</div>
                            <div class="msg-info-time">${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
                        </div>
                        <div class="msg-text">
                            ${msg.message}
                        </div>
                    </div>
                </div>
            `;
            $("#chatSection").append(newMessage);
            });
        });
    });
    setTimeout(() => {
        window.Echo.channel('chatMessage')
            .listen('chat', (e) => {

                let newMessage = '';

                if (e.receiver_id == $("#receiver_id").val()) {
                    newMessage = `
                    <div class="msg left-msg">
                        <div class="msg-img" style="background-image: url(https://cdn-icons-png.flaticon.com/128/3135/3135715.png)"></div>
                        <div class="msg-bubble">
                            <div class="msg-info">
                                <div class="msg-info-name">${e.username}</div>
                                <div class="msg-info-time">12:45</div>
                            </div>
                            <div class="msg-text">
                                ${e.message}
                            </div>
                        </div>
                    </div>
                    `;
                } else {
                    newMessage = `
                    <div class="msg right-msg">
                        <div class="msg-img" style="background-image: url(https://cdn-icons-png.flaticon.com/128/149/149071.png)"></div>
                        <div class="msg-bubble">
                            <div class="msg-info">
                                <div class="msg-info-name">${e.username}</div>
                                <div class="msg-info-time">12:45</div>
                            </div>
                            <div class="msg-text">
                                ${e.message}
                            </div>
                        </div>
                    </div>
                    `;
                }

                console.log('Received:', e.username);
                $("#chatSection").append(newMessage);
            });
    }, 100);

    function broadcastMethod() {
        $.ajax({
            url: '{{ route("chat.broadcast") }}',
            type: 'POST',
            data: { receiver_id: $('#receiver_id').val(), message: $('#message').val() },
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            success: function (response) {
                $('#message').val('');
            }
        });
    }
</script>