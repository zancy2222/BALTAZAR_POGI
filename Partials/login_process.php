<?php
session_start();

// Include the database connection file
require_once('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user data based on the entered username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row["password"])) {
            // Insert a log entry for login
            $log_sql = "INSERT INTO Logs (user_id, action, date, time) VALUES ('{$row['id']}', 'Login', CURDATE(), CURTIME())";
            mysqli_query($connection, $log_sql);

            // Set session variables
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            // Redirect to the landing page upon successful login
            header("Location: Logs.php");
            exit();
        } else {
            echo '<script>alert("Wrong password. Try again.");</script>';
        }
    } else {
        echo '<script>alert("You must be registered first.");</script>';
    }
}

mysqli_close($connection);
?>
