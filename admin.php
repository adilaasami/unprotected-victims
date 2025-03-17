<?php
// Start session
session_start();
// For metadata
$title = "UnProtected Victims Admin Login";
// Includes the database file.
include("dbconn.inc.php");
// Includes the shared content.
include("shared.php");
// Connects the database.
$conn = dbConnect();
// Clears out all of the session variables upon logout.
if (isset($_GET['logout'])){
    $_SESSION['access'] = false;
    $_SESSION = array();
    session_destroy();
    echo "<script>alert('You have been logged out. Thanks!');</script>";
}

// Checks to see if a password and email has been entered
if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to pull account data
    $sql = "SELECT password FROM Logins WHERE email = ?";
    // Initialize the statement.
    $stmt = $conn->stmt_init();
    // If the query is valid
    if ($stmt->prepare($sql))
    {
      // Bind the ? to email
      $stmt->bind_param('s',$email);
      // Execute the statement
      $stmt->execute();
      // Bind the password result from the db
      $stmt->bind_result($check_pass);
      // Store the result
      $stmt->store_result();
      // If there is a result
    if ($stmt->num_rows == 1) {
      // Fetch the row
      $stmt->fetch();
     // If the hash matches
        if (password_verify($password, $check_pass)) {
          // Send to admin home
          $_SESSION['access'] = true;
          header('Location: admin-home.php');
          exit;
        }
        else{ // Compose the error message
          $message = "<div class='errMsg important'>Invalid information. Please try again!</div>";
        }
      }
    else{ // Compose the error message
      $message = "<div class='errMsg important'>Invalid information. Please try again!</div>";
    }
    }



$stmt->close();

} else if (isset($_POST['email']) || isset($_POST['password'])){ // If only one field is filled out
    $message = "<div class='errMsg important'>Please enter both the user name and password to log in.</div>"; // Tells user to enter both

}
else if(isset($_GET['logout']))
{
  $message = ""; // No separate message if logged out
}
else {
    $message = "<div>Please sign in to the admin login.</div>";// Default message when screen first appears.

}

$conn->close();
$form = "<form class='mt-3 login d-flex flex-column w-50' id='loginForm' action='' method='post'>
    <label for='email'>Email:</label><input type='email' id='email' name='email' class='form-control' value='' required>
    <span id='emailMessage' class='errMsg'></span>
    <label for='password'>Password:</label><input type='password' id='password' class='form-control' name='password' required>
    <span id='passwordMessage' class='errMsg'></span>
    <br><button type='submit' name='submit'>Login</button>
    </form>";
?>

<?=$header?>
<script>
function init()
{
  // Listen to blur of the following elements
  form =   document.getElementsByClassName('form-control');
  for(let i = 0; i<form.length;i++)
  {
    fieldId = form[i].id;
    document.getElementById(fieldId).addEventListener('blur', process, false);
  }

}


function process()
{ // Grab id ans value
  id = this.id;
  value = this.value;
  // If either field is empty add an error, otherwise remove them
  if(id == "email")
  {
    if(value == "")
    {
      document.getElementById("emailMessage").innerHTML = "Please enter the email you registered with.";
      error("email");
    }
    else{
      document.getElementById("emailMessage").innerHTML = "";
      removeError("email");
    }

  }
  if(id == "password")
  {
    if(value == "")
    {
      document.getElementById("passwordMessage").innerHTML = "Please enter the password you registered with.";
      error("password");
    }
    else{
      document.getElementById("passwordMessage").innerHTML = "";
      removeError("password");
    }
  }

}
window.addEventListener('load',init,false);
</script>
  </head>
  <body>
      <?= $nav ?> <!--Shared nav-->
    <main>
          <div class="hero get-help-hero">
            <h1>Admin</h1>
          </div>
        <div class="container-fluid my-5"> <!--Bootstrap grid-->
            <div class="row">
          <div class="col-12  d-flex justify-content-center">
            <?php echo $message ?> <!--Send the message about the form-->
        </div>
        <div class="col-12 d-flex justify-content-center">
          <?php
          if(isset($_GET['logout']))
            echo "<div class='d-flex flex-column'><h2>Thank you for your time!</h2>
                  <p>You have been successfully logged out. Check out the <a href='index.php'>Home Page</a> if you would like to explore.</p></div>";
            else {
              echo $form;
            }?>
        </div>
        </div>
      </div>
    </main>
    <?=$footer?> <!--Footer-->

</body>
</html>
