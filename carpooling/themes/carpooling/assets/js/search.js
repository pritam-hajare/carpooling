$(document).ready(function() {
	
	
$("#findform").validate({
   errorElement: "spnError",    
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
});

function initialize1() {
    var input = document.getElementById('source');
    //var options = {componentRestrictions: {country: 'ind'}};
                 
   autocomplete =  new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $('#source').val();
			geocoder = new google.maps.Geocoder();	
			 
			geocoder.geocode( { 'address': data}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {		
			 //alert(results[0].geometry.location.lat());
				 source=results[0].geometry.location.lat()+","+results[0].geometry.location.lng();	 
				 $('#formlatlng').val(source);
				 //alert(source);
			}
			else
			{
				alert('given lat and long cannot be found please choose different location');
				$("#formlatlng").val('');
			}
		
			});	
	 });
}

function initialize2() {
    var input = document.getElementById('destination');
   // var options = {componentRestrictions: {country: 'ind'}};
                 
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
			alert('given lat and long cannot be found please choose different location');
			$("#tolatlng").val('');
		} 
	
		});	
	
	 });
}
google.maps.event.addDomListener(window, 'load', initialize1);
google.maps.event.addDomListener(window, 'load', initialize2);

function filter_result(url) {
	$body = $("body");
   	$body.addClass("loading");	
   var locationdata = "";
	var Source = $("#source").val()?$("#source").val():'';
	var Source_lan = $("#formlatlng").val()?$("#formlatlng").val():'';
	//alert(Source);
	var Destination_lan = $("#tolatlng").val()?$("#tolatlng").val():'';
	var Destination = $("#destination").val()?$("#destination").val():'';
	var Frequency = $("#frequency").val()?$("#frequency").val():'';
	var date = $("#journey_date").val()?$("#journey_date").val():'';
	//var type = $( "input:radio[name=returntype]:checked" ).val();
	var Return = $( "input:radio[name=returntype]:checked" ).val()?$( "input:radio[name=returntype]:checked" ).val():'';
	var FrequencyFilter = $( "input:radio[name=frequencytype]:checked" ).val()?$( "input:radio[name=frequencytype]:checked" ).val():'';	

    var vechicletype = [];
	var amenitiestype = [];
	var traveltype = [];
	var allowedtype = [];
	var vechiclecategory = [];
	
	
	$('#vechicle_category :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    vechiclecategory.push(condept);
     });
   
	 $('#vechicle_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    vechicletype.push(condept);
     });	
	 
	  $('#amenities :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    amenitiestype.push(condept);
     }); 
	 
	  $('#travel_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    traveltype.push(condept);
     }); 
	 
	 $('#allowed_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    allowedtype.push(condept);
     }); 
		
	
     pricefrom=0;
	 priceto=25000;

	 
	//$("#searchresult1").mask("");
	


var param = 'source='+escape(Source)+'&destination='+escape(Destination)+'&formlatlng='+escape(Source_lan)+'&tolatlng='+escape(Destination_lan)+'&frequency='+escape(Frequency)+'&VECHICATEGORY_FILTER='+escape(vechiclecategory)+'&VECHITYPE_FILTER='+escape(vechicletype)+'&AMENITIES_FILTER='+escape(amenitiestype)+'&TRAVELTYPE_FILTER='+escape(traveltype)+'&TRAVELALLOW_FILTER='+escape(allowedtype)+'&Return_Type='+Return+'&FREQUENCY_FILTER='+FrequencyFilter+'&FILTER=1&journey_date='+date;
			
		$.ajax({
		type: "POST",
		url: baseurl+"search/search_ajax/"+url,
		data:param,
		success: function(html){
		
	var left = $('<div />').append(html).find('#leftarea').html();
	var  right = $('<div />').append(html).find('#rightarea').html();
	

  	$("#count").html(left);
	$("#rightarea").html(right);
	//$("#rightarea").unmask();
	$body.removeClass("loading");	
	loaded_messages =0;
	
	

	$('#search_results').scrollPagination({

		nop     : 3, // The number of posts per scroll to be loaded
		offset  : 0, // Initial offset, begins at 0 in this case
		error   : 'No More Trips!', // When the user reaches the end this is the message that is
		                            // displayed. You can change this if you want.
		delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
		               // This is mainly for usability concerns. You can alter this as you see fit
		scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
		               // but will still load if the user clicks.
		
	});
	
}
	});      
	
}

$('body').on('click','.map-view', function()
{
	
	$body = $("body");
   	$body.addClass("loading");	
   var locationdata = "";
	var Source = $("#source").val()?$("#source").val():'';
	var Source_lan = $("#formlatlng").val()?$("#formlatlng").val():'';
	//alert(Source);
	var Destination_lan = $("#tolatlng").val()?$("#tolatlng").val():'';
	var Destination = $("#destination").val()?$("#destination").val():'';
	var Frequency = $("#frequency").val()?$("#frequency").val():'';
	var date = $("#journey_date").val()?$("#journey_date").val():'';
	//var type = $( "input:radio[name=returntype]:checked" ).val();
	var Return = $( "input:radio[name=returntype]:checked" ).val()?$( "input:radio[name=returntype]:checked" ).val():'';
	var FrequencyFilter = $( "input:radio[name=frequencytype]:checked" ).val()?$( "input:radio[name=frequencytype]:checked" ).val():'';	

    var vechicletype = [];
	var amenitiestype = [];
	var traveltype = [];
	var allowedtype = [];
	var vechiclecategory = [];
	
	
	$('#vechicle_category :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    vechiclecategory.push(condept);
     });
   
	 $('#vechicle_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    vechicletype.push(condept);
     });	
	 
	  $('#amenities :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    amenitiestype.push(condept);
     }); 
	 
	  $('#travel_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    traveltype.push(condept);
     }); 
	 
	 $('#allowed_type :checked').each(function() {
	 condept = "~"+$(this).val()+"~";
	    allowedtype.push(condept);
     }); 
		
	

