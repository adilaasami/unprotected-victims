// Placeholder for errors
var err = [];

// Display field with an error marking
function error(id)
{
  document.getElementById(id).style.borderLeft = "2px solid red";
}

// Remove the error marking
function removeError(id)
{
  document.getElementById(id).style.borderLeft = "none";
}
// Clear the form of errors and messages
function resetForm()
{
  // Grab all elements with the 'form-control' class
  form =   document.getElementsByClassName('form-control');
  for(let i = 0; i<form.length;i++)
  {
    // Grab id and value
    fieldId = form[i].id;
    form[i].value="";
    // Set message and error as none
    document.getElementById(fieldId +"Message").innerHTML="";
    document.getElementById(fieldId).style.border = "none";
    document.getElementById(fieldId).style.borderBottom = ".15em solid var(--black)";
    removeError(id);
  }
}
// Determine if errors are still present
function errorCheck(evt)
{
  // Capture evt
  var evt = (evt) ? evt : ((window.event) ? event : null);
  if(evt)
  {
    // Capture message id
    eId = evt.target.id;
    eId += "Message";
    // If the message does not have an error
    if(!err.includes(eId) && document.getElementById(eId).firstChild != null && document.getElementById(eId).firstChild.className=="errMsg")
    {
      // Push to the errors array
            err.push(eId);
    }// Else if there is an error
    else if(err.includes(eId) && document.getElementById(eId).firstChild == null) {
      // Grab the index
        const index = err.indexOf(eId);
      // Remove from the array
        if (index > -1) {
            err.splice(index, 1);
        }
    }
    else{
      // Return
      return;
    }
  }


}

// Grab the XmlHTTP Object
function GetXmlHttpObject(){
  var xmlHttp=null;
  if (window.XMLHttpRequest) { // Non-IE
    xmlHttp = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlHttp;
}
// Respond with a message if the field is empty, else remove the error
function validate(id, value)
{// Empty
	if(value == "")
	{ // Add error
		document.getElementById(id+"Message").innerHTML = "Please enter a " + id + " for the event.";
		error(id);
	}
	else{ // Remove
		document.getElementById(id+"Message").innerHTML = "";
		removeError(id);
	}
}
