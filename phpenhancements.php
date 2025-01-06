<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body>
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>
    <hr class="special">
<section class="enhancements">
<section id="enhancement1">
   <h2>Registration and Login for Managers</h2>
   <p>The registration and login feature for managers allows secure access to manage and view applications from applicants.</p> 
    <p>This functionality ensures that only authorized personnel can enter the system, maintaining confidentiality and data integrity.</p>
        <p>Managers must register and log in to access the system, with a security measure in place: if login attempts exceed three incorrect tries, a timeout is triggered to prevent unauthorized access. <p>
        <p> This robust feature safeguards sensitive information while providing managers with the necessary tools to efficiently oversee the hiring process.</p>
    <p>This effect can be viewed here: <a href="login.php">Login webpage</a> and <a href="registration.php">Register webpage</a></p>
</section>
<section id="enhancement2">
    <h2>Position Creation Feature</h2>
    <p>The position creation feature empowers hiring managers to dynamically generate and store new job positions directly within the system's database. This functionality streamlines the process of adding and managing vacancies,</p> 
    <p>enabling managers to respond promptly to evolving staffing needs. By leveraging this feature, hiring managers can efficiently create, edit, and update job positions, ensuring that the system remains up-to-date with the latest</p> 
    <p>recruitment requirements. With seamless integration into the database, this feature offers a centralized and organized approach to managing job openings, enhancing overall efficiency and effectiveness in the hiring process</p>
    <p>This effect can be viewed here: <a href="create.php">Create positions webpage</a> and <a href="jobs.php">Jobs webpage</a></p>
</section>
</section>
    <?php include 'footer.inc'; ?>
    </body>
</html>