$(document).ready(function() {
  $("#name").autocomplete({
    source: function(req, add){
	  //pass request to server
	  $.getJSON("get_school.php?callback=?", req, function(data) {
	    //create array for response objects
	    var suggestions = [];
							
	    //process response
	    $.each(data, function(i, val){								
	      suggestions.push(val.name);
	    });
							
	    //pass array to callback
	    add(suggestions);
	  });
	}
  });
 
});
