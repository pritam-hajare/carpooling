	$(document).ready(function() {
		jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z]+$/i.test(value);
					}, "Please enter only letters"); 
		
		// validate contact form on keyup and submit
	$("#frmtrip").validate({
			
			 errorElement: "spnError", 
			 ignore: [],
			 
			//set the rules for the fild names
			rules: {
			
				vechicletype: {
					required: true,					
					
				},
				vehnum: {
					required: true,					
					
				},
				
				'amenities[]': {
					required: true,					
					
				},
				txtsource: {
					required: true,					
					
				},
				txtdestination: {
					required: true,					
					
				},
				avail_seats: {
					required: true,	
					maxlength:3,
					digits: true				
					
				},
				jhour: {
					required: true,					
					
				},	
				passenger_type: {
					required: true,					
					
				},
				name: {
					required: true,					
					
				},
				number: {
					required: true,
					minlength: 4,
					maxlength:15,
					digits: true					
					
				},
				comments: {
					required: true,					
					
				},
				jquerytagboxtext:{
					required: true,
				},
				tzone:{
					
				},
				
					
				
				
			},
			//set messages to appear inline
			messages: {
			
				vechicletype: {
					required: "",
				},
				
				vehnum: {
					required: "",
				},
				'amenities[]': {
					required: "Choose one amenities ",
				},
				txtsource: {
					required: "",
				},
				txtdestination: {
					required: "",
				},
				avail_seats: {
					required: "",
				},
				jhour: {
					required: "Please check your active trips/timings",
				},
				passenger_type: {
					required: "",
				},
				name: {
					required: "",
				},
				number: {
					required: "",
					
				},
				comments: {
					required: "",
				},
				jquerytagboxtext:{
					required: "Please add atleast one route",
				},
				tzone:{
					required: "Please check your timings",
				},
				
						
				
				
			},
			submitHandler:function(form){	
				from = $("#fhh").val()+":"+$('#fmm').val()+" "+$('#fzone').val()	
				to = $("#thh").val()+":"+$('#tmm').val()+" "+$('#tzone').val()
                               

				var param = 'time='+from+'&t_time='+to+'&tid='+$('#tripid').val()+'&vid='+$('#vechicletype').val()+'&frequency='+$('#frequency_ids').val()+'&date='+$('#rpt_from_date').val()+'&return_flg='+$("input[name=return]:checked").val()
				
				if($("#yes").is(":checked"))
				{
					if( from == to)
					{							
						Boxy.alert("SAME TIME", function() {			 	
								return false;			
							 },{title: 'Alert'});
						//alert('SAME TIME');
						return false;
					}
				}
					/*else
					{
					*/
						$body = $("body");
   						$body.addClass("loading");	
						$.ajax({
							type: "POST",
							url: baseurl+"addtrip/check/",
							dataType:"json",
							data:param,
							success: function(json){	
								if(json.result == 1){
									
									$.ajax({
										type: "POST",
										url: baseurl+'addtrip/form/0/true',
										data:$("#frmtrip").serialize(),
										dataType:"json",
										success: function(json){	
										if (json.result == 0){						
												$body.removeClass("loading");
												Boxy.alert(json.error,function() {			 	
													return false;			
												 },{title: 'Alert'});
												//alert(json.error)												
												return false;
											} else if (json.result == 1) {
												window.location	= baseurl +'addtrip';
											}
										
										
										},
									});
									
								}
								else if (json.result == 0) {
									//alert(json.message)	
									Boxy.alert(json.message,function() {			 	
											return false;			
										 },{title: 'Alert'});	
										 return false;		
								}
							}
						});
					
				//}
		
					
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});	

		
		});

function change_trip(type_id)
{
	if(type_id == '1')
  {
	$('#return').hide();
	
	
  }
	if(type_id == '2')
  {
	
	$('#return').show();
	
  }
}	

function change_type(type_id)
{
	if(type_id == '1')
  {
	$('#casuals').hide();
	$('#regular').show();
	$('#rpt_from_date').val('');
	//$('#jhour').val('');
	$('#frmtrip').find('input[type=checkbox]:checked').removeAttr('checked');
	//$('#tzone').attr('selectedIndex', 0);
	//$('[name=tzone]').val( '' );
	$('#frequency_ids').val('');
	
  }
	if(type_id == '2')
  {
      
	$('#regular').hide();
	$('#casuals').show();
	$('#frequency_ids').val('');
	//$('[name=tzone]').val( '' );
  }
}	

jQuery(function() {
  jQuery("#jquerytagboxtext").tagBox();
  jQuery("#jquery-tagbox-select").tagBox({ 
	enableDropdown: true, 
	dropdownSource: function() {
	  return jQuery("#jquery-tagbox-select-options");
	}
  });
});

