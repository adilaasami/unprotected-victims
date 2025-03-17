<?php
// For ajax submission
// Start session
session_start();
include("dbconn.inc.php");
// Connects the database.
$conn = dbConnect();
// Grab the values
$q = trim($_GET["q"]);
$id = $_GET['id'];
$email = trim($_GET['email']);
$password = trim($_GET['password']);
// Err placeholder
$err = false;
// Set missing array
$missing = array();
// If email field
if($id=="email")
  {
    $stmt = $conn->stmt_init();
    // Query for determining the db hashed password
    $sql = "SELECT * FROM Logins WHERE email = ?";
    // Flag to determine if email is not used
      $emailValid = 0;
      // If sql could be prepared
      if ($stmt->prepare($sql)){
        // Bind the email
        $stmt->bind_param('s', $q);
        // Execute
        $stmt->execute();
        // Store the result
        $stmt->store_result();
        // If there are no rows, the email is valid
        if($stmt->num_rows !== 0){
          $emailValid = 1;
        }
        $stmt->close();
        $conn->close();
      } // If empty
    if(empty($q))
    {
      echo  "<span class='errMsg'>Please enter your email.</span>";
    } // If invalid
    else if(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$q))
    {
      echo "<span class='errMsg'>Please enter a valid email. It can not start with a special character or a number and must have an @ sign included.</span>";
    } // If used before
    else if($emailValid === 1)
    {
      echo "<span class='errMsg'>Email is taken. Please try another one.</span>";
    }

  } // If password
else if($id=="password")
{ // If empty
  if(empty($q))
    echo  "<span class='errMsg'>Please enter a password.</span>";
  else if(strlen($q) < 7) // If too short
  {
    echo "<span class='errMsg'>Please enter a valid password. It must be at least 7 characters.</span>";
  }
  else{
    echo "";
  }
}
else if($id==="loginForm") // When full form submitted
{
  // Expected array
    $expected = array("email", "password");
      $error = false;
      // Loop through the required items
      foreach($required as $index => $field)
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
      { // If the email is invalid, compose the message
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 7)
        {
        $error = true;
        }
        if($error)
        {
          echo "<span class='errMsg'>Please fix the errors above.</span>";
        }
        else{ // Hash the password
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
    				} // Else there is already one email and it is invalid
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
                  $valid=true; // Flag the operation as a success
                  echo "<span class='successMessage'>Congrats! A new admin has been registered to $email. Please have them log in via the link in the footer to get started.</span>";
                  exit;
    						} else {
    							//If the execution failed
    							echo "<span class='errMsg'>The account was not added to the database.  Please contact the web team.</span>";
    						}
    					} else{
                echo "<span class='errMsg'>Database query failed.  Please contact the webmaster.</span>";
              }
              // Close the statement
              $stmt->close();
              // Close the connection
              $conn->close();
            }
            else{
    					echo "<span class='errMsg'>An account with this email is already taken. Please use a different email.</span>";
    				}
        }



      }
      else
      { // Remind them to fix errors
        echo "<span class='errMsg'>Please fix the above errors.";
    }
}

?>
