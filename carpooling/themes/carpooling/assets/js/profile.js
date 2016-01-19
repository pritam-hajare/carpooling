$(document).ready(function() {
	
	var switches = document.querySelectorAll('input[type="checkbox"].ios-switch');

	for (var i=0, sw; sw = switches[i++]; ) {
		var div = document.createElement('div');
		div.className = 'switch';
		sw.parentNode.insertBefore(div, sw.nextSibling);
	}

	/* Ajax Uploading Image */
	$('body').on('change','#photoimg', function()
	{
	var values=$("#uploadvalues").val();
	$("#previeww").html('<img src="http://localhost/vehicle/vehicle/themes/vehicle/assets/img/loader.gif"/>');
	$("#imageform").ajaxForm({target: '#preview',
	 beforeSubmit:function(){
		 $("#imageloadstatus").show();
		 $("#imageloadbutton").hide();
		 },
		success:function(){
		 $("#imageloadstatus").hide();
		 $("#imageloadbutton").hide();
		  $("#uploadlink").hide();
		 
		},
		error:function(){
		 $("#imageloadstatus").hide();
		 $("#imageloadbutton").hide();
		} }).submit();
	
	});
	
		/* Uploading group Image */
	$('body').on('click','.add-photo', function()
	{
		$( "#photoimg" ).trigger( "click" );
	});
	
	$('body').on('click','.back', function()
	{
		location.reload(true);
	});
	
	$('body').on('click','.remove-photo', function()
	{
		if(confirm('Conform to delete image'))
		{
			var img_name = $("input[name=uploadvalues]").val();
			var dataString = 'img_name='+ img_name ;
			$.ajax({
				type: "POST",
				url:baseurl+"vechicle/delete_image",
				data: dataString,
				cache: false,
				//beforeSend: function(){$("#friendstatus").html($.loaderIcon); },
				success: function(html)
				{
					if(html)
					{
						setTimeout(function(){ 
						
						$(".groupimage").fadeOut("slow");
						$("#uploadlink").fadeIn();
						$("input[name=uploadvalues]").val('');				
						}, 1000);
						  
						
					}
				}
			});
		}
		return false;
	});
	
	
	
	$('body').on("click",'.edit',function(){
		
	var ID = $(this).attr('rel');	
		$.ajax({
		type: "POST",
		url:  baseurl+"vechicle/vechicleform/"+ID,		
		cache: false,
		success: function(html){
			if(html){
				$body = $("body");
   				$body.addClass("loading");
				setTimeout(function(){ 						
				$("#vehicle-list").fadeOut('slow');
				$("#vehicle-from-content").html(html);
				$("#vehicle-from-content").fadeIn('slow');			
				}, 1000);
				setTimeout(function(){ 						
				$body.removeClass("loading");						
				}, 1500);
			}
			else
			{
				$.goNotification("You cannot edit this vehicle, Because already allocated one trip", { 
				type: 'error', // success | warning | error | info | loading
				position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
				timeout: 5000, // time in milliseconds to self-close; false for disable 4000 | false
				animation: 'fade', // fade | slide
				animationSpeed: 'slow', // slow | normal | fast
				allowClose: true, // display shadow?true | false
				});
			}
		 }
	  });
	
		return false;
	
	});
	
	$('body').on("click",'.new',function(){
	
		$.ajax({
		type: "POST",
		url:  baseurl+"vechicle/vechicleform/",		
		cache: false,
		success: function(html){
			if(html){
				$body = $("body");
   				$body.addClass("loading");
				setTimeout(function(){ 						
				$("#vehicle-list").fadeOut('slow');
				$("#vehicle-from-content").html(html);
				$("#vehicle-from-content").fadeIn('slow');						
				}, 1000);
				setTimeout(function(){ 						
				$body.removeClass("loading");						
				}, 1500);
					
			}
		 }
	  });
	
		return false;
	
	});
	
	
	
	$('body').on("change",'#vechiclecategory',function(){
	var ca_id = $(this).val();
	var param = 'cid='+ca_id;
	$.ajax({
                type: "POST",
                url: baseurl+"vechicle/get_types", 
				dataType: "json",
				data: param,
                success: function(locations) 
                {
				//alert(group_id);
				//alert();
				// $('#property_cat_id').empty();
				   $('#vechicletype').find('option').remove().end();
				   $('#vechicletype').append('<option value="">-Select Type-</option>');
                    $.each(locations,function(id,location) 
                    {
						//alert(id);
                        var opt = $('<option />'); 
                        opt.val(id);
                        opt.text(location);
                        $('#vechicletype').append(opt); 
                    }); 
					$( "#txtvechicle" ).val('');
					
  				}
 			});	

	});
	
	$('body').on("change",'#vechicletype',function(){
		$( "#txtvechicle" ).removeClass('disable');
	});	
	
	
	$('body').on("click",'.delete',function(){
		var redirect = $(this).attr("href");
		Boxy.confirm("Are you want to delete this Vehicle", function() {			 	
				window.location = redirect;				
			 }, {title: 'Confirmation'});
    	return false;
	});	
	
	
	
	$('body').on("click",'#search_but',function(){
		
		$("#vechicleform").validate({
			errorElement: "div",			 
			//set the rules for the fild names
			rules: {				
				vechiclecategory: {
					required: true,
					
					
				},
				vechicletype: {
					required: true,
					
				},	
				txtvechicle: {
					required: true,
					
					
				},
							
			},
			
			//set messages to appear inline
			messages: {	
						
				vechiclecategory: {
					required:"",
				},
				vechicletype: {
					required: "",				
				},
				txtvechicle: {
					required: "",				
				},				
								
			},
			
			submitHandler: function(form) {            		
					$('#vspnErrorpop').html(' ');	
					var ID = $('#vehicleid').val();	
					$body = $("body");
   					$body.addClass("loading");		
				$.ajax({
					type: "POST",	
					url: baseurl+'vechicle/vechicleform/'+ID,	
					dataType: "json",	
					data:$('#vechicleform').serialize(),
					success: function(json)	{
				
						if (json.result == 0){					
												
							return false;
						} else if (json.result == 1) {
							//window.location	= baseurl +'profile#my-cars-info';
							location.reload(true);
						}
					}
				});
			      
			},
			
			errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});
	});	
	
	
	/* profile Image uploading */
	$('body').on('change','#profileimg', function()
	{
	
	$("#profileimageform").ajaxForm({target: '#ProfilePic',
	 beforeSubmit:function(){
		 $("#imageloadstatus").show();
		 $("#imageloadbutton").hide();
		 },
		success:function(){
		 $("#imageloadstatus").hide();
		 $("#imageloadbutton").hide();
		  $("#uploadlink").hide();
		  $('#old-image').hide();
		 
		},
		error:function(){
		 $("#imageloadstatus").hide();
		 $("#imageloadbutton").hide();
		} }).submit();
	
	});
	
		/* Uploading group Image */
	$('body').on('click','#edit-profile', function()
	{
		$( "#profileimg" ).trigger( "click" );
	});


});

