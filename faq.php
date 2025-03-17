<?php
// Metadata
$title = "UnProtected Victims";
include 'shared.php'?>
<?=$header?> <!--Header-->
</head>
<body>
<?=$nav?><!--Nav-->
<main>

<main>
<div class="hero get-help-hero">
<h1>FAQ</h1>
</div>

<div class="container">
  <div class="row justify-content-center">

    <div class="col-xs-12 col-md-10">
<button class="accordion">What are civil rights? <i class="fa fa-angle-down" aria-hidden="true"></i>
</button>
<div class="panel">
  <p>Civil rights are personal rights guaranteed and protected by the U.S. Constitution and federal laws enacted by Congress, such as the Civil Rights Act of 1964 and the Americans with Disabilities Act of 1990. Civil rights include protection from unlawful discrimination.</p>
</div>

<button class="accordion">What can I do If my civil rights have been violated? <i class="fa fa-angle-down" aria-hidden="true"></i>
</button>
<div class="panel">
  <p> If you believe that you have been discriminated against because of your race, color, national origin, disability, age, or sex you can file a compliant </p>
  <h3>Education</h3>
  <p>The <a href="https://www2.ed.gov/about/offices/list/ocr/index.html?src=oc" title="US Department of Education">U.S. Department of Education, Office for Civil Rights</a> enforces several Federal civil rights laws that prohibit discrimination in programs or activities that receive federal financial assistance from the Department of Education.  It also has responsibilities under Title II of the Americans with Disabilities Act of 1990 (prohibiting disability discrimination by public entities, whether or not they receive federal financial assistance).</p>
  <h3>Housing</h3>
  <p>The U.S. Department of Housing and Urban Development’s Office of Fair Housing and Equal Opportunity administers and enforces federal laws and establishes policies that make sure all Americans have equal access to the housing of their choice.</p>
  <h3>Conditions of Institutional Confinement/Conduct of Law Enforcement Agencies</h3>
  <p>The U.S. Department of Justice, Civil Rights Division, Special Litigation Section enforces federal civil rights statutes related to conditions of institutional confinement, conduct of law enforcement agencies, access to reproductive health facilities and places of religious worship, and religious exercise of institutionalized persons.</p>
  <h3>Agriculture</h3>
  <p>The U.S. Department of Agriculture, Office of the Assistant Secretary for Civil Rights enforces federal civil rights laws in programs funded by the USDA, such as the Food Stamp Program, that address discrimination on the basis of race, color, national origin, sex (including gender identity and expression), religion, age, disability, sexual orientation, marital or familial status, political beliefs, parental status, protected genetic information, or because all or part of an individual's income is derived from any public assistance program.</p>
<h3>Employment</h3>
<p>The Equal Employment Opportunity Commission enforces various federal laws prohibiting discrimination in employment on the basis of race, color, sex, religion, national origin, age, or disability. Discrimination by employers with 15 or more employees is prohibited in all aspects of the hiring and employment process: job application, hiring, firing, promoting, training, wage earning, or any other terms, privileges, or conditions of employment.
For more information about other entities that enforce civil rights non-discrimination laws, please go to this information provided by the <a href="https://www.usccr.gov/pubs/uncsam/complain/when.htm" title="US Commission on Civil Rights"> U.S. Commission on Civil Rights</a>. 
</p>
</div>

<button class="accordion">What information must be provided to file a civil rights complaint? <i class="fa fa-angle-down" aria-hidden="true"></i>
</button>
<div class="panel">
  <p>Please include the following:
    <ul>
      <li>Your name</li>
<li>Full address</li>
<li>Telephone numbers (include area code)</li>
<li>Email address (if available)</li>
<li>Name, full address, and telephone number of the person, agency or organization you believe discriminated against you</li>
<li>Brief description of what happened</li>
<li>	How, why, and when you believe your (or someone else's) civil rights were violated</li>
<li>	Any other relevant information</li>
<li>	Your signature and Date of Compliant</li>
</p>
</div>
<button class="accordion">What is the time limit for filing a civil rights complaint? <i class="fa fa-angle-down" aria-hidden="true"></i>
</button>
<div class="panel">
  <p>Civil Rights may extend this period if there is good cause.)</p>
</div>
<button class="accordion">Who can file a civil rights complaint? <i class="fa fa-angle-down" aria-hidden="true"></i>
</button>
<div class="panel">
  <p>Any individual or organization can file a civil rights complaint; you do not need to be the victim of discrimination in order to file a complaint, so long as the complaint is against an entity that is covered by one of the civil rights laws and the complaint is on a basis covered by those laws, e.g., race, color, national origin, sex, age, or disability.</p>
</div>
</div></div></div>
<script> // Sets accordians to display if clicked
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";



    } else {
      panel.style.display = "block";
    }
  });
}
</script>




</main>
<?=$footer?> <!--Footer-->
  </body>
</html>
