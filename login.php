<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Start output buffering

include './includes/db.php';

$email = $password = "";
$emailErr = $passwordErr = "";
$loginSuccess = "";
$loginErr = "";

//echo "Script start<br>"; // Debugging output

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Form submitted<br>"; // Debugging output

    if (empty($_POST['email'])) {
        $emailErr = "Email is Required";
    } else {
        $email = validate_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email Format.";
        }
    }
    if (empty($_POST['password'])) {
        $passwordErr = "Password is Required.";
    } else {
        $password = validate_input($_POST['password']);
    }

    if (empty($emailErr) && empty($passwordErr)) {
        try {
            //echo "Connecting to database<br>"; // Debugging output
            // $conn = include './includes/db.php';
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                //echo "User found<br>"; // Debugging output
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashedPassword = $row['password'];
                $id = $row['id'];
                $uname = $row['username'];

                if (password_verify($password, $hashedPassword)) {
                    session_start();
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $uname;
                    //echo "Redirecting to dashboard..."; // Debugging output
                    header("Location: ./user/dashboard.php");
                    ob_end_flush(); // Flush output buffer and send headers
                    exit();
                } else {
                    $loginErr = "Invalid email or password.";
                }
            } else {
                $loginErr = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Error" . "<br>" . $e->getMessage();
        }
    }
}

function validate_input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}
