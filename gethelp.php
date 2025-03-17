<?php
// For metadata
$title = "UnProtected Victims";
// For section components
$sectionTitle = "We Are Here to Help";
$content = "<p>If you are a victim who has been wrongfully jailed and then released with little to no explanation from the police or any similar situation we are here to help. We have resources for nonprofit lawyers, mental health resources, as well as a form for you to contact us with any other needs you may have. </p>";
include 'shared.php';



?>
<?=$header?>
<script>
function init(){
  // listen to the following elements
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
    // Toggle on blur
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
    if(id != "contact-form" && message.firstChild != null && message.firstChild.className=='errMsg')
    { // Toggle errors
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
  if(id == "contact-form")
    {
      fields = "&name="+name+"&email="+email+"&confirmation="+confirmation+"&comment="+comment+"&type=Get Help";
      // In case the required attribute is not supported, the form will not be submitted with empty forms
      // Toggle errors upon submission
      if(err.length==0 && email==confirmation && name!="" && email != "" && confirmation != "" && comment!="")
        resetForm();
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
    }// Confirmation validation
  if(id == "confirmation")
  {
    fields = "&email="+email;
    if(email!=confirmation && confirmation !="" && document.getElementById('emailMessage').innerHTML=="")
    if(document.getElementById('emailMessage').innerHTML=="")
      document.getElementById('emailMessage').innerHTML = "<span class='errMsg'>Emails do not match!</span>";
    else{
      document.getElementById('emailMessage').firstChild.innerHTML = "Emails do not match and are not valid either. They can not start with a special character or a number and must have an @ sign included.";
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
  if(id!="contact-form" && name != "" && email != "" && confirmation != "" && comment != "" && document.getElementById('contact-formMessage').innerHTML !="" && err.length==0)
    document.getElementById('contact-formMessage').innerHTML = "<span class='successMessage'>Errors have been fixed. Go ahead and submit.</span>";
  else if(err.length > 0)
    document.getElementById('contact-formMessage').innerHTML = "<span class='errMsg'>Please fix the errors above.</span>";

  // Send url
	url = "contact_forms.php?q="+userInput+"&id="+id + fields;
	pageRequest.open("GET", url, true);
	pageRequest.send(null);

}


// Run init on load
window.addEventListener('load',init,false);
</script>
</head>
<body>
<?=$nav?>
<main>

<div class="hero get-help-hero-help">
<h1>Get Help</h1>
</div>
<?=$section?>

<div class="container-full resources-container">
  <div class="row justify-content-center">
    <div class=" col-xs-12 col-md-8 help-resoucres">
<div class="resources">
<h2>Helpful Resources</h2>
<h3>Nonprofit Lawyers</h3>
<div class="accordion-text">
<div class="resource-info">
<a href="https://texaslawhelp.org/directory/legal-resource/legal-aid-northwest-texas-dallas-office" title="Texas Law Help">Texas Law Help <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>


<div class="resource-info">
<a href="https://texas.freelegalanswers.org/" title="Free Legal Answers">Free Legal Answers <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>


<div class="resource-info">
<a href="https://internet.lanwt.org/en-us" title="Legal Aid of NorthWest Texas ">Legal Aid of NorthWest Texas <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>
<div class="resources">
<h3>Mental Health Resources</h3>
<div class="accordion-text">

<div class="resource-info">
<a href="https://www.mhadallas.org/" title= "Mental Health America">Mental Health America <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>


<div class="resource-info">
<a href="https://www.naminorthtexas.org/" title="National Alliance on Mental Illness">National Alliance on Mental Illness <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>

<div class="resource-info">
<a href="https://www.myresourcecenter.org/health/counseling/" title="My Resource Center.org">My Resource Center.org <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>

</div>
</div>
<div class="resources">
<h3>Other Nonprofits</h3>
<div class="accordion-text">
<div class="resource-info">
<a href="https://txcivilrights.org/criminal-injustice-reform/" title="Texas Civil Rights.org">Texas Civil Rights.org <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>
<div class="resource-info">
<a href="https://naacp.org/"title="NAACP">NAACP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>


<div class="resource-info">
<a href="https://www.aclutx.org/en" title = "ACLU">ACLU<i class="fa fa-angle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>
</div>
<div class=" d-xs-none col-md-4 no-margin">
<div class="resources-pic">
<img src=".." alt="">
</div>

</div></div></div>



<div class="container-fluid">
  <div class=" row d-flex justify-content-around">
    <div class="col-xs-12 col-md-5 form-img-get-help">
      <h2>Ask for Help </h2>
      <p> Please fill out this form to send an email to Ms. Melissa who will get back to you as soon as possible with how we can help. </p>
    </div>
    <div class="contact col-xs-12 col-md-7">
      <span class="important">All fields are required!</span>
          <form id="contact-form" action="gethelp-form.php#message" method="POST">
          		<label for="name" id="nameLabel" class="form-label">Name: </label>
          		<input type="text" size="25" id="name" name="nameInput" class="form-control" required >
              <span id="nameMessage"></span>
              <label for="email" id="emailLabel" class="form-label">Email Address: </label>
              <input type="email" size="25" id="email" name="emailInput" class="form-control" required >
              <span id="emailMessage"></span>
              <label for="confirmation" id="confirmationLabel" class="form-label">Confirm Email Address:</label>
              <input type="email" size="25" id="confirmation" name="confirmationInput" class="form-control" required>
              <span id="confirmationMessage"></span>
              <label for="comment" id="commentLabel" class="form-label">What can we do for you? </label>
              <textarea type="text" rows="10" size="25" id="comment" name="commentInput" class="form-control" required ></textarea>
              <span id="commentMessage"></span>
          		<div>
          		<button type="submit" value="Send" name="submit" id="submit" class="mt-3">Send</button>
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
