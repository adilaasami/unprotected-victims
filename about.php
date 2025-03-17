<?php
// For meta data
$title = "About UnProtected Victims";
// For section component
$sectionTitle = "About Us";
$content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at mattis purus, elementum ultrices orci. Mauris quis mi at libero pretium cursus. Nulla rhoncus laoreet ligula id eleifend. Nulla id mauris at nisi vestibulum vestibulum a et lectus. Phasellus odio risus, efficitur sed pretium eu, sollicitudin sit amet lorem. Fusce pellentesque, tellus in sollicitudin viverra, quam arcu tempor nunc, nec sodales velit nibh eu eros. Fusce faucibus augue risus, at aliquet urna tincidunt sit amet.</p>
<ul class='list-unstyled social-items d-flex'>
  <li><i class='fab fa-2x fa-facebook'></i></li>
  <li><i class='fab fa-2x fa-twitter'></i></li>
  <li><i class='fab fa-2x fa-instagram'></i></li>
</ul>";
include 'shared.php'?>
<!--Header-->
<?=$header?>
</head>
<body>
  <!--Nav-->
<?=$nav?>
<main>
<div class="hero hero-blue">
  <h1>About Us</h1>
</div>
   <div class="container container-full">
    <div class="blue-section row justify-content-center">
      <h2 class="col-12">Our Story</h2>
      <p class="col-12">Our founder, Melissa Dent, was a victim of police brutality on January 17th, 2018. Arlington police conspired with representatives from her apartment complex to punish her for winning a landlord tenant dispute. The officer fabricated a warrant and padded her case file with one belonging to a hispanic male whose case was from 2001. She was taken to jail under his name and case. After three days in jail, humiliated and confused, she was released. </p>
      <p class="col-12"> What was done to her was not only offensive, it was illegal and an extreme violation of her constitutional and human rights at the hands of a corrupt and abusive criminal justice system. For this reason she started this nonprofit organization to help those who also have had their rights violated, spread awareness of situations like these, and to get others involved.</p>
    </div>
  </div>
    <br><br><br>
  <div class='container container-full'>
  <div class='section row justify-content-between'>
    <div class='col-xs-12 align-items-center col-md-5'>
      <div class='love-bg section-box'>
      </div>
    </div>
    <div class='col-12 col-md-6 md-5 mt-5'>
      <h2>LunchBox of Love</h2>
      <p>Consider helping our other nonprofit too! Our sister nonprofit organization is Lunch Box of Love. Lunch Box of Love is a registered 501(c)(3) nonprofit organization. They try to meet all needs for those less fortunate, or who have been displaced, going without food or clothing. Donations are used to provide food, clothing, toiletries, and household supplies. Visit its site to find out more.</p>
      <a href="http://www.lunchboxoflove.org/" target="_blank" title="View Site"><button>View Site</button></a>
    </div>
  </div>
  </div>
  <br><br><br>
<!--Donate component-->
 <?php  echo $donate ?>
</main>
<!--Footer-->
<?=$footer?>
  </body>
</html>
