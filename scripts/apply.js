/**
 * Author: Thi Ngan Ha Do
 * Target: apply.html
 * Purpose: Form Validation and Data Transfer
 * Create: 20/04/2024
 * Last update: 26/04/2024
 * Credits:
 */

"use strict";

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.includes('apply.html')) {
    var refInput = document.getElementById("ref");
    refInput.readOnly = true;
    refInput.required = true; 

    // Prevent form submission if "ref" is blank
    var regForm = document.getElementById("regform");
    regForm.onsubmit = function(event) {
        var ref = document.getElementById("ref").value.trim();
        if (ref === "") {
            event.preventDefault(); // Prevent form submission
            document.getElementById("refError").textContent = "Please enter job reference number";
            document.getElementById("refError").style.color = "red";
            document.getElementById("refError").style.fontSize = "13px";
        }
    };
}});

//function to validate inputs 
function validate() {
    var result = true;

    if (!debug){
        validate();
    }
    
    //firstname validation
    document.getElementById("firstnameError").textContent = "";
    var firstname = document.getElementById("firstname").value;
    if (!firstname.match(/^[a-zA-Z ]{1,20}$/)) {
        document.getElementById("firstnameError").textContent = "First name must only contain up to 20 alpha characters";
        document.getElementById("firstnameError").style.color = "red"; 
        document.getElementById("firstnameError").style.fontSize = "13px";
        result = false;
    } 

    //lastname validation 
    document.getElementById("lastnameError").textContent = "";
    var lastname = document.getElementById("lastname").value;
    if (!lastname.match(/^[a-zA-Z ]{1,20}$/)) {
        document.getElementById("lastnameError").textContent = "Last name must only contain up to 20 alpha characters";
        document.getElementById("lastnameError").style.color = "red"; 
        document.getElementById("lastnameError").style.fontSize = "13px";
        result = false;
    } 

    //specific data validation: dob validation
    document.getElementById("dobError").textContent = "";
    var dob = document.getElementById("date").value;
    if (!dob.match(/^((((0[1-9]|1\d|2[0-8])\/(0[1-9]|1[0-2])|(29|30)\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/((19|[2-9]\d)\d{2}))|(29\/02\/((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00))))$/)) {
        document.getElementById("dobError").textContent = "Please enter a valid date of birth";
        document.getElementById("dobError").style.color = "red"; 
        document.getElementById("dobError").style.fontSize = "13px";
        result = false;
    }    
    
    //specific data validation: age validation
    var age = calculateAge(dob);
    if (age.year < 15 || age.year > 80) {            
        document.getElementById("dobError").textContent = "Applicants must be between 15 and 80 years old";
        document.getElementById("dobError").style.color = "red"; 
        document.getElementById("dobError").style.fontSize = "13px";
        result= false;}
    
    //gender validation
    var female = document.getElementById("female").checked;
    var male = document.getElementById("male").checked;
    var unspecified = document.getElementById("unspecified").checked;
    document.getElementById("genderError").textContent = "";
    if (!(female || male || unspecified)) {
        document.getElementById("genderError").textContent = "Please select your gender";
        document.getElementById("genderError").style.color = "red"; 
        document.getElementById("genderError").style.fontSize = "13px";
        result = false;
    }

    //email validation
    var email = document.getElementById("email").value;
    document.getElementById("emailError").textContent = "";
    if (!email.match(/[aZ-zA0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/)) {
        document.getElementById("emailError").textContent = "Please enter a valid email";
        document.getElementById("emailError").style.color = "red"; 
        document.getElementById("emailError").style.fontSize = "13px";
        result = false;
    }

    //phone number validation
    var phonenumber = document.getElementById("phone").value;
    document.getElementById("phoneError").textContent = "";
    if (!phonenumber.match(/[0-9 ]{8,12}/)) {
        document.getElementById("phoneError").textContent = "Please enter a valid phone number";
        document.getElementById("phoneError").style.color = "red"; 
        document.getElementById("phoneError").style.fontSize = "13px";
        result = false;
    }

    //street address validation
    var address = document.getElementById("address").value;
    document.getElementById("streetError").textContent = "";
    if (!address.trim() || address.length > 40) {
        if (!address.trim()) {
            document.getElementById("streetError").textContent = "Please enter a street address";
            document.getElementById("streetError").style.color = "red"; 
            document.getElementById("streetError").style.fontSize = "13px";
        } else {
            document.getElementById("streetError").textContent = "Please enter a street address with maximum 40 characters";
        }
        result = false;
    }

    //suburb/town validation
    var town = document.getElementById("town").value;
    document.getElementById("townError").textContent = "";
    if (!town.trim() || town.length > 40) {
        if (!town.trim()) {
            townError.textContent = "Please enter a suburb/town";
            document.getElementById("townError").style.color = "red"; 
            document.getElementById("townError").style.fontSize = "13px";
        } else {
            townError.textContent = "Please enter a suburb/town with maximum 40 characters";
            document.getElementById("townError").style.color = "red"; 
            document.getElementById("townError").style.fontSize = "13px";
        }
        result = false;
    }

    //state validation
    var state = document.getElementById("state").value;
    document.getElementById("stateError").textContent = "";
    if(state == "") {
        document.getElementById("stateError").textContent = "Please select a state";
        document.getElementById("stateError").style.color = "red"; 
        document.getElementById("stateError").style.fontSize = "13px";
        result = false;
    }

    //postcode validation
    var postcode = document.getElementById("postcode").value;
    var postcodeError = document.getElementById("postcodeError")
    postcodeError.textContent = "";
    if(!postcode.match(/^[0-9]{4}$/)) {
        postcodeError.textContent = "Postcode must be 4 digits";
        postcodeError.style.color = "red"; 
        postcodeError.style.fontSize = "13px";
        result = false;
    } 

    //specific data validation: state must match the first digit of the postcode
    switch (state) {
        case "VIC":
            if (postcode[0] !== "3" && postcode[0] !== "8") {
                postcodeError.textContent = "VIC postcode must start with 3 or 8";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "NSW":
            if (postcode[0] !== "1" && postcode[0] !== "2") {
                postcodeError.textContent = "NSW postcode must start with 1 or 2";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "QLD":
            if (postcode[0] !== "4" && postcode[0] !== "9") {
                postcodeError.textContent = "QLD postcode must start with 4 or 9";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "NT":
            if (postcode[0] !== "0") {
                postcodeError.textContent = "NT postcode must start with 0";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "WA":
            if (postcode[0] !== "6") {
                postcodeError.textContent = "WA postcode must start with 6";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "SA":
            if (postcode[0] !== "5") {
                postcodeError.textContent = "SA postcode must start with 5";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "TAS":
            if (postcode[0] !== "7") {
                postcodeError.textContent = "TAS postcode must start with 7";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        case "ACT":
            if (postcode[0] !== "0") {
                postcodeError.textContent = "ACT postcode must start with 0";
                postcodeError.style.color = "red"; 
                postcodeError.style.fontSize = "13px";
                result = false;
            }
            break;
        default:
            postcodeError.textContent = "Invalid state selected";
            result = false;
    }

    //skill validation
    var html = document.getElementById("html").checked;
    var css = document.getElementById("css").checked;
    var other_skills = document.getElementById("other_skills").checked;
    document.getElementById("skillError").textContent = "";
    document.getElementById("textareaError").textContent = "";
    if (!(html || css || other_skills)) {
        document.getElementById("skillError").textContent = "Please select at least one skill";
        document.getElementById("skillError").style.color = "red"; 
        document.getElementById("skillError").style.fontSize = "13px";
        result = false;
    }

    //textarea skill validation
    var other_skills_textarea = document.getElementById("other_skills_textarea").value;
    document.getElementById("textareaError").textContent="";
    if (other_skills && !other_skills_textarea.trim()) {
        document.getElementById("textareaError").textContent = "Please type in other skills";
        document.getElementById("textareaError").style.color = "red"; 
        document.getElementById("textareaError").style.fontSize = "13px";
        result = false;
    }
        //job reference number validation
    document.getElementById("refError").textContent = "";
    var ref = document.getElementById("ref").value.trim();
    if (ref === "") {
        document.getElementById("refError").textContent = "Please enter job reference number";
        document.getElementById("refError").style.color = "red";
        document.getElementById("refError").style.fontSize = "13px";
        result = false;
    }
    
    if (result){
        storeForm()
    }
    return result;
}

//function to calculate age
function calculateAge(birthdate) {
    var parts = birthdate.split("/");
    var birthDay = parseInt(parts[0], 10);
    var birthMonth = parseInt(parts[1], 10);
    var birthYear = parseInt(parts[2], 10);
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth() + 1;
    var currentYear = today.getFullYear();
    var ageYears = currentYear - birthYear;
    var ageMonths = currentMonth - birthMonth;
    var ageDays = currentDay - birthDay;
 
    //adjust age if birthdate hasn't occurred this year
    if (ageMonths < 0 || (ageMonths === 0 && ageDays < 0)) {
        ageYears--;
        ageMonths += 12;
    }
    //if days are negative, adjust months and days
    if (ageDays < 0) {
        ageMonths--;
        var daysInPreviousMonth = new Date(currentYear, currentMonth - 1, 0).getDate();
        ageDays = daysInPreviousMonth + ageDays; //calculate the correct number of days
    }
 
    return {
        year : ageYears
    };
}

//function to store form if applicants apply for the second job (session storage)
function storeForm() {
    //get all variables to be stored
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var email = document.getElementById("email").value;
    var dob = document.getElementById("date").value;
    var phonenumber = document.getElementById("phone").value;
    var address = document.getElementById("address").value;
    var town = document.getElementById("town").value;
    var state = document.getElementById("state").value;
    var postcode = document.getElementById("postcode").value;
    var other_skills_textarea = document.getElementById("other_skills_textarea").value;

    //store gender with single choice
    var female = document.getElementById("female").checked;
    var male = document.getElementById("male").checked;
    var unspecified = document.getElementById("unspecified").checked;
    var gender = "";
    if(female) gender = "Female";
    if(male) gender = "Male";
    if(unspecified) gender = "Unspecified";

    //assign all inputs to sessionStorage attribute
    sessionStorage.firstname = firstname;
    sessionStorage.lastname = lastname;
    sessionStorage.email = email;
    sessionStorage.dob = dob;
    sessionStorage.phonenumber = phonenumber;
    sessionStorage.address = address;
    sessionStorage.town = town;
    sessionStorage.state = state;
    sessionStorage.postcode = postcode;
    sessionStorage.other_skills_textarea = other_skills_textarea;
    sessionStorage.gender = gender;

    //store checkboxes with multiple choices
    var checkboxSkills = document.querySelectorAll('input[name="checkbox_skills[]"]:checked');
    var skillsString = "";
    checkboxSkills.forEach(function(skill) {
        skillsString += skill.value + ",";
    });
    sessionStorage.checkbox_skills = skillsString.slice(0, -1);
}

function prefill_form() {
    //check if values exist, if so prefill the form
    var firstname = document.getElementById("firstname");
    if (firstname) {
    if(sessionStorage.firstname !== undefined){
        document.getElementById("firstname").value = sessionStorage.firstname;
        document.getElementById("lastname").value = sessionStorage.lastname;
        document.getElementById("date").value = sessionStorage.dob;
        document.getElementById("email").value = sessionStorage.email;
        document.getElementById("phone").value = sessionStorage.phonenumber;
        document.getElementById("address").value = sessionStorage.address;
        document.getElementById("town").value = sessionStorage.town;
        document.getElementById("state").value = sessionStorage.state;
        document.getElementById("postcode").value = sessionStorage.postcode;
        document.getElementById("other_skills_textarea").value = sessionStorage.other_skills_textarea;
        //recall stored radio gender
        switch(sessionStorage.gender){
            case "Female":
                document.getElementById("female").checked = true;
                break;
            case "Male":
                document.getElementById("male").checked = true;
                break;
            case "Unspecified":
                document.getElementById("unspecified").checked = true;
                break;
        }

        //recall stored checkbox skills
        var storedSkills = sessionStorage.checkbox_skills;
        if (storedSkills !== undefined) {
            var skillsArray = storedSkills.split(",");
            skillsArray.forEach(function(skill) {
                document.getElementById(skill).checked = true;
            });
        }
    }
}}

//localStorage: job reference number
document.addEventListener('DOMContentLoaded', function() {
    var applyButtons = document.querySelectorAll('.apply_btn');
    var jobRef = localStorage.getItem('jobRef'); //retrieve the job reference number from local storage

    //iterate over each apply button
    applyButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); //prevent the default behavior of the link
            var jobRef = button.getAttribute('data-job-ref'); //extract the job reference number from the data attribute
            localStorage.setItem('jobRef', jobRef); //store the job reference number in local storage
            window.location.href = button.href; //redirect to apply.html
        });
    });

    //if job reference number exists, pre-fill the input field and make it read-only
    var refInput = document.getElementById("ref");
    if (refInput) {
        refInput.readOnly = true;
        if (jobRef) {
            refInput.value = jobRef;
        }
    }
});

function init() {
    if (window.location.pathname.includes('apply.html')) {
    var regForm = document.getElementById("regform");
    regForm.onsubmit = validate; 
}
prefill_form();
}

window.onload = init;