<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];

try {
    // Count total tasks assigned to the user
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_tasks FROM tasks WHERE assigned_to = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_tasks = $result['total_tasks'];

    // Count pending tasks
    $stmt = $conn->prepare("SELECT COUNT(*) AS pending_tasks FROM tasks WHERE assigned_to = :user_id AND status = 'pending'");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pending_tasks = $result['pending_tasks'];

    // Count tasks in progress
    $stmt = $conn->prepare("SELECT COUNT(*) AS progress_tasks FROM tasks WHERE assigned_to = :user_id AND status = 'in_progress'");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $progress_tasks = $result['progress_tasks'];

    // Count completed tasks
    $stmt = $conn->prepare("SELECT COUNT(*) AS completed_tasks FROM tasks WHERE assigned_to = :user_id AND status = 'completed'");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $completed_tasks = $result['completed_tasks'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding-top: 1rem;
        }

        .sidebar .sidebar-items a {
            display: block;
            padding: 1rem;
            color: #fff;
            text-align: center;
            text-decoration: none;
        }

        .sidebar .sidebar-items a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .dashboard-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
        }

        .dashboard-box a {
            color: inherit;
            text-decoration: none;
        }

        .dashboard-box:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3>Logo</h3>
        </div>
        <div class="sidebar-items">
            <a href="dashboard.php">
                <div class="dashboard">
                    <h3>Dashboard</h3>
                </div>
            </a>
            <a href="my_tasks.php">
                <div class="profile">
                    <h3>My Tasks</h3>
                </div>
            </a>
            <a href="profile.php">
                <div class="profile">
                    <h3>Profile</h3>
                </div>
            </a>
            <a href="notifications.php">
                <div class="notifications">
                    <h3>Notifications</h3>
                </div>
            </a>
            <a href="../chats/chats.php">
                <div class="chats">
                    <h3>Chats</h3>
                </div>
            </a>
            <a href="../logout.php">
                <div class="logout">
                    <h3>Logout</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="main-content">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="tasks.php">
                            <h4><?php echo $total_tasks; ?> No of Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="pending_tasks.php">
                            <h4><?php echo $pending_tasks; ?> No of Pending Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="progress_tasks.php">
                            <h4><?php echo $progress_tasks; ?> No of In Progress Tasks</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="completed_tasks.php">
                            <h4><?php echo $completed_tasks; ?> No of Completed Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="notifications.php">
                            <h4>Notifications</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="../chats/chats.php">
                            <h4>Chats</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
