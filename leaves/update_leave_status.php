<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

include '../includes/db.php';

$leave_id = $_GET['id'];
$status = $_GET['status'];

try {
    $stmt = $conn->prepare("UPDATE leaves SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $leave_id);
    $stmt->execute();

    $_SESSION['success_message'] = "Leave request status updated successfully!";
    header("Location: manage_leaves.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
