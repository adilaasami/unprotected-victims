<?php
// Session Start
session_start();
// For metadata
$title = "UnProtected Victims Events Form";
// Placeholder
$button = "Update Calendar";
include("dbconn.inc.php");
include("shared.php");
$conn = dbConnect();
$EID = ""; //Set as empty to prepare to add a new one.
$Title = "";
$Description = "";
$URL = "";
$CalendarDate = "";
$Keywords = "";


// Checks to see if there is an EID available via query string.
if (isset($_GET['EID'])) {

	$EID = intval($_GET['EID']); // Set the value as an integer.

	if ($EID > 0){ // If the value is greater than 0 it is a valid entry.
		// Query to select the event details.
	$sql = "SELECT Title, Description, URL, CalendarDate, Keywords FROM Events WHERE EID = ?";
// Initialize the statement.
	$stmt = $conn->stmt_init();
// If the query is valid.
		if($stmt->prepare($sql)){ // Prepare the statement
			$stmt->bind_param('i',$EID); // Bind to EID.
			$stmt->execute(); // Execute the statement
					//Bind the results.
					$stmt->bind_result($Title, $Description, $URL, $CalendarDate, $Keywords);

					$stmt->store_result(); // Store the results.

					// Proceed if a match is found.
					if($stmt->num_rows == 1){
						$stmt->fetch(); // Fetch the result.
						// Convert the times to proper format
            $date = date("Y-m-d",strtotime($CalendarDate));
            $time = date("H:i:s",strtotime($CalendarDate));
					} else { // Alert of an error.
            $message = "<span class='errMsg'>Event not found! If it is an error, please contact the webmaster.  Thank you.</span>";
						$EID = ""; // Reset $EID
					}

		} else {
			// Reset $EID
			$EID = "";
			// Compose an error message.
      $message = "<span class='errMsg'>If you are expecting to edit an existing item, some errors have occured in the process. The selected event is not recognizable.  Please try again.  Thank you.</span>";
		}

		$stmt->close();
	} // Close statement.

}

if (isset($_POST['submit'])) { //If there us a submission.

	$expected = array("Title", "Description", "image", "date", "keys", "time", "date"); //Sets up the expected array, everything is required.

  $label = array ('Title'=>'Event Name', "Description"=>'Description', "image"=>"Image", "date"=>'Date', "time"=>"Time","keys"=>'Keywords'); //Sets up nice labels.

	$missing = array(); // Sets up a missing array.

	foreach ($expected as $field){ // For each field

		if (empty($_POST[$field])) { // If empty add to missing array
			// If it's editing and they don't upload a new image, ignore.
			if($field == "image" && isset($_GET['EID']))
			{
				break;
			} // Validate image
      else if($field=="image")
      { // Push to missing if invalid
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 0)
        {
          array_push ($missing, $field);
        }
        else{
          $image = $_POST[$field];
        }

      }
			else{
				array_push ($missing, $field);
			}

		} else { //If not

			if (!isset($_POST[$field])) { // If field is not set.
				${$field} = ""; // Set variable variable to empty.
			} else {// Set user submission to variable variable
				${$field} = $_POST[$field];
			}

		}

	}


