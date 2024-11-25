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
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $duedate = $_POST['duedate'];

        $stmt = $conn->prepare("UPDATE tasks SET title = :title, description = :description, status = :status, duedate = :duedate WHERE id = :id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':duedate', $duedate);
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();

        if ($status === 'completed') {
            echo "<script>alert('Task completed successfully!'); window.location.href = 'my_tasks.php';</script>";
        } else {
            header("Location: my_tasks.php");
            exit();
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
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
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $task['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $task['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="in_progress" <?php if ($task['status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
                    <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="duedate" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="duedate" name="duedate" value="<?php echo $task['duedate']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
