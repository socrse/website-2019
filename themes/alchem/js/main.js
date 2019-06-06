jQuery(document).ready(function($){
 $(".site-nav-toggle").click(function(){
        $(".site-nav").toggle();
 });  

 
// retina logo
if( window.devicePixelRatio > 1 ){
	if($('.normal_logo').length && $('.retina_logo').length){
		$('.normal_logo').hide();
		$('.retina_logo').show();
		}
	//
	$('.page-title-bar').addClass('page-title-bar-retina');
	
	}
// responsive or not
if( alchem_params.responsive == 'no' ){
   $('meta[name="viewport"]').prop('content', 'width='+alchem_params.site_width.replace('px',''));
}
// parallax scrolling
if( $('.parallax-scrolling').length ){
	$('.parallax-scrolling').parallax({speed : 0.15});
	}

	 
// related posts
var related = $(".alchem-related-posts");

related.owlCarousel({
    loop:true,
    margin:15,
	navText: [" "," "],
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
})

	//fixed header
	$(window).scroll(function(){
   if( $('.fxd-header').length ){
    if( $("body.admin-bar").length){
		if( $(window).width() < 765) {
				stickyTop = 46;
				
			} else {
				stickyTop = 32;
			}
	  }
	  else{
		  stickyTop = 0;
		  }
		  
	 var stickyTop2 = stickyTop;
	 if( $(".top-bar").length ){
	 stickyTop2 = stickyTop + $(".top-bar").outerHeight() ;		  
     }
	 if( $('.slider-above-header .page-top-slider').length ){
		 stickyTop2 = stickyTop2 + $('.slider-above-header .page-top-slider').outerHeight() ;
		 }
		 
		  ////
		 if( !($(window).width() < 919 && alchem_params.isMobile == 0 )) {
	 
		  $('.fxd-header').css('top',stickyTop);
					var scrollTop = $(window).scrollTop(); 
				if ( scrollTop > stickyTop2  ) { 
				if( !$(".top-banner").length ){
					$('.main-header').hide();
				}
					$('.fxd-header').show();
					} else {
						if( !$(".top-banner").length ){
						$('.main-header').show(); 
						}
						$('.fxd-header').hide();
					}  
					
		 }
					
					////////////
					
               }
     });
	
// nav menu search icon
  
  if( alchem_params.show_search_icon === 'yes' ){
	   $.ajax({type:"POST",dataType:"html",url:alchem_params.ajaxurl,data:"action=alchem_nav_searchform",
	    success:function(data){
			$('header .main-header .main-nav').append('<li class="menu-item menu-item-search-icon"><a href="javascript:;"><i class="fa fa-search site-search-toggle"></i></a>'+data+'</li>');
			},error:function(){}});
	   $('header').on('click','.site-search-toggle',function(){
            $('.menu-item-search-icon .search-form').toggle();		  
          });
	  
	  }

// tool tip
$('[data-toggle="tooltip"]').tooltip(); 

// slider
if( $('.alchem-carousel').length){
	var interval = parseInt(alchem_params.slideshow_speed);
	if(alchem_params.slider_autoplay == 'no')
	interval = false;
	
$('.alchem-carousel').carousel({ interval: interval, cycle: true });
}


// scheme
 if( typeof alchem_params.global_color !== 'undefined' && alchem_params.global_color !== '' ){
 less.modifyVars({
        '@color-main': alchem_params.global_color
    });
   }
   


 //masonry

 // blog
$('.blog-grid').masonry({
 // options
                itemSelector : '.entry-box-wrap'
            });

	$('.blog-timeline-wrap .entry-box-wrap').each(function(){
													   
	var position   = $(this).offset();		
	var left       = position.left;
	var wrap_width = $(this).parents('.blog-timeline-wrap').innerWidth();
	if( left/wrap_width > 0.5){
		  $(this).removeClass('timeline-left').addClass('timeline-right');
		}else{
		  $(this).removeClass('timeline-right').addClass('timeline-left');	
 }
 });

 //side header	
$('.side-header .site-nav .menu_column  .sub-menu').css({'width':$('.post-wrap').width()});

//nav arrow on mobiles
$('.site-nav ul li.menu-item-has-children').each(function(){
	 $(this).prepend('<i class="fa fa-caret-down menu-dropdown-icon"></i>');
	
   })
$(document).on('click','.menu-dropdown-icon',function(){
		var submenu = 	$(this).parent('li').find('>ul.sub-menu');								  
		submenu.slideToggle();	
   });

$(window).resize(function() { 
 //side header		  
 $('.side-header .site-nav .menu_column  .sub-menu').css({'width':$('.post-wrap').width()});
 // blog timeline
 $('.site-nav ul li .sub-menu').attr("style","");
 $('.site-nav').attr("style","");
 $('.blog-timeline-wrap .entry-box-wrap').each(function(){
	var position   = $(this).offset();		
	var left       = position.left;
	var wrap_width = $(this).parents('.blog-timeline-wrap').innerWidth();
	if( left/wrap_width > 0.5){
		  $(this).removeClass('timeline-left').addClass('timeline-right');
		}else{
		  $(this).removeClass('timeline-right').addClass('timeline-left');	
 }
 });				  
						  
 });

  
  jQuery('header .site-nav').onePageNav({filter: 'ul li a[href^="#"]',scrollThreshold:0.2});	
  

});

     

