<?php

/*********************************************/
/**************** INCLUDES *******************/
/*********************************************/
global $theretailer_theme_options;

/**********************************************/
/************* Theme Options Array ************/
/**********************************************/
//$theretailer_theme_options = get_option('The Retailer_options');
$theretailer_theme_options = $smof_data;
//include_once('inc/fonts_from_google.php'); // Load Fonts from Google


/*********************************************/
/****************** STYLES *******************/
/*********************************************/

function theretailer_secondary_styles()  
{	
	wp_register_style('prettyphoto', get_template_directory_uri() . '/inc/prettyphoto/css/prettyPhoto_woo.css', array(), '3.1.5', 'all' );
	
	wp_enqueue_style( 'prettyphoto' );	
	
}  
add_action( 'wp_enqueue_scripts', 'theretailer_secondary_styles', 99 );



/**********************************************/
/************ OVERRIDE ACTIONS **********/
/**********************************************/
function remove_default_actions() {

}
// Call 'remove_thematic_actions' (above) during WP initialization
add_action('init','remove_default_actions');



/**********************************************/
/************ OVERRIDE SHORTCODES **********/
/**********************************************/
add_action( 'after_setup_theme', 'my_child_setup' );

function my_child_setup() {
	remove_shortcode( 'featured_1' );
	add_shortcode( 'featured_1', 'shortcode_featured_1_child' );
	///
	remove_shortcode( 'featured_1' );
	add_shortcode( 'team_member', 'team_member_child' );
	///
	remove_shortcode( 'custom_featured_products' );
	add_shortcode( 'custom_featured_products', 'shortcode_custom_featured_products_child' );
}

// [featured_1]
function shortcode_featured_1_child($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'image_url' => '',
		'title' => 'Title',
		'button_text' => 'Link button',
		'button_url' => '#'
	), $params));
	
	$content = do_shortcode($content);
	$featured_1 = '		
		<div class="shortcode_featured_1">';
			if($image_url) $featured_1 .= '<div class="shortcode_featured_1_img_placeholder"><img src="'.$image_url.'" alt="" /></div>';
			if($title != 'Title') $featured_1 .= '<h3>'.$title.'</h3>';
			$featured_1 .= '<p>'.$content.'</p>
			<a href="'.$button_url.'">'.$button_text.'</a>
		</div>
	';
	return $featured_1;
}

// [team_member]
function team_member_child($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'image_url' => '',
		'name' => 'Name',
		'role' => 'Role'
	), $params));
	
	$content = do_shortcode($content);
	$team_member = '
		<div class="shortcode_meet_the_team">
			<div class="shortcode_meet_the_team_img_placeholder"><img src="'.$image_url.'" alt="" /></div>
			<h3>'.$name.'</h3>
			<div class="small_sep"></div>';
	if($role != '' && $role != 'Role') $team_member .= '<div class="role">'.$role.'</div>';
	$team_member .= '<p>'.$content.'</p>
			</div>
		';
	return $team_member;
}

