<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}
include '../includes/db.php';

// Fetch counts
try {
    // Count total employees
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_employees FROM users");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_employees = $result['total_employees'];
    
    // Count total tasks
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_tasks FROM tasks");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_tasks = $result['total_tasks'];
    
    // Count overdue tasks
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT COUNT(*) AS overdue_tasks FROM tasks WHERE duedate < :today AND status != 'completed'");
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $overdue_tasks = $result['overdue_tasks'];
    
    // Count tasks with deadlines
    $stmt = $conn->prepare("SELECT COUNT(*) AS deadline_tasks FROM tasks WHERE duedate IS NOT NULL");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $deadline_tasks = $result['deadline_tasks'];
    
    // Count tasks due today
    $stmt = $conn->prepare("SELECT COUNT(*) AS due_today_tasks FROM tasks WHERE duedate = :today");
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $due_today_tasks = $result['due_today_tasks'];
    
    // Count notifications (for demonstration purposes, assuming notifications are stored in a notifications table)
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_notifications FROM notifications");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_notifications = $result['total_notifications'];
    
    // Count pending tasks
    $stmt = $conn->prepare("SELECT COUNT(*) AS pending_tasks FROM tasks WHERE status = 'pending'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pending_tasks = $result['pending_tasks'];
    
    // Count tasks in progress
    $stmt = $conn->prepare("SELECT COUNT(*) AS progress_tasks FROM tasks WHERE status = 'in_progress'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $progress_tasks = $result['progress_tasks'];
    
    // Count completed tasks
    $stmt = $conn->prepare("SELECT COUNT(*) AS completed_tasks FROM tasks WHERE status = 'completed'");
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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            background-color: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding-top: 1rem;
        }

        .admin-sidebar .admin-sidebar-items a {
            display: block;
            padding: 1rem;
            color: #fff;
            text-align: center;
            text-decoration: none;
        }

        .admin-sidebar .admin-sidebar-items a:hover {
            background-color: #495057;
        }

        .admin-main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .admin-dashboard-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
        }

        .admin-dashboard-box a {
            color: inherit;
            text-decoration: none;
        }

        .admin-dashboard-box:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <!-- Admin sidebar -->
    <div class="admin-sidebar">
        <div class="logo">
            <h3>Logo</h3>
        </div>
        <div class="admin-sidebar-items">
            <a href="admin-dashboard.php">
                <div class="dashboard">
                    <h3>Dashboard</h3>
                </div>
            </a>
            <a href="manage_users.php">
                <div class="manage-users">
                    <h3>Manage Users</h3>
                </div>
            </a>
            <a href="create_task.php">
                <div class="create-task">
                    <h3>Create Task</h3>
                </div>
            </a>
            <a href="../chats/chats.php">
                <div class="chats">
                    <h3>Chats</h3>
                </div>
            </a>
            <a href="all_tasks.php">
                <div class="all-tasks">
                    <h3>All Tasks</h3>
                </div>
            </a>
            <a href="logout_admin.php">
                <div class="logout">
                    <h3>Logout</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="admin-main-content">
        <h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="employees.php">
                            <h4><?php echo $total_employees; ?> No of Employees</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="all_tasks.php">
                            <h4><?php echo $total_tasks; ?> No of All Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="overdue.php">
                            <h4><?php echo $overdue_tasks; ?> No of Overdue</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="deadlines.php">
                            <h4><?php echo $deadline_tasks; ?> No of Deadline</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="due_today.php">
                            <h4><?php echo $due_today_tasks; ?> No of Due Today</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="notifications.php">
                            <h4><?php echo $total_notifications; ?> No of Notifications</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="pending_tasks.php">
                            <h4><?php echo $pending_tasks; ?> No of Pending</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="progress_tasks.php">
                            <h4><?php echo $progress_tasks; ?> No of Progress</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="completed_tasks.php">
                            <h4><?php echo $completed_tasks; ?> No of Completed</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
