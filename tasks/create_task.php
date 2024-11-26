<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duedate = $_POST['duedate'];
    $assigned_to = $_POST['assigned_to'];

    try {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, assigned_to, status, duedate) VALUES (:title, :description, :assigned_to, 'pending', :duedate)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':duedate', $duedate);
        $stmt->execute();

        // Fetch the assigned user's name for the success message
        $stmt = $conn->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->bindParam(':id', $assigned_to);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_name = $user['name'];

        $_SESSION['success_message'] = "Task successfully created and assigned to " . $user_name . ".";
        header("Location: create_task.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $stmt = $conn->prepare("SELECT id, name FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <a href="../admin/admin-dashboard.php">Go back!</a>
        <h2>Create Task</h2>
        
        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])) { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php } ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="duedate" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="duedate" name="duedate" required>
            </div>
            <div class="mb-3">
                <label for="assigned_to" class="form-label">Assigned To</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