function filter_result() {
   
 //var department = $("#department").val()?$("#department").val():'';
 
  var deptdata = [];
   $('#regular :checked').each(function() {
  condept = "~"+$(this).val()+"~";
   //tokendata.push($(this).attr('token'));
       deptdata.push(condept);
     });
  //alert(deptdata);
  $('#frequency_ids').val(deptdata);
  //$('#jhour').val('');
 // $('[name=tzone]').val( '' );
}

function filter_result1() {
   
 //var department = $("#department").val()?$("#department").val():'';
 
  var amtdata = [];
   $('#amenities :checked').each(function() {
  condept = "~"+$(this).val()+"~";
   //tokendata.push($(this).attr('token'));
       amtdata.push(condept);
     });
  //alert(deptdata);
  $('#amenities_ids').val(amtdata);
  
}

/*function calculatehours()
{	


if($('#frequency_ids').val() == '' && $('#rpt_from_date').val() == ''){
	alert('Please select trip frequency or date');
	$('[name=tzone]').val( '' );
	return false;
}

if($("#fhh").val() !='' && $('#fmm').val() !='' && $('#fzone').val() !='')
{
	//alert();
from = $("#fhh").val()+":"+$('#fmm').val()+" "+$('#fzone').val()	
to = $("#thh").val()+":"+$('#tmm').val()+" "+$('#tzone').val()

frmtime = new Date(
   '01/01/1971 ' +from
  ).getTime();
totime = new Date(
   '01/01/1971 ' +to
  ).getTime();




$('#timing').html('');
var param = 'time='+from+'&t_time='+to+'&tid='+$('#tripid').val()+'&vid='+$('#vechicletype').val()+'&frequency='+$('#frequency_ids').val()+'&date='+$('#rpt_from_date').val()
$.ajax({
		type: "POST",	
		url: baseurl + "addtrip/check/",	
		dataType: "json",
		data:param,			
		success: function(json)	{
				if (json.result == 0){
					$('#jhour').val('');
					$('#error').html('You cant add the trip, the same active/inactive trips may exist. Please check');
					//$('#spnError').show();
					return false;
				} else if (json.result == 1) {
					$('#jhour').val('');
					$('#error').html('');
					
					$('#depature_time').val(from);
					$('#arrival_time').val(to);
					 
					 d = new Date(totime - frmtime);
  					 //d.getUTCHours() + ':' + d.getUTCMinutes()
					 result =  d.getUTCHours() +" Hours "+d.getUTCMinutes()+" Minutes"
					  $('#jhour').val(result)
					  $('#edited').val('1');
				}
		}
	});

}else
{
	alert('please select depature time');
	return false;
}
//alert(result);

}

function toSeconds(time_str) {
	// Extract hours, minutes and seconds
	var parts = time_str.split(':');
	// compute  and return total seconds
	return parts[0] * 3600 + // an hour has 3600 seconds
	parts[1] * 60 + // a minute has 60 seconds
	+
	parts[2]; // seconds
}

function convertTo24Hour(time) {
    var hours = parseInt(time.substr(0, 2));
    if(time.indexOf('am') != -1 && hours == 12) {
        time = time.replace('12', '0');
    }
    if(time.indexOf('pm')  != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    return time.replace(/(am|pm)/, '');
}*/

function checkroute(){
	var latlng = $('#welcome').val()
	geocoder = new google.maps.Geocoder();	
	//alert(latlng);
	if(latlng)
	{			
		geocoder.geocode( { 'address': latlng}, function(results, status) {	
			if (status != google.maps.GeocoderStatus.OK) {		
				alert('Latitude and longitude not found for your input please try different(near by) location');
				$("#welcome").val('');
				return false;
			}
			
	
		});	
		
	}
	
	//return true;

	
	
}
function filter_route() {
	
	   var routedata = [];
		var routelan = [];
		var routes = [];
		
	
	   if($('#jquerytagboxtext').val() == ''){
	   		$('#route_lanlat').val('');
	   }
		  rout = $('#jquerytagboxtext').val().split('~'); 
	   	  //alert(rout[0]);
		  for(j=0;j<rout.length;j++)
		  {
		  		
				routes.push(rout[j]+'~');
				
		  }
		  $('#routesdata').val(routes);
		  for(j=0;j<rout.length;j++)
		  {
		  		selrout = rout[j].split(',');
				//alert(selrout[0]);
				routedata.push(selrout[0]);
				
		  }
		  $('#routes').val(routedata);
		 // conroute = $('#routes').val()+','+vals;
		   conroute = $('#routesdata').val();
		   //$('#routes').val(conroute);
	 
	  // var myArray = conroute.split(',');
	   conroute = conroute.slice(0, -1);
	   var myArray = conroute.split('~,');
	   //alert(myArray);
	   for (var i=0; i<myArray.length; i++){
		//$('#route_ids').val();
		var s = myArray[i];
		var lastIndex = s.lastIndexOf(",");
		var latlng = s.substring(0, lastIndex);
		geocoder = new google.maps.Geocoder();	
			//alert(myArray[i]);
			if(latlng)
			{
				geocoder.geocode( { 'address': latlng}, function(results, status) {	
				 //alert(results[0].geometry.location.lat());
					 latlan= "~"+results[0].geometry.location.lat()+","+results[0].geometry.location.lng()+"~";
					
						routelan.push(latlan);
						//alert(routelan);
						$('#route_lanlat').val(routelan)
				});	
				
			}
			
			
		}
		$('hour').attr('selectedIndex', 0);
	    $('minu').attr('selectedIndex', 0);
		$('zone').attr('selectedIndex', 0);
		if($('#routesdata').val() !='~')
		$( "#route-map" ).trigger( "click" );
   
}