/*========================================================================================
 * SmoothScroll v0.9.9
 * Licensed under the terms of the MIT license.
 * People involved
 * - Balazs Galambosi: maintainer (CHANGELOG.txt)
 * - Patrick Brunner (patrickb1991@gmail.com)
 * - Michael Herf: ssc_pulse Algorithm
 *========================================================================================*/
;(function($){

    // Scroll Variables (tweakable)
    var ssc_framerate = 150; // [Hz]
    var ssc_animtime  = 500; // [px]
    var ssc_stepsize  = 150; // [px]
    
    // ssc_pulse (less tweakable)
    // ratio of "tail" to "acceleration"
    var ssc_pulseAlgorithm = true;
    var ssc_pulseScale     = 6;
    var ssc_pulseNormalize = 1;
    
    // Keyboard Settings
    var ssc_keyboardsupport = true;
    var ssc_arrowscroll     = 50; // [px]
    
    // Other Variables
    var ssc_frame = false;
    var ssc_direction = { x: 0, y: 0 };
    var ssc_initdone  = false;
    var ssc_fixedback = true;
    var ssc_root = document.documentElement;
    var ssc_activeElement;
    
    var ssc_key = { left: 37, up: 38, right: 39, down: 40, spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36 };
    
    function ssc_init(){if(!document.body)return;var a=document.body;var b=document.documentElement;var c=window.innerHeight;var d=a.scrollHeight;ssc_root=(document.compatMode.indexOf('CSS')>=0)?b:a;ssc_activeElement=a;ssc_initdone=true;if(top!=self){ssc_frame=true}else if(d>c&&(a.offsetHeight<=c||b.offsetHeight<=c)){ssc_root.style.height="auto";if(ssc_root.offsetHeight<=c){var e=document.createElement("div");e.style.clear="both";a.appendChild(e)}}if(!ssc_fixedback){a.style.backgroundAttachment="scroll";b.style.backgroundAttachment="scroll"}if(ssc_keyboardsupport){ssc_addEvent("keydown",ssc_keydown)}}var ssc_que=[];var ssc_pending=false;function ssc_scrollArray(k,l,m,n){n||(n=1000);ssc_directionCheck(l,m);ssc_que.push({x:l,y:m,lastX:(l<0)?0.99:-0.99,lastY:(m<0)?0.99:-0.99,start:+new Date});if(ssc_pending){return};var o=function(){var a=+new Date;var b=0;var c=0;for(var i=0;i<ssc_que.length;i++){var d=ssc_que[i];var e=a-d.start;var f=(e>=ssc_animtime);var g=(f)?1:e/ssc_animtime;if(ssc_pulseAlgorithm){g=ssc_pulse(g)}var x=(d.x*g-d.lastX)>>0;var y=(d.y*g-d.lastY)>>0;b+=x;c+=y;d.lastX+=x;d.lastY+=y;if(f){ssc_que.splice(i,1);i--}}if(l){var h=k.scrollLeft;k.scrollLeft+=b;if(b&&k.scrollLeft===h){l=0}}if(m){var j=k.scrollTop;k.scrollTop+=c;if(c&&k.scrollTop===j){m=0}}if(!l&&!m){ssc_que=[]}if(ssc_que.length){setTimeout(o,n/ssc_framerate+1)}else{ssc_pending=false}};setTimeout(o,0);ssc_pending=true}function ssc_wheel(a){if(!ssc_initdone){init()}var b=a.target;var c=ssc_overflowingAncestor(b);if(!c||a.defaultPrevented||ssc_isNodeName(ssc_activeElement,"embed")||(ssc_isNodeName(b,"embed")&&/\.pdf/i.test(b.src))){return true}var d=a.wheelDeltaX||0;var e=a.wheelDeltaY||0;if(!d&&!e){e=a.wheelDelta||0}if(Math.abs(d)>1.2){d*=ssc_stepsize/120}if(Math.abs(e)>1.2){e*=ssc_stepsize/120}ssc_scrollArray(c,-d,-e);a.preventDefault()}function ssc_keydown(a){var b=a.target;var c=a.ctrlKey||a.altKey||a.metaKey;if(/input|textarea|embed/i.test(b.nodeName)||b.isContentEditable||a.defaultPrevented||c){return true}if(ssc_isNodeName(b,"button")&&a.keyCode===ssc_key.spacebar){return true}var d,x=0,y=0;var e=ssc_overflowingAncestor(ssc_activeElement);var f=e.clientHeight;if(e==document.body){f=window.innerHeight}switch(a.keyCode){case ssc_key.up:y=-ssc_arrowscroll;break;case ssc_key.down:y=ssc_arrowscroll;break;case ssc_key.spacebar:d=a.shiftKey?1:-1;y=-d*f*0.9;break;case ssc_key.pageup:y=-f*0.9;break;case ssc_key.pagedown:y=f*0.9;break;case ssc_key.home:y=-e.scrollTop;break;case ssc_key.end:var g=e.scrollHeight-e.scrollTop-f;y=(g>0)?g+10:0;break;case ssc_key.left:x=-ssc_arrowscroll;break;case ssc_key.right:x=ssc_arrowscroll;break;default:return true}ssc_scrollArray(e,x,y);a.preventDefault()}function ssc_mousedown(a){ssc_activeElement=a.target}var ssc_cache={};setInterval(function(){ssc_cache={}},10*1000);var ssc_uniqueID=(function(){var i=0;return function(a){return a.ssc_uniqueID||(a.ssc_uniqueID=i++)}})();function ssc_setCache(a,b){for(var i=a.length;i--;)ssc_cache[ssc_uniqueID(a[i])]=b;return b}function ssc_overflowingAncestor(a){var b=[];var c=ssc_root.scrollHeight;do{var d=ssc_cache[ssc_uniqueID(a)];if(d){return ssc_setCache(b,d)}b.push(a);if(c===a.scrollHeight){if(!ssc_frame||ssc_root.clientHeight+10<c){return ssc_setCache(b,document.body)}}else if(a.clientHeight+10<a.scrollHeight){overflow=getComputedStyle(a,"").getPropertyValue("overflow");if(overflow==="scroll"||overflow==="auto"){return ssc_setCache(b,a)}}}while(a=a.parentNode)}function ssc_addEvent(a,b,c){window.addEventListener(a,b,(c||false))}function ssc_removeEvent(a,b,c){window.removeEventListener(a,b,(c||false))}function ssc_isNodeName(a,b){return a.nodeName.toLowerCase()===b.toLowerCase()}function ssc_directionCheck(x,y){x=(x>0)?1:-1;y=(y>0)?1:-1;if(ssc_direction.x!==x||ssc_direction.y!==y){ssc_direction.x=x;ssc_direction.y=y;ssc_que=[]}}function ssc_pulse_(x){var a,start,expx;x=x*ssc_pulseScale;if(x<1){a=x-(1-Math.exp(-x))}else{start=Math.exp(-1);x-=1;expx=1-Math.exp(-x);a=start+(expx*(1-start))}return a*ssc_pulseNormalize}function ssc_pulse(x){if(x>=1)return 1;if(x<=0)return 0;if(ssc_pulseNormalize==1){ssc_pulseNormalize/=ssc_pulse_(1)}return ssc_pulse_(x)}$.browser.chrome=/chrome/.test(navigator.userAgent.toLowerCase());if($.browser.chrome){ssc_addEvent("mousedown",ssc_mousedown);ssc_addEvent("mousewheel",ssc_wheel);ssc_addEvent("load",ssc_init)}

})(jQuery);
