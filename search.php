<?php
include_once "dbconn.inc.php";
// Start session
session_start();
$conn = dbConnect();
// modeled after https://phpdelusions.net/mysqli_examples/search_filter, modified to add pagination and order
$limit = 5;
// Set these arrays as placeholders
$conditions = [];
$parameters = [];
// Determine page number - based on https://www.youtube.com/watch?v=S0Getpg3l_A (Bootstrap Pagination in PHP and MySQL With dynamic limit by learnwebcoding)
if(isset($_GET['page']) && $_GET['page'] != '')
{
  $page = $_GET['page'];
}
else{ // Start at 1 is not set
  $page = 1;
}
// Determine start based on limit
$start = ($page - 1) * $limit;

// Conditional statements based on search
if (isset($_GET['k']) && $_GET['k'] != "")
{
    // Save the keywords and set as the query
    $k = $_GET['k'];
    $query = 'k';
    $queryTerm = $k;
    // Split up each keyword by space
    $keywords = explode(" ", $k);
    foreach($keywords as $word)
    {
      // Save the parameters in the parameters array
      $parameters[] = "%$word%";
      // Save the sql conditions in an array
      $conditions[] = 'Keywords LIKE ?';
    }



}

// The main query
$sql = "SELECT Keywords, EID, Title, Description, URL, CalendarDate FROM Events";

// A smart code to add all conditions, if any
if ($conditions)
{
    $sql .= " WHERE ".implode(" OR ", $conditions);
}

// If order is set
if(isset($_GET['o']) && $_GET['o'] != "")
{
  // Get the order and set as the query
  $o = $_GET['o'];
  $query = 'o';
  $queryTerm = $o;
  // Determine type of order
  if($o=="date")
  {
    $order = "CalendarDate";
  }
  if($o=="title"){
    $order = "Title";
  }


}

// A search query always needs at least a `LIMIT` clause,
$sql .= " LIMIT ?,?";
$parameters[] = $offset;
$parameters[] = $limit;
// Prepare the statement
$stmt = $conn->prepare($sql);
  // Dynamically bind the parameters based on the number of times we added to the parameters array
  $stmt->bind_param(str_repeat("s", count($parameters)), ...$parameters);
  // Execute
  $stmt->execute();
  // Save the data
  $stmt->bind_result($Keywords, $EID, $Title, $Description, $URL, $CalendarDate);
  $stmt->store_result();
  $count = $stmt->num_rows();
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
        $Title_js = htmlspecialchars($Title, ENT_QUOTES); // Converts quotation marks in review title to html entity code to avoid javascript conflicts.
        $adminOps = "<script>if(delete) confirmDel(\"$Title_js\",$EID)</script>
        <div class='d-flex mt-3'>
        <a class='mr-1' href='events_form.php?EID=$EID'><button>Edit</button></a>
        <a href='?delete&EID=$EID&title=$newTitle' id='delete'><button>Delete</button></a>
        </div>";

      }
    // Create datetime from date in db
    $dtime = new DateTime($CalendarDate);
    // Format it
    $mysqldate = date_format($dtime,"l, F jS, Y \a\\t g:i a");
    $keys = explode(" ",$Keywords);
    $keys = implode(", ", $keys );
    // Modify the output
      $result.= "<div class='row my-sm-5'>
              <div class='col-12 col-sm-6 d-flex justify-content-center align-items-center'>
                <img class='w-75 h-75' src='$URL' alt=''>
              </div>
              <div class='col-12 col-sm-6 d-flex flex-column'>
                <h2>$Title</h2>
                <p>$Description</p>
                <span>$mysqldate CST</span>
                <span>Keywords: $Keywords</span>
                $adminOps
              </div>
            </div>";

  }
  if($count==0)
  {
    $result = "<div class='error'> There are no events identified by those search terms. Please try again.</div>";
  }
  else if($count > $limit){
    // Calculate number of pages
    $pages = round($count / $limit);
    // Create the pagination dynamically
    $pagination = "<nav class='bg-transparent mt-3' aria-label='Search results navigation'>
  <ul class='pagination justify-content-center'>";
  // Grab the querystring
  $queryString = $_SERVER['QUERY_STRING'];
    for($i = 1; $i <= $pages; $i++)
    { // Keep page in mind
      if(str_contains($queryString, "page=$i"))
        {
          $position = strpos($queryString, "page=$i");
          $queryString = substr($position+7);
        }
      else{
        if(strlen($queryString) > 0)
          $queryString .= "&page=$i";
        else {
          $queryString = "page=$i";
        }
        // Keep order in mind
        if(isset($_GET['o']) && $_GET['o']!="")
        {
          $queryString.="&o="."{$_GET['o']}";
        }
      } // Determine active page
      $active = "";
      if($i==$page)
      {
        $active = "active";
      }
      $pagination .= "<li class='page-item $active'><a class='page-link' href='?$queryString'>$i</a></li>";
    }
    $pagination.="  </ul>
    </nav>";
    $result.=$pagination;
  }
  $stmt->close();
  // Return result
  echo $result;
?>
