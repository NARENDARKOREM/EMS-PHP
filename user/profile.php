<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT name, username, email, role FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

        .table-profile {
            margin-top: 2rem;
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
        <h2>Profile Details</h2>
        <div class="container table-profile">
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <td><?php echo $user['name']; ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo $user['username']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?php echo $user['role']; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
