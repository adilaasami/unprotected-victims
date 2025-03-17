<?php
// Start the session.
session_start();
// For metadata
$title = "UnProtected Victims Admin Registration";
include('shared.php');
include("dbconn.inc.php");
//Connects the database.
$conn = dbConnect();
// Initialize the statement
$stmt = $conn->stmt_init();
// Query for determining the db hashed password
$sql = "SELECT * FROM Logins WHERE email = ?";
// Flag to determine if email is not used
  $emailValid = 0;
  // If sql could be prepared
  if ($stmt->prepare($sql)){
    // Bind the email
    $stmt->bind_param('s', $email);
    // Execute
    $stmt->execute();
    // Store the result
    $stmt->store_result();
    // If there are no rows, the email is valid
    if($stmt->num_rows !== 0){
      $emailValid = 1;
    }
    $stmt->close();
  }

// Form submission backup if ajax disabled
// If the register button has been clicked
if(array_key_exists('register',$_POST))
{
  $expected = array("email", "psw");
  $outputLabel = array("emailMessage", "passwordMessage");
    $error = false;
    // Loop through the required items
    foreach($expected as $index => $field)
    { // Store the user input
      $userInput = $_POST[$field];
      // If the input is empty put it in the missing array
      if(empty($userInput))
        array_push($missing, $outputLabel[$index]);
        // Else use variable variable to save the input
      else {
        ${$field} = $userInput;
      }
    }
    // If nothing is missing
    if(empty($missing))
    { // If the email is valid, compose the message
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $error = true;
        $emailMessage = "<span class='errMsg'>Please enter a valid email. It can not start with a special character or a number and must have an @ sign included.</span>";
      }
      if(strlen($psw) < 7)
      {
        $error = true;
        $passwordMessage = "<span class='errMsg'>Please enter a valid password. It must be at least 7 characters.</span>";

      }
      if($error)
      {
        $message = "<span class='errMsg'>Please fix the errors below.</span>";
      }
      else{ // Hash the password
        $hashed_password = password_hash($psw, PASSWORD_DEFAULT);
        // Initialize the statement
        $stmt = $conn->stmt_init();
        // Query for determining the db hashed password
        $sql = "SELECT * FROM Logins WHERE email = ?";
        // Flag to determine if email is not used
          $emailValid = 0;
          // If sql could be prepared
          if ($stmt->prepare($sql)){
            // Bind the email
            $stmt->bind_param('s', $email);
            // Execute
            $stmt->execute();
            // Store the result
            $stmt->store_result();
            // If there are no rows, the email is valid
            if($stmt->num_rows !== 0){
              $emailValid = 1;
            }
            $stmt->close();
          }

 // Else there is already one email and it is invalid
  $stmt = $conn->stmt_init();
          if($emailValid === 0)
          { // Insert query
            $sql = "INSERT INTO Logins(`email`, `password`) VALUES (?, ?)";
            // If prepared
            if($stmt->prepare($sql)){
              // Bind both the email and hashed password
              $stmt->bind_param('ss', $email, $hashed_password);

              // Set the statement as prepared
              $stmt_prepared = 1;
            } // If prepared
            if ($stmt_prepared == 1){
              // If executed
              if ($stmt->execute()){
                $message = "<span class='successMessage'>Congrats! A new admin has been registered to $email. Please have them log in via the link in the footer to get started.</span>";
                // Compose the messages
              } else {
                // If the execution failed
                $message = "<span class='errMsg'>The account was not added to the database.  Please contact the web team.</span>";
              }
            } else{
              $message = "<span class='errMsg'>Database query failed.  Please contact the webmaster.</span>";
            }
            // Close the statement
            $stmt->close();
            // Close the connection
            $conn->close();
          }
          else{
            $emailMessage = "<span class='errMsg'>An account with this email is already taken. Please use a different email.</span>";
          }
      }



    }
    else
    {
      foreach($missing as $m)
      {
        // Using variable variable to set the missing message with default response
        // Grab the field name
        $f = substr($m, 0, -7);
        ${$m} = "Please fill in your $f.";
      }
      $message = "<span class='errMsg'>Please fix the errors below.</span>";
  }

}
// Return the field if there are errors
function returnValue($field)
{
  global $missing;
  global $error;
   if(!empty($missing) || $error || $emailValid == 1)
    return $field;
}
// Body if this is for an admin
$body = "<form id='loginForm' class='w-50 mt-3 login d-flex flex-column' action='' method='post'>$message
      <label for='email'>Email: </label><input class='form-control' id='email' type='email' size='25' name='email' value='".returnValue($email)."' required>
      <span id='emailMessage'>$emailMessage</span>
      <label for='password'>Password: </label><input class='form-control' id='password' type='password' size='25' name='psw' value='".returnValue($psw)."' required>
      <span id='passwordMessage'>$passwordMessage</span>
      <br><button type='submit' name='register'>Register This Admin</button>
      <span id='loginFormMessage'>
  </form>";
