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
          
           var _active_slide = jQuery('.slide_items li.active-project');
            if ( _active_slide.length == 0 ) _active_slide = jQuery('.slide_items li.project:last');
            if ( ! _next_slide ) {
              _next_slide =  _active_slide.next().length ? _active_slide.next() : jQuery('.slide_items li.project:first');
            }

        //  if the previous slide is still running then don't do anything
            if (_active_slide.is(':animated') ) {
              return false;
            }

             _active_slide.addClass('last-active');
            //_updateSlideInfo(_next_slide);
            _next_slide.css({opacity: 0.0}).addClass('active-project').animate(
              {opacity: 1.0}, 
              transition_speed, 
              function() {
                _active_slide.removeClass('active-project last-active');
              }
            ); 
      }
      
      /* show a particular content slide, or the next slide if no slide is specified */
      var _showContentSlide = function(_next_slide) {
          
            var _active_slide = jQuery('.slide_items_right li.active-project');
            if ( _active_slide.length == 0 ) _active_slide = jQuery('.slide_items_right li.project:last');
            if ( ! _next_slide ) {
              _next_slide =  _active_slide.next().length ? _active_slide.next() : jQuery('.slide_items_right li.project:first');
            }

        //  if the previous slide is still running then don't do anything
            if (_active_slide.is(':animated') ) {
              return false;
            }

             _active_slide.addClass('last-active');
            //_updateSlideInfo(_next_slide);
            _next_slide.css({opacity: 0.0}).addClass('active-project').animate(
              {opacity: 1.0}, 
              transition_speed, 
              function() {
                _active_slide.removeClass('active-project last-active');
              }
            ); 
      }
      
      /* show a particular image of Project or Art
        _next_slide is either null or an object
      */
      var _showImageSlide = function(_next_slide) {
          
            var _active_slide = jQuery('.slide_items li.active-project .single_gallery ul li.active');
            if ( _active_slide.length == 0 ) _active_slide = jQuery('.slide_items li.active-project .single_gallery ul li:last');
            if ( ! _next_slide ) {
              _next_slide =  _active_slide.next().length ? _active_slide.next() : jQuery('.slide_items li.active-project .single_gallery ul li:first');
            }
        //  if the previous slide is still running then don't do anything
            if (_active_slide.is(':animated') || _next_slide.hasClass("active")) {
              return false;
            }

            _active_slide.addClass('last-active');
            _updateSlideInfo(_next_slide);
            _next_slide.css({opacity: 0.0}).addClass('active').animate(
              {opacity: 1.0}, 
              transition_speed, 
              function() {
                _active_slide.removeClass('active last-active');
              }
            );
            
            
      }
      
      
      
      var _showDot = function() {
        
      }
      
      /* show a particular dot, or the next dot if no dot is specified */
      var OLD_showDot = function(_next_dot) {
          
            var _active_dot = jQuery('li.active-project .dots ul li.active');
            if ( _active_dot.length == 0 ) _active_dot = jQuery('li.active-project .dots ul li:last');
            if ( ! _next_dot ) {
              _next_dot =  _active_dot.next().length ? _active_dot.next() : jQuery('li.active-project .dots ul li:first');
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
        update relevant areas based on an active slide
      */
      var _updateSlideInfo = function(_obj) {
//  project pages
        if ( jQuery("body").hasClass("node-type-project") ) {
//  update the dots
          _i = jQuery(_obj).index();
          jQuery("li .dots ul li").removeClass("active").eq(_i+1).addClass("active");
        }
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
        if(jQuery('.slide_items li').size() > 1) {
          //  _startSlideshow();

        //  create some buttons if we don't have them already
            jQuery(".arrow").show();

        //  listen for clicks on the navigation arrows
              jQuery(".arrows .arrow a").click(function(event) {
                  
                if ( jQuery(this).hasClass("next") ) {
                 // _stopSlideshow();
                  _showSlide();
                  _showContentSlide();
                 
                } else if ( jQuery(this).hasClass("previous") ) {
                 // _stopSlideshow();
                  var _active_slide = jQuery('.slide_items li.active-project');
                  _previous_slide = _active_slide.prev().length ? _active_slide.prev() : jQuery('.slide_items li.project:last');
                  
                  _showSlide(_previous_slide);
                  
                  _active_slide = jQuery('.slide_items_right li.active-project');
                  _previous_slide = _active_slide.prev().length ? _active_slide.prev() : jQuery('.slide_items_right li.project:last');
                  
                  _showContentSlide(_previous_slide);
                }
              });
              
                         
              
              
        } else {
          jQuery(".arrow").hide();
        }
        
/* do we have enough images in the gallery to display the dot navigation ? 
  this is currently blank because we've loaded all the projects in to each page
*/
//  if( jQuery('.single_gallery ul li').size() > 1 ) {
  if( jQuery('li.active-project .single_gallery ul li').size() > 1 ) {
    jQuery('li .dots').show();
  } else {
    jQuery('li .dots').hide();
  }
  

/* gallery navigation using the dots */
  jQuery("li .dots ul li").click(function(event) {
//  get the index of the dot clicked 
    _i = jQuery(this).index();
    _next_image_slide = jQuery("li.active-project .single_gallery ul li:eq(" + _i + ")");
    _showImageSlide(_next_image_slide);
  });
        
	
});

