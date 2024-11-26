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
        // Update status value to match exactly with ENUM values
        $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();

        if ($status === 'completed') {
            $_SESSION['success_message'] = "Task completed successfully!";
        } else if ($status === 'in progress') {
            $_SESSION['success_message'] = "Task status changed to 'In Progress' successfully!";
        } else {
            $_SESSION['success_message'] = "Task status updated successfully!";
        }
        header("Location: my_tasks.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