?>
<?=$header?>
<script>
function init()
{
  // Listen to  the following elements
  form =   document.getElementsByClassName('form-control');
  for(let i = 0; i<form.length;i++)
  {
    fieldId = form[i].id;
    document.getElementById(fieldId).addEventListener('keyup', process, false);
    document.getElementById(fieldId).addEventListener('change', process, false);
    document.getElementById(fieldId).addEventListener('input', process, false);
    document.getElementById(fieldId).addEventListener('blur', process, false);
  }

  document.getElementById('loginForm').addEventListener('submit', process, false);
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
    // Evaluate errors upon blur
    if(evt.type=="blur")
    {
      errorCheck(evt);
    }
  }

	// Get the values
  email = document.getElementById('email').value;
  password = document.getElementById('password').value;
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
		if (pageRequest.readyState == 4){// Once it reaches 4 process the server response
		var chContent = pageRequest.responseText;
		// Insert server response to the div message based on the id.
    var message = document.getElementById(id+"Message");
		message.innerHTML = chContent;
    // Toggle error messages
    if(id != "loginForm" && message.firstChild != null && message.firstChild.className=='errMsg')
    {
      error(id);


    }
    else{
      removeError(id);
    }


		}
	}, false);


	// Set up the URL
  // If it's the form send over each form field

  fields = "";
  if(id == "loginForm")
    {
      fields = "&email="+email+"&password="+password;
      // In case the required attribute is not supported, the form will not be submitted with empty forms
      if(err.length==0 && email != "" && password != "")
      {
        form =   document.getElementsByClassName('form-control');
        for(let i = 0; i<form.length;i++) // Toggle errors
        {
          fieldId = form[i].id;

          document.getElementById(fieldId +"Message").innerHTML="";
          document.getElementById(fieldId).style.border = "none";
          document.getElementById(fieldId).style.borderBottom = ".15em solid var(--black)";
          removeError(id);
        }
      }

      if(email=="")
        {
          document.getElementById('emailMessage').innerHTML = "<span class='errMsg'>Please enter an email.</span>";
          error("email");
        }
      else{
        removeError("email");
      }
      if(password=="")
        {
            document.getElementById('passwordMessage').innerHTML = "<span class='errMsg'>Please enter a password.</span>";
          error("password");
        }
      else{
        removeError("password");
      }

    }
  // Cleanup to remove the error left from them not matching
  var emailPattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;

    if(email != "" && emailPattern.test(email))
     {
       document.getElementById('email').style.border = "none";
        document.getElementById('email').style.borderBottom = ".15em solid var(--black)";
        document.getElementById('emailMessage').innerHTML = "";
      }



  // Reset message if errors have been fixed based on user input
  if(id!="loginForm" && email != "" && password != "" && document.getElementById('loginFormMessage').innerHTML !="" && err.length==0)
    document.getElementById('loginFormMessage').innerHTML = "";
  else if(err.length > 0)
    document.getElementById('loginFormMessage').innerHTML = "<span class='errMsg'>Please fix the errors above.</span>";
    // Send over built url
	url = "create.php?q="+userInput+"&id="+id + fields;
	pageRequest.open("GET", url, true);
	pageRequest.send(null);

}


// Init upon load
window.addEventListener('load',init,false);
</script>
<?php
// Toggle error
if(isset($_POST['email']) && $_POST['email'] != "")
{
  if($emailValid==1)
  {
    echo "<script>error('email');</script>";
  }
  else{
    echo "<script>removeError('email');</script>";
  }
}
 ?>
</head>
<body>
    <?= $nav ?> <!--Shared nav-->
  <main>

  <div class="hero get-help-hero">
    <h1>Create Account</h1>
  </div>
<div class="container-fluid my-5"> <!--Bootstrap grid-->
    <div class="row">
  <div class="col-12 d-flex flex-column justify-content-center align-items-center error">
    <span class="important">Both fields are required! Your password must be at least 7 characters.</span>
</div>
<div class="col-12 d-flex justify-content-center">
  <?php
            if($_SESSION['access']) // If the user is logged in as an admin echo the admin main info, otherwise put a disclaimer.
                    echo $body;
                  else {
                    echo "<div class='d-flex flex-column align-items-center'><h2>Restricted Access</h2><p>You do not have the proper credentials to be in this area. Please return
                    to the <a href='index.php'>home page</a>. If you believe this is a mistake please contact the web team. Thank you!</div>";
                  }?>
</div>
</div>
</div>

</main>
<?php print $footer?>



  </body>
</html>
