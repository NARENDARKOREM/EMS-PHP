<?php
include '../includes/db.php';

try {
    $stmt = $conn->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.duedate, tasks.status, users.name AS assigned_user FROM tasks INNER JOIN users ON tasks.assigned_to = users.id");
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Task List</h2>
        <a href="create_task.php" class="btn btn-success mb-3">Create Task</a>
        <nav>
            <a href="due_today.php" class="btn btn-primary">Due Today</a>
            <a href="overdue.php" class="btn btn-warning">Overdue</a>
            <a href="deadlines.php" class="btn btn-info">No of Deadline</a>
            <a href="all_tasks.php" class="btn btn-secondary">All Tasks</a>
        </nav>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task) { ?>
                    <tr>
                        <td><?php echo $task['id']; ?></td>
                        <td><?php echo $task['title']; ?></td>
                        <td><?php echo $task['description']; ?></td>
                        <td><?php echo $task['duedate']; ?></td>
                        <td><?php echo $task['status']; ?></td>
                        <td><?php echo $task['assigned_user']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>