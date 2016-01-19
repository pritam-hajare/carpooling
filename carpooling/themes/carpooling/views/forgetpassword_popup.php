<script type="text/javascript">
  var baseurl = "<?php print base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript">

function showdiv(id) {
  
  
	$("#resend").hide();
		
	
	$("#resendsuccess").show();
	
  //  div.style.display = 'block';
   
}
function notRecive(id) {
  
  
	$("#resendsuccess").hide();
		
	
	$("#resend").show();
	
  //  div.style.display = 'block';
   
}
	$(document).ready(function() {
		
		
			$("#resendForm").validate({
			errorElement: "div",			 
			//set the rules for the fild names
			rules: {				
				email: {
					required: true,
					email: true
					
				}
								
			},
			//set messages to appear inline
			messages: {				
				email: "",				
								
			},
			
			submitHandler: function(form) {
            			$('#resendStatus').html('Please wait...');		
				$.ajax({
					type: "POST",	
					url: '<?php echo base_url('login/send_password/true'); ?>',	
					dataType: "json",	
					data:$('#resendForm').serialize(),
					success: function(json)	{
				
						if (json.result == 0){
						
							$('#resendStatus').html(json.message);
						
							//$('#spnError').show();
							return false;
						} else if (json.result == 1) {
							$('#resendStatus').html('');
							$('#statusmsg').html(json.message);
							showdiv('login');
							//window.location	= '<?php //echo base_url('secure/dashboard'); ?>';
						}
					}
				});
			      
			},
			
			errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});
		
		
		
	


	

		});
</script>


<div id="loginpopup">

<div id="resend">
             <div class="log_cont_fgt">
             <form id="resendForm">
                 <div class="log_fgt_tit">Enter your Email-id</div>
                   <input type="text" placeholder="Email-id" name="email" id="email">
                   <input type="hidden" value="1" name="submitted" />
 <input type="hidden" value="" name="redirect"/>
 <span id="resendStatus"></span>
                    <input type="submit" value="Submit" class="button">
                    </form>
             </div>
             <div class="fgt_para"> Please enter your registered email-id in the box above to request a new password.</div>
             
    </div>
    <div id="resendsuccess" style="display:none">
           <div class="log_fgt_tit" id="statusmsg"></div>
             <div class="fgt_para"> <a href="javascript:void(0)" onclick="notRecive('login');">Password not recived?</a> </div>
             
    </div>
             
        </div>
