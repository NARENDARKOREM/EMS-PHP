<?php
session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['admin_id'];

// Fetch the list of users
try {
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE id != :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch chat messages
try {
    $stmt = $conn->prepare("SELECT chats.message, chats.created_at, users.username, chats.sender_id FROM chats INNER JOIN users ON chats.sender_id = users.id WHERE chats.group_chat = TRUE ORDER BY chats.created_at ASC");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 90vh;
        }

        .user-list {
            width: 100%;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .chat-area {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
            padding: 1rem;
            background-color: #ffffff;
        }

        .messages {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .message-input {
            display: flex;
            margin-top: auto;
        }

        .message-input textarea {
            flex-grow: 1;
            resize: none;
            margin-right: 1rem;
        }

        .message {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin: 0.5rem 0;
            max-width: 75%;
            position: relative;
            clear: both;
        }

        .message-sent {
            background-color: #007bff;
            color: white;
            float: right;
        }

        .message-received {
            background-color: #e9ecef;
            float: left;
        }

        .message strong {
            display: block;
            font-size: 0.9rem;
        }

        .message small {
            position: absolute;
            bottom: -15px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .message-sent small {
            right: 0;
        }

        .message-received small {
            left: 0;
        }

        .user-list .list-group-item:hover {
            background-color: #e9ecef;
        }

        @media (min-width: 768px) {
            .chat-container {
                flex-direction: row;
            }

            .user-list {
                width: 25%;
                border-right: 1px solid #dee2e6;
                border-bottom: none;
                background-color: #f8f9fa;
            }

            .chat-area {
                width: 75%;
                height: 100%;
                padding: 1rem;
                background-color: #ffffff;
            }

            .message {
                max-width: 60%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="chat-container">
            <div class="user-list">
                <a href="../user/dashboard.php">Go back!</a>
                <h4>Users</h4>
                <ul class="list-group">
                    <li class="list-group-item active">Group Chat</li>
                    <?php foreach ($users as $user) { ?>
                        <li class="list-group-item" data-id="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="chat-area">
                <div class="messages">
                    <?php foreach ($messages as $message) { ?>
                        <div class="message <?php echo $message['sender_id'] == $user_id ? 'message-sent' : 'message-received'; ?>">
                            <strong><?php echo $message['username']; ?>:</strong> <?php echo $message['message']; ?>
                            <small><?php echo $message['created_at']; ?></small>
                        </div>
                    <?php } ?>
                </div>
                <div class="message-input">
                    <form id="chat-form">
                        <textarea class="form-control" id="message" rows="3" placeholder="Type a message..."></textarea>
                        <input type="hidden" id="receiver_id" name="receiver_id" value="">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var message = document.getElementById('message').value;
            var receiverId = document.getElementById('receiver_id').value;
            var groupChat = receiverId === '' ? 'true' : 'false';

            // Send message to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('message').value = '';
                    loadMessages();
                }
            }
            xhr.send('message=' + message + '&receiver_id=' + receiverId + '&group_chat=' + groupChat);
        });

        // Function to refresh chat messages
        function loadMessages() {
            var receiverId = document.getElementById('receiver_id').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_messages.php?receiver_id=' + receiverId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector('.messages').innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        }

        // Function to switch between group chat and direct messages
        document.querySelectorAll('.list-group-item').forEach(function(item) {
            item.addEventListener('click', function() {
                document.querySelectorAll('.list-group-item').forEach(function(item) {
                    item.classList.remove('active');
                });
                this.classList.add('active');
                var receiverId = this.getAttribute('data-id') || '';
                document.getElementById('receiver_id').value = receiverId;
                loadMessages();
            });
        });

        setInterval(loadMessages, 5000); // Refresh messages every 5 seconds
    </script>
</body>

</html>
