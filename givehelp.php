<?php
// For metadata and section component
$title = "Volunteer with UnProtected Victims";
$sectionTitle = "Volunteer With Us";
$content = "<p>Volunteers and donations make our organization to be in the best possible position to help victims of being wrongfully jailed. We need volunteers in all sorts of positions, which are listed below. Volunteering is a great way to add work and volunteer experience to your resume all while helping out a good cause. Browse through our different positions and fill out the form at the bottom of the page to apply.
</p>";
$image="section-volunteer";
include 'shared.php'?>
<?=$header?>
<script>
// Values placeholders
var name;
var email;
var confirmation;
var experience;
var join;
var options;
var posButtons;
function init(){
  // Listen to the following elements
  form =   document.getElementsByClassName('form-control');
  for(let i = 0; i<form.length;i++)
  {
    fieldId = form[i].id;
    document.getElementById(fieldId).addEventListener('keyup', process, false);
    document.getElementById(fieldId).addEventListener('change', process, false);
    document.getElementById(fieldId).addEventListener('input', process, false);
    document.getElementById(fieldId).addEventListener('blur', process, false);
  }

  posButtons =   document.getElementsByClassName('selectPosition');
  for(let i = 0; i<posButtons.length;i++)
  {
    posButtons[i].addEventListener('click', readButtons, false);
  }
  document.getElementById('positions').addEventListener('change', process, false);
  document.getElementById('contact-form').addEventListener('submit', process, false);


}
// Fuction to process values from buttons
function readButtons(evt)
{
  // Grab options
   options = document.getElementById('positions').options;
  var evt = (evt) ? evt : ((window.event) ? event : null);
  if(evt)
  {
      // Grab innerHTML
      selectedVal = evt.target.innerHTML;
      if(selectedVal.includes("Apply for"))
      {
        // Only keep value after the word 'Apply For'
        selectedRole = selectedVal.substring(selectedVal.indexOf("Apply for") + 10);
      }
      else{
        // Only keep value after the word 'Unselect'
        selectedRole = selectedVal.substring(selectedVal.indexOf("Unselect") + 9);
      }
      // Loop over the position options
       for(let i = 0; i<options.length; i++)
       { // If a position has been selected, the two values match
         if(selectedRole == options[i].value)
         { // Add the selected attribute in the selection menu and toggle what the button says
           if(selectedVal.includes("Apply for"))
           {
             options[i].selected = true;
             action = "Unselect";
             verb = "selected";
           } // Otherwise remove
           else if(selectedVal.includes("Unselect")){
             options[i].selected = false;
             action = "Apply for";
             verb = "unselected";
           } // Set the button html and alert the user
           evt.target.innerHTML = action + " " + selectedRole;
           alert(options[i].innerHTML + " has been " + verb + " below as a position of interest.");
         }


       }
  }
}

