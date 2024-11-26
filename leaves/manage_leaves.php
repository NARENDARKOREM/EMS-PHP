<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

include '../includes/db.php';

try {
    $stmt = $conn->prepare("SELECT leaves.id, users.username, leaves.start_date, leaves.end_date, leaves.reason, leaves.status 
                            FROM leaves 
                            INNER JOIN users ON leaves.user_id = users.id");
    $stmt->execute();
    $leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leaves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Manage Leave Requests</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaves as $leave) { ?>
                    <tr>
                        <td><?php echo $leave['id']; ?></td>
                        <td><?php echo $leave['username']; ?></td>
                        <td><?php echo $leave['start_date']; ?></td>
                        <td><?php echo $leave['end_date']; ?></td>
                        <td><?php echo $leave['reason']; ?></td>
                        <td><?php echo ucfirst($leave['status']); ?></td>
                        <td>
                            <?php if ($leave['status'] == 'pending') { ?>
                                <a href="update_leave_status.php?id=<?php echo $leave['id']; ?>&status=approved" class="btn btn-success btn-sm">Approve</a>
                                <a href="update_leave_status.php?id=<?php echo $leave['id']; ?>&status=rejected" class="btn btn-danger btn-sm">Reject</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
