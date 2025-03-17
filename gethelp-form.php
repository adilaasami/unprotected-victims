<?php
// Backup if javascript disabled
// For metadata
$title = "UnProtected Victims Get Help Form";
// Placeholders
$err = false;
$emailInvalid = false;
$missing = array();
$msgType = "errMsg";
$message = "All fields are required!";
include 'shared.php';
// If submitted
if(array_key_exists('submit',$_POST))
{ // Arrays
  $expected = array("nameInput", "commentInput", "emailInput", "confirmationInput");
  $messageLabel = array("nameMessage", "commentMessage", "emailMessage", "confirmationMessage");
// Loop through
  foreach($expected as $index => $field)
  { // Grab input
    $userInput = $_POST[$field];

    if(!is_array($userInput))
      $userInput = trim($userInput);
      // Push to missing
    if(empty($userInput))
    {
      array_push($missing, $messageLabel[$index]);
    }
    else {
      ${$field} = $userInput;
    }
  }
  // Email validation
  if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$emailInput))
  {
    $err = true;
    $emailInvalid = true;
    $emailMessage = "Email is invalid. It must contain an @ symbol and be registered to a valid domain.";
    if(!empty($confirmationInput))
      $confirmationMessage = "This email is also invalid.";
  }
  // Confirmation Validation
  if($emailInput != $confirmationInput && !empty($emailInput) && !empty($confirmationInput) != "")
  {
    $err = true;
    $confirmationMessage = "The two emails do not match.";
    if($emailInvalid)
      $emailMessage = "This is not a valid email and the emails do not match. They must contain an @ symbol and be registered to a valid domain.";
    else{
      $emailMessage = "The emails do not match.";
    }
  }
  // If the confirmation was filled out and the email wasn't
  if(!empty($confirmationInput) && empty($emailInput))
  {
    $err = true;
    $confirmationMessage = "Please fill out your email first.";
    if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$confirmationInput))
    $confirmationMessage .= " The entered input is also invalid. It must contain an @ symbol and be registered to a valid domain.";
  }
  // Name validation
  if(!preg_match("/^[a-zA-Z-' ]*$/",$nameInput))
  {
    $err = true;
    $nameMessage = "Please enter a valid name";
  }


  if(empty($missing) && !$err)
  {

      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      // the message
      $commentInput = nl2br(htmlentities($_POST['commentInput']));
      $msg = 'Name: '.$_POST['nameInput'].'<br>';
      $msg .='Email: ' .$_POST['emailInput'].'<br>';
      $msg .='Comment: '.$commentInput.'<br>';


      // send email
      $cMsg = "Thank you for reaching out to UnProtectedVictims.<br>Your Get Help Form has been submitted and is being reviewed by the UnProtected Victims team. We will be in touch within 1-2 business days. This email serves as a confirmation for your purposes. If you have any further questions or need any help in the meantime please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Below is the information submitted.<br>".$msg."<br>Thank you!";
      $result = mail("isaac.kolodny@mavs.uta.edu","Get Help Form Submitted",$msg, $headers);
      mail($emailInput, "UnProtectedVictims Get Help Form Received",$cMsg, $headers);
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
      //using variable variable to set the missing message with default response
      //grab the field name
      $f = substr($m, 0, -7);
      ${$m} = "Please fill in your $f.";
    }
    $message = "Please fix the following errors below.";

  }
}


?>
<?=$header?>
</head>
<body>
<?=$nav?>
<main>

  <div class="hero get-help-hero-help">
    <h1>Get Help Form</h1>
  </div>
  <div class="container-fluid">
    <div class=" row d-flex justify-content-around">
      <div class="col-xs-12 col-md-5 form-img-get-help">
        <h2>Ask for Help</h2>
          <p>Please fill out this form to send an email to Ms. Melissa who will get back to you as soon as possible with how we can help. </p>
      </div>
      <div class="contact col-xs-12 col-md-7">
            <form id="newForm" action="#message" method="POST">
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
                <label for="comment" class="form-label">What can we do for you? </label>
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
</main>
<?=$footer?>


  </body>
</html>