function process(evt){
  // Grab the values
   name = document.getElementById('name').value;
   email = document.getElementById('email').value;
   confirmation = document.getElementById('confirmation').value;
   experience = document.getElementById('experience').value;
   join = document.getElementById('join').value;
   options = document.getElementById('positions').options;
  // Disable submit button
  // Prevent form submission
  // Capture the event
  var evt = (evt) ? evt : ((window.event) ? event : null);
  if(evt)
  { // Prevent form submission
    target = evt.target;
    if (evt.preventDefault)
    {
      evt.preventDefault();
    } else {
      evt.returnValue = false;
    } // Toggle error
    if(evt.type=="blur")
    {
      errorCheck(evt);
    } // Affect buttons based on selection change
    if(target.id=="positions")
    {
      if(evt.type=="change")
      {
        // Grab selected option text
        selectedVal = options[target.selectedIndex].value;
        // Loop over the position options
         for(let i = 0; i<posButtons.length; i++)
         { // If a position has been selected, the two values match
           if(posButtons[i].textContent.includes("Apply for"))
           {
             // Only keep value after the word 'Apply for'
             selectedRole = posButtons[i].textContent.substring(posButtons[i].textContent.indexOf("Apply for") + 10);
           }
           else{
             // Only keep value after the word 'Unselect'
             selectedRole = posButtons[i].textContent.substring(posButtons[i].textContent.indexOf("Unselect") + 9);
           }
           if(selectedVal == selectedRole)
           { // Add the selected attributed
             if(options[target.selectedIndex])
             {
               action = "Unselect";
             }
           } // Reset if not selected
           else if(!options[i].selected)
            action = "Apply for";
            // Set buttons html
           posButtons[i].innerHTML = action + " " + selectedRole;

         }
      }
    }




  }
// Positions capture
  var positions = [];
  //  Loop through the option list and see if any of the option is chosen.  If yes, put it in the positions array
  for (var i=0; i<options.length; i++){
    if (options[i].selected) {
      positions.push(options[i].innerHTML);
    }
  }
// Capture values
	userInput = this.value;
  id = this.id;


  	// Set up XMLHttpRequest object
  	pageRequest = GetXmlHttpObject();
      if (pageRequest==null){
        alert ("Your browser does not support AJAX! Please use the form by submitting normally with the submission button.");
        return;  // Stop the code right here
      }

      // Monitor the change of readyState
        pageRequest.addEventListener('readystatechange', function () {
    		if (pageRequest.readyState == 4){// Once it reaches 4, process the server response
    		var chContent = pageRequest.responseText;
    		//Insert server response to the div message based on the id.
        var message = document.getElementById(id+"Message");
    		message.innerHTML = chContent;
        // Toggle errors
        if(id != "contact-form" && message.firstChild != null && message.firstChild.className=='errMsg')
        {
          error(id);
          if(email != "" && confirmation != "")
          {
            if(email!=confirmation)
            {
              if(id=="confirmation")
              error('email');
              if(id=="email" && confirmation!="")
              error('confirmation');
            }
            else if(email==confirmation){
              removeError('email');
              removeError('confirmation');
            }
          }


        }
        else{
          removeError(id);
        }


    		}
    	}, false);

    	// Set up the URL
      // If it's the form send over each form field

      fields = "";
      positionsString = positions.join('+');
      if(id == "contact-form")
        {
          fields = "&name="+name+"&email="+email+"&confirmation="+confirmation+"&experience="+experience+"&join="+join+"&type=Give Help"+"&positions="+positionsString;
          // In case the required attribute is not supported, the form will not be submitted with empty forms
          if(err.length==0 && email==confirmation && name!="" && email != "" && confirmation != ""  && positionsString != "")
          { // Reset upon successful submission
            resetForm();
            for(let i=0;i<options.length;i++)
            {
              options[i].selected = false;
            }
          }
            // Toggle errors
            if(name=="")
              {
                document.getElementById('nameMessage').innerHTML = "<span class='errMsg'>Please enter a name.</span>";
                error("name");
              }
            else{
              removeError("name");
            }
            if(email=="")
              {
                document.getElementById('emailMessage').innerHTML = "<span class='errMsg'>Please enter your email.</span>";
                error("email");
              }
            else {
              removeError("email");
            }
            if(confirmation=="")
              {
                document.getElementById('confirmationMessage').innerHTML = "<span class='errMsg'>Please re-enter your email.</span>";
                error("confirmation");
              }
            else{
              removeError("confirmation");
            }
              if(positionsString == "")
                {
                  error("positions");
                  document.getElementById('positionsMessage').innerHTML = "<span class='errMsg'>Please select at least one volunteer opportunity.</span>";
                }
              else{
                removeError("positions");
              }

        }// Confirmation validation
      if(id == "confirmation")
      {
        fields = "&email="+email;
        if(email!=confirmation && confirmation !="" && document.getElementById('emailMessage').innerHTML=="")
        if(document.getElementById('emailMessage').innerHTML=="" && email!="")
          document.getElementById('emailMessage').innerHTML = "<span class='errMsg'>Emails do not match!</span>";
        else{
          document.getElementById('emailMessage').firstChild.innerHTML = "<span class='errMsg'>Emails do not match and are not valid either. They can not start with a special character or a number and must have an @ sign included.</span>";
        }
      } // Email validation
      if(id == "email")
      {
        fields = "&confirmation="+confirmation;
        if(email!=confirmation && confirmation !="")
          document.getElementById('confirmationMessage').innerHTML = "<span class='errMsg'>Emails do not match!</span>";
      }
      // Cleanup to remove the error left from them not matching
      var emailPattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
      if(email==confirmation)
      {
        if(email != "" && emailPattern.test(email))
         {
           document.getElementById('email').style.border = "none";
            document.getElementById('email').style.borderBottom = ".15em solid var(--black)";
            document.getElementById('emailMessage').innerHTML = "";
          }
        else if(confirmation != "" && emailPattern.test(confirmation))
        {
          document.getElementById('confirmation').style.border = "none";
          document.getElementById('confirmation').style.borderBottom = ".15em solid var(--black)";
          document.getElementById('confirmationMessage').innerHTML = "";
        }


      }
      // Reset message if errors have been fixed based on user input
      if(id!="contact-form" && document.getElementById('contact-formMessage').innerHTML !="" && name != "" && email != "" && confirmation != "" && positionsString != "" && err.length==0)
      {
        // If one of the fields are not required and empty we'll start with this statement
        disclaimer = "While not required, we would still love to hear about ";
        if(join != "" && experience != "")
          value =  "There are no errors. You can go ahead and submit.";
        else if(join == "" && experience == ""){
          value = disclaimer + "your experiences and why you would like to join our team!";
        }
        else if(join == ""){
          value = disclaimer + "why you would like to join our team!";
        }
        else{
          value = disclaimer + "your experiences!"
        }
        // Put together the statement
          document.getElementById('contact-formMessage').innerHTML = "<span class='successMessage'>"+value+"</span>";


      } // Error statement
      else if(err.length > 0)
        document.getElementById('contact-formMessage').innerHTML = "<span class='errMsg'>Please fix the errors above.</span>";


        // Build the url
        url = "contact_forms.php?q="+userInput+"&id="+id + fields;
        pageRequest.open("GET", url, true);
        pageRequest.send(null);



}// Upon load run init
window.addEventListener('load',init,false);
</script>
</head>
<body>
<?=$nav?> <!--Nav-->
<main>
<div class="hero hero-blue">
  <h1>Give Help</h1>
