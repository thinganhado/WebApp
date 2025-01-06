<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body data-page="jobs">
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>
    <hr class="special">
<aside>
    <section class="logo1"><img src="images/logo.png" alt="logo"></section>
    <h3>Join Our Talent Pool</h3>
    <p>Join our team! We're looking for talented individuals like you to help us achieve 
        our goals and drive innovation. Are you ready to make a difference? Apply now and become 
        part of our exciting journey!</p>
    <h3>About Us</h3>
    <p>At Reboot, we specialize in building software solutions for financial institutions, 
        with a focus on modernizing their systems and overall customer experience. We understand the 
        critical importance of data security and compliance, and we prioritize these elements in 
        all our software solutions.</p>
</aside>
<!--Job openings: click for more details-->
<section class="job">
    <?php
    require_once('settings.php');
    $conn = @mysqli_connect($host, $user, $pwd, $dbname);

    if ($conn) {
        $query = "SELECT * FROM job_description";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<section id="job' . $row['id'] . '">';
                echo '<details>';
                echo '<summary class="short_description">';
                echo '<h1>' . htmlspecialchars($row['title']) . '</h1>'; // title column
                echo '<h2><strong>Reference number:</strong> ' . htmlspecialchars($row['job_reference_number']) . '</h2>'; // job_reference_number column
                echo '<h3><strong>Location:</strong> ' . htmlspecialchars($row['job_location']) . '</h3>'; // job_location column
                echo '<a class="toggle_arrow" href="#detailed_description"></a>';
                echo '<a href="apply.php" class="apply_btn" id="apply_btn_job' . $row['id'] . '" data-job-ref="' . htmlspecialchars($row['job_reference_number']) . '">Apply</a>'; // change data-job-ref to match job_reference_number column
                echo '</summary>';
                echo '<div class="detailed_description">';
                echo '<h2>Brief description</h2>';
                echo '<p>' . htmlspecialchars($row['job_description']) . '</p>'; // job_description column
                echo '<p><strong>Salary range:</strong> ' . htmlspecialchars($row['salary']) . '</p>'; // salary column
                echo '<p><strong>Report to:</strong> ' . htmlspecialchars($row['report_to']) . '</p>'; // report_to column
                echo '<br>';
                echo '<h2>Key responsibility</h2>';
                echo '<p>' . htmlspecialchars($row['responsibility']) . '</p>'; // responsibility column
                echo '<br>';
                echo '<h2>Required qualifications</h2>';
                echo '<h3>Required</h3>';
                echo '<p>' . htmlspecialchars($row['required_qualification']) . '</p>'; // required_qualification column
                echo '<h3>Preferable</h3>';
                echo '<p>' . htmlspecialchars($row['preferable_qualification']) . '</p>'; // preferable_qualification column
                echo '</div>';
                echo '</details>';
                echo '</section>';
            }
            mysqli_free_result($result);
        } else {
            echo "<p>Error retrieving job descriptions: " . mysqli_error($conn) . "</p>";
        }
        mysqli_close($conn);
    } else {
        echo "<p>Database connection failure</p>";
    }
    ?>
    <br>
    <?php include 'footer.inc'; ?>
</body>
</html>