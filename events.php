<?php
//Set the session.
session_start();
// Metadata
$title = "Events for UnProtected Victims";
include 'shared.php';
include_once "dbconn.inc.php";
// Placeholders
$output = "";
$count = 0;
$conn = dbConnect();
$limit = 5;
?>
<?=$header?>

<script>
function init()
{
  // Binding statement
  document.getElementById('sortDropdown').addEventListener('click', dropdown, false);
  document.getElementById('search').addEventListener('keyup', showCalendar, false);
// Filters
var filterArr=document.getElementsByClassName("custom");
for(let index=0; index<filterArr.length; index++)
{
	filterArr[index].addEventListener('click', showCalendar, false);
}
document.getElementById('delete').addEventListener('click', confirmClick, false);


}
// Set deleted value to confirm click in php
function confirmClick(){
  deleted = true;
}

function confirmDel(title, eid) {
// Javascript function to ask for deletion confirmation.
if(title.includes("-"))
  title.replace("-"," ");

	url = "?delete&EID="+eid+"&title="+title; // Refreshes the page with the delete query string, eid, and title.
	var agree = confirm("Delete this event: " + title + "? ");
	if (agree) {
		// Deletes within this script.
		location.href = url;
	}
	else {
		// Do nothing
		return;
	}
}
// Show dropdown upon click
function dropdown(){
  var dropdown = document.getElementById('sort');
  if(dropdown.style.display == 'block') // If this is block, display none
{
    value = "none";
}

  else{
    value = "block";
  }

  dropdown.style.display = value;
}


function showCalendar()
{
  // Get page
  urlParams = new URLSearchParams(window.location.search);
  // Set page as 1 by default
  if(urlParams.get('page')!=null)
  {
    page = urlParams.get('page')
  }
  else{
    page = 1;
  }
  // Get user input
  value = this.value;;
  // Set up XMLHttpRequest object
  pageRequest = GetXmlHttpObject();
    if (pageRequest==null){
      alert ("Your browser does not support AJAX! Please contact unprotectedvictims@gmail.com for more information.");
      return;  // Stop the code right here
    }

    // Monitor the change of readyState
	    pageRequest.addEventListener('readystatechange', function () {
			if (pageRequest.readyState == 4){// Once it reaches 4, process the server response
			chContent = pageRequest.responseText;
			// Insert server response to the div "dataViewer".
    document.getElementById("dataViewer").innerHTML = chContent;
			}
		}, false);
    query = "";
    // If search
    if(this.id=="search")
    { // The query to add is k and the current query string should be added upon an empty value
      query = "k";
      if(this.value=="")
      {
        location.href = "?" + urlParams;

      }


    } // If the user clicked on order, set the query
    if(this.className == "order")
    {
      query = "o";
    }
    var customArr=document.getElementsByClassName("custom");
    for(let index=0; index<customArr.length; index++)
    {
      if(document.getElementById("search").value!="")
      { // Add the value to the query as the user interacts with k
        href = customArr[index].getAttribute('href');
        if(href.includes("k="))
        {
          href+="+" + value;
        }
        else{
          href+="&k=" + value;
        }
        // Keep the page in mind
        if(this.className == "order")
        {
          pageQuery = "page=" + page + "&";
        }
        else{
          pageQuery = "";
        }
        // Edit the href to include these details
        customArr[index].setAttribute('href', href);
      }

    }
    // Build the url based on the page, search, and sort
      url = "search.php?" + pageQuery + query + "=" + value;
      pageRequest.open("GET", url, true);
      pageRequest.send(null);



}

// Add upon load
	window.addEventListener('load',init,false);
</script>
<?php
//Sees if the EID is available from the query string and the user is an admin.
if (isset($_GET['EID']) && isset($_GET['title']) && isset($_GET['delete'])  && $_SESSION['access']) {

	// EID is available
	$EID = intval($_GET['EID']); // Store EID as an int.
  // Store title
  $title = $_GET['title'];
	// Validate EID by checking if greater than 0.
		if ($EID>0 ){
			// If delete is available via the query string, the user is attempting to delete this event.
			if(isset($_GET['delete'])){
				$sql = "DELETE from Events WHERE EID = ?"; //Query to delete

			$stmt = $conn->stmt_init(); //Initialize the statement.

			if ($stmt->prepare($sql)){ //If the query is valid

					$stmt->bind_param('i', $EID); //Bind the EID.

				if ($stmt->execute()){ //If it was executed
				      echo "<script>alert('Success! $title has been deleted.');</script>";

				} else {//It was not executed. It could not delete.
					echo "<script>alert('Database error! $title could not be deleted. Please reach out to the web team.');</script>";
				}
			}

			}
			else{ //If the EID is set, but delete is not there is no action provided.
        echo "<script>alert(Please select an action!');</script>";

			}


		}
		 else {
			// EID is <=0
			$EID = "";
			//Error message.
      echo "<script>alert('Database error! Please reach out to the web team.');</script>";
		}
}
// Determine page number - based on https://www.youtube.com/watch?v=S0Getpg3l_A (Bootstrap Pagination in PHP and MySQL With dynamic limit by learnwebcoding)
// Modified to add info about sort
if(isset($_GET['page']) && $_GET['page'] != '')
{
  $page = $_GET['page'];
  $pageQuery = "&page=$page";
}
else{ // start at 1 if not set
  $page = 1;
  $pageQuery = "";
}
$order = "CalendarDate";
$sort = "Date"; // If order is set, determine the order.
if(isset($_GET['o']) && $_GET['o'] != '')
{
  if($_GET['o'] == 'title')
  {
    $order = "Title";
    $sort = "Title";
  }

}
// Determine start item
$start = ($page - 1) * $limit;
// Used to determine number of items
$results = "SELECT Title FROM Events";
// Sql statement with limit
$sql = "SELECT Keywords, EID, Title, Description, URL, CalendarDate FROM Events ORDER BY $order LIMIT $start, $limit";
// Prepare the statement to count the number of results in total
$stmt = $conn->stmt_init();
if ($stmt->prepare($results))
{
  // Execute
  $stmt->execute();
  $stmt->store_result();
  $count = $stmt->num_rows();
}

