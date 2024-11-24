<?php
include './includes/db.php';

$name = $email = $uname = $password = $confirmPassword = $role = "";
$nameErr = $emailErr = $unameErr = $passwordErr = $confirmPasswordErr = $roleErr = "";
$signInSuccess = "";
$signInErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['name'])) {
        $nameErr = "Name is Required";
    } else {
        $name = validate_input($_POST['name']);
        if (!preg_match("/^[A-Za-z ]*$/", $name)) {
            $nameErr = "Name Contains Only letters.";
        }
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email is Required";
    } else {
        $email = validate_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email Format.";
        }
    }

    if (empty($_POST['username'])) {
        $unameErr = "Username is Required";
    } else {
        $uname = validate_input($_POST['username']);
    }

    if (empty($_POST['password'])) {
        $passwordErr = "Password is Required";
    } else {
        $password = validate_input($_POST['password']);
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters length.";
        }
    }

    if (empty($_POST['confirmPassword'])) {
        $confirmPasswordErr = "Confirm Password is Required";
    } else {
        $confirmPassword = validate_input($_POST['confirmPassword']);
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match.";
        }
    }

    if (empty($_POST['role'])) {
        $roleErr = "Role is Required";
    } else {
        $role = validate_input($_POST['role']);
    }

    if (empty($nameErr) && empty($emailErr) && empty($unameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($roleErr)) {
        // Check if email or username already exists
        $sql = "SELECT * FROM users WHERE email = :email OR username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $uname);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $signInErr = "Email or Username already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users(name, username, email, password, role) VALUES (:name, :username, :email, :password, :role)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':username', $uname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                $signInSuccess = "Hello! $uname, you registered successfully.";
                header("Location: index.php?signup=success");
                exit();
            } else {
                echo "Error: Could not execute query.";
                $signInErr = "Error Occurs. Check your details once again.";
            }
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