// [custom_featured_products]
function shortcode_custom_featured_products_child($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'per_page'  => '12',
		'orderby' => 'date',
		'order' => 'desc'
	), $atts));
	ob_start();
	?>
	
	<?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>  
	
	<script>
	(function($){
		$(window).load(function(){
			
			/* items_slider */
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
				navNextSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_sliders_nav .big_arrow_right'),
				navPrevSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_sliders_nav .big_arrow_left'),
				onSliderLoaded: custom_featured_products_UpdateSliderHeight,
				//onSlideChange: custom_featured_products_UpdateSliderHeight,
				//onSliderResize: custom_featured_products_UpdateSliderHeight
			});
			
			function custom_featured_products_UpdateSliderHeight(args) {
									
				//currentSlide = args.currentSlideNumber;
				
				/* update height of the first slider */
				
				var t = 0; // the height of the highest element (after the function runs)
				var t_elem;  // the highest element (after the function runs)
				$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .product_item').each(function () {
					$this = $(this);
					if ( $this.outerHeight() > t ) {
						t_elem = this;
						t = $this.outerHeight();
					}
				});
	
				setTimeout(function() {
					//var setHeight = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider .product_item:eq(' + (args.currentSlideNumber-1) + ')').outerHeight(true);
					//$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').animate({ height: setHeight+20 }, 300);
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').css({
						height: t+30,
						visibility: "visible"
					});
				},300);
				
			}
		
		})
	})(jQuery);
	</script>
	
	<div class="gbtr_items_slider_id_<?php echo $sliderrandomid ?> custom_featured_products" >
	
		<div class="gbtr_items_sliders_header">
			<div class="gbtr_items_sliders_title">
				<div class="gbtr_featured_section_title"><strong><?php echo $title ?></strong></div>
			</div>
			<div class="gbtr_items_sliders_nav">                        
				<a class='big_arrow_right'></a>
				<a class='big_arrow_left'></a>
				<div class='clr'></div>
			</div>
		</div>
	
		<div class="gbtr_bold_sep"></div>   
	
		<div class="gbtr_items_slider_wrapper">
			<div class="gbtr_items_slider">
				<ul class="slider">
					<?php
			
					$args = array(
						'post_status' => 'publish',
						'post_type' => 'product',
						'ignore_sticky_posts'   => 1,
						'meta_key' => '_featured',
						'meta_value' => 'yes',
						'posts_per_page' => $per_page,
						'orderby' => $orderby,
						'order' => $order,
					);
					
					$products = new WP_Query( $args );
					
					if ( $products->have_posts() ) : ?>
								
						<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					
							<?php woocommerce_get_template_part( 'content', 'product' ); ?>
				
						<?php endwhile; // end of the loop. ?>
						
					<?php
					
					endif; 
					//wp_reset_query();
					
					?>
				</ul>     
			</div>
		</div>
	
	</div>
	
	<?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


/**********************************************/
/************ NEW SHORTCODES **********/
/**********************************************/
// [banner_full_width]
function banner_full_width($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'title' => 'Title',
		'subtitle' => 'Subtitle',
		'link_url' => '',
		'title_color' => '#fff',
		'subtitle_color' => '#fff',
		'border_color' => '#000',
		'bg_color' => '#000',
		'bg_image' => '',
		'h_padding' => '20px',
		'v_padding' => '20px',
		'sep_padding' => '5px',
		'sep_color' => '#fff',
		'sep_width' => '50%',
		'with_bullet' => 'no',
	), $params));
	
	$content = do_shortcode($content);
	$banner_full_width = '
		<div class="shortcode_banner_full_width" onclick="location.href=\''.$link_url.'\';" style="background-color:'.$border_color.'; background:url('.$bg_image.') repeat-x 50% 100%;">
			<div class="content_grid_12 shortcode_banner_full_width_inside">
				<div class="shortcode_banner_full_width_package"><img src="/wp-content/themes/ps-retailer/images/shipping_banner_package.png" /></div>
				<div class="shortcode_banner_full_width_text" style="padding:'.$v_padding.' '.$h_padding.'; background-color:'.$bg_color.';">
					<h3 style="color:'.$title_color.'">'.$title.'</h3>
					<h4 style="color:'.$subtitle_color.'">'.$subtitle.'</h4>
					<div class="shortcode_banner_full_width_sep" style="margin:'.$sep_padding.' auto; background-color:'.$sep_color.'; width: '.$sep_width.';"></div>
				</div>';
	$banner_full_width .= '</div></div>';
	return $banner_full_width;
}

