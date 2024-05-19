<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat List</title>
    <style>
        .chat_list-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .chat_user {
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

        .contacts_list,
        .chat_list {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            height: auto;
            overflow-y: auto;
        }

        .contact_user,
        .chat_user {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .contact_user img,
        .chat_user img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .contact_user .contact-name,
        .chat_user {
            font-size: 18px;
        }
    </style>
</head>

<body>



    <script>
        function openConverstionPage(contact_id, user_id) {
            var url = "/chat/" + contact_id + '/' + user_id;
            window.location.href = url;
        }
    </script>

    <div class="container">
        <h1 class="my-4">Contacts</h1>
        <div class="contacts_list">
            <?php foreach ($contacts as $contact) : ?>
                <div class="contact_user" onclick="openConverstionPage('<?= $contact->contact_id; ?>','<?= $contact->user_id; ?>')">
                    <img src="<?= htmlspecialchars($contact->profile_picture) ?>" alt="<?= htmlspecialchars($contact->full_name) ?>">
                    <div class="contact-name"><?= htmlspecialchars($contact->full_name) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <div class="chat_list-container">
        <h1>Chats</h1>
        <?php
        foreach ($conversations as $conversation) : ?>
            <div class="chat_user" id="chat_list" onclick="openConverstionPage('<?= $conversation['contact_user']['id']; ?>','<?= $current_user_id; ?>')" style="cursor:pointer;">
                <img src="<?php echo $conversation['contact_user']['profile']; ?>" alt="" class="profile-picture">
                <div class="chat-details">
                    <div class="chat-header">
                        <h3><?php echo $conversation['contact_user']['full_name']; ?></h3>
                        <span class="timestamp"><?php echo $conversation['latest_message']['created_at']; ?></span>
                    </div>
                    <p class="content"><?php echo $conversation['latest_message']['content']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>