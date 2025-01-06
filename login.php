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
        input[type="text"], input[type="password"] {
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
        .error {
            color: red;
            margin-top: 5px;
        }
        .register-link {
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

<form method="POST" action="login.php">
    <h2>Login</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="pswd" required>

    <button type="submit" name="login">Login</button>
    <a class="register-link" href="registration.php">Register</a>
</form>

<?php
session_start();

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $remaining_time = $_SESSION['lockout_time'] - time();
    echo "<p class='error'>Too many failed attempts. Please try again after $remaining_time seconds.</p>";
} else {
    if (isset($_POST['login'])) {
        require_once('settings.php');
        $conn = @mysqli_connect($host, $user, $pwd, $dbname);

        if ($conn) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['pswd']);

            $query = "SELECT * FROM users WHERE username='$username' AND pswd='$password'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['login_attempts'] = 0; // Reset login attempts on successful login
                header("Location: manage.php");
                exit();
            } else {
                $_SESSION['login_attempts'] += 1;

                if ($_SESSION['login_attempts'] >= 3) {
                    $_SESSION['lockout_time'] = time() + 60; // Lock out for 60 seconds
                    echo "<p class='error'>Too many failed attempts. Please try again after 60 seconds.</p>";
                } else {
                    $remaining_attempts = 3 - $_SESSION['login_attempts'];
                    echo "<p class='error'>Invalid username or password. You have $remaining_attempts more attempt(s).</p>";
                }
            }

            mysqli_close($conn);
        } else {
            echo "<p class='error'>Database connection failure</p>";
        }
    }
}
?>
<?php include 'footer.inc'; ?>
</body>
</html>