// [wood_plank_triplet]
function wood_plank_triplet($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'link_url_1' => '',
		'link_url_2' => '',
		'link_url_3' => '',
		'title_1' => '',
		'title_2' => '',
		'title_3' => ''
	), $params));
	
	$content = do_shortcode($content);
	$wood_plank_triplet = '
		<div class="shortcode_wood_plank_triplet">
			<a class="plank1" href="'.$link_url_1.'">'.$title_1.'</a>
			<a class="plank2" href="'.$link_url_2.'">'.$title_2.'</a>
			<a class="plank3" href="'.$link_url_3.'">'.$title_3.'</a>';
	$wood_plank_triplet .= '</div>';
	return $wood_plank_triplet;
}


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
			
			/* items_slider */
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
				
				/* update height of the first slider */

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
					if (!preg_match_all("/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches)) {
						return do_shortcode($content);
					} 
					else {
						$output = '';
						for($i = 0; $i < count($matches[0]); $i++) {
										
							$output .= '<li class="products_slider_item custom_images_slider_item">
											<div class="products_slider_content">
												<div class="products_slider_images_wrapper">
													<div class="products_slider_images"><img src="' . do_shortcode(trim($matches[5][$i])) .'"/></div>                                
												</div>
											</div>
										</li>';
						}
						echo $output;
						
					}
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

//[media_slider]
function shortcode_media_slider($atts, $content=null, $code) {
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
	   $(function(){
			
			/* items_slider */
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
			
			//rollover for image slides
			$('.media_slider_image a').on({
				mouseenter: function(e){
					$(this).find('span').stop().animate({opacity:1}, 500);
				},
				mouseleave: function(e){
					$(this).find('span').stop().animate({opacity:0}, 500);
				}
			});
			
			function update_height_products_slider(args) {
				
				/* update height of the first slider */

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
			<div class="gbtr_items_slider products_slider media_slider">
				<ul class="slider style_2">
					
					<?php
					$items = explode(",", $content);
					
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

//[media_slider_image]
function shortcode_media_slider_image( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'src' => '',
			'url' => ''
		), $atts ) );
   return '<div class="products_slider_images media_slider_image">'.
			'<a href="'.esc_attr($url).'">'.
			'<span>'.$content.'</span><img src="'.esc_attr($src).'"/>'.
			'</a>'.
			'</div>';
}

//[media_slider_video]
function shortcode_media_slider_video( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'videoid' => ''
		), $atts ) );
   return '<div class="products_slider_images media_slider_video">'.
			'<iframe src="//player.vimeo.com/video/'.esc_attr($videoid).'?title=0&amp;byline=0&amp;portrait=0&amp;color=05597a" width="600" height="338" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'.
			'</div>';
}



