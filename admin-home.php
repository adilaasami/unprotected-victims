<?php
session_start();
// For metadata
$title = 'UnProtected Victims Admin Login';
include 'shared.php';
// Body if they have access
$body="<div class='col-12 d-flex flex-column align-items-center'>
            <h2>Welcome!</h2>
            <p>Welcome to your admin home. Here is your home base for all maintenance as needed.
              Below are some navigational options that will help you move around the site.
          </div>
      <div class='col-sm-6  d-flex justify-content-center'>
            <div class='card'>
              <div class='card-body'>
                <h5 class='card-title'>Edit Your Events</h5>
                <p class='card-text'>Visit the events page to add new events, edit old ones, upload images, and more!</p>
                <a href='events.php'><button>Go to Events</button></a>
              </div>
            </div>
        </div>
        <div class='col-sm-6  d-flex justify-content-center'>
          <div class='card'>
            <div class='card-body'>
              <h5 class='card-title'>New Admins</h5>
              <p class='card-text'>Need help updating the events page? We have an admin registration form for you right here.</p>
              <a href='create-account.php'><button>Add an Admin</button></a>
            </div>
          </div>
        </div>
            </div>";
?>
<!--Header-->
<?=$header?>
  </head>
  <body>
      <?= $nav ?> <!--Shared nav-->
    <main>
          <div class='hero get-help-hero'>
            <h1>Admin Home</h1>
          </div>
      <div class='container-fluid my-5'>
            <div class='row justify-content-center'>
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
    <?=$footer?> <!--Footer-->

</body>
</html>
