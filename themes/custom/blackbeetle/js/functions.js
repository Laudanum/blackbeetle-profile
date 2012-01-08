jQuery(document).ready(function(){

	jQuery("#body .col .link .title .num").mouseover(function(){
          //alert("good");
          jQuery(this).parent().parent().children(".img").children(".text").show();
	});
    jQuery("#body .col .link .title .num").mouseout(function(){
          //alert("good");
          jQuery(this).parent().parent().children(".img").children(".text").hide();
          jQuery(this).parent().parent().children(".img").children(".text").removeAttr("style");
    });
    jQuery("#body .col .link .title h2").mouseover(function(){
          jQuery(this).parent().parent().children(".img").children(".text").show();
    });
    jQuery("#body .col .link .title h2").mouseout(function(){
          jQuery(this).parent().parent().children(".img").children(".text").hide();
          jQuery(this).parent().parent().children(".img").children(".text").removeAttr("style");
    });


	
	
	
});

