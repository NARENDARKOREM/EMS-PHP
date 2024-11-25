<?php
session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['admin_id'];
$receiver_id = isset($_GET['receiver_id']) ? $_GET['receiver_id'] : '';

try {
    if ($receiver_id) {
        $stmt = $conn->prepare("SELECT chats.message, chats.created_at, users.username, chats.sender_id FROM chats INNER JOIN users ON chats.sender_id = users.id WHERE (chats.sender_id = :user_id AND chats.receiver_id = :receiver_id) OR (chats.sender_id = :receiver_id AND chats.receiver_id = :user_id) ORDER BY chats.created_at ASC");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
    } else {
        $stmt = $conn->prepare("SELECT chats.message, chats.created_at, users.username, chats.sender_id FROM chats INNER JOIN users ON chats.sender_id = users.id WHERE chats.group_chat = TRUE ORDER BY chats.created_at ASC");
    }
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        $message_class = $message['sender_id'] == $user_id ? 'message-sent' : 'message-received';
        echo '<div class="message ' . $message_class . '"><strong>' . $message['username'] . ':</strong> ' . $message['message'] . ' <small class="text-muted">' . $message['created_at'] . '</small></div>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