var param = 'source='+escape(Source)+'&destination='+escape(Destination)+'&formlatlng='+escape(Source_lan)+'&tolatlng='+escape(Destination_lan)+'&frequency='+escape(Frequency)+'&VECHICATEGORY_FILTER='+escape(vechiclecategory)+'&VECHITYPE_FILTER='+escape(vechicletype)+'&AMENITIES_FILTER='+escape(amenitiestype)+'&TRAVELTYPE_FILTER='+escape(traveltype)+'&TRAVELALLOW_FILTER='+escape(allowedtype)+'&Return_Type='+Return+'&FREQUENCY_FILTER='+FrequencyFilter+'&FILTER=1&journey_date='+date;
			
		$.ajax({
			type: "POST",
			url: baseurl+"search/search_map/",
			data:param,
			success: function(html){
				if(html){
					setTimeout(function(){ 						
					$("#rightarea").fadeOut('slow');
					$("#map-content").html(html);
					$('.map-view').addClass("current-map-view");
					$('.list-view').removeClass("current-li-view");
					$("#map-content").fadeIn('slow');	
					initialize_map();		
					}, 1000);
					setTimeout(function(){ 						
					$body.removeClass("loading");						
					}, 1500);
				}
				else
				{
					setTimeout(function(){ 						
					$body.removeClass("loading");						
					}, 1500);
				}
				
			}
		});
	
});

$('body').on('click','.list-view', function()
{
	$body = $("body");
   	$body.addClass("loading");	
	setTimeout(function(){ 	
	$("#map-content").fadeOut('slow');	
	$('.map-view').removeClass("current-map-view");
	$('.list-view').addClass("current-li-view");
	$("#rightarea").fadeIn('slow');
	}, 1000);
	setTimeout(function(){ 						
	$body.removeClass("loading");						
	}, 1500);
});


function show_animation()
{
	$('#saving_container').css('display', 'block');
	$('#saving').css('opacity', '.2');
}

function hide_animation()
{
	//$('#saving_container').fadeOut();
	$('#saving_container').hide();
}

function intimate_close()
{
	setTimeout(function () { $('.intimate_bx').fadeOut() }, 300);
	
}
function getfrequency(){
	
	 var d = new Date($("#journey_date").val());
    var n = d.getDay()
	$('#frequency').val(n);
}
function areyousure()
{	
	if($('#tolatlng').val()  != '' && $('#formlatlng').val() != '')
	{
		return true;
	}
	else
	{
		alert('please reselect source and destination');
		return false
	}
}

function viewPopcontact(pmId)
 {
	
	var pmQueryString	= 'pmId='+pmId;	
	$.ajax({
			type: "POST",	
			url: baseurl + "communication/sendenquiry/true",		
			dataType: "json",	
			data:pmQueryString,
			success: function(json)	{
		
				if (json.result == 0){
					
					$('#enquiry_'+pmId).html('<img src="'+tickicon+'"/>Your request already sent. You may call if required')					
					//$('#spnError').show();
					return false;
				} else if (json.result == 1) {
					$('#enquiry_'+pmId).html('<img src="'+tickicon+'"/>Your Enquiry has been submitted successfully!')
				}
			}
		});
}

function saveintimate()
{
	//var saveflg = $("#sms").val()?$("#sms").val():'';
	//input:checkbox
	//var sms = $( "input:checkbox[name=sms]:checked" ).val();
	var emailid = $("#email").val()?$("#email").val():'';
	//return false;
	if(emailid == "")
	{
		alert('please specify your Email-Id');
		return false;
	}
	var sms = $('#sms').attr('checked')?1:0;
	var type = $( "input:radio[name=return]:checked" ).val()?$( "input:radio[name=return]:checked" ).val():'';
	var Source = $("#source").val()?$("#source").val():'';
	var Destination = $("#destination").val()?$("#destination").val():'';
	var frequency = $("#frequency").val()?$("#frequency").val():'';
	var date = $("#journey_date").val()?$("#journey_date").val():'';
	 var email = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;  
	if((emailid.match(email)))  
	{  
		$('#int_status').html('')
		var param = 's_inti='+sms+'&typ='+type+'&src='+Source+'&dest='+Destination+'&date='+date+'&frq='+frequency+'&email='+emailid;
	
		$('#btnsave').html('<input type="button" id="save"  value="wait">')
		$.ajax({
				type: "POST",	
				url: baseurl + "search/intimate/true",				
				dataType: "json",	
				data:param,
				success: function(json)	{		
					if (json.result == 1) {
						$('#intimate').html('<span class="enq_suc"><img src="'+tickicon+'"/>Thank you for registering with us, you will get mail once your search is matching.</span>')
						setTimeout(function () { $('.intimate_bx').fadeOut() }, 2000);
					}
				}
			});  
	}  
	else  
	{
			$('#int_status').html('Please enter valid phone number')
			return false; 
	}  
	
	
}


