function changepic(event) {

			if(event.target.type){ // for firefox (in here when we click upon the img the firefox will not return the image 
                                // it will return button as a target element. )

				id = event.target.firstChild.id; // get image id.
				pics = event.target.parentNode.getElementsByClassName("rating"); // 1st go to the parent target button 
            // which in firefox it is button and then find all other elements which have the rating class
				data = event.target.parentNode.getAttribute("data-for-this-book"); // go to the parent of target node and find the specified attribute.
				data += "&rating="+id; // append or concatenate id (1 -- 5)

			} else { // for chrome the target element is image not button.

				id = event.target.id;
				pics = event.target.parentNode.parentNode.getElementsByClassName("rating"); // get all other images
				data = event.target.parentNode.parentNode.getAttribute("data-for-this-book");
				data += "&rating="+id;
			}

			for (var i = 0; i < pics.length; i++) { // in this function first the unselected image will be brought from
				pics[i].src = "icons/unselected.png";  // the icons folder.
			}

			for (var i = 0; i < id; i++) {   // then for i< id  when you select 3 (from 0 until 2) brought the selected
				pics[i].src = "icons/selected.png";  // images..
			}


			getRecommendedBooks(data); // (isbn=2333&id=0&rating=3)  call this function when the person clicked the 
                                  // stars

}



function createRequest() {

  try {

    request = new XMLHttpRequest(); // this object is used to interact with servers. can retrieve data from
                                 // from a url without having to do full page refresh. used in ajax programming.
                                    // keystone (asas) of ajax is XMLHttpRequest
  } catch (tryMS) { // for internet explorer it will through an exception.

    try {
      request = new ActiveXObject("Msxml2.XMLHTTP"); // internet explorer use this instead of XMLHttprequest.
    } catch (otherMS) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");// for other browsers ...  n
      } catch (failed) { 
        request = null;
      }
    }
  }
  return request;
}


function getRecommendedBooks(data) {

  request = createRequest(); // first create request so we can get data from the url (ajax request)

  if (request == null) {
    alert("Unable to create request");
    return;
  }


  var url= "processratingajax.php?" + data;
  // we set parameters to request object
  request.open("GET", url, true);
  request.onreadystatechange = displayDetails;
  // now we send the request to the server
  request.send(null);
}


function displayDetails() {

  if (request.readyState == 4) {
      // data received
    if (request.status == 200) {
      
      booksDiv = document.getElementById("recommendedbooks");
      booksDiv.innerHTML = request.responseText;
    }
  }
}
