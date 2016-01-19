$(document).ready(function() {
		
	$("#searchform").validate({
   errorElement: "div",    
   //set the rules for the fild names
   rules: { 
   
     destination: {
     required: true,
     
     
     },
        source: {
     required: true,
        },
  journey_date: {
     required: true,
     
     
    }
   },
   //set messages to appear inline
   messages: { 
      
  destination: {
     required: "",
    },
  source: {
     required: "",
    },
        
        journey_date: {
    required: "",
    
    },
  
   },

  
  errorPlacement: function(error, element) {               
    error.appendTo(element.parent());     
   }

  });	
  
  
  $("#subscribe").validate({
			errorElement: "span",			 
			//set the rules for the fild names
			rules: {	
				email_id: {
					required: true,					
					email: true
					
				},
									
			},
			//set messages to appear inline
			messages: {	
				email_id: {
					required: "",
				},
					
								
			},

		submitHandler: function(form) {
			$('#send').html('<input type="submit" value="Please Wait..." class="cs-blue-bg colorwhite subs-brd">')
			
			
			$.ajax({
				type:"POST",
				url: baseurl + "pages/add_subscriber/true",
				dataType: "json",
				data:$('#subscribe').serialize(),
				success:function(json)
				{
					if (json.result == 0){
					
					$('#send').html('<input type="submit" value="Subscribe" class="cs-blue-bg colorwhite subs-brd">')
					alert(json.message);					
						return false;
					} else if (json.result == 1) {
						$('#email_id').val('')						
						$('#send').html('<input type="submit" value="Thank You" class="cs-blue-bg colorwhite subs-brd">')
						setTimeout(function(){ $('#send').html('<input type="submit" value="Subscribe" class="cs-blue-bg colorwhite subs-brd">') }, 3000);
					}
					
				}
			});
		},
		errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});

	
});

function initialize1() {
    var input = document.getElementById('source');
	
   // var options = {componentRestrictions: {country: 'all'}};
                 
   autocomplete =  new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $('#source').val();
			geocoder = new google.maps.Geocoder();	
			 
			geocoder.geocode( { 'address': data}, function(results, status) {	
			if (status == google.maps.GeocoderStatus.OK) {
			 //alert(results[0].geometry.location.lat());
				 source=results[0].geometry.location.lat()+","+results[0].geometry.location.lng();	 
				 $('#formlatlng').val(source);
				
			}
			else
			{
				alert('Latitude and longitude not found for your input please try different(near by) location');
				$("#formlatlng").val('');
			}			
		
			});	
	 });
}

function initialize2() {
    var input = document.getElementById('destination');
   // var options = {componentRestrictions: {country: 'all'}};
                 
    autocomplete =  new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $("#destination").val();
		geocoder = new google.maps.Geocoder();	
			 
		geocoder.geocode( { 'address': data}, function(results, status) {	
		if (status == google.maps.GeocoderStatus.OK) {
		 //alert(results[0].geometry.location.lat());
			 destination= results[0].geometry.location.lat()+","+results[0].geometry.location.lng();	
			 $('#tolatlng').val(destination);	
		}
		else
		{
			alert('Latitude and longitude not found for your input please try different(near by) location');
			$("#tolatlng").val('');
		}
	
		});	
	
	 });
}
google.maps.event.addDomListener(window, 'load', initialize1);
google.maps.event.addDomListener(window, 'load', initialize2);

function getfrequency()
{
	 var d = new Date($("#journey_date").val());
    var n = d.getDay()
	$('#frequency').val(n);
	
}

function initialize1mob() {
    var input = document.getElementById('mob_source');
	
   // var options = {componentRestrictions: {country: 'all'}};
                 
   autocomplete =  new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $('#mob_source').val();
			geocoder = new google.maps.Geocoder();	
			 
			geocoder.geocode( { 'address': data}, function(results, status) {	
			if (status == google.maps.GeocoderStatus.OK) {
			 //alert(results[0].geometry.location.lat());
				 source=results[0].geometry.location.lat()+","+results[0].geometry.location.lng();	 
				 $('#mob_formlatlng').val(source);
				
			}
			else
			{
				alert('Latitude and longitude not found for your input please try different(near by) location');
				$("#mob_formlatlng").val('');
			}			
		
			});	
	 });
}

function initialize2mob() {
    var input = document.getElementById('mob_destination');
   // var options = {componentRestrictions: {country: 'all'}};
                 
    autocomplete =  new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $("#mob_destination").val();
		geocoder = new google.maps.Geocoder();	
			 
		geocoder.geocode( { 'address': data}, function(results, status) {	
		if (status == google.maps.GeocoderStatus.OK) {
		 //alert(results[0].geometry.location.lat());
			 destination= results[0].geometry.location.lat()+","+results[0].geometry.location.lng();	
			 $('#mob_tolatlng').val(destination);	
		}
		else
		{
			alert('Latitude and longitude not found for your input please try different(near by) location');
			$("#mob_tolatlng").val('');
		}
	
		});	
	
	 });
}
google.maps.event.addDomListener(window, 'load', initialize1mob);
google.maps.event.addDomListener(window, 'load', initialize2mob);

function getfrequencymob()
{
	 var d = new Date($("#mob_journey_date").val());
    var n = d.getDay()
	$('#mob_frequency').val(n);
	
}



