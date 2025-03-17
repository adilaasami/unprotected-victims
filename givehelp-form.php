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
{
  // Arrays
  $expected = array("nameInput", "emailInput", "confirmationInput", "positions", "experienceInput", "join");
  $required = array("nameInput", "emailInput", "confirmationInput", "positions");
  $messageLabel = array("nameMessage", "emailMessage", "confirmationMessage", "positionsMessage", "experienceMessage", "joinMessage");
// Loop through
  foreach($expected as $index => $field)
  {
    // User input
    $userInput = $_POST[$field];

    if(!is_array($userInput))
      $userInput = trim($userInput);
      // Determine if missing
    if(in_array($field, $required) && empty($userInput))
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
  } // Confirmation validation
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
  } // Name validation
  if(!preg_match("/^[a-zA-Z-' ]*$/",$nameInput))
  {
    $err = true;
    $nameMessage = "Please enter a valid name";
  }
  // Output if a nonrequired field is empty and there are other errors
$nonReq = "While this field is not required, we would still love to hear your input.";
  // If join is empty
  if(empty($join))
  {
    $joinMessage = $nonReq;
  }
  // If experience is empty
  if(empty($experienceInput))
  {
    $experienceMessage = $nonReq;
  }


  if(empty($missing) && !$err)
  {
    // Deal with array input, positions
		$positionsList = implode(" ", $positions);
    // HTML email
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      // Formatting the positions returned
      $positionsArr = explode(" ", $positionsList);
      $positionsString = "";
      // Loop through the positions array
      foreach($positionsArr as $p)
      { // If it's the last item in the array
        if($p == end($positionsArr))
        { // If it's not the only item add an "and"
          if(sizeof($positionsArr) > 1)
          {
            $positionsString.="and $p";
          }
          else {  // Else it's the only item returned
            $positionsString.="$p";
          }
        }
        else{ // If it's not the last item
          if(sizeof($positionsArr) == 2)
          { // If the size is 2 this is the first item
            $positionsString.="$p ";
          }
          else
          { // Otherwise there are multiple, and we add a comma
            $positionsString.="$p, ";
          }
        }
      }
      // The message
      $msg = '<b>Name:</b><br> '.$nameInput.'<br>';
      $msg .='<b>Email:</b><br> ' .$emailInput.'<br>';
      $msg .='<b>Volunteer Opportunities:</b><br> '.$positionsString.'<br>';
      // Extra fields
      if(isset($experienceInput) && $experienceInput != "")
        $msg .='<b>Relevant Experience:</b><br> '.$experienceInput.'<br>';
      if(isset($join) && $join != "")
        $msg .='<b>Why You Want to Work With Us:</b><br> '.$join.'<br>';


      // Send email
      $cMsg = "Thank you for reaching out to UnProtectedVictims.<br>Your Get Help Form has been submitted and is being reviewed by the UnProtected Victims team. We will be in touch within 1-2 business days. This email serves as a confirmation for your purposes. If you have any further questions or need any help in the meantime please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Below is the information submitted.<br>".$msg."<br>Thank you!";
      $result = mail("isaac.kolodny@mavs.uta.edu","Give Help Form Submitted",$msg, $headers);
      mail($emailInput, "UnProtectedVictims Give Help Form Received",$cMsg, $headers);
      if($result) {
        $msgType = "successMessage";
        $message = "The email form was submitted! We will be in touch within 1-2 business days. If you do not hear from us, please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. A confirmation email will be sent shortly to $emailInput. Thank you!";
      } else {
        $message = "Email was not able to send. Please contact the support team at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Thank you!";
      }
      $message.= "<br>Explore the rest of our site from our <a href='index.php'>homepage</a> or by visting other pages in our navigation.";


  }

  if(!empty($missing))
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


?>
<?=$header?> <!--Header-->
</head>
<body>
<?=$nav?> <!--Nav-->
<main>

  <div class="hero get-help-hero-help">
    <h1>Give Help Form</h1>
  </div>
  <div class="container-fluid">
    <div class=" row d-flex justify-content-around">
      <div class="col-xs-12 col-md-5 form-img-apply">
        <h2>Apply </h2>
        <p> Please fill out this form to let us know what position you would be interested in volunteering for. This will send us an email with your information and we will email you back as soon as possible.</p>
      </div>
      <div class="contact col-xs-12 col-md-7">
            <form id="newForm" action="" method="POST">
              <?="<span id='message' class='$msgType'>$message</span>";?>
            		<label for="name" class="form-label">Name*: </label> <!--Values upon errors-->
            		<input type="text" size="25" name="nameInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($nameInput);?>" required >
                <?="<span class='errMsg'>$nameMessage</span>";?>
                <label for="email" class="form-label">Email Address*: </label>
                <input type="email" size="25" name="emailInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($emailInput);?>" required>
                <?="<span class='errMsg'>$emailMessage</span>";?>
                <label for="confirmation" class="form-label">Confirm Email Address*:</label>
                <input type="email" size="25" name="confirmationInput" class="form-control" value="<? if(!empty($missing) || $err) echo htmlentities($confirmationInput);?>" required>
                <?="<span class='errMsg'>$confirmationMessage</span>";?>
                <?php // Return selected items
                function checkSelected($val)
                {
                  global $missing;
                  global $err;
                  if(isset($_POST['positions']) && (!empty($missing) || $err) && in_array($val,$_POST['positions']))
                    $checked = "selected";
                  else {
                    $checked = "";
                  }
                  echo $checked;
                } ?>

                <label for="positions">Choose a Volunteer Opportunity*:</label>
                <select name="positions[]" id="positions" multiple size="6" required>
                  <option value="General Volunteer" <?php checkSelected('Volunteer') ?>>General Volunteer</option>
                  <option value="Lawyer" <?php checkSelected('Lawyer') ?>>Lawyer</option>
                  <option value="Copywriter" <?php checkSelected('Copywriter') ?>>Copywriter</option>
                  <option value="Photographer" <?php checkSelected('Photographer') ?>>Photographer</option>
                  <option value="Social Media Marketer" <?php checkSelected('Social Media Marketer') ?>>Social Media Marketer</option>
                  <option value="Activist" <?php checkSelected('Activist') ?>>Activist</option>
                </select>
                <?="<span class='errMsg'>$positionsMessage</span>";?>
                <label for="experience" id="experienceLabel" class="form-label">Relevant Experience: </label>
                <textarea type="text" rows="3" size="25" id="experience" name="experienceInput" class="form-control"></textarea>
                <?="<span class='successMessage'>$experienceMessage</span>";?>
                <label for="join" id="joinLabel" class="form-label">Why You Would Like to Work With Us? </label>
                <textarea type="text" rows="3" size="25" id="join" name="join" class="form-control"></textarea>
                <?="<span class='successMessage'>$joinMessage</span>";?>
                <div>
            		<button type="submit" value="Send" name="submit" class="mt-3">Send</button>
      </div>
            </form>
    </div>
    </div>
  </div>
</div>
</main>
<?=$footer?> <!--Footer-->


  </body>
</html>
