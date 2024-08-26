@extends('admin.app')
@section('styles')
    <link rel="stylesheet" href="/admin/css/chat.css">

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel='stylesheet prefetch'
        href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
@endsection
@section('content')
    <div id="frame">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="/{{ Auth::user()->avatar }}" class="online h-100" alt="" />
                    <p>{{ Auth::user()->name }}</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="Search contacts..." />
            </div>
            <div id="contacts">
                <ul>
                    <li class="contact">
                        {{-- <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                            <div class="meta">
                                <p class="name">Louis Litt</p>
                                <p class="preview">You just got LITT up, Mike.</p>
                            </div>
                        </div> --}}
                    </li>
                </ul>
            </div>
            <div id="bottom-bar">
                <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add
                        contact</span></button>
                <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>
                    <span>Settings</span></button>
            </div>
        </div>
        <div class="content">
            <div class="contact-profile">
                <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                <p>Harvey Specter</p>
                <div class="social-media">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </div>
            </div>
            <div class="messages" id="messages">
            </div>
            <div class="message-input">
                <div class="wrap">
                    <div id="chat">
                        <input type="text" id="message" placeholder="Nhập tin nhắn..." />
                        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                        <button onclick="sendMessage()" class="submit"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="module">
        Echo.channel('chat')
            .listen('ChatPusherEvent', (e) => {
                const messages = document.getElementById('messages');
                const ulReceived = document.createElement('ul');
                ulReceived.classList.add('received');
                const receivedMessageElement = document.createElement('li');
                receivedMessageElement.classList.add('received');
                receivedMessageElement.textContent = e.message;
                ulReceived.appendChild(receivedMessageElement);
                messages.appendChild(ulReceived);
            });
    </script>
    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;

            axios.post('/admin/send-message', {
                message: message
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
        }
    </script>
    <script src="/admin/js/chat.js"></script>
    @vite('resources/js/app.js')
@endsection