</div>

<?php
// Section component
echo $section;
// Donate component
echo $donate;
 ?>




<div class="container">
  <div class="row positions-heading">
    <div class="col-12 ">
  <h2>Volunteer Positions</h2>
</div>
<div class="col-12">
  <div class="volunteerRoles">
  <div class="card" style="width: 18rem;">
      <img class="card-img-top" src="images/volunteer.jpg" alt="Volunteer">
      <div class="card-body">
        <h5 class="card-title">General Volunteer</h5>
        <p class="card-text">Just want to lend a helping hand? Perfect, because we need you! We always need helping hands to work at events and prep marketing materials. Please apply by using the form at the bottom of the page.
    </p>
    <div class="d-flex flex-center">
      <button class="selectPosition" value="General">Apply for General</button>
    </div>
      </div>
    </div>

  <div class="card" style="width: 18rem;">
  <img class="card-img-top" src="images/lawyer.jpg" alt="Lawyer">
  <div class="card-body">
    <h5 class="card-title">Laywer</h5>
    <p class="card-text">Many of our victims need legal guidance and are not aware of what their rights are. If you would like to donate time to help advise those in need, please fill out the form at the bottom of the page.</p>
    <div class="d-flex flex-center">
      <button class="selectPosition" value="Lawyer">Apply for Lawyer</button>
    </div>
  </div>
</div>
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="images/copywriter1.jpg" alt="Copywriter">
  <div class="card-body">
    <h5 class="card-title">Copywriter</h5>
    <p class="card-text">We need copywriters to help spread awareness by writing content for flyers, our website, and other marketing materials. If you have that skill set and are looking for some experience, please fill out the form at the bottom of the page.
