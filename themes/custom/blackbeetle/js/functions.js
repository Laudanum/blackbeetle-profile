var transition_speed = 700;
var slide_speed = 7000;

jQuery(document).ready(function(){

    //Front Section  Number Hover
	jQuery("#body .col .link .title .num").mouseover(function(){
          jQuery(this).parent().parent().children(".img").children(".text").show();
	});
    jQuery("#body .col .link .title .num").mouseout(function(){
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
    
    //Init for Selected Project & Arts's slidshow    
    jQuery('.gallery ul').jcarousel({
         scroll: 4,
     });
     
     
    /* show a particular slide, or the next slide if no slide is specified */
      var _showSlide = function(_next_slide) {
          
            var _active_slide = jQuery('.single_gallery ul li.active');
            if ( _active_slide.length == 0 ) _active_slide = jQuery('.single_gallery ul li:last');
            if ( ! _next_slide ) {
              _next_slide =  _active_slide.next().length ? _active_slide.next() : jQuery('.single_gallery ul li:first');
            }

        //  if the previous slide is still running then don't do anything
            if (_active_slide.is(':animated') ) {
              return false;
            }

             _active_slide.addClass('last-active');
            //_updateSlideInfo(_next_slide);
            _next_slide.css({opacity: 0.0}).addClass('active').animate(
              {opacity: 1.0}, 
              transition_speed, 
              function() {
                _active_slide.removeClass('active last-active');
              }
            ); 
      }
      
      /* show a particular dot, or the next dot if no dot is specified */
      var _showDot = function(_next_dot) {
          
            var _active_dot = jQuery('.dots ul li.active');
            if ( _active_dot.length == 0 ) _active_dot = jQuery('.dots ul li:last');
            if ( ! _next_dot ) {
              _next_dot =  _active_dot.next().length ? _active_dot.next() : jQuery('.dots ul li:first');
            }

        //  if the previous slide is still running then don't do anything
            if (_active_dot.is(':animated') ) {
              return false;
            }

             _active_dot.addClass('last-active');
            _next_dot.css({opacity: 0.0}).addClass('active').animate(
              {opacity: 1.0}, 
              transition_speed, 
              function() {
                _active_dot.removeClass('active last-active');
              }
            ); 
            
               
      }  
      
        
      
    /*
      start the slideshow and trigger the first image update
      */
      var _startSlideshow = function() {
        //  update the info area with the correct information
            _updateSlideInfo(jQuery(".single_gallery li.active"));
            jQuery("body").addClass("slideshow-running").everyTime(slide_speed, "slideshow", function() {
              _showSlide();
            });
      }
      
      
    /* 
      update the title area and set the active class on the current thumbnail 
      */
      var _updateSlideInfo = function(_obj) {
       // //  update the correct thumbnail
//            _src = jQuery(_obj).find("img").attr("src");
//            jQuery(".secondary a.active").removeClass("active");
//            jQuery(".secondary a[href=" + _src + "]").addClass("active");
        //  front page - update the header with the title of the work shown
//            var gallery_info = jQuery(_obj).find('.detail-info').html();
//            if(gallery_info != ""){
//              jQuery("#slidecontent").fadeOut(transition_speed, function() {
//                jQuery('#slidecontent').html(gallery_info).fadeIn(transition_speed);
//              });
//            }  
      }
      
      
      var _stopSlideshow = function() {
        jQuery("body").removeClass("slideshow-running").stopTime("slideshow");
      }


      var _toggleSlideshow = function() {
        if ( jQuery("body").hasClass("slideshow-running") ) 
          _stopSlideshow();
        else {
          _showSlide();
          _startSlideshow();
        }
      }

          
    /* if we have a gallery set up a slideshow and run it */
        if(jQuery('.single_gallery ul li').size() > 1) {
          //  _startSlideshow();

        //  create some buttons if we don't have them already
            jQuery(".arrow").show();

        //  listen for clicks on the navigation arrows
              jQuery(".arrows .arrow a").click(function(event) {
                if ( jQuery(this).hasClass("next") ) {
                 // _stopSlideshow();
                  _showSlide();
                  _showDot();
                } else if ( jQuery(this).hasClass("previous") ) {
                 // _stopSlideshow();
                  var _active_slide = jQuery('.single_gallery ul li.active');
                  _previous_slide = _active_slide.prev().length ? _active_slide.prev() : jQuery('.single_gallery ul li:last');
                  _showSlide(_previous_slide);
                  
                  var _active_dot = jQuery('.dots ul li.active');
                  _previous_dot = _active_dot.prev().length ? _active_dot.prev() : jQuery('.dots ul li:last');
                  _showSlide(_previous_dot);
                }
              });
        }else {
            jQuery(".arrow").hide();
        }
        
        
        //Checking Dots size   
        if(jQuery('.dots ul li').size() > 1) {
                jQuery('.dots').show();
                //Clicking Dot
               jQuery(".dots ul li a").click(function(event) {
                   
                    var className = jQuery(this).parent().attr('class').trim();
                    if(className != ""){
                         var last = className.split(" ");
                         var lastName =  last[last.length-1]; 
                         
                         var _active_slide = jQuery('.single_gallery ul li.' + lastName );
                          var _active_dot = jQuery(this).parent();
                          
                          _showSlide(_active_slide);
                          _showDot(_active_dot);
                   }
              });
        }else {
            jQuery('.dots').hide();
        }
	
});