if (empty($missing)){ //If missing is empty
	// Define constant for upload folder
	define('UPLOAD_DIR', '/home/irkutacl/ctec4350.irk9623.uta.cloud/UnProtectedVictims/images/');
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM);
	$detectedType = exif_imagetype($_FILES['image']['tmp_name']);
	$fileName = str_replace(" ", "_", $_FILES['image']['name']);
	// Capture date and time
  $dateString = date("Y-m-d",strtotime($_POST['date']));
  $timeString = date("H:i:s",strtotime($_POST['time']));
	// Create the new date
	$newDate = new DateTime("$dateString $timeString", new DateTimeZone("America/Chicago"));
	// Get current time
	$today = time();
	// Form calendar date
	$CalendarDate = date_format($newDate,'Y-m-d H:i:s');
	// Placeholders
	$dateInvalid = false;
	$imageInvalid = false;
	// Validate if past or future date
	if(strtotime($CalendarDate) < $today)
	{
		$dateMessage = "<span class='errMsg'>You can not enter a past date.</span>";
		$dateInvalid = true;
		$message = "<span class='errMsg'>Please fix the errors below</span>";
	} // Send image if date is valid
		if(in_array($detectedType, $allowedTypes) && !$dateInvalid)
		{

			// Move the file to the upload folder and rename it - only use processed file without spaces here
			if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$fileName)){
					// Upload successful
					//Initialize the statement.
						$stmt = $conn->stmt_init();
					// Create mysql DateTime from date input by user.
					// Filename url
					$URL = "images/$fileName";

					if ($EID != "") { //If EID is not empty, it already exists.

						$EID = intval($EID); //Store as an int.

						$sql = "Update Events SET Title = ?, Description = ?, URL = ?, CalendarDate = ?, Keywords = ? WHERE EID = ?"; //Update the event with this info.
						if($stmt->prepare($sql)){ //Prepare the statement. Checks if query valid.
							$stmt->bind_param('sssssi',$Title, $Description, $URL, $CalendarDate, $_POST['keys'], $EID); // Bind the parameters.
							$stmt_prepared = 1; // Indicate the statement was prepared.
						}

					} else {
						$sql = "Insert Into Events (Title, Description, URL, CalendarDate, Keywords) values (?, ?, ?, ?, ?)"; // Query to add the event
						if($stmt->prepare($sql)){ // If query valid
							$stmt->bind_param('sssss',$Title, $Description, $URL, $CalendarDate, $_POST['keys']); // Bind tbe parameters.
							$stmt_prepared = 1; // Indicate the statement was prepared.
						}
					}

					if ($stmt_prepared == 1){ //If prepared
						if ($stmt->execute()){ //If executed
							if($EID != "")
							{
								$type = "updated";
                $button = "Update Event";
							}
							else{
								$type = "created";
							}



              $message = "<span class='successMessage'>Success! $Title has been $type.</span>";
              $_SESSION['message'] = $message;
						} else {
							// $Stmt->execute() failed.
							$message = "<span class='errMsg'>Database operation failed.  Please contact the webmaster.</span>";
						}
					} else {
						// Statement is not successfully prepared (issues with the query).
						$message = "<span class='errMsg'>Database query failed.  Please contact the webmaster.</span>";
					}

						}
					else {
				// Something is wrong with file
				$message = "<span class='errMsg'>We have encountered issues in uploading this file.  Please try again later or contact the web master.</span>";
					$imageInvalid = true;
								}
				$stmt->close();


		}
       // If the image is empty upon editing, ignore
		else if(isset($_GET['EID']) && $image == "" && !$dateInvalid)
		{
			//Initialize the statement.
			$stmt = $conn->stmt_init();
			$sql = "Update Events SET Title = ?, Description = ?, CalendarDate = ?, Keywords = ? WHERE EID = ?"; //Update the event with this info.
			if($stmt->prepare($sql)){ // Prepare the statement. Checks if query valid.
				$stmt->bind_param('ssssi',$Title, $Description, $CalendarDate, $_POST['keys'], $EID); // Bind the parameters.
				$stmt_prepared = 1; // Indicate the statement was prepared.
			}
			if ($stmt_prepared == 1){ // If prepared
				if ($stmt->execute()){ // If executed
					$message = "<span class='successMessage'>Success! $Title has been updated.</span>";
          $_SESSION['message'] = $message;

				} else {
					// $Stmt->execute() failed.
					$message = "<span class='errMsg'>Database operation failed.  Please contact the webmaster.</span>";
				}
			} else {
				// Statement is not successfully prepared (issues with the query).
				$message = "<span class='errMsg'>Database query failed.  Please contact the webmaster.</span>";
			}
			$stmt->close();
		}


	} else {
		// $Missing is not empty.
		$message = "<span class='errMsg'>Missing fields detected!";
		$message .= "The following required fields are missing in your form submission: ";
		foreach($missing as $m){ //List missing fields
			$message .= "{$label[$m]} ";
		}
		$message .= "</span>";

		}
	}

function loadImg($img)
{
	// Load the image if this is to edit
	// Always load example
		$ret = "<div class='d-flex flex-column'><div class='d-flex flex-column'><b>Example Form</b> <img class='h-100 w-75' src='images/example-event.jpg' alt=''></div>";
	if(isset($_GET['EID']))
		$ret.= "<div class='d-flex flex-column'>Current Image <img class='h-50 w-50' src='$img' alt=''></div>";
		$ret.= "</div>";
	echo $ret;

}


$conn->close();
?>
<?=$header?><!--Header-->
<script>
function init()
{
  // listen to blur of the following elements
  form =   document.getElementsByClassName('form-control');
  for(let i = 0; i<form.length;i++)
  {
    fieldId = form[i].id;
    document.getElementById(fieldId).addEventListener('blur', process, false);
  }

}

