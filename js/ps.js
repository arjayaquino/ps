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
		var $gallery = $body.find(".gallery");
		var $productCategorySidebar = $body.find("ul.product-categories");
		
		function init(){
			
			initMailChimpForm();
			
			//don't enable paralax for mobile
			if(!Modernizr.mq('(max-width: 479px)') && $banner.length > 0){
				initParalax();
			}
			
			if($gallery.length > 0 && !$body.hasClass("single")){
				initGalleryContentSwitcher();
			}
			
			if($productCategorySidebar.length > 0){
				$productCategorySidebar.find(".cat-parent .cat-parent > a")
				.attr("href", "javascript:void(0);");
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
		
		
		
		/**							GALLERY
		 * ______________________________
		 */
		
		function initGalleryContentSwitcher(){
			
			var galleryItemContentList = $body.find(".shortcode_approach_content_container").toArray();
			var currentItemIndex = -1;
			
			//change the markup of the caption text a bit
			$gallery.find(".wp-caption-text").each(function(){
				var $caption = $(this);
				var text = $caption.text();
				$caption.html("<span>"+text+"</span>");
			});
			
			//rollover for image slides
			$gallery.find('.gallery-item').each(function(index){
				var $galleryItem = $(this);
				var $captionText = $galleryItem.find('.wp-caption-text');
				
				$galleryItem.on({
					mouseenter: function(e){
						if(!$captionText.hasClass("active")){
							$captionText.stop().animate({opacity:1}, 300);
						}
					},
					mouseleave: function(e){
						if(!$captionText.hasClass("active")){
							$captionText.stop().animate({opacity:0}, 300);
						}
					},
					click: function(e){
						e.preventDefault();
						var $selectedItemContent = $(galleryItemContentList[index]);
						var $currentContent = null;
						if(currentItemIndex != index){
							$body.find(".wp-caption-text.active").removeClass("active").animate({opacity:0}, 500);
							$captionText.addClass("active");
							//fade out current first
							if(currentItemIndex != -1){
								$currentContent = $(galleryItemContentList[currentItemIndex]);
								$currentContent.fadeOut(250, function(){
									displaySelectedGalleryItemContent($selectedItemContent);
								});
							} else {
								displaySelectedGalleryItemContent($selectedItemContent);
							}
							
							currentItemIndex = index;
							
						} else {
							//do nothing already selected
						}
					}
				});
			});
		}
		
		function displaySelectedGalleryItemContent($selectedItemContent){
			//fade in element
			if(isElementInView($selectedItemContent.parent())){
				$selectedItemContent.fadeIn(300);
			} 
			//show and scroll
			else {
				$selectedItemContent.show();
				$('html, body').animate({
				       scrollTop: $selectedItemContent.offset().top
			    }, 1000);
			}
		}
		
		function isElementInView($element){
		    var docViewTop = $window.scrollTop();
		    var docViewBottom = docViewTop + $window.height();

		    var elemTop = $element.offset().top;
		    var elemBottom = elemTop + $element.height();

		    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
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