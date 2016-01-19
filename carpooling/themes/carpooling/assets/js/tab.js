var back_r = 0;


/* /// select  /// */
jQuery(document).ready(function(){
 jQuery('#selected').click(function(){
     if(jQuery('#currencies').is(':visible') == true){
  jQuery('#currencies').hide();
     }else{
  jQuery('#currencies').show();
     }
 });
 jQuery('ul#currencies li  a').click(function(){
     jQuery('#selected').html(jQuery(this).html());
     jQuery('#currencies').hide();
 });
 
 
 
 /* /// owners /// */
 var left =  jQuery('.owners .obj_left').height();
 var right = jQuery('.owners .obj_right').height();
 var minus1 = jQuery('.minus1').height();
 var minus2 = jQuery('.minus2').height();
 var heig =  jQuery('.heig').height();
 if (right < left) {
    heig = left - minus1 - minus2 - 100;    
    jQuery('.heig').height(heig);
 } else if (right > left) {
    heig = right;
    jQuery('.owners .obj_left').height(heig);
 }
 
 
 /* /// property */ 
    back_r = $('.property .obj_right').height(); 
    height_right();
    });
    
    

/* /// property */    
function height_right() {    
    var p_left = jQuery('.property .obj_left').height();
    var p_right = jQuery('.property .obj_right').height();
if (p_right < p_left) {   
    jQuery('.property .obj_right').height(p_left); 
//alert(p_left);
//alert(p_right);      
} else {
    if (p_left > back_r) {
        jQuery('.property .obj_right').height(p_left);
    } else {
        jQuery('.property .obj_right').height(back_r);
    }    
}  
}


    

  


 
 

/* //// blog menu /// */

function blog_hover (el) {
    var a = jQuery(el).find('a');
    var ul =  jQuery(el).find('.level2');
    if (ul) {
        jQuery(ul).css("display", "block" );
        jQuery(a).addClass("hover"); 
    }
}

function no_blog_hover(el) {
    var a = jQuery(el).find('a');
    var ul =  jQuery(el).find('.level2');
    if (ul) {
        jQuery(ul).css("display", "none" );
        jQuery(a).removeClass("hover");
         
    }
}

/* /// button /// */      

function tab_tab (el, slass_tab) {                
                var div = $(el).parent('div');
                var button = $(div).children('#a_tab');
                var tab = $('.'+slass_tab);
                var i = 0;
                var a = 1;
                var num = 1;               
                $(button).each(function(){                    
                    if (this == el) {                        
                        $(this).addClass('active');
                        i = num;
                    } else {
                        $(this).removeClass('active');
                    } 
                    num++;                                       
                })
                $(tab).each(function(){
                    if (a == i) {                        
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    a++;                                        
                })                                                                             
            }



/* /// button book now /// */
function tab_tab_book () { 
                var div_book = $('.b_t_2').parent('div');                
                var book_a = $(div_book).children('#a_tab');
                var book = $('.p_block_bottom');                 
                var a = 1; 
                $(book).each(function(){
                    a == 5 ? $(this).show() :  $(this).hide();  
                    a++; 
                })
                a = 1
                $(book_a).each(function(){
                    a == 5 ? $(this).addClass('active') :  $(this).removeClass('active');  
                    a++; 
                })                                                                             
            }

   


   
jQuery(document).ready(function(){
     jQuery('label>input:checkbox').click(function(){ 
     thels = $(this).parent();
	 if (this.checked) {
	   thels.css("backgroundColor", "rgb(178, 209, 129)" ); 
     } else {
        thels.css("backgroundColor", "rgb(255, 255, 255)" );
                   
     }  
     });

});


jQuery(document).ready(function(){
     var howmanylabels = jQuery('.r_c_title>p').length;
     var parentdivwith = howmanylabels * 53;
     var thiswidth = 385;
     
     if (parentdivwith > thiswidth) {
        jQuery('.r_c_center').addClass("overf");
        jQuery('.r_c_center .r_c_title').width(parentdivwith);
        jQuery('.r_c_center .r_c_cont_top').width(parentdivwith);
        jQuery('.r_c_center .r_c_cont').width(parentdivwith);
     } else {
        jQuery('.r_c_center').removeClass("overf");
     }
      
});


    
 