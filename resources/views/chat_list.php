<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat List</title>
    <style>
        .chat-list-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .chat-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .profile-picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-details {
            flex: 1;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
        }

        .timestamp {
            font-size: 12px;
            color: #888;
        }

        .content {
            margin-top: 5px;
            color: #333;
            font-size: 14px;
        }
    </style>
</head>

<body>



    <script>
        function openChatPage(conversationId) {
            var url = "/chat/" + conversationId;
            window.location.href = url;
        }
    </script>

    <div class="chat-list-container">
        <?php foreach ($conversations as $conversation) : ?>
            <div class="chat-item" id="chat_list" onclick="openChatPage('<?= $conversation['conversation_id']; ?>')">
                <img src="<?php echo $conversation['latest_message']['sender']['profile']; ?>" alt="" class="profile-picture">
                <div class="chat-details">
                    <div class="chat-header">
                        <h3><?php echo $conversation['latest_message']['sender']['full_name']; ?></h3>
                        <span class="timestamp"><?php echo $conversation['latest_message']['created_at']; ?></span>
                    </div>
                    <p class="content"><?php echo $conversation['latest_message']['content']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>