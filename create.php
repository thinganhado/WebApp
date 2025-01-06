<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        form {
            max-width: 100%;
            margin: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
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
    </style>
</head>
<body>
<!--Navigation bar-->
<header>
    <section class="logo"><img src="images/logo.png" alt="logo">
    <ul class="logo">    
        <li><a href="manage.php">View Applications</a></li>
        <li><a href="create.php">Create Positions</a></li>
    </ul>
    </section>
</header>

    <hr class="special">

    <?php
require_once('settings.php');
$conn = @mysqli_connect($host, $user, $pwd, $dbname);

if ($conn) {
    $create_table_query = "CREATE TABLE IF NOT EXISTS job_description (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        job_reference_number VARCHAR(255) NOT NULL,
        job_location VARCHAR(255) NOT NULL,
        job_description TEXT NOT NULL,
        salary VARCHAR(10) NOT NULL,
        report_to VARCHAR(255) NOT NULL,
        responsibility TEXT NOT NULL,
        required_qualification TEXT NOT NULL,
        preferable_qualification TEXT NOT NULL
    )";

    if (mysqli_query($conn, $create_table_query)) {
        // Table created successfully or already exists
    } else {
        echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $job_reference_number = mysqli_real_escape_string($conn, $_POST['job_reference_number']);
        $job_location = mysqli_real_escape_string($conn, $_POST['job_location']);
        $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        $report_to = mysqli_real_escape_string($conn, $_POST['report_to']);
        $responsibility = mysqli_real_escape_string($conn, $_POST['responsibility']);
        $required_qualification = mysqli_real_escape_string($conn, $_POST['required_qualification']);
        $preferable_qualification = mysqli_real_escape_string($conn, $_POST['preferable_qualification']);

        // Validate job reference number
        if (!preg_match('/^[A-Z]{2}\d{3}$/', $job_reference_number)) {
            echo "<p>Error: Job reference number must be of 5 characters.</p>";
        } else {
            // Check if all fields are filled
            if (empty($title) || empty($job_reference_number) || empty($job_location) || empty($job_description) || empty($salary) || empty($report_to) || empty($responsibility) || empty($required_qualification) || empty($preferable_qualification)) {
                echo "<p>Error: Please fill in all fields.</p>";
            } else {
                // Insert into database
                $insert_query = "INSERT INTO job_description (title, job_reference_number, job_location, job_description, salary, report_to, responsibility, required_qualification, preferable_qualification)
                                 VALUES ('$title', '$job_reference_number', '$job_location', '$job_description', '$salary', '$report_to', '$responsibility', '$required_qualification', '$preferable_qualification')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "<p>New job position created successfully.</p>";
                } else {
                    echo "<p>Error: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    }

    mysqli_close($conn);
} else {
    echo "<p>Database connection failure</p>";
}
?>

    <form method="POST" action="create.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="job_reference_number">Job Reference Number:</label>
        <input type="text" id="job_reference_number" name="job_reference_number" required>

        <label for="job_location">Location:</label>
        <input type="text" id="job_location" name="job_location" required>

        <label for="job_description">Description:</label>
        <textarea id="job_description" name="job_description" required></textarea>

        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" required>

        <label for="report_to">Report To:</label>
        <input type="text" id="report_to" name="report_to" required>

        <label for="responsibility">Responsibility:</label>
        <textarea id="responsibility" name="responsibility" required></textarea>

        <label for="required_qualification">Required Qualification:</label>
        <textarea id="required_qualification" name="required_qualification" required></textarea>

        <label for="preferable_qualification">Preferable Qualification:</label>
        <textarea id="preferable_qualification" name="preferable_qualification" required></textarea>

        <button type="submit">Create Position</button>
    </form>

<?php include 'footer.inc'; ?>
</body>
</html>