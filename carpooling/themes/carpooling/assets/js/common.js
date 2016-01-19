	$(document).ready(function() {
		
		
	
	
	$('body').on("click",'.save-leg',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		
		var hour = $('.hour'+ID).val();
	 	var mini = $('.min'+ID).val();
		var zone = $('.zone'+ID).val();
		
		var time = hour+':'+mini+' '+zone;
		
		var dataString = 'time=' + time +'&lid='+ ID;
		$.ajax({
		type: "POST",
		url:  baseurl+"addtrip/update_time/true",
		dataType: "json",
		data: dataString,
		cache: false,
		success: function(json){
			if(json.result == 1)
			{
					$('#time_'+ID).html(json.time);
					$('#trip_time_'+ID).val(json.time);
					$('#edit-time-'+ID).fadeOut('slow');
					$('#leg-time-'+ID).fadeIn('slow');					
				
			}
			else if(json.result == 0)
			{
				alert(json.message);
			}
		
		}
		 
		});			
		
	});
	
	$('body').on("click",'.edit-leg',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		if(ID !='')
		{
			$('#leg-time-'+ID).fadeOut('slow');
			$('#edit-time-'+ID).fadeIn('slow');
		}
				
		
	});
	
	$('body').on("click",'.cancel-leg',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		if(ID !='')
		{
			$('#edit-time-'+ID).fadeOut('slow');
			$('#leg-time-'+ID).fadeIn('slow');
			
		}
				
		
	});
	
	/*Edit route rates*/
	$('body').on("click",'.save-leg-rate',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		var Rate = $('#rate'+ID).val();
		if($.isNumeric(Rate))
		{
			
			var dataString = 'rate=' + Rate +'&lid='+ ID;
			$.ajax({
			type: "POST",
			url:  baseurl+"addtrip/update_rate/true",
			dataType: "json",
			data: dataString,
			cache: false,
			success: function(json){
			if(json.result == 1)
			{
					$('#rate'+ID).val(json.rate);
					$('#trip_rate_'+ID).val(json.rate);
					$('#amount_'+ID).text(json.rate);
					$('#edit-rate-'+ID).fadeOut('slow');
					$('#leg-rate-'+ID).fadeIn('slow');					
				
			}
			else if(json.result == 0)
			{
				alert(json.message);
			}
			}
			
			});
		}
			
	});
	
	
	
	$('body').on("click",'.edit-leg-rate',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		if(ID !='')
		{
			$('#leg-rate-'+ID).fadeOut('slow');
			$('#edit-rate-'+ID).fadeIn('slow');
		}
				
		
	});
	
	$('body').on("click",'.cancel-leg-rate',function()
	{
	
		var ID = parseInt($(this).attr("rel"));
		if(ID !='')
		{
			$('#edit-rate-'+ID).fadeOut('slow');
			$('#leg-rate-'+ID).fadeIn('slow');
			
		}
				
		
	});
			
			

		
	});


