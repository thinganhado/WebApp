<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
    <style>
        .table-container {
            overflow-x: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
            white-space: nowrap;
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($conn) {
            // Updating statuses
            if (isset($_POST['update_status']) && isset($_POST['status'])) {
                foreach ($_POST['status'] as $eoi_number => $status) {
                    $eoi_number = mysqli_real_escape_string($conn, $eoi_number);
                    $status = mysqli_real_escape_string($conn, $status);
                    $update_query = "UPDATE eoi SET status='$status' WHERE EOInumber='$eoi_number'";
                    mysqli_query($conn, $update_query);
                }
            }

            // Deleting selected EOIs
            if (isset($_POST['delete_eois']) && isset($_POST['selected_eois'])) {
                foreach ($_POST['selected_eois'] as $eoi_number) {
                    $eoi_number = mysqli_real_escape_string($conn, $eoi_number);
                    $delete_query = "DELETE FROM eoi WHERE EOInumber='$eoi_number'";
                    mysqli_query($conn, $delete_query);
                }
            }
            mysqli_close($conn);

            // Redirect to refresh the page
            header("Location: manage.php");
            exit();
        } else {
            echo "<p>Database connection failure</p>";
        }
    }
    ?>

    <form method="GET" action="manage.php">
        <label for="job_ref">Filter by Job Reference Number:</label>
        <select name="job_ref" id="job_ref">
            <option value="">--Select Job Reference--</option>
            <?php
                if ($conn) {
                    $jobRefQuery = "SELECT DISTINCT job_reference_number FROM eoi";
                    $jobRefResult = mysqli_query($conn, $jobRefQuery);
                    while ($jobRefRow = mysqli_fetch_assoc($jobRefResult)) {
                        $selected = isset($_GET['job_ref']) && $_GET['job_ref'] == $jobRefRow['job_reference_number'] ? 'selected' : '';
                        echo "<option value=\"{$jobRefRow['job_reference_number']}\" $selected>{$jobRefRow['job_reference_number']}</option>";
                    }
                    mysqli_free_result($jobRefResult);
                }
            ?>
        </select>
        <button type="submit" name="filter_job_ref">Filter by Job Reference</button>

        <br><br>

        <label for="search_name">Search by Applicant Name:</label>
        <input type="text" id="search_name" name="search_name" placeholder="First Name, Last Name or Both" value="<?php echo isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : ''; ?>">
        <button type="submit" name="search_name_btn">Search by Name</button>
    </form>

    <hr class="special">

    <form method="POST" action="manage.php">
        <div class="table-container">
            <?php
            if ($conn) {
                $sql_table = "eoi";
                $query = "SELECT EOInumber, job_reference_number, first_name, last_name, street_address, suburb_town, state, postcode, email_address, phone_number, checkbox_skills, other_skills, status FROM $sql_table WHERE 1=1";

                // Filter by job reference number if the button is pressed
                if (isset($_GET['filter_job_ref']) && isset($_GET['job_ref']) && !empty($_GET['job_ref'])) {
                    $job_ref = mysqli_real_escape_string($conn, $_GET['job_ref']);
                    $query .= " AND job_reference_number = '$job_ref'";
                }

                // Search by applicant name if the button is pressed
                if (isset($_GET['search_name_btn']) && isset($_GET['search_name']) && !empty($_GET['search_name'])) {
                    $search_name = mysqli_real_escape_string($conn, $_GET['search_name']);
                    $names = explode(' ', $search_name);

                    if (count($names) == 1) {
                        $query .= " AND (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%')";
                    } else {
                        $first_name = $names[0];
                        $last_name = $names[1];
                        $query .= " AND (first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%')";
                    }
                }

                $query .= " ORDER BY EOInumber";

                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "<p>Something is wrong with the query: ", mysqli_error($conn), "</p>";
                } else {
                    echo "<table border=\"1\">";
                    echo "<tr>\n"
                        . "<th scope=\"col\">Select</th>\n"
                        . "<th scope=\"col\">EOI</th>\n"
                        . "<th scope=\"col\">Job Reference</th>\n"
                        . "<th scope=\"col\">First Name</th>\n"
                        . "<th scope=\"col\">Last Name</th>\n"
                        . "<th scope=\"col\">Street Address</th>\n"
                        . "<th scope=\"col\">Suburb/Town</th>\n"
                        . "<th scope=\"col\">State</th>\n"
                        . "<th scope=\"col\">Postcode</th>\n"
                        . "<th scope=\"col\">Email Address</th>\n"
                        . "<th scope=\"col\">Phone</th>\n"
                        . "<th scope=\"col\">Skills</th>\n"
                        . "<th scope=\"col\">Other Skills</th>\n"
                        . "<th scope=\"col\">Status</th>\n"
                        . "</tr>\n";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><input type=\"checkbox\" name=\"selected_eois[]\" value=\"{$row["EOInumber"]}\"></td>";
                        echo "<td>", $row["EOInumber"], "</td>";
                        echo "<td>", $row["job_reference_number"], "</td>";
                        echo "<td>", $row["first_name"], "</td>";  
                        echo "<td>", $row["last_name"], "</td>";
                        echo "<td>", $row["street_address"], "</td>";
                        echo "<td>", $row["suburb_town"], "</td>";
                        echo "<td>", $row["state"], "</td>";
                        echo "<td>", $row["postcode"], "</td>";
                        echo "<td>", $row["email_address"], "</td>";
                        echo "<td>", $row["phone_number"], "</td>";
                        echo "<td>", $row["checkbox_skills"], "</td>";
                        echo "<td>", $row["other_skills"], "</td>";
                        echo "<td>
                                <select name=\"status[{$row["EOInumber"]}]\">
                                    <option value=\"New\" ", $row["status"] == 'New' ? 'selected' : '', ">New</option>
                                    <option value=\"Current\" ", $row["status"] == 'Current' ? 'selected' : '', ">Current</option>
                                    <option value=\"Final\" ", $row["status"] == 'Final' ? 'selected' : '', ">Final</option>
                                </select>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    mysqli_free_result($result);
                }
                mysqli_close($conn);
            }
            ?>
        </div>
        <button type="submit" name="update_status">Update Status</button>
        <button type="submit" name="delete_eois">Delete Selected EOIs</button>
    </form>

<?php include 'footer.inc'; ?>
</body>
</html>