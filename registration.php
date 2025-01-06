<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .login-link {
            display: inline-block;
            margin-left: 10px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<header>
    <section class="logo"><img src="images/logo.png" alt="logo">
    </section>
</header>

<hr class="special">

<?php
require_once('settings.php');
$conn = @mysqli_connect($host, $user, $pwd, $dbname);

if ($conn) {
    $create_table_query = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        pswd VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL
    )";

    if (mysqli_query($conn, $create_table_query)) {
        // Table created successfully or already exists
    } else {
        echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pswd']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

        $insert_query = "INSERT INTO users (username, email, pswd, full_name)
                         VALUES ('$username', '$email', '$password', '$full_name')";

        if (mysqli_query($conn, $insert_query)) {
            $registration_successful = true;
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    mysqli_close($conn);
} else {
    echo "<p>Database connection failure</p>";
}
?>

<form method="POST" action="registration.php">
    <h2>Register</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="pswd" required>

    <label for="full_name">Full Name:</label>
    <input type="text" id="full_name" name="full_name" required>

    <button type="submit">Register</button>
    <a class="login-link" href="login.php">Login</a>
</form>

<?php include 'footer.inc'; ?>
</body>
</html>