<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body>
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>

    <hr class="special">
<?php
    require_once('settings.php');
    
    $conn = @mysqli_connect(
		$host,
		$user,
		$pwd,
		$dbname
	);

    // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {

// Sanitize input function
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validate function
// function validate() {
    $errMsg = "";

    // if gender is empty => judgement => sanitize

    // check if empty => Sanitize inputs
    $ref = sanitizeInput($_POST['ref']);
    $firstname = sanitizeInput($_POST['givenname']);
    $lastname = sanitizeInput($_POST['familyname']);
    $dob = sanitizeInput($_POST['date']);
    $gender = sanitizeInput($_POST['gender']);
    $email = sanitizeInput($_POST['email']);
    $phonenumber = sanitizeInput($_POST['phone']);
    $address = sanitizeInput($_POST['address']);
    $town = sanitizeInput($_POST['town']);
    $states = sanitizeInput($_POST['state']);
    $postcode = sanitizeInput($_POST['postcode']);
    $skills = isset($_POST['checkbox_skills']) ? $_POST['checkbox_skills'] : array();
    $skills_list = implode(', ', $skills);
    $other_skills_textarea = sanitizeInput($_POST['textarea_skills']);

    $sql_table="eoi";
    $fieldDefinition="EOInumber INT AUTO_INCREMENT PRIMARY KEY, job_reference_number VARCHAR(5), first_name VARCHAR(20), last_name VARCHAR(20), 
                    street_address VARCHAR(40), suburb_town VARCHAR(40), state VARCHAR(3), postcode VARCHAR(4), email_address VARCHAR(50), phone_number VARCHAR(12), 
                    checkbox_skills VARCHAR(50), other_skills TEXT, status ENUM('New', 'Current', 'Final') DEFAULT 'New'";
    
    // check: if table does not exist, create it
    $sqlString = "show tables like '$sql_table'";  
    $result = @mysqli_query($conn, $sqlString);
    // checks if any tables of this name
    if(mysqli_num_rows($result)==0) {
        echo "<p>Table does not exist - create table $sql_table</p>"; // Might not show in a production script 
        $sqlString = "create table " . $sql_table . "(" . $fieldDefinition . ")";; 
        $result2 = @mysqli_query($conn, $sqlString);
        // checks if the table was created
        if($result2===false) {
            echo "<p class=\"wrong\">Unable to create Table $sql_table.". msqli_errno($conn) . ":". mysqli_error($conn) ." </p>"; //Would not show in a production script 
        } else {
        // display an operation successful message
        echo "<p class=\"ok\">Table $sql_table created OK</p>"; //Would not show in a production script 
        } // if successful query operation

    } else {
        // display an operation successful message
        echo "<p>Table  $sql_table already exists</p>"; //Would not show in a production script 
    } // if successful query operation
    
    // Perform validations
    // First name validation
    if (empty($firstname)) {
        $errMsg .= "<p>Please enter your first name.</p>";
    } else if (!preg_match("/^[a-zA-Z ]{1,20}$/", $firstname)) {
        $errMsg .= "<p>First name must only contain up to 20 alpha characters.</p>";
    }

    // Last name validation
    if (empty($lastname)) {
        $errMsg .= "<p>Please enter your last name.</p>";
    } else if (!preg_match("/^[a-zA-Z ]{1,20}$/", $lastname)) {
        $errMsg .= "<p>Last name must only contain up to 20 alpha characters.</p>";
    }

    // Date of birth validation
    if (empty($dob)) {
        $errMsg .= "<p>Please enter your date of birth.</p>";
    } else if (!preg_match("/^((((0[1-9]|1\d|2[0-8])\/(0[1-9]|1[0-2])|(29|30)\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/((19|[2-9]\d)\d{2}))|(29\/02\/((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00))))$/", $dob)) {
        $errMsg .= "<p>Please enter a valid date of birth.</p>";
    } else {
        // Calculate age
        $parts = explode("/", $dob);
        $birthDay = (int)$parts[0];
        $birthMonth = (int)$parts[1];
        $birthYear = (int)$parts[2];
        $today = new DateTime();
        $currentDay = (int)$today->format('d');
        $currentMonth = (int)$today->format('m');
        $currentYear = (int)$today->format('Y');

        $ageYears = $currentYear - $birthYear;
        $ageMonths = $currentMonth - $birthMonth;
        $ageDays = $currentDay - $birthDay;

        if ($ageMonths < 0 || ($ageMonths === 0 && $ageDays < 0)) {
            $ageYears--;
            $ageMonths += 12;
        }

        if ($ageDays < 0) {
            $ageMonths--;
            $daysInPreviousMonth = (new DateTime())->setDate($currentYear, $currentMonth - 1, 0)->format('t');
            $ageDays = $daysInPreviousMonth + $ageDays;
        }

        if ($ageYears < 15 || $ageYears > 80) {
            $errMsg .= "<p>Applicants must be between 15 and 80 years old.</p>";
        }
    }

    // Gender validation
    if (empty($gender)) {
        $errMsg .= "<p>Please select your gender.</p>";
    }

    // Email validation
    if (empty($email)) {
        $errMsg .= "<p>Please enter your email.</p>";
    } else if (!preg_match("/[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/", $email)) {
        $errMsg .= "<p>Please enter a valid email.</p>";
    }

    // Phone number validation
    if (empty($phonenumber)) {
        $errMsg .= "<p>Please enter your phone number.</p>";
    } else if (!preg_match("/^[0-9 ]{8,12}$/", $phonenumber)) {
        $errMsg .= "<p>Please enter a valid phone number.</p>";
    }

    // Street address validation
    if (empty($address)) {
        $errMsg .= "<p>Please enter a street address.</p>";
    } else if (strlen($address) > 40) {
        $errMsg .= "<p>Please enter a street address with maximum 40 characters.</p>";
    }

    // Suburb/town validation
    if (empty($town)) {
        $errMsg .= "<p>Please enter a suburb/town.</p>";
    } else if (strlen($town) > 40) {
        $errMsg .= "<p>Please enter a suburb/town with maximum 40 characters.</p>";
    }

    // State validation
    if (empty($states)) {
        $errMsg .= "<p>Please select a state.</p>";
    }

    // Postcode validation
    if (empty($postcode)) {
        $errMsg .= "<p>Please enter a postcode.</p>";
    } else if (!preg_match("/^[0-9]{4}$/", $postcode)) {
        $errMsg .= "<p>Postcode must be 4 digits.</p>";
    } else {
        // State and postcode validation
        switch ($states) {
            case "VIC":
                if ($postcode[0] !== "3" && $postcode[0] !== "8") {
                    $errMsg .= "<p>VIC postcode must start with 3 or 8.</p>";
                }
                break;
            case "NSW":
                if ($postcode[0] !== "1" && $postcode[0] !== "2") {
                    $errMsg .= "<p>NSW postcode must start with 1 or 2.</p>";
                }
                break;
            case "QLD":
                if ($postcode[0] !== "4" && $postcode[0] !== "9") {
                    $errMsg .= "<p>QLD postcode must start with 4 or 9.</p>";
                }
                break;
            case "NT":
                if ($postcode[0] !== "0") {
                    $errMsg .= "<p>NT postcode must start with 0.</p>";
                }
                break;
            case "WA":
                if ($postcode[0] !== "6") {
                    $errMsg .= "<p>WA postcode must start with 6.</p>";
                }
                break;
            case "SA":
                if ($postcode[0] !== "5") {
                    $errMsg .= "<p>SA postcode must start with 5.</p>";
                }
                break;
            case "TAS":
                if ($postcode[0] !== "7") {
                    $errMsg .= "<p>TAS postcode must start with 7.</p>";
                }
                break;
            case "ACT":
                if ($postcode[0] !== "0") {
                    $errMsg .= "<p>ACT postcode must start with 0.</p>";
                }
                break;
        }
    }

    // Skill validation
    if (empty($skills)) {
        $errMsg .= "<p>Please select at least one skill.</p>";
    }

    // Other skills textarea validation
    if (in_array("other_skills", $skills) && empty($other_skills_textarea)) {
        $errMsg .= "<p>Please type in other skills.</p>";
    }

    // Job reference number validation
    if (empty($ref)) {
        $errMsg .= "<p>Please enter job reference number.</p>";
    }

    // Display validation result and errors
    if (!empty($errMsg)) {
    echo "<h2> Form Validation </h2>";
    echo "<h3> Error list: </h3>";
    echo $errMsg;
    } else {

    // Set up the SQL command to add the data into the table
	$query = "insert into $sql_table"
        ."(job_reference_number, first_name, last_name, street_address, suburb_town, state, 
        postcode, email_address, phone_number, checkbox_skills, other_skills)"
        . " values "
        ."('$ref', '$firstname', '$lastname', '$address', '$town', '$states', 
        '$postcode', '$email', '$phonenumber', '$skills_list', '$other_skills_textarea')";
        // execute the query
        $result = mysqli_query($conn, $query);
    // checks if the execution was successful
    if(!$result) {
        echo "<p class=\"wrong\">Something is wrong with ",	$query, "</p>";  //Would not show in a production script 
    } else {
    // display an operation successful message
    $EOInumber = mysqli_insert_id($conn);
    $firstname = htmlspecialchars(trim($_POST['givenname']));
        echo "<p class=\"ok\">Your EOI has been successfully added!<br> 
                Your EOI number is $EOInumber</p>";
    } // if successful query operation

        // close the database connection
    mysqli_close($conn);
    }
}

?>
    <?php include 'footer.inc'; ?>
</body>
</html>