<?php
// Meta data
$title = "Contact UnProtected Victims";
include 'shared.php'?>
<!--Header-->
<?=$header?>
<script>
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

  document.getElementById('contact-form').addEventListener('submit', process, false);

}

function process(evt){
  // Disable submit button
  // Prevent form submission
  var evt = (evt) ? evt : ((window.event) ? event : null);
  if(evt)
  {
    if (evt.preventDefault)
    {
      evt.preventDefault();
    } else {
      evt.returnValue = false;
    }
    // Upon blur, re-evaluate the number of errors
    if(evt.type=="blur")
    {
      errorCheck(evt);
    }
  }

	// Get the values
  name = document.getElementById('name').value;
  email = document.getElementById('email').value;
  comment = document.getElementById('comment').value;
  confirmation = document.getElementById('confirmation').value
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
		// Insert server response to the div message based on the id.
    var message = document.getElementById(id+"Message");
		message.innerHTML = chContent;
    // Add errors if the error message exists
    if(id != "contact-form" && message.firstChild != null && message.firstChild.className=='errMsg')
    {
      error(id); // Validate if email and confirmation match if filled
      if(email != "" && confirmation != "") // Toggle errors accordingly
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
  if(id == "contact-form")
    {
      fields = "&name="+name+"&email="+email+"&confirmation="+confirmation+"&comment="+comment+"&type=Contact";
      // In case the required attribute is not supported, the form will not be submitted with empty forms
      if(err.length==0 && email==confirmation && name!="" && email != "" && confirmation != "" && comment!="")
        resetForm();
        // Toggle errors if empty or not
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
      if(comment=="")
        {
            document.getElementById('commentMessage').innerHTML = "<span class='errMsg'>Please enter a comment.</span>";
          error("comment");
        }
      else{
        removeError("comment");
      }

    } // Validation for confirmation
  if(id == "confirmation")
  { // Supply email to test for match
    fields = "&email="+email;
    // If filled, set the error messages
    if(email!=confirmation && confirmation !="" && document.getElementById('emailMessage').innerHTML=="")
    if(document.getElementById('emailMessage').innerHTML=="")
      document.getElementById('emailMessage').innerHTML = "<span class='errMsg'>Emails do not match!</span>";
    else{
      document.getElementById('emailMessage').firstChild.innerHTML = "Emails do not match and are not valid either. They can not start with a special character or a number and must have an @ sign included.";
    }
  }
  // If email
  if(id == "email")
  { // Send over confirmation for match
    fields = "&confirmation="+confirmation;
    // If filled and not equal, set error message
    if(email!=confirmation && confirmation !="")
      document.getElementById('confirmationMessage').innerHTML = "<span class='errMsg'>Emails do not match!</span>";
  }
  // Cleanup to remove the error left from them not matching
  var emailPattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
  // If they match, remove the errors
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
  if(id!="contact-form" && name != "" && email != "" && confirmation != "" && comment != "" && document.getElementById('contact-formMessage').innerHTML !="" && err.length==0)
    document.getElementById('contact-formMessage').innerHTML = "<span class='successMessage'>Errors have been fixed. Go ahead and submit.</span>";
  else if(err.length > 0)
    document.getElementById('contact-formMessage').innerHTML = "<span class='errMsg'>Please fix the errors above.</span>";
  // Build url and send it over
	url = "contact_forms.php?q="+userInput+"&id="+id + fields;
	pageRequest.open("GET", url, true);
	pageRequest.send(null);

}


// Run the init function upon load
window.addEventListener('load',init,false);
</script>
</head>
<body>
<?=$nav?><!--Nav-->
<main>
<div class="hero hero-blue">
<h1>Contact Us</h1>
</div>


<div class="container contact-container">
  <div class="row">
    <div class="col-xs-12 col-md-5">
<div class="mellissa-img">
<img src="" alt="">
</div>
</div>
<div class="col-xs-12 col-md-7">
<div class="contact-text">
  <h2>Melissa Dent</h2>
<p>Founder of UnProtected Victims and LunchBox of Love, Melissa Dent works with the community to fight for a better world from many angles. </p>
<ul class='list-unstyled'>
  <li><b>Email:</b> <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a></li>
</ul>
</div>
</div>
</div>
</div>

<div class="container contact-container">
  <div class="row">
    <div class="col-xs-12 col-md-5">
<div class="nicole-img">
  <img src="" alt="">
</div>
</div>
<div class="col-xs-12 col-md-7">
<div class="contact-text">
<h2>Nicole B. White</h2>
<p>Nicole White is another champion of justice. She also works with her community to spread awareness and fight for social injustice.</p>
<ul class='list-unstyled'>
  <li><b>Email:</b> <a href='mailto:nicole@centertorise.com'>nicole@centertorise.com</a></li>
</ul>
</div>
</div>
</div>
</div>


<!--Messages for error placeholders-->
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-md-5 form-img-home">
      <h2>Let's Get In Touch</h2>
    </div>
    <div class="contact col-xs-12 col-md-7">
      <form id="contact-form" action="contact-form.php" method="POST">
        <span class="important">All fields are required!</span>
        <div>
          <label for="name" id="nameLabel" class="form-label">Name: </label>
          <input type="text" size="25" id="name" name="nameInput" class="form-control" required>
          <span id="nameMessage"></span>
        </div>
        <div>
          <label for="email" id="emailLabel" class="form-label">Email Address: </label>
          <input type="email" size="25" id="email" name="emailInput" class="form-control" required>
          <span id="emailMessage"></span>
        </div>
        <label for="confirmation" id="confirmationLabel" class="form-label">Confirm Email Address:</label>
        <input type="email" size="25" id="confirmation" name="confirmationInput" class="form-control" required>
        <span id="confirmationMessage"></span>
        <div>
          <label for="comment" id="commentLabel" class="form-label">Comment: </label>
          <textarea type="text" size="25" id="comment" name="commentInput" class="form-control" required></textarea>
          <span id="commentMessage"></span>
        </div>
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
<?=$footer?><!--Footer-->
  </body>
</html>