</p>
<div class="d-flex flex-center">
  <button class="selectPosition" value="Copywriter">Apply for Copywriter</button>
</div>
  </div>
</div>
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="images/photographer.jpg" alt="Photographer">
  <div class="card-body">
    <h5 class="card-title">Photographer</h5>
    <p class="card-text">We need photographers to take pictures at our events so that we may use them on our website and marketing materials. If you are passionate about photography and standing against civil injustice please apply by using the form at the bottom of the page.</p>
    <div class="d-flex flex-center">
      <button class="selectPosition" value="Photographer">Apply for Photographer</button>
    </div>
  </div>
</div>
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="images/socialmedia.jpg" alt="Social Media">
  <div class="card-body">
    <h5 class="card-title">Social Media Marketer</h5>
    <p class="card-text">We need to get people involved and aware, social media is vital to that mission. If you are looking to get some social media marketing and volunteer experience added to your resume, this is the position for you.  Please apply by using the form at the bottom of the page.</p>
    <div class="d-flex flex-center">
      <button class="selectPosition" value="Marketer">Apply for Marketer</button>
    </div>
</div>
</div>
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="images/activisit.jpg" alt="Activist">
  <div class="card-body">
    <h5 class="card-title">Activist</h5>
    <p class="card-text">We need people to help spread our message! There is power in numbers so the more the merrier. If you would like to donate time to be at our events and stand against civil injustice, please fill out the form at the bottom of the page.
</p>
  <div class="d-flex flex-center">
    <button class="selectPosition" value="Activist">Apply for Activist</button>
  </div>
  </div>
</div>

</div></div>
</div>

</div>



 <div class="container-fluid">
  <div class="row d-flex justify-content-around">
    <div class="col-xs-12 col-md-5 form-img-apply">
      <h2>Apply </h2>
      <p> Please fill out this form to let us know what position you would be interested in volunteering for. This will send us an email with your information and we will email you back as soon as possible.</p>
    </div>
    <div class="contact col-xs-12 col-md-7">
      <span class="important">* fields are required</span>
      <form id="contact-form" action="givehelp-form.php" method="POST">
      		<label for="name" id="nameLabel" class="form-label">Name*: </label>
      		<input type="text" size="25" id="name" name="nameInput" class="form-control" required>
          <span id="nameMessage"></span>
          <label for="email" id="emailLabel" class="form-label">Email Address*: </label>
          <input type="email" size="25" id="email" name ="emailInput"class="form-control" required>
          <span id="emailMessage"></span>
          <label for="confirmation" id="confirmationLabel" class="form-label">Confirm Email Address*:</label>
          <input type="email" size="25" id="confirmation" name="confirmationInput" class="form-control" required>
          <span id="confirmationMessage"></span>
        <label for="positions">Choose Volunteer Opportunities*:</label>
        <select name="positions" id="positions" multiple size="6" required>
          <option value="General">General Volunteer</option>
          <option value="Lawyer">Lawyer</option>
          <option value="Copywriter">Copywriter</option>
          <option value="Photographer">Photographer</option>
          <option value="Marketer">Social Media Marketer</option>
          <option value="Activist">Activist</option>
      </select>
      <span id="positionsMessage"></span>

          <label for="experience" id="experienceLabel" class="form-label">Relevant Experience: </label>
          <textarea type="text" rows="3" size="25" id="experience" name="experienceInput" class="form-control"></textarea>
          <span id="experienceMessage"></span>
          <label for="join" id="joinLabel" class="form-label">Why You Would Like to Work With Us? </label>
          <textarea type="text" rows="3" size="25" id="join" name="join" class="form-control"></textarea>
          <span id="joinMessage"></span>
        <div>
      		<label></label>
      		<input type="submit" value="Send" name="submit" id="submit" class="mt-3">
      	</div>
        <span id="contact-formMessage"></span>
      </form>

  </div>
  </div>
</div>
</main>
<?=$footer?> <!--Footer-->
  </body>
</html>
