var base_url = $('base').attr('href');


jQuery(document).ready(function($) {
	$('.topics_follow').owlCarousel({
		items: 2,
		loop:false,
		nav:true,	
		navText: ["<img src='"+base_url+"assets/images/left-scroll-icon.svg'>","<img src='"+base_url+"assets/images/right-scroll-icon.svg'>"],	
		margin: 10,
		responsive: {
			600: {
				items: 2
			}
		}
    });
	 
	$('.people_follow').owlCarousel({	
		items: 4,
		loop:true,
		nav:true,	
		navText: ["<img src='"+base_url+"assets/images/left-scroll-icon.svg'>","<img src='"+base_url+"assets/images/right-scroll-icon.svg'>"],	
		margin: 10,
		responsive: {
			600: {
				items: 4
			}
		}
    });
});