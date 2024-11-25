<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ems";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql1 = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            username VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'employee') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $sql2 = "CREATE TABLE tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            assigned_to INT,
            status ENUM('pending', 'in progress', 'completed') DEFAULT 'pending'
        )";

        $sql3 = "CREATE TABLE notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            message TEXT NOT NULL,
            recipient INT NOT NULL,
            type VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            is_read BOOLEAN DEFAULT FALSE
        )";

        $sql4 = "CREATE TABLE chats (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT DEFAULT NULL,
            group_chat BOOLEAN DEFAULT FALSE,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id),
            FOREIGN KEY (receiver_id) REFERENCES users(id)
        )";

        $sql5 = "CREATE TABLE leaves (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE NOT NULL,
            reason TEXT NOT NULL,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";

        $conn->exec($sql1);
        $conn->exec($sql2);
        $conn->exec($sql3);
        $conn->exec($sql4);
        $conn->exec($sql5);

        echo "Tables Created Successfully";
        
    } catch (PDOException $e) {
        echo "ERROR" . "<br>" . $e->getMessage();
    }

    return $conn;
?>
