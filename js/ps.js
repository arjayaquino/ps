PS = {};

(function($){
	
	PS.Controller = function(){
		
		var $window = $(window);
		var $body = $("body");
		var $mcSignup = $body.find("#mc_signup");
		
		var $headerWrapper = $body.find(".gbtr_header_wrapper");
		var $banner = $body.find(".custom_images_slider, .fullwidthbanner-container");
		var $slider = $banner.find(".gbtr_items_slider");
		var $content = $body.find("#full-width-wrapper");
		
		function init(){
			
			initMailChimpForm();
			
			//don't enable paralax for mobile
			if(!Modernizr.mq('(max-width: 479px)') && $banner.length > 0){
				initParalax();
			}
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
		
		
		/**							PARALAX
		 * ______________________________
		 */
		
		function initParalax(){
			$headerWrapper.addClass("fixed");
			$content.addClass("fixed-padding");
			
			var sliderState = "autoSlidePlay";
			
			$window.on("scroll.ps", function(e){
				var scrollTop = $window.scrollTop();
				var scrollPos = scrollTop * 0.3;
				var currentContentPos = $content.offset().top - scrollTop;
				
				//slowly scroll banner out of view
				$banner.css("top", "-"+scrollPos + "px");
				
				//don't fix the header once the content touches it
				if(currentContentPos <= $headerWrapper.height()){
					var headerOffset = currentContentPos - $headerWrapper.height(); 
					if($slider.length > 0 && sliderState == "autoSlidePlay"){
						sliderState = "autoSlidePause";
						$slider.iosSlider(sliderState);
					}
					$banner.addClass("transparent-banner");
					$headerWrapper.css("top", headerOffset + "px");
				} else {
					if($slider.length > 0 && sliderState == "autoSlidePause"){
						sliderState = "autoSlidePlay";
						$slider.iosSlider(sliderState);
					}
					$banner.removeClass("transparent-banner");
					$headerWrapper.css("top", "0");
				}
				
			}).trigger("scroll");
		}
		
		
	}
	
})(jQuery);

var controller;
jQuery(function(){
	controller = new PS.Controller();
});