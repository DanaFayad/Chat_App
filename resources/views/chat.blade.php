<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat</title>
    <style>
    </style>
</head>

<body>
    <h1>Real-Time Chat</h1>
    <div id="chat-container">
    </div>
    <form id="message_form">
        <input type="hidden" id="chat-id" value="{{ $conversation_id }}">
        <input type="hidden" id="user_id" value="{{ $user_id  }}">
        <input type="hidden" id="contact_id" value="{{ $contact_id  }}">

        <input type="text" id="msg_input" placeholder="Type your message...">
        <button type="submit">Send</button>
    </form>

    <div id="pusher_credentials" data-pusher-key="{{ env('PUSHER_APP_KEY') }}" data-pusher-cluster="{{ env('PUSHER_APP_CLUSTER') }}">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        var pusher;

        $(document).ready(function() {
            var pusherKey = $('#pusher_credentials').data('pusher-key');
            var pusherCluster = $('#pusher_credentials').data('pusher-cluster');
            pusher = new Pusher(pusherKey, {
                cluster: pusherCluster,
                encrypted: true
            });

            $('#message_form').submit(function(event) {
                event.preventDefault();
                var messageContent = $('#msg_input').val();
                sendMessage(messageContent);
                $('#msg_input').val('');
            });

            fetchAllMessages();
            setInterval(fetchAllMessages, 5000);

        });

        function fetchAllMessages() {

            $.ajax({
                url: '/messages/' + $("#chat-id").val(),
                method: 'GET',
                success: function(messages) {
                    $('#chat-container').empty();
                    messages.forEach(function(message) {
                        $('#chat-container').append('<div><strong>' + message.sender_id + ':</strong> ' + message.content + '</div>');
                    });
                },
                error: function(xhr, status, error) {
                    $('#chat-container').html('<div style="color: red;">Error fetching messages. Please try again later.</div>');
                    console.error('Error fetching messages:', error);
                }
            });
        }

        function sendMessage(content) {
            $.ajax({
                url: '/new_chat',
                method: 'POST',
                data: {
                    content: content,
                    user_id: $("#user_id").val(),
                    contact_id: $("#contact_id").val(),

                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Message sent successfully:', response);
                    subscribeToChannel(response.conversation_id);
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', error);
                    alert('Error sending message. Please try again later.');
                }
            });
        }

        function subscribeToChannel(conversation_id) {
            console.log('Subscribing to channel: chat.' + conversation_id);
            var channel = pusher.subscribe('chat.' + conversation_id);

            channel.bind('pusher:subscription_succeeded', function() {
                console.log('Subscription succeeded for channel: chat.' + conversation_id);
            });

            channel.bind('pusher:subscription_error', function(status) {
                console.log('Subscription error:', status);
            });

            channel.bind('NewMessage', function(data) {
                console.log(data);
                $('#chat-container').append('<div><strong>' + data.message.sender_id + ':</strong> ' + data.message.content + '</div>');
            });
        }
    </script>
</body>

</html>