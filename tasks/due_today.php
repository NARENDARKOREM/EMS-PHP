<?php
include '../includes/db.php';

try {
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.duedate, tasks.status, users.name AS assigned_user FROM tasks INNER JOIN users ON tasks.assigned_to = users.id WHERE tasks.duedate = :today");
    $stmt->bindParam(':today', $today);
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
    <title>Due Today</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
    <a href="../admin/admin-dashboard.php">Go back!</a>

        <h2>Tasks Due Today</h2>
        <table class="table table-striped">
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