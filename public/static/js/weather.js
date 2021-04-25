(function($, document, window){
	
	$(document).ready(function(){
		initNavigation();
	});

	function initNavigation() {
		// Cloning main navigation for mobile menu
		$(".mobile-navigation").append($(".main-navigation .menu").clone());

		// Mobile menu toggle
		$(".menu-toggle").click(function(){
			$(".mobile-navigation").slideToggle();
		});
	}
})(jQuery, document, window);