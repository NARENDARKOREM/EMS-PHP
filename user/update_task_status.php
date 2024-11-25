<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();

        if ($status === 'completed') {
            echo "<script>alert('Task completed successfully!'); window.location.href = 'my_tasks.php';</script>";
        } else {
            header("Location: my_tasks.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