// [custom_featured_coffee]
function shortcode_custom_featured_coffee($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		'per_page'  => '12',
        'orderby' => 'date',
        'order' => 'desc'
	), $atts));
	ob_start();
	?>
    
    <?php 
	/**
	* Check if WooCommerce is active
	**/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	?>  
    
    <script>
	(function($){
		$(function(){
			var $slider = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?>');
			/* items_slider */
			$slider.find('.gbtr_items_slider').iosSlider({
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
				navNextSelector: $slider.find('.gbtr_items_sliders_nav .big_arrow_right'),
				navPrevSelector: $slider.find('.gbtr_items_sliders_nav .big_arrow_left'),
				onSliderLoaded: custom_featured_products_UpdateSliderHeight,
				//onSlideChange: custom_featured_products_UpdateSliderHeight,
				//onSliderResize: custom_featured_products_UpdateSliderHeight
			});	
			
			if($slider.find('.product_item').length < 2){
				$slider.find('.gbtr_items_sliders_nav .big_arrow_right').hide();
				$slider.find('.gbtr_items_sliders_nav .big_arrow_left').hide();
			}
			
			//show the info overlay
			$slider.find('.product_item').on({
				mouseenter: function(e){
					$(this).find('.info-overlay').fadeIn(500);
				},
				mouseleave: function(e){
					$(this).find('.info-overlay').fadeOut(500);
				}
			});
			
			function custom_featured_products_UpdateSliderHeight(args) {
									
				//currentSlide = args.currentSlideNumber;
				
				/* update height of the first slider */
				
				var t = 0; // the height of the highest element (after the function runs)
				var t_elem;  // the highest element (after the function runs)
				$slider.find('.product_item').each(function () {
					$this = $(this);
					if ( $this.outerHeight() > t ) {
						t_elem = this;
						t = $this.outerHeight();
					}
				});
	
				setTimeout(function() {
					//var setHeight = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider .product_item:eq(' + (args.currentSlideNumber-1) + ')').outerHeight(true);
					//$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').animate({ height: setHeight+20 }, 300);
					$slider.find('.gbtr_items_slider').css({
						height: t+30,
						visibility: "visible"
					});
				},300);
				
			}
		
		});
	})(jQuery);
	</script>
    
    <div class="gbtr_items_slider_id_<?php echo $sliderrandomid ?>">
    
        <div class="gbtr_items_sliders_header">
            <div class="gbtr_items_sliders_title">
                <div class="gbtr_featured_section_title"><strong><?php echo $title ?></strong></div>
            </div>
            <div class="gbtr_items_sliders_nav">                        
                <a class='big_arrow_right'></a>
                <a class='big_arrow_left'></a>
                <div class='clr'></div>
            </div>
        </div>
    
        <div class="gbtr_bold_sep"></div>   
    
        <div class="gbtr_items_slider_wrapper">
            <div class="gbtr_items_slider featured_coffees">
                <ul class="slider">
                    <?php
            
                    $args = array(
                        'post_status' => 'publish',
                        'post_type' => 'product',
						'ignore_sticky_posts'   => 1,
                        //'meta_key' => '_featured',
                        //'meta_value' => 'yes',
                        'posts_per_page' => $per_page,
						'orderby' => $orderby,
						'order' => $order,
						'product_cat' => 'coffee'
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                                
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                            <?php woocommerce_get_template_part( 'content', 'coffee-product' ); ?>
                
                        <?php endwhile; // end of the loop. ?>
                        
                    <?php
                    
                    endif; 
                    //wp_reset_query();
                    
                    ?>
                </ul>     
            </div>
        </div>
    
    </div>
    
    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}




add_shortcode('banner_full_width', 'banner_full_width');
add_shortcode('wood_plank_triplet', 'wood_plank_triplet');
add_shortcode("custom_images_slider", "shortcode_custom_images_slider");
add_shortcode("media_slider", "shortcode_media_slider");
add_shortcode("media_slider_image", "shortcode_media_slider_image");
add_shortcode("media_slider_video", "shortcode_media_slider_video");
add_shortcode("custom_featured_coffee", "shortcode_custom_featured_coffee");


/**********************************************/
/************ Plugin recommendations **********/
/**********************************************/

add_action( 'tgmpa_register', 'my_theme_register_secondary_plugins' );
function my_theme_register_secondary_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     				=> 'Regenerate Thumbnails', // The plugin name
			'slug'     				=> 'regenerate-thumbnails', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/regenerate-thumbnails.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Unlimited Sidebars Woosidebars', // The plugin name
			'slug'     				=> 'woosidebars', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/woosidebars.1.3.1.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.3.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)

	);

	tgmpa( $plugins, $config );

}




// Hide standard shipping option when free shipping is available
add_filter( 'woocommerce_available_shipping_methods', 'hide_standard_shipping_when_free_is_available' , 10, 1 );
/**
* Hide Standard Shipping option when free shipping is available
*
* @param array $available_methods
*/
function hide_standard_shipping_when_free_is_available( $available_methods ) {
if( isset( $available_methods['free_shipping'] ) AND isset( $available_methods['flat_rate'] ) ) {
 
	// remove standard shipping option
	unset( $available_methods['flat_rate'] );
	}
	 
	return $available_methods;
}

