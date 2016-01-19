(function($) {
	
	loaded_messages =0;

	$.fn.scrollPagination = function(options) {
		
		var settings = { 
			nop     : 3, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Trips!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			if($settings.scroll == true) $initmessage = 'Scroll for more or click here';
			else $initmessage = 'Click for more';
			
			// Append custom messages and extra UI
			$this.append('<div class="search_results"></div><div class="loading-bar">'+$initmessage+'</div>');
			
			function getData() {
				
				// Post data to ajax.php
				loaded_messages += 3;
				 var locationdata = "";
var Source = $("#source").val()?$("#source").val():'';
	var Destination = $("#destination").val()?$("#destination").val():'';
	var Source_lan = $("#formlatlng").val()?$("#formlatlng").val():'';
	var Destination_lan = $("#tolatlng").val()?$("#tolatlng").val():'';
	var Frequency = $("#frequency").val()?$("#frequency").val():'';
	//var type = $( "input:radio[name=returntype]:checked" ).val();
	var Return = $( "input:radio[name=returntype]:checked" ).val()?$( "input:radio[name=returntype]:checked" ).val():'';
	var date = $("#journey_date").val()?$("#journey_date").val():'';
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

var param = 'source='+Source+'&destination='+escape(Destination)+'&formlatlng='+escape(Source_lan)+'&tolatlng='+escape(Destination_lan)+'&frequency='+escape(Frequency)+'&VECHICATEGORY_FILTER='+escape(vechiclecategory)+'&VECHITYPE_FILTER='+escape(vechicletype)+'&AMENITIES_FILTER='+escape(amenitiestype)+'&TRAVELTYPE_FILTER='+escape(traveltype)+'&TRAVELALLOW_FILTER='+escape(allowedtype)+'&Return_Type='+Return+'&FREQUENCY_FILTER='+FrequencyFilter+'&FILTER=0&rand='+Math.random()+'&journey_date='+date;


				$.post('search/search_ajax/'+loaded_messages, {
						
					action        : 'scrollpagination',
				    number        : $settings.nop,
				    offset        : offset,
					VECHICATEGORY_FILTER		  : vechiclecategory.toString(),
					VECHITYPE_FILTER		  : vechicletype.toString(),
					AMENITIES_FILTER		  : amenitiestype.toString(),
					TRAVELTYPE_FILTER : traveltype.toString(),
					TRAVELALLOW_FILTER : allowedtype.toString(),
					//CATEGORY_FILTER : categorydata.toString(),
					source		: escape(Source),
					destination  : escape(Destination), 
					formlatlng	:	escape(Source_lan),
					tolatlng	:	escape(Destination_lan),
					frequency       : escape(Frequency), 
					Return_Type     : escape(Return),
					journey_date   : escape(date), 
					FREQUENCY_FILTER : escape(FrequencyFilter) 
				}, function(data) {
						
					// Change loading bar content (it may have been altered)
					$this.find('.loading-bar').html($initmessage);
						
					// If there is no data returned, there are no more posts to be shown. Show error
					if($.trim(data) == "") { 
						$this.find('.loading-bar').html($settings.error);	
					}
					else {
						
						// Offset increases
					    offset = offset+$settings.nop; 
						    
						// Append the data to the content div
						
					   	$this.find('.search_results').append(data);
						
						// No longer busy!	
						busy = false;
					}	
						
				});
					
			}	
			
			getData(); // Run function initially
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						
						// Now we are working, so busy is true
						busy = true;
						
						// Tell the user we're loading posts
						$this.find('.loading-bar').html('Loading Trips');
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar').click(function() {
			
				if(busy == false) {
					busy = true;
					getData();
				}
			
			});
			
		});
	}

})(jQuery);
