PS = {};

(function($){
	
	PS.Controller = function(){
		
		var $mcSignup = $("#mc_signup");
		
		function init(){
			
			initMailChimpForm();
		} 
		init();
		
		//use placeholder instead of a label
		function initMailChimpForm(){
			$mcSignup.find("input[type='text']").each(function(index){
				var $input = $(this);
				var $label = $input.siblings("label");
				$label.hide();
				$input.attr("placeholder", $label.text());
			});
		}
	}
	
})(jQuery);

var controller;
jQuery(function(){
	controller = new PS.Controller();
});