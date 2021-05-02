(function($, document, window){
	
	$(document).ready(function(){
		initNavigation();
	});

	function initNavigation() {
		// Mobile menu toggle
		$(".menu-toggle").click(function(){
      const hasClass = $("#custom-menu").hasClass("mobile-navigation");
      if (hasClass) {
        $("#custom-menu").attr('class', 'main-navigation main-navigation-menu');
      } else {
        $("#custom-menu").attr('class', 'mobile-navigation');
      }

      $("#custom-menu").slideToggle();
		});
	}
})(jQuery, document, window);