// Prepare the statement
$stmt = $conn->stmt_init();
if ($stmt->prepare($sql))
{
  // Execute
  $stmt->execute();
  // Save the data
  $stmt->bind_result($Keywords, $EID, $Title, $Description, $URL, $CalendarDate);

  $stmt->store_result();
  while($stmt->fetch()){ // Fetch results
    // If the user has access as an admin
    if($_SESSION['access'])
      { // Make title more user-friendly
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
        <div class='d-flex mt-3'>
        <a class='mr-1' href='events_form.php?EID=$EID'><button>Edit</button></a>
        <a href='?delete&EID=$EID&title=$newTitle' id='delete'><button>Delete</button></a>
        </div>";

      }
    // Create datetime from date in db
    $dtime = new DateTime($CalendarDate);
    // Format it
    $mysqldate = date_format($dtime,"l, F jS, Y \a\\t g:i a T");
    $keys = explode(", ",$Keywords);
    $keys = implode(", ", $keys);
    // Modify the output
      $output.= "<div class='row my-sm-5'>
              <div class='col-12 col-sm-6 d-flex align-items-center justify-content-center'>
                <img class='w-75 h-75' src='$URL' alt=''>
              </div>
              <div class='col-12 col-sm-6 d-flex flex-column'>
                <h2>$Title</h2>
                <p>$Description</p>
                <span>$mysqldate</span>
                <span>Keywords: $keys</span>
                $adminOps
              </div>
            </div>";
  }
  if($count==0)
  {
    $output = "There are no events identified by those search terms. Please try again.";
  }
  else if($count > $limit){
    // Calculate number of pages
    $pages = round($count / $limit);
    // Create the pagination dynamically
    $pagination = "<nav class='bg-transparent mt-3' aria-label='Search results navigation'>
  <ul class='pagination justify-content-center'>";
// Add the order to the querystring in the pagination
  if(isset($_GET['o']) && $_GET['o']!="")
  {
    $queryString.="&o="."{$_GET['o']}";
  }
  // Determine if active page
    for($i = 1; $i <= $pages; $i++)
    {
      $active = "";
      if($i==$page)
      {
        $active = "active";
      }
      $pagination .= "<li class='page-item $active'><a class='page-link' href='?page=$i$queryString'>$i</a></li>";
    }
    $pagination.="</ul></nav>";
    $output.=$pagination;
  }
}
else {
  $output = "There was an error with the query. Please try again.";
}


   // Close the statement
  $stmt->close();
  $conn->close();
  ?>
</head>
<body>
<header>
<?=$nav?><!--Nav-->
</header>
<main>
<div class="hero get-help-hero">
  <h1>Events</h1>
</div>
<div class="container">
  <nav class="row navbar filter justify-content-around justify-content-lg-between">
    <form action="search.php" method="GET" name="" class="col-12 col-sm-3 mb-0 form-inline"><!--Search engine which uses GET to capture terms-->
      <input id="search" class="form-control mr-sm-2" type="text" placeholder="Search" name="k" autocomplete="off" aria-label="Search">
    </form>
    <?php // Add edit button if admin
    if($_SESSION['access'])
      echo "<a class='col-12 col-sm-3' href='events_form.php'><button>Add an Event</button></a>";
    ?>
    <ul class="list-unstyled col-12 col-sm-1 nav-item dropdown mb-0">
        <li class="mr-2 mr-lg-auto"><a class="nav-link dropdown-toggle" id="sortDropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <?=$sort?> <!--Toggle what dropdown says based on sort-->
        </a></li>
        <li class="dropdown-menu"  id="sort" aria-labelledby="sortDropdown">
          <ul class="list-unstyled"><!--Update links based on current pagequery-->
            <li><a href="?o=date<?=$pageQuery?>" class="dropdown-item order custom"  value="date">Date</a></li>
            <li><a href="?o=title<?=$pageQuery?>"class="dropdown-item order custom"  value="title">Title</a></li>
        </ul>
        </li>
      </ul>
  </nav>
</div>
<div class="container" id="dataViewer">
  <?=$output;?> <!--Output-->
</div>
</main>
<?=$footer?> <!--Footer-->
  </body>
</html>
