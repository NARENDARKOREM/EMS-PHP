<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$task_id = $_GET['id'];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();

        if ($status === 'completed') {
            $_SESSION['success_message'] = "Task completed successfully!";
            header("Location: my_tasks.php");
            exit();
        } else {
            header("Location: my_tasks.php");
            exit();
        }
    } else {
        $stmt = $conn->prepare("SELECT title, description, status, duedate FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Task</h2>
        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])) { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php } ?>
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $task['title']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo $task['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="in progress" <?php if ($task['status'] == 'in progress') echo 'selected'; ?>>In Progress</option>
                    <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="duedate" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="duedate" name="duedate" value="<?php echo $task['duedate']; ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
            <a href="../tasks/my_tasks.php">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