function clearnow()
{
	$('#edited').val('1');
	$('#jhour').val('');
	$('#timing').html('');
	$('#tzone').val('');
	//alert();	
}

function initialize1() {
    var input = document.getElementById('txtsource');
	if(country != '')
	{
		var options = {componentRestrictions: {country: country}};
		autocomplete =  new google.maps.places.Autocomplete(input,options);	
	}
	else
	{
		autocomplete =  new google.maps.places.Autocomplete(input);
	}
   // var options = {componentRestrictions: {country: 'all'}};
                 
   
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		$( "#route-map" ).trigger( "click" );
		$('#edited').val('1');
		var data = $('#txtsource').val();		
			geocoder = new google.maps.Geocoder();	
			 //alert(data);
			geocoder.geocode( { 'address': data}, function(results, status) {	
			if (status == google.maps.GeocoderStatus.OK) {
				 source="~"+results[0].geometry.location.lat()+","+results[0].geometry.location.lng()+"~";	 				
			 	$('#source_ids').val(source);
				
			}else
			{
				alert('Latitude and longitude not found for your input please try different(near by) location');
				$('#txtsource').val('');		
			}
			});	
			
			
			
			
	 });
}

function initialize2() {
    var input = document.getElementById('txtdestination');
	if(country != '')
	{
		var options = {componentRestrictions: {country: country}};
		autocomplete =  new google.maps.places.Autocomplete(input,options);	
	}
	else
	{
		autocomplete =  new google.maps.places.Autocomplete(input);
	}
    //var options = {componentRestrictions: {country: 'all'}};
                 
    
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
	$( "#route-map" ).trigger( "click" );
	$('#edited').val('1');
		var data = $("#txtdestination").val();
		geocoder = new google.maps.Geocoder();				
		geocoder.geocode( { 'address': data}, function(results, status) {	
		if (status == google.maps.GeocoderStatus.OK) {		
			 destination="~"+results[0].geometry.location.lat()+","+results[0].geometry.location.lng()+"~";				
			 $('#destination_ids').val(destination);
			
		}else
		{
			alert('Latitude and longitude not found for your input please try different(near by) location');
			$("#txtdestination").val('');
		} 	 
	
		});	
	
	 });
}

function initialize3() {
    var input = document.getElementById('welcome');
	if(country != '')
	{
		var options = {componentRestrictions: {country: country}};
		autocomplete =  new google.maps.places.Autocomplete(input,options);	
	}
	else
	{
		autocomplete =  new google.maps.places.Autocomplete(input);
	}
	//alert(input);
    //var options = {componentRestrictions: {country: 'all'}};
                 
    
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var data = $("#welcome").val();
		geocoder = new google.maps.Geocoder();				
		geocoder.geocode( { 'address': data}, function(results, status) {	
			if (status != google.maps.GeocoderStatus.OK) {		
				alert('Latitude and longitude not found for your input please try different(near by) location');
				$("#welcome").val('');
			}
	
		});	
	
	 });
}
google.maps.event.addDomListener(window, 'load', initialize1);
google.maps.event.addDomListener(window, 'load', initialize2);
google.maps.event.addDomListener(window, 'load', initialize3);

function cancel()
{
	window.location = baseurl +'addtrip'
}


$('body').on("click",'#route-map',function()
{
	var param = 'route='+$('#jquerytagboxtext').val()+'&source='+$('#txtsource').val()+'&desti='+$('#txtdestination').val()
	$.ajax({
			type: "POST",	
			url: baseurl + "addtrip/route_map/true",
			//dataType:"json",				
			data:param,
			success: function(html)	{
		
				if (html){				
					$('#route-map-data').html(html)
					initialize_map();
					//setTimeout(function(){ initialize_map(); }, 2000);
					//initialize_map();
					 //google.maps.event.addDomListener(window, 'load', initialize_map);
					
				} 
			}
		});
});




function get_vehicle()
{
var param = 'vid='+$('#vechicletype').val()
$.ajax({
		type: "POST",	
		url: baseurl + "addtrip/get_vehiclenumber/true",		
		dataType: "json",	
		data:param,
		success: function(json)	{
	
			if (json.result == 0){
				
				$('#vehnum').text('')
				//$('#spnError').show();
				return false;
			} else if (json.result == 1) {
				$('#vehnum').text(json.vnum)
			}
		}
	});
			      

}
	