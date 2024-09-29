@extends('layouts.master')
@section('title', 'Chat Room')
@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div class="chat">
                    @if($receiver)
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="{{ $receiver->profile_image ? asset('storage/' . $receiver->profile_image) : 'https://bootdey.com/img/Content/avatar/avatar2.png' }}" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0">{{ $receiver->name }}</h6>
                                    <small>Last seen: {{ $receiver->last_seen ? $receiver->last_seen->diffForHumans() : 'No activity' }}</small>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden-sm text-right">
                                <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history">
                        <ul class="m-b-0" id="chat-history">
                            <!-- Messages will be dynamically loaded here -->
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <form id="messageForm" onsubmit="return false;">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-send"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter text here..." id="messageInput">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" onclick="sendMessage()">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
 function formatMessageTime(createdAt) {
    const messageDate = new Date(createdAt);
    const today = new Date();

    // Check if the message date is today
    const isToday = messageDate.toDateString() === today.toDateString();

    // If it's today, display "Today" followed by the time; otherwise, display the full date and time
    if (isToday) {
        return `Today ${messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
    } else {
        return `${messageDate.toLocaleDateString()} ${messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
    }
}

const receiverId = "{{ $receiver->id }}"; // Use the correct variable

function fetchMessages() {
    $.get("{{ route('chat.fetch') }}", { receiver_id: receiverId }, function(messages) {
        $("#chat-history").empty(); // Clear existing messages

        messages.forEach(message => {
            const messageTime = formatMessageTime(message.created_at);
            const isSender = message.sender_id == "{{ Auth::user()->id }}";

            // Determine the message data based on sender/receiver
            const messageData = isSender 
                ? `<div class="message-data text-right">
                    <span class="message-data-time">${messageTime}</span>
                    <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://bootdey.com/img/Content/avatar/avatar7.png' }}" alt="avatar" />
                   </div>`
                : `<div class="message-data">
                    <span class="message-data-time">${messageTime}</span>
                    <img src="${message.sender.profile_image ? message.sender.profile_image : 'https://bootdey.com/img/Content/avatar/avatar7.png'}" alt="avatar" />
                   </div>`; // Use sender's image for receiver

            // Determine the message class based on sender/receiver
            const messageClass = isSender ? "other-message float-right" : "my-message";

            // Append the message HTML
            $("#chat-history").append(`
                <li class="clearfix">
                    ${messageData}
                    <div class="message ${messageClass}">${message.message}</div>
                </li>
            `);
        });

        // Scroll to the bottom of the chat
        $('.chat-history').scrollTop($('.chat-history')[0].scrollHeight);
    });
}

function sendMessage() {
    const messageContent = $("#messageInput").val().trim(); // Get and trim the input value
    const csrfToken = "{{ csrf_token() }}";

    // Check if the message is not empty
    if (messageContent === "") {
        return;
    }

    // Create the message object
    const messageData = {
        receiver_id: receiverId,
        message: messageContent,
        _token: csrfToken
    };

    $.ajax({
        url: "{{ route('chat.send') }}",
        type: "POST",
        data: messageData,
        success: function(response) {
            // Clear the input field after sending the message
            $("#messageInput").val("");

            // Scroll to the bottom of the chat
            $('.chat-history').scrollTop($('.chat-history')[0].scrollHeight);
        },
        error: function(xhr, status, error) {
            console.error("Error sending message:", error); // Log error
            alert("There was an error sending your message. Please try again."); // Optional: alert on error
        }
    });
}

window.onload = () => {
    // Fetch initial messages
    fetchMessages();

    // Listen for new messages
    window.Echo.channel('chat')
        .listen('MessageSent', function(data) {
            const message = data.message;
            const messageTime = formatMessageTime(message.created_at); // Use the formatted message time

            // Check if the message is sent by the authenticated user
            const isSender = message.sender_id == "{{ Auth::user()->id }}";
            const messageClass = isSender ? "other-message float-right" : "my-message";

            // Append the new message to the chat history
            $("#chat-history").append(`
                <li class="clearfix">
                    <div class="message-data ${isSender ? 'text-right' : ''}">
                        <span class="message-data-time">${messageTime}</span>
                        <img src="${message.sender.profile_image ? message.sender.profile_image : 'https://bootdey.com/img/Content/avatar/avatar7.png'}" alt="avatar" />
                    </div>
                    <div class="message ${messageClass}">${message.message}</div>
                </li>
            `);

            // Scroll to the bottom of the chat
            $('.chat-history').scrollTop($('.chat-history')[0].scrollHeight);
        });
};

</script>
@endsection
