<?php
// Metadata
$title = "News Related to UnProtected Victims";
include 'shared.php';
?>
<?=$header?>
<script>
function init(){
  // Upon load pull up the rss feed
  showInfo('https://www.nbcdfw.com/?rss=y');
}

// Declare a variable here to store the xmlHttpRequest object so it can be used in multiple functions
var xmlHttp;
// This function filters based on keywords supplied
function findNews(desc)
{
  var keywords = ["unprotected", "victims", "police", "crime", "police violence", "accused", "custody"];
  for(k in keywords)
  {
    if(desc.includes(k))
    {
      return true;
    }
  }
}

function showInfo(str){

	// Set up xmlHttpRequest object
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request. Please email unprotectvictims@gmail.com for assistance.");
	return;
	}

	 // Prepare to send the xmlHttpRequest object

	 var proxyURL = "proxy.php";
	 // RealDestination will be embedded in a query string
	 var realDestination=str;

	 var requestURL = proxyURL+"?url="+encodeURIComponent(realDestination);

	 // Catch the readystatechange event and bind it to the processing function
	 xmlHttp.onreadystatechange=function(){stateChanged(str)};

	 // Send the request
	 xmlHttp.open("GET",requestURL,true);
	 xmlHttp.send(null);
}

function stateChanged(str)
{
  // For pagination
  limit = 5;
  // Grab the url
  urlParams = new URLSearchParams(window.location.search);
  // Determine page with 1 as default
  if(urlParams.get('page')!=null)
  {
    page = urlParams.get('page')
  }
  else{
    page = 1;
  }
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
  // Get the request result as an XML document
  xmlDoc=xmlHttp.responseXML;

 // Set the variable to store HTML output
 var output = "";

 // Get all the channels
 var channels = xmlDoc.getElementsByTagName("channel");

   // loop through all "channel" elements in the RSS document
    for (i=0;i<channels.length ;i++ )
    {
     // Add the channel title to the output
     output = output + "<span class='channelTitle'>"+channels[i].getElementsByTagName("title")[0].childNodes[0].nodeValue+"</span><br>";

     // Get all items in a channel
     var items = channels[i].getElementsByTagName("item");
     // Loop through all "item" elements in a channel
     // Start at current page (all results up to that multiple minus the limit) and end at the product of that multiple
     for (j = page*limit-limit; j < limit*page; j++){
       if(findNews(checkContent(items[j], "description")))
       { // Validate the content
         title = checkContent(items[j], "title");
         link = checkContent(items[j], "link");
         description = checkContent(items[j], "description");
         // Shorten the description
         start = description.indexOf('<p>');
         end = description.indexOf('</p>');
         paragraph = description.substring(start, end-start+5);
         // Grab the image
         image = items[j].getElementsByTagName('media:content')[0].getElementsByTagName('media:thumbnail')[0].getAttribute('url');
         pubDate = checkContent(items[j], "pubDate");

         if (title != "(n/a)") { // Only include the record with a title
           output += "<div class='row my-sm-5'>";
           output += "<div class='col-12 col-sm-6 justify-content-center align-items-center'>";
           output += "<img class='w-75 h-75' src='" + image + "'>" + "</div><div class='col-12 col-sm-6 d-flex flex-column'><h2>";
           output += title + "</h2>";
           output += paragraph + "<span>";
           output += pubDate + "</span><br><a href='";
           output += link + "'>View Full Article on '";
           output += title + "'</a></div></div>";


         }
       }

     }

   }  // Determine if pagination needed
    if(items.length > limit){
      // Calculate number of pages
      pages = items.length / limit;
      // Create the pagination dynamically
      pagination = "<nav class='bg-transparent mt-3' aria-label='Search results navigation'>";
      pagination += "<ul class='pagination justify-content-center'>";
      for(y = 1; y <= pages; y++)
      {
        active = "";
        if(y==page)
        {
          active = "active";
        }
        pagination += "<li class='page-item " + active + "'><a class='page-link' href='?page="+ y + "'>"+ y + "</a></li>";
      }
      pagination+="</ul></nav>";
      output+=pagination;
    }
    // Print out the HTML output in the specified div
   document.getElementById("dataViewer").innerHTML= output;
  }

}

function checkContent(itemObj, tagName){
    // Check to ensure the desired element is availabe and with a value
    if (itemObj.getElementsByTagName(tagName).length > 0 && itemObj.getElementsByTagName(tagName)[0].childNodes.length > 0) {
      if(tagName == "content")
         value = itemObj.getElementsByTagName('media:thumbnail')[0].getAttributes().getNamedItem("url").textContent;
      else{
        value = itemObj.getElementsByTagName(tagName)[0].childNodes[0].nodeValue;
      }

    } else {
        value = "(n/a)";
    }
    return value;
}

// Upon load run init
window.addEventListener('load', init);
</script>
</head>
<body>
<?=$nav?> <!--Nav-->
<main>
  <div class="hero get-help-hero">
    <h1>News</h1>
  </div>
  <div class="container mt-5" id="dataViewer">
    <div class="row"> <!--Placeholder-->
      <span>Articles are currently loading. Thank you.</span>
  </div>
  </div>
</main>
<?=$footer?>
  </body>
</html>
