<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'] ? $_POST['receiver_id'] : NULL;
    $group_chat = $_POST['group_chat'] === 'true' ? true : false;

    try {
        $stmt = $conn->prepare("INSERT INTO chats (sender_id, receiver_id, group_chat, message) VALUES (:sender_id, :receiver_id, :group_chat, :message)");
        $stmt->bindParam(':sender_id', $user_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':group_chat', $group_chat, PDO::PARAM_BOOL);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
