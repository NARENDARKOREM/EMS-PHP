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
        .chat-container {
            display: flex;
            height: 80vh;
        }

        .user-list {
            width: 25%;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
        }

        .chat-area {
            width: 75%;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .messages {
            flex-grow: 1;
            overflow-y: auto;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1rem;
        }

        .message-input {
            display: flex;
        }

        .message-input textarea {
            flex-grow: 1;
            resize: none;
        }

        .message {
            padding: 0.5rem;
            border-radius: 10px;
            margin: 0.5rem 0;
            max-width: 60%;
        }

        .message-sent {
            background-color: #d1e7dd;
            align-self: flex-end;
        }

        .message-received {
            background-color: #f8f9fa;
            align-self: flex-start;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="chat-container">
            <div class="user-list">
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
                            <small class="text-muted"><?php echo $message['created_at']; ?></small>
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
