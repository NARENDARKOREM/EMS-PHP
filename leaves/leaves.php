<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?signup=success");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    try {
        $stmt = $conn->prepare("INSERT INTO leaves (user_id, start_date, end_date, reason) VALUES (:user_id, :start_date, :end_date, :reason)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':reason', $reason);
        $stmt->execute();

        $_SESSION['success_message'] = "Leave request submitted successfully!";
        header("Location: leaves.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Apply for Leave</h2>

        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])) { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Apply for Leave</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
