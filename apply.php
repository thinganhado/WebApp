<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body class="apply_body" data-page="apply">
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>

    <hr class="special">
<!--Application form-->
<section class="form">
	<h1>JOIN OUR TALENT POOL</h1>
	<form method="post" action="processEOI.php" id="regform" novalidate="novalidate">
    <section class="form_columns">
    <section class="form_left">
        <p>
            <label for="ref">Job reference number</label> <!--Pattern specicially for ref number-->
            <input id="ref" type="text" name="ref" pattern= "^[S]{1}[D]{1}[0-9]{3}" maxlength="5" required="required">
            <span id="refError" class="error"></span>
        </p>
        <p>
            <label for="firstname">First Name</label> 
            <input id="firstname" type="text" name="givenname" pattern="^[a-zA-Z ]+$" maxlength="20" required="required">
            <span id="firstnameError" class="error"></span>
        </p>
        <p>    
            <label for="lastname">Family Name</label> 
            <input id="lastname" type="text" name="familyname" pattern="^[a-zA-Z ]+$" maxlength="20" required="required">
            <span id="lastnameError" class="error"></span>
        </p>
        <p>
            <label for="date">Date of Birth</label> 
            <input id="date" type="text" name="date" placeholder="dd/mm/yyyy" pattern="(?:((?:0[1-9]|1[0-9]|2[0-9])\/(?:0[1-9]|1[0-2])|(?:30)\/(?!02)(?:0[1-9]|1[0-2])|31\/(?:0[13578]|1[02]))\/(?:19|20)[0-9]{2})">
            <span id="dobError" class="error"></span>
        </p>
        <fieldset id="gender" class="gender">
		    <legend>Gender</legend>
            <p>
                <input id="female" type="radio" name="gender" value="F" required="required">
                <label for="female">Female</label>
                <input id="male" type="radio" name="gender" value="M">
                <label for="male">Male</label>
                <input id="unspecified" type="radio" name="gender" value="X">
                <label for="unspecified">Unspecified</label>
	        </p>
            <span id="genderError" class="error"></span>
        </fieldset>
        <p>
            <label for="email">Email address</label> 
            <input id="email" type="text" name="email" pattern="[aZ-zA0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required="required">
            <span id="emailError" class="error"></span>
        </p> 
        <p>
            <label for="phone">Phone number</label> 
            <input id="phone" type="text" name="phone" pattern="[0-9 ]{8,12}" required="required">
            <span id="phoneError" class="error"></span>
        </p> 
    </section>
    <section class="form_right">
        <p>
            <label for="address">Street Address</label> 
            <input id="address" type="text" name="address" maxlength="40" required="required">
            <span id="streetError" class="error"></span>
        </p>
        <p>
            <label for="town">Suburb/Town</label> 
            <input id="town" type="text" name="town" maxlength="40" required="required">
            <span id="townError" class="error"></span>
        </p>
        <p>
            <label for="state">State</label> 
            <select id="state" name="state">
                <option value="">Please select</option>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="NT">NT</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
            </select>
            <span id="stateError" class="error"></span>
        </p>
        <p>
            <label for="postcode">Postcode</label> 
            <input id="postcode" type="text" name="postcode" pattern= "\d{4}" required="required">
            <span id="postcodeError" class="error"></span>
        </p>
        <p>Skill list</p>

<!-- Checkbox skills -->
        <p class="checkbox">
            <input id="html" type="checkbox" name="checkbox_skills[]" value="html" checked="checked">
            <label for="html">HTML</label><br>
            <input id="css" type="checkbox" name="checkbox_skills[]" value="css">
            <label for="css">CSS</label><br>
            <input id="other_skills" type="checkbox" name="checkbox_skills[]" value="other_skills">
            <label for="other_skills">Other skills</label><br>
        </p>
        <span id="skillError" class="error"></span>

        <p>
            <label for="other_skills_textarea">Other skills</label><br>
            <textarea id="other_skills_textarea" name="textarea_skills" placeholder="Write description of your other skills here..." rows="4" cols="40"></textarea>
            <span id="textareaError" class="error"></span>
        </p>
    </section>
    </section>
        <p class="button_container">
            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </p>
	</form>
</section>
    <?php include 'footer.inc'; ?>
</body>
</html>