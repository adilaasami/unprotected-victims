<?php
// This is a backup for form submission if javascript is disabled
// for metadata
$title = "UnProtected Victims Get Help Form";
// Flag err and emailInvalid as false
$err = false;
$emailInvalid = false;
// Missing array placeholder
$missing = array();
// Placeholders for messages
$msgType = "errMsg";
$message = "All fields are required!";
include 'shared.php';
// Upon submission
if(array_key_exists('submit',$_POST))
{ // Expected and messagelabel arrays
  $expected = array("nameInput", "commentInput", "emailInput", "confirmationInput");
  $messageLabel = array("nameMessage", "commentMessage", "emailMessage", "confirmationMessage");
  // Loop through
  foreach($expected as $index => $field)
  {
    // Store input
    $userInput = $_POST[$field];

    if(!is_array($userInput))
      $userInput = trim($userInput);
    // Determine if missing
    if(empty($userInput))
    {
      array_push($missing, $messageLabel[$index]);
    }
    else {
      ${$field} = $userInput;
    }
  }
  // Validation for email
  if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$emailInput))
  {
    // Set err and emailInvalid
    $err = true;
    $emailInvalid = true;
    $emailMessage = "Email is invalid. It must contain an @ symbol and be registered to a valid domain.";
    if(!empty($confirmationInput))
      $confirmationMessage = "This email is also invalid.";
  }
  // Validation for confirmation
  if($emailInput != $confirmationInput && !empty($emailInput) && !empty($confirmationInput) != "")
  {
    // Set err
    $err = true;
    $confirmationMessage = "The two emails do not match.";
    // Adjust based on validity of email
    if($emailInvalid)
      $emailMessage = "This is not a valid email and the emails do not match. They must contain an @ symbol and be registered to a valid domain.";
    else{
      $emailMessage = "The emails do not match.";
    }
  }
  // If the confirmation was filled out and the email wasn't
  if(!empty($confirmationInput) && empty($emailInput))
  {
    // Set err
    $err = true;
    $confirmationMessage = "Please fill out your email first.";
    // Check validity of confirmation
    if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$confirmationInput))
    $confirmationMessage .= " The entered input is also invalid. It must contain an @ symbol and be registered to a valid domain.";
  }
  // Validation of name
  if(!preg_match("/^[a-zA-Z-' ]*$/",$nameInput))
  {
    // Set err
    $err = true;
    $nameMessage = "Please enter a valid name";
  }


  if(empty($missing) && !$err)
  {
    // HTML email
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      // The message
      $commentInput = nl2br(htmlentities($_POST['commentInput']));
      $msg = 'Name: '.$_POST['nameInput'].'<br>';
      $msg .='Email: ' .$_POST['emailInput'].'<br>';
      $msg .='Comment: '.$commentInput.'<br>';
      // Send email
      $cMsg = "Thank you for reaching out to UnProtectedVictims.<br>Your Get Help Form has been submitted and is being reviewed by the UnProtected Victims team. We will be in touch within 1-2 business days. This email serves as a confirmation for your purposes. If you have any further questions or need any help in the meantime please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Below is the information submitted.<br>".$msg."<br>Thank you!";
      $result = mail("isaac.kolodny@mavs.uta.edu","Contact Form Submitted",$msg, $headers);
      mail($emailInput, "UnProtectedVictims Contact Form Received",$cMsg, $headers);
      if($result) {
        $msgType = "successMessage";
        $message = "The email form was submitted! We will be in touch within 1-2 business days. If you do not hear from us, please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. A confirmation email will be sent shortly to $emailInput. Thank you!";
      } else {
        $message = "Email was not able to send. Please contact the support team at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Thank you!";
      }
      $message.= "<br>Explore the rest of our site from our <a href='index.php'>homepage</a> or by visting other pages in our navigation.";


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
    $message = "Please fix the following errors below.";

  }
}


?><!--Header-->
<?=$header?>
</head>
<body>
<?=$nav?><!--Nav-->
<main>

  <div class="hero get-help-hero-help">
    <h1>Contact Form</h1>
  </div>
  <div class="container-fluid">
    <div class=" row d-flex justify-content-around">
      <div class="col-xs-12 col-md-5 form-img-home">
        <h2>Let's Get In Touch</h2>
      </div>
      <div class="contact col-xs-12 col-md-7">
            <form id="newForm" action="" method="POST">   <!--Fill with values upon errors with validation-->
              <?="<span id='message' class='$msgType'>$message</span>";?>
            		<label for="name" class="form-label">Name: </label>
            		<input type="text" size="25" name="nameInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($nameInput);?>" required >
                <?="<span class='errMsg'>$nameMessage</span>";?>
                <label for="email" class="form-label">Email Address: </label>
                <input type="email" size="25" name="emailInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($emailInput);?>" required>
                <?="<span class='errMsg'>$emailMessage</span>";?>
                <label for="confirmation" class="form-label">Confirm Email Address:</label>
                <input type="email" size="25" name="confirmationInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($confirmationInput);?>" required>
                <?="<span class='errMsg'>$confirmationMessage</span>";?>
                <label for="comment" class="form-label">Comment:</label>
                <textarea type="text" rows="10" size="25" name="commentInput" class="form-control" required><? if(!empty($missing) || $err) echo htmlentities($commentInput);?></textarea>
                <?="<span class='errMsg'>$commentMessage</span>";?>
            		<div>
            		<button type="submit" value="Send" name="submit" class="mt-3">Send</button>
      </div>
            </form>
    </div>
    </div>
  </div>
</div>
</main><!--Footer-->
<?=$footer?>


  </body>
</html>