function process(evt)
{
	// Disable submit button
	// Prevent form submission
	var evt = (evt) ? evt : ((window.event) ? event : null);
	if(evt)
	{
		// Capture values
		id = evt.target.id;
		value = evt.target.value;
		var today = new Date();
		var currentTime = today.getTime();
// Validate date based on time and toggle errors
		if(id == "date")
		{
			dateValue = new Date(value).getTime();
			if(value == "")
			{
				document.getElementById("dateMessage").innerHTML = "Please enter a date for the event.";
				error("date");
			}
			else if(currentTime > dateValue)
			{
				document.getElementById("dateMessage").innerHTML = "The date can not be a past date.";
				error("date");
			}
			else{
				document.getElementById("dateMessage").innerHTML = "";
				removeError("date");
			}
		}
		else{
				validate(id, value);
		}


	}

}
// Init upon load
window.addEventListener('load',init,false);
</script>
  </head>
  <body>
      <?= $nav ?> <!--Shared nav-->
    <main>
      <div class="container-fluid"> <!--Bootstrap grid-->
        <div class="row">
          <div class="hero get-help-hero">
            <h1>Event Form</h1>
          </div>
        <div class="col-12 d-flex justify-content-center align-items-center  my-5">
					<?php // Thank you message upon success
          if(isset($_SESSION['message']) && $_SESSION['message']!="" && !$dateInvalid && !$imageInvalid)
          {
            $m = $_SESSION['message'];
            $_SESSION['message'] = "";
            $body = "<div class='d-flex flex-column mt-3'><h2>Thank you!</h2><p>$m</p><a href='events.php'><button>Back to Events</button></a></div>";

          } // Show form upon first time or failure
          else if(!isset($_SESSION['message']) || $_SESSION['message']==""||!empty($missing)||$dateInvalid||$imageInvalid){
            if($_SESSION['access'] && $_GET['EID'])
            $required = "";
            else {
              $required = "required";
            }
						 if(isset($_SESSION['message']) || $_SESSION['message']!="")echo "";
						else {
							echo $message;
						}
						// Determines if keywords are from the database or form submission upon failure
						if(!isset($_POST['submit']))
						{
							$retKeys = $Keywords;
						}
						else{
							$retKeys = $_POST['keys'];
						} // Fills values upon editing and failure
            $body = "<form class='mt-3 pb-5 login d-flex flex-column' enctype='multipart/form-data' action='' method='POST'>
                        <span class='important'>All fields are required!</span>
                          <label for='title'>Title:</label>
                          <input type='text' name='Title' class='form-control' id='title' required value='".htmlentities($Title)."'>
													<span class='errMsg' id='titleMessage'></span>
                          <label for='description'>Event Description:</label>
                          <textarea type='text' name='Description' class='form-control' id='description' required>".htmlentities($Description)."</textarea>
													<span class='errMsg' id='descriptionMessage'></span>
                          <label for='date'>Date:</label>
                          <input type='date' name='date' id='date' class='form-control' required value=$date>
													<span class='errMsg' id='dateMessage'>$dateMessage</span>
                          <label for='time'>Time:</label>
                          <input type='time' id='time' name='time' class='form-control' value=$time required>
													<span class='errMsg' id='timeMessage'></span>
                            <label for='image'>Upload an Image:</label>
                            <input type='file' id='image' class='form-control' name='image' $required>
														<span class='errMsg' id='imageMessage'></span>
                            <label for='keywords'>Keywords:</label><span class='text-muted'>Separate by comma and space as in the example.</span>
                            <input type='text' name='keys' id='keywords' required class='form-control' value='"."$retKeys'>
														<span class='errMsg' id='keywordsMessage'></span>
                          <button class='mt-3' id-'submit' type='submit' name='submit'>$button</button>
                      </form>".loadImg($URL);
          }


				            if($_SESSION['access']) // If the user is logged in as an admin echo the admin main info, otherwise put a disclaimer.
										{
											echo $body;
										}
				             else {
				                    echo "<div class='d-flex flex-column my-3'><h2>Restricted Access</h2><p>You do not have the proper credentials to be in this area. Please return
				                    to the <a href='index.php'>home page</a>. If you believe this is a mistake please contact the web team. Thank you!</div>";
				                  }
						?>
        </div>
        </div>
      </div>
    </main>
    <?=$footer?> <!--Footer-->

</body>
</html>
