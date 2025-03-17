<?php
// Grab all the queries from the forms via AJAX
$q = trim($_GET["q"]);
$id = $_GET['id'];
$type = $_GET['type'];
$name = trim($_GET['name']);
$email = trim($_GET['email']);
$comment = trim(htmlentities(nl2br($_GET['comment'])));
$experience = trim(htmlentities(nl2br($_GET['experience'])));
$join = trim(htmlentities(nl2br($_GET['join'])));
$positions = $_GET['positions'];
$confirmation = trim($_GET['confirmation']);
// Flag err placeholder
$err = false;
// Empty missing array to fill
$missing = array();
// Setting this up early since this has to be run in an if statement
$required = array();
// If the email field was interacted with
if($id=="email")
  {
    // Warn them if empty
    if(empty($q))
    {
      echo  "<span class='errMsg'>Please enter your email.</span>";
    } // Warn them if email is invalid
    else if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$q))
    {
      echo "<span class='errMsg'>Please enter a valid email. It can not start with a special character or a number and must have an @ sign included.</span>";
    } // If the email and confirmation don't match
    if($confirmation!="" && $confirmation!=$q && $email!="")
    {
      echo "<span class='errMsg'>Emails do not match!</span>";
    }

  } // If it's for the confirmation field
else if($id=="confirmation")
{
  // Warn if empty
  if(empty($q))
    echo  "<span class='errMsg'>Please re-enter your email.</span>";
  else if(empty($email)) // Warn if email is empty
    echo  "<span class='errMsg'>Please enter your email above first.</span>";
  else if($q!=$email) // Warn if mismatch
    echo "<span class='errMsg'>Emails do not match!</span>";
  else if($q==$email && !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$q)) // Warn if both invalid
    echo "<span class='errMsg'>This email is also invalid.</span>";
}
else if($id=="name") // If name is the event id
{
  if(empty($q)) // Warn if empty
    echo  "<span class='errMsg'>Please enter a name.</span>";
  else if(!preg_match("/^[a-zA-Z-' ]*$/",$q)) // Warn if invalid
  echo "<span class='errMsg'>Please enter a valid name.</span>";
}
else if($id=="comment") // If event is comment
{
  if(empty($q)) // If empty
    echo  "<span class='errMsg'>Please enter a comment.</span>";
}
else if($id==="contact-form") // If the whole form is to be validated
{
  // Set expected array based on the type of form
  if($type == "Get Help" || $type == "Contact")
  {
    $expected = array("name", "email", "confirmation", "comment");
  }
  else if($type == "Give Help")
  {
    $expected = array("name", "email", "confirmation", "positions", "experience", "join");
    // This is the only form that needs only some fields required
    $required = array("name", "email", "confirmation", "positions");
  }

  // Loop through expected fields
  foreach($expected as $index => $field)
  { // Capture input from query
    $userInput = $_GET[$field];
    // If not array, trim
    if(!is_array($userInput))
      $userInput = trim($userInput);
    // Here we need to check if the required array is necessary to consider, the first case. If it is the other 2 forms we will just look in the expected array.
    if((in_array($field, $required) && $type == "Give Help" && empty($userInput)) || ($type == "Get Help" || $type == "Contact") && empty($userInput))
    { // Add to missing
      array_push($missing, $expected[$index]);
    }
    else { // Store input
      ${$field} = $userInput;
    }
  }
// If email is empty or invalid
  if(!empty($email) && (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$email) || $email != $confirmation) || !empty($name) && !preg_match("/^[a-zA-Z-' ]*$/",$name))
  {
    // Set error
    $err = true;
  } // If confirmation invalid
  if($field=="confirmation" && !empty($confirmation) && !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$email))
    echo "This email is also invalid.";

// If nothing is missing
  if(empty($missing))
  {
    if($err) // If there are errors, send error message
    {
      echo "<span class='errMsg'>Please fix the above errors.</span>";
    }
    else{ // Turn into html email
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      // The message comprised of the field values
      $comment = nl2br(htmlentities($comment));
      $msg = '<b>Name:</b><br> '.$name.'<br>';
      $msg .='<b>Email:</b><br> ' .$email.'<br>';
      // Additional fields depending on form type
      if($type == "Get Help" || $type == "Contact")
      $msg .='<b>Comment:</b><br> '.$comment.'<br>';
      else if($type == "Give Help")
      {
        // Grab the positions
        $positionsArr = explode("+", $positions);
        $positionsString = implode(", ", $positionsArr);

        $msg .='<b>Volunteer Opportunities:</b><br> '.$positionsString.'<br>';
        // Add experience and reason to join if applicable
        if(isset($experience) && $experience != "")
          $msg .='<b>Relevant Experience:</b><br> '.$experience.'<br>';
        if(isset($join) && $join != "")
          $msg .='<b>Why You Want to Work With Us:</b><br> '.$join.'<br>';
      }
      $cMsg = "Thank you for reaching out to UnProtectedVictims.<br>Your $type Form has been submitted and is being reviewed by the UnProtected Victims team. We will be in touch within 1-2 business days. This email serves as a confirmation for your purposes. If you have any further questions or need any help in the meantime please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Below is the information submitted:<br>".$msg."<br>Thank you!";
      // Send email to both parties
      $result = mail("isaac.kolodny@mavs.uta.edu","$type Form Submitted",$msg, $headers);
      mail($email, "UnProtectedVictims $type Form Received",$cMsg, $headers);
      if($result) {
          echo "<span class='successMessage'>The email form was submitted! We will be in touch within 1-2 business days. If you do not hear from us, please email us at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. A confirmation email will be sent shortly to $email. Thank you! <br>Explore the rest of our site from our <a href='index.php'>homepage</a> or by visting other pages in our navigation.</span>";
      }
     else {
        echo "<span class='errMsg'>The email was not able to send. Please contact the support team at <a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a>. Thank you! <br>Explore the rest of our site from our <a href='index.php'>homepage</a> or by visting other pages in our navigation.</span>";
      }
      }

  }
  else
  {
    // Backup if html5 required attributes fail
    $response =  "<span class='errMsg'>Please fill in your missing fields above.</span>";
    if($err)
      $response .= "<span class='errMsg'>There are also errors above that need to be addressed.</span>";
  }
  echo $response;

}
?>
