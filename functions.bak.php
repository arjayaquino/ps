<?php


/*
// [custom_images_slider]
function shortcode_custom_images_slider($atts, $content=null, $code) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		'per_page'  => '12',
		'orderby' => 'date',
		'order' => 'desc'
	), $atts));
	ob_start();
	?> 
	
	<script>
	(function($){
	   $(window).load(function(){
			
			/* items_slider 
			$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').iosSlider({
				snapToChildren: true,
				desktopClickDrag: true,
				scrollbar: true,
				scrollbarHide: true,
				scrollbarLocation: 'bottom',
				scrollbarHeight: '2px',
				scrollbarBackground: '#ccc',
				scrollbarBorder: '0',
				scrollbarMargin: '0',
				scrollbarOpacity: '1',
				navNextSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_next'),
				navPrevSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_previous'),
				onSliderLoaded: update_height_products_slider,
				onSlideChange: update_height_products_slider,
				onSliderResize: update_height_products_slider
			});
			
			function update_height_products_slider(args) {
				
				/* update height of the first slider 

				$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_item').unbind('mouseenter mouseleave');

				setTimeout(function() {
					var setHeight = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_item:eq(' + (args.currentSlideNumber-1) + ')').outerHeight(true);
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider').css({ visibility: "visible" });
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider').stop().animate({ height: setHeight+20 }, 300);
				},0);
				
			}

			// need to update the slider to get the image widths working correctly
			$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').iosSlider('update');
			
	   })
	})(jQuery);

	</script>
	
	<div class="gbtr_items_slider_id_<?php echo $sliderrandomid ?> products_slider custom_images_slider">  
	
		<div class="gbtr_items_slider_wrapper">
			<div class="gbtr_items_slider products_slider">
				<ul class="slider style_2">
					
					<?php
					$items = explode(",", $content);
					/*if (!preg_match_all("/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches)) {
						return do_shortcode($content);
					} 
					else { 
						$output = '';
						for($i = 0; $i < count($items); $i++) {
										
							$output .= '<li class="products_slider_item custom_images_slider_item">
											<div class="products_slider_content">
												<div class="products_slider_images_wrapper">
													' . do_shortcode(str_replace("<br />", "", trim($items[$i]))) .'                               
												</div>
											</div>
										</li>';
						}
						echo $output;
						
					//}
					?>

				</ul>
									   
				<div class='products_slider_previous'></div>
				<div class='products_slider_next'></div>
					
			</div>
		</div>
	
	</div>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

//[custom_images_slider_image]
function shortcode_custom_images_slider_image( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'url' => '',
		), $atts ) );
   return '<div class="products_slider_images"><span>'.$content.'</span><img src="'.esc_attr($url).'"/></div>';
}
*/