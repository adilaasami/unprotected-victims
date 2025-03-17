<?php
// Start session
session_start();
// Set time
date_default_timezone_set("America/Chicago");

// A dynamic header for meta data, css, and scripts
$header = "<!DOCTYPE html>
<html>
  <head>
      <meta charset='utf-8'>
      <meta name='keywords' content='False Imprisonment, Wrongful Convictions, How to defend yourself against false accusations, false arrests convictions and imprisonments, Can you sue for being wrongfully imprisoned?, Innocent people accused of crimes, Wrongful Imprisonment Lawyers, Can you sue for false imprisonment?, Police doing false arrests, American Innocence, nonprofit job board, non profit organizations list, non profit organization in dallas texas, charitable foundations in texas, non profit organizations in dallas for community service, dallas texas non profit organizations, texas nonprofit search, dallas non profits, what are civil rights, discriminations and civil rights, discrimination charities, leading nonprofit organizations, criminal justice advocacy groups, social justice nonprofits, civil rights organization, texas criminal justice reform, texas violation of civil rights, civil rights organizations near me, dallas foundation, dallas community, legal services of north texas, free legal aid dallas texas, nonprofit north texas, texas free legal aid, Unprotected victims, nonprofit, Melissa Dent Nonprofit, Contact Unprotected Victims, About Unprotected Victims, Get help from Unprotected Victims, volunteer unprotected victims, $keywords'>
      <meta name='author' content='Melissa Dent'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <link rel='preconnect' href='https://fonts.gstatic.com'>
      <link href='https://fonts.googleapis.com/css2?family=Poppins&display=swap' rel='stylesheet'>
      <title>$title</title>
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6' crossorigin='anonymous'>
      <script src='https://kit.fontawesome.com/25b727f389.js' crossorigin='anonymous'></script>
      <link rel='stylesheet' type='text/css' href='css/styles.css'>
      <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js' integrity='sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG' crossorigin='anonymous'></script>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js' integrity='sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc' crossorigin='anonymous'></script>
      <script src='js/basic.js'></script>";

// Admin navigation if access is granted
$adminOps = "";
if($_SESSION['access'] && !isset($_GET['logout']))
{
  $admin = "admin-home.php";
  $adminOps = "<nav class='navbar navbar-expand-lg navbar-light justify-content-md-center'>
              <span class='m-3 m-md-0 mt-0'>Your Actions:</span>
              <ul class='navbar-nav m-3 m-md-0 mt-0'>
                <li class='nav-item'>
                  <a class='nav-link' href='events.php'>Edit Events</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='create-account.php'>Register an Admin</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='admin.php?logout'>Log Out</a>
                </li>
              </ul>
            </nav>";
}
else{
  $admin = "admin.php";
}


// Navigation
$nav = "<header class='sticky-top'><nav class='navbar navbar-expand-lg navbar-light'>
  <div class='container-fluid'>
    <a class='navbar-brand' href='index.php'><img id='logo' src='images/uv-logo.png' alt='UnProtected Victims'></a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
  </div>
  <div class='collapse navbar-collapse mx-5' id='navbarNavDropdown'>
    <ul class='navbar-nav'>
      <li class='nav-item'>
        <a class='nav-link' href='index.php'>Home</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='about.php'>About Us</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='gethelp.php'>Get Help</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='givehelp.php'>Give Help</a>
      </li>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
          What's Happening
        </a>
        <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
          <li><a class='dropdown-item' href='events.php'>Events</a></li>
          <li><a class='dropdown-item' href='news.php'>News</a></li>
        </ul>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='contact.php'>Contact</a>
      </li>
    </ul>
    <a href='https://www.paypal.com/donate/?hosted_button_id=5S699X7BXELDS'title='donate'><button>Donate via Paypal</button></a>
  </div>
</nav>$adminOps</header>";

$footer = "<footer><div class=
'container footer'>
<div class='d-flex justify-content-between row mx-3'>
  <div class='col-12 col-md- 6 col-lg-3'>
    <img id='footer-logo' src='images/uv-logo.png' alt='UnProtected Victims'>
<<<<<<< Updated upstream
    
=======
    <p>We protect the unprotected.</p>
>>>>>>> Stashed changes
  </div>
  <div class='col-12 col-md-3 col-lg-2'>
    <h3 class='footer-headings'>Quick Links</h3>
    <ul class='list-unstyled footer-items'>
      <li><a href='index.php'>Home</a></li>
      <li><a href='givehelp.php'>Give Help</a></li>
      <li><a href='gethelp.php'>Get Help</a></li>
      <li><a href='https://www.paypal.com/donate/?hosted_button_id=5S699X7BXELDS'>Donate via Paypal</a></li>
    </ul>
  </div>
  <div class='col-12 col-md-3 col-lg-2'>
    <h3 class='footer-headings'>Others</h3>
    <ul class='list-unstyled footer-items'>
      <li><a href='faq.php'>FAQ</a></li>
      <li><a href='privacy.php'>Privacy Policy</a></li>
      <li><a href='$admin'>Admin</a></li>
    </ul>
  </div>
  <div class='col-12 col-md-3 col-lg-2'>
    <h3 class='footer-headings'>Contact</h3>
    <ul class='list-unstyled footer-items'>
      <li><a href='mailto:unprotectedvictims@gmail.com'>unprotectedvictims@gmail.com</a></li>
      <li><a href='#'>(999)-333-1022</a></li>
    </ul>
    <ul class='list-unstyled social-items d-flex'>
      <li><i class='fab fa-2x fa-facebook'></i></li>
      <li><i class='fab fa-2x fa-twitter'></i></li>
      <li><i class='fab fa-2x fa-instagram'></i></li>
    </ul>
  </div>
</div>
</div>
<div class='row align-items-center legal'>
<div class='col-12'>
  <span class='ml-3'> <a href='privacy.php'>privacy policy </a></span><br>
  
</div>
</div>
</footer>";

// Section component for any repetitive image and text components
$section = "<div class='container-fluid'>
<div class='row'>
  <div class='d-none d-md-flex align-items-center col-md-6 no-margin'>
    <div class='section-box $image'>

    </div>
  </div>
  <div class='col-12 col-md-6 section-text'>
    <h2>$sectionTitle</h2>
    $content
  </div>
</div>
</div>";

// Mobile dividers
$mobileSection = '<div class="container container-full">
    <div class="row">
      <div class="mobile-division col-12">
      </div>
    </div>
  </div>';

$spacer = "<div class='spacer'>
</div>";

// Donate component
$donate = "<div class='container-full donate-container'>
<div class='row '>
  <div class='col-xs-12 col-md-7'>
  <div class='donate-text'>
<h2>Donate</h2>
<p>Donations help our organization run. We use this money to help victims get the resources they need such as legal guidance, mental health assistance, or any other way they might need a hand. We also use donations to fund events to raise awareness about civil injustice.</p>
<a href='https://www.paypal.com/donate/?hosted_button_id=5S699X7BXELDS' title='Donate Now'><button>Donate via Paypal</button></a>
<br>
<h3>Donate by Shopping</h3>
<p>Shop at smile.amazon.com and choose us as your favorite charitable organization and Amazon will donate to us at no cost to you.</p>
<a href='https://smile.amazon.com/gp/chpf/homepage/ref=smi_chpf_redirect?ie=UTF8&ein=85-2050783&ref_=smi_ext_ch_85-2050783_cl' title='Shop & Donate'><button>Shop Now</button></a>
</div></div>
<div class='col-xs-12 col-md-5 donate-pic-container'>
<div class='donate-pic'>
</div>
</div>
</div></div>";
