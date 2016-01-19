function isValidEmail(pmEmail)	{
	/* Function will check whether the given email is valid or not. */
	if (!pmEmail) return false;
	pmEmail = trim(pmEmail);
	pmEmail = pmEmail.replace(/\r\n|\r|\n/g, ''); 
	
	if (isRegExpSupported()) {
		var vPattern = "^[A-Za-z0-9](([_\\.\\-]?[a-zA-Z0-9_]+)*)@([A-Za-z0-9]+)(([\\_.\\-]?[a-zA-Z0-9]+)*)\\.([A-Za-z]{2,})$";
		var vRegExp = new RegExp(vPattern);
		return (vRegExp.test(pmEmail));
	} else	{
		if(pmEmail.indexOf('@') == -1 || pmEmail.indexOf('.') == -1 || pmEmail.indexOf(' ') != -1) return false;
		else {
			var vSplit = pmEmail.split("@");
			if(vSplit.length > 2) return false;
			else 	{
				var vDomain = vSplit[1].split('.');
				var vLength = vDomain.length;
				for(var vLoop = 0; vLoop < vLength; vLoop++)
					if(vDomain[vLoop].length <= 0)	return false;
				return true;
			}
		} 
	}
}

/* Jquery Popup Window */
function JqueryPopup(pmTitle, pmHeight, pmWidth, pmFileName, pmQueryString){
	try{
		pmTitle = ( pmTitle == "" )? false : pmTitle; 
		pmHeight = ( pmHeight == "" )? 500 : pmHeight; 
		pmWidth = ( pmWidth == "" )? 500 : pmWidth; 
		$( "#dialog_modal" ).dialog( "destroy" );
		$( "#dialog_modal" ).dialog({title:pmTitle,height:pmHeight,width:pmWidth,modal: true,draggable:false,resizable:false,model:true});
		$( "#dialog_modal" ).html('Please wait...');
//		alert('<div class="dialogPopup"><img src="'+gCommonImagePath+'loading.png"/></div>');
		$.ajax({
			type : "POST",
			url	 : pmFileName,
			data : pmQueryString,
			dataType: "html",
			success: function(html){
//			alert(html)
				$( "#dialog_modal" ).html(html);
//				alert($("#dialog_modal").html())
			}
		});
		
	} catch(error) { 
		ErrorHandling(error);
	}
}