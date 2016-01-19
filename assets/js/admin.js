	$(document).ready(function() {
			
					/* Ajax Uploading Image */
	$('body').on('change','#testimonialsimg', function()
	{
	var values=$("#uploadvalues").val();
	$("#previeww").html('<img src="http://localhost/vehicle/vehicle/themes/vehicle/assets/img/loader.gif"/>');
	$("#testimonialsimageform").ajaxForm({target: '#preview',
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
	
	
	
	$('body').on('change','#vehiclesimg', function()
	{
	var values=$("#uploadvalues").val();
	$("#previeww").html('<img src="http://localhost/vehicle/vehicle/themes/vehicle/assets/img/loader.gif"/>');
	$("#vehiclesimageform").ajaxForm({target: '#preview',
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
	
	
	
	$('body').on('change','#logoimg', function()
	{
	var values=$("#uploadvalues").val();
	$("#previeww").html('<img src="http://localhost/vehicle/vehicle/themes/vehicle/assets/img/loader.gif"/>');
	$("#logoimgform").ajaxForm({target: '#preview',
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
	$('body').on('click','#camera', function()
	{
		$( "#testimonialsimg" ).trigger( "click" );
	});
	
	$('body').on('click','#camera1', function()
	{
		$( "#vehiclesimg" ).trigger( "click" );
	});
	
	$('body').on('click','#camera2', function()
	{
		
		$( "#logoimg" ).trigger( "click" );
	});
	
	
	$('body').on('click','#testimonials-img-remove', function()
	{
		if(confirm('Conform to delete image'))
		{
			var img_name = $("input[name=uploadvalues]").val();
			var dataString = 'img_name='+ img_name ;
			$.ajax({
				type: "POST",
				url:baseurl+"admin/testimonials/delete_image",
				data: dataString,
				cache: false,
				//beforeSend: function(){$("#friendstatus").html($.loaderIcon); },
				success: function(html)
				{
					if(html)
					{
						setTimeout(function(){ 
						
						$(".testimonialsimage").fadeOut("slow");
						$("#uploadlink").fadeIn();
						$("input[name=uploadvalues]").val('');				
						}, 1000);
                                                setTimeout(function(){ 
						
						$(".testimonialsimage").remove();			
						}, 1500);
						  
						
					}
				}
			});
		}
		return false;
	});
	
	$('body').on('click','#vehicles-img-remove', function()
	{
		if(confirm('Conform to delete image'))
		{
			var img_name = $("input[name=uploadvalues]").val();
			var dataString = 'img_name='+ img_name ;
			$.ajax({
				type: "POST",
				url:baseurl+"admin/vehicle/delete_image",
				data: dataString,
				cache: false,
				//beforeSend: function(){$("#friendstatus").html($.loaderIcon); },
				success: function(html)
				{
					if(html)
					{
						setTimeout(function(){ 						
						$(".vehiclesimage").fadeOut("slow");
						$("#uploadlink").fadeIn();
						$("input[name=uploadvalues]").val('');				
						}, 1000);
                                                setTimeout(function(){ 						
                                                    $(".vehiclesimage").remove();			
						}, 1500);
                                                
						
					}
				}
			});
		}
		return false;
	});
	
	
	$('body').on('click','#logo-img-remove', function()
	{
		if(confirm('Conform to delete image'))
		{
			var img_name = $("input[name=uploadvalues]").val();
			var dataString = 'img_name='+ img_name ;
			$.ajax({
				type: "POST",
				url:baseurl+"admin/admin/delete_image",
				data: dataString,
				cache: false,
				//beforeSend: function(){$("#friendstatus").html($.loaderIcon); },
				success: function(html)
				{
					if(html)
					{
						setTimeout(function(){ 						
						$(".logoimg").fadeOut("slow");
						$("#uploadlink").fadeIn();
						$("input[name=uploadvalues]").val('');				
						}, 1000);
                                                setTimeout(function(){ 						
                                                    $(".logoimg").remove();			
						}, 1500);
                                                
						
					}
				}
			});
		}
		return false;
	});
	
	
$('body').on("click",'.change-status',function(e){
  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/category/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 
 $('body').on("click",'.change-status-country',function(e){  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/country/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 $('body').on("click",'.change-status-traveller',function(e){
  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/traveller/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 $('body').on("click",'.change-status-testimonials',function(e){
  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/testimonials/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 $('body').on("click",'.change-status-trip',function(e){
  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/trip/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 $('body').on("click",'.change-status-widget',function(e){
  
  var mid = $(this).attr("rel");
  var ID = $(this).attr("id");
  var temp = ID.split("-");  
  var status = temp[0];
  var dataString = 'mid='+ mid+'&status='+status;
  $.ajax({
  type: "POST",
  url:  baseurl+"admin/widgets/change_status",
  data: dataString,
  cache: false,
  success: function(html){
   if(html){
    
    if(status == 'enable')
    {
     $('#label-'+mid).addClass('label-success').removeClass('label-default');
     $('#label-'+mid).html('Active') 
     $('#btn-'+mid).removeClass('open')
     $('#'+status+'-'+mid).html('Disable').attr("id","disable-"+mid); 
     
    }
    else if(status == 'disable')
    {
     $('#label-'+mid).addClass('label-default').removeClass('label-success');
     $('#label-'+mid).html('Inactive')
     $('#btn-'+mid).removeClass('open') 
     $('#'+status+'-'+mid).html('Enable').attr('id','enable-'+mid);
    }
   }
   }
   });
 
  return false;
 
 });
 
 	
	
		
});