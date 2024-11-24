<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <!-- sidebar -->
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
            <a href="chats.php">
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
                            <h4>No of Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="overdue.php">
                            <h4>No of Overdue</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="deadlines.php">
                            <h4>No of Deadline</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="pending.php">
                            <h4>No of Pending</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="progress.php">
                            <h4>No of Progress</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box">
                        <a href="completed.php">
                            <h4>No of Completed</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>