<?php
// For metadata
$title = "UnProtected Victims";
// For section component
$sectionTitle = "We are Here to Help";
$content = "<p>Civil injustice is a regularly occurring event. We are a nonprofit organization located in the DFW area designed to help those who have been wrongfully jailed and then released with little to no explanation from the police. Our founder has been through a similar situation and started this organization to help others who are going through it now. Our mission is to assist victims, raise awareness, and get people involved in our cause through local events, volunteer work, and by giving donations.
</p>
";
$image = "section-home";
include 'shared.php';
include_once "dbconn.inc.php";
$conn = dbConnect();?>
<?=$header?> <!--Header-->
</head>
<body>
<?=$nav?> <!--Nav-->
<main>
<div class="hero home-hero">
    <div class="container">
      <h1>We Help Those Whose <br>Civil Rights Have Been Violated</h1>
        <br><br>
      <div class="call-btn">
      <a href="gethelp.php"><button type="button">Receive Assistance</button></a>
       <a href="https://www.paypal.com/donate/?hosted_button_id=5S699X7BXELDS"><button type="button">Donate Today</button></a>
       </div>
   </div>
</div>
<?php // For the events at the bottom
$sql = "SELECT EID, Title, Description, URL, CalendarDate FROM Events ORDER BY CalendarDate LIMIT 3";
// Prepare the statement
$stmt = $conn->stmt_init();
if ($stmt->prepare($sql))
{
  // Execute
  $stmt->execute();
  // Save the data
  $stmt->bind_result($EID, $Title, $Description, $URL, $CalendarDate);
  $count = 0;
  $stmt->store_result();
  $output = "<div class='card-group d-flex flex-column flex-md-row'>";
  while($stmt->fetch()){ // Fetch results
    // If the user has access as an admin
    if($_SESSION['access'])
      {
        if(strpos($Title, " ") > 0)
        {
          $newTitle = str_replace(" ", "-", $Title);
        }
        else{
          $newTitle = $Title;
        }
        // Prepare admin control operations
        $Title_js = htmlspecialchars($title, ENT_QUOTES); // Converts quotation marks in review title to html entity code to avoid javascript conflicts.
        $adminOps = "<script>if(delete) confirmDel(\"$Title_js\",$EID)</script>
        <div class='d-flex'>
        <a href='events_form.php?EID=$EID'><button>Edit</button></a>
        <a href='?delete&EID=$EID&title=$newTitle' id='delete'><button>Delete</button></a>
        </div>";

      }
    // Create datetime from date in db
    $dtime = new DateTime($CalendarDate);
    // Format it
    $mysqldate = date_format($dtime,"l, F jS, Y \a\\t g:i a T");
    // Modify the output
      $output.= "<div class='card home-card'>
                  <img class='card-img-top' src='$URL' alt=''>
                  <div class='card-body'>
                    <h3 class='card=title'>$Title</h3>
                    <p class='card-text'>$Description</p>
                    <span class='cart-subtitle'>$mysqldate</span>
                    $adminOps
                  </div>
                </div>";
  }
  $output.="</div>";
}
else {
  $output = "There was an error with the query. Please try again.";
}
$stmt->close();
$conn->close();
echo $section; // Section component
echo $donate; // Donate component
 ?>
<div class="container-fluid">
  <div class="row justify-content-center">
   <div class="col-xs-12 col-md-5 gray-square g-5">
<h2>Give Help</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at mattis purus, elementum ultrices orci. Mauris quis mi at libero pretium cursus. Nulla rhoncus laoreet ligula id eleifend. Nulla id mauris at nisi vestibulum vestibulum a et lectus. Phasellus odio risus, efficitur sed pretium eu, sollicitudin sit amet lorem.</p>
<a href="givehelp.php"><button>Explore Options</button></a>
</div>
<div class="col-xs-12 col-md-5 gray-square g-3">
<h2>Get Help</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at mattis purus, elementum ultrices orci. Mauris quis mi at libero pretium cursus. Nulla rhoncus laoreet ligula id eleifend. Nulla id mauris at nisi vestibulum vestibulum a et lectus. Phasellus odio risus, efficitur sed pretium eu, sollicitudin sit amet lorem.</p>
<a href="gethelp.php"><button>Reach Out</button></a>
</div>
</div>
</div>

<div class="container mb-3 mt-3">
  <div class="row justify-content-center">
  <h2> Events</h2>
  <?=$output?> <!--Output-->

  </div>
  </div>
  </div>
<div class="home-footer">
</div>
</main>
<?=$footer?> <!--Footer-->
  </body>
</html>
