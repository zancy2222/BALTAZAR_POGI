<?php
session_start();

// Include the database connection file
require_once('dbconn.php');
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: _login.php");
    exit();
}

// You can display the logs using a SELECT query similar to this
$log_query = "SELECT * FROM Logs WHERE user_id = '{$_SESSION['user_id']}'";
$log_result = mysqli_query($connection, $log_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .actions {
            text-align: center;
        }

        .delete, .update {
            padding: 8px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        .delete {
            background-color: #ff6666;
            color: #fff;
        }

        .update {
            background-color: #4CAF50;
            color: #fff;
        }

        .add-btn {
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        /* Pop-up Form Styles */
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        form {
            display: grid;
            grid-gap: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Welcome</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Actions</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($log_row = mysqli_fetch_assoc($log_result)) {
                echo "<tr>";
                echo "<td>{$log_row['ID']}</td>";
                echo "<td>{$log_row['action']}</td>";
                echo "<td>{$log_row['date']}</td>";
                echo "<td>{$log_row['time']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>


</body>
</html>
<?php mysqli_close($connection); ?>
