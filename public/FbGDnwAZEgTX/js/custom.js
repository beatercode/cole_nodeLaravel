$(document).ready(function()
{  
	// Toggle .headerSticky class to #header when page is scrolled		
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
		  $('.stickyHeader').addClass('headerSticky');
		} else {
		  $('.stickyHeader').removeClass('headerSticky');
		}
	});		
	stickyHead();	
	function stickyHead() {		
		if ($(window).scrollTop() > 100) {
			$('.stickyHeader').addClass('headerSticky');
		} else {
			$('.stickyHeader').removeClass('headerSticky');
		}
	}
	
	/* ------- Trigger modal when page is loaded ------- */
	$(window.location.hash).modal('toggle');
	
  
	/* For Mobile navigation */
	$(".mobNav").on('click',function() {	  
		$('.navMenu').toggleClass('active');
		$(this).find('i').toggleClass('far-times');
	});
	
	/* For Side Bar shrink navigation */
	$(".mobSideNav").on('click',function() {	  
		$('.sideBar').toggleClass('active');		
	});
	
	/* For Side Bar shrink navigation */
	$(".sideBarToggler").on('click',function() {	  
		$('.sideBarCol').toggleClass('shrink');		
	});

});