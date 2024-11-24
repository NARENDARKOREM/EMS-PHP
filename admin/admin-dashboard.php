<?php
// session_start();
// if (!isset($_SESSION['admin_id'])) {  // Assuming session key for admin
//     header("Location: ../index.php?signup=success");
//     exit();
// }
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
            <a href="admin_dashboard.php">
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
            <a href="chats.php">
                <div class="chats">
                    <h3>Chats</h3>
                </div>
            </a>
            <a href="all_tasks.php">
                <div class="all-tasks">
                    <h3>All Tasks</h3>
                </div>
            </a>
            <a href="../logout.php">
                <div class="logout">
                    <h3>Logout</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="admin-main-content">
        <!-- <h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2> -->
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="employees.php">
                            <h4>No of Employees</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="all_tasks.php">
                            <h4>No of All Tasks</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="overdue_tasks.php">
                            <h4>No of Overdue</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="deadlines.php">
                            <h4>No of Deadline</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="today_tasks.php">
                            <h4>No of Due Today</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="notifications.php">
                            <h4>No of Notifications</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="pending_tasks.php">
                            <h4>No of Pending</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="progress_tasks.php">
                            <h4>No of Progress</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-dashboard-box">
                        <a href="completed_tasks.php">
                            <h4>No of Completed</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadContent(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('main-content').innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>