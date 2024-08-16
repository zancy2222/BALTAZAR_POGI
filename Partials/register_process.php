<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Establish a database connection
    $connection = mysqli_connect("localhost", "root", "", "db_login");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username already exists.";
    } else {
        // Insert user data into the "users" table
        $sql = "INSERT INTO users (first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$password')";

        if (mysqli_query($connection, $sql)) {
            // Insert a log entry for registration
            $log_sql = "INSERT INTO Logs (user_id, action, date, time) VALUES (LAST_INSERT_ID(), 'Registered', CURDATE(), CURTIME())";
            mysqli_query($connection, $log_sql);

            echo '<script>alert("Successfully registered!");</script>';
             // Redirect to the landing page upon successful login
             header("Location: _login.php");
             exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }

    mysqli_close($connection);
}
?>
