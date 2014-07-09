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

add_filter('show_admin_bar', '__return_false');

/*********************************************/
/****************** STYLES *******************/
/*********************************************/

function theretailer_secondary_styles()  
{	
	wp_register_style('prettyphoto', get_template_directory_uri() . '/inc/prettyphoto/css/prettyPhoto_woo.css', array(), '3.1.5', 'all' );
	
	wp_enqueue_style( 'prettyphoto' );	
	
	wp_register_script('jquery-placeholder', get_stylesheet_directory_uri() . '/js/plugins/placeholders.jquery.min.js', 'jquery', '3.0.2', TRUE);
	wp_enqueue_script('jquery-placeholder');
}  
add_action( 'wp_enqueue_scripts', 'theretailer_secondary_styles', 99 );


/******************************************************/
/**************** CUSTOM IMAGE SIZES ******************/
/******************************************************/

add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'sliding_banner_image' => __('Sliding Banner Image'),
    ) );
}


/**
 * Define image sizes
 */
function child_theme_image_setup() {
  	$catalog = array(
		'width' 	=> '190',	// px
		'height'	=> '190',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '510',	// px
		'height'	=> '510',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '114',	// px
		'height'	=> '114',	// px
		'crop'		=> 1 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
add_action( 'after_setup_theme', 'child_theme_image_setup', 11 );


/**********************************************/
/************ OVERRIDE SHORTCODES **********/
/**********************************************/
add_action( 'after_setup_theme', 'my_child_setup' );

function my_child_setup() {
	remove_shortcode( 'container' );
	add_shortcode( 'container', 'shortcode_container_child' );
	///
	remove_shortcode( 'featured_1' );
	add_shortcode( 'featured_1', 'shortcode_featured_1_child' );
	///
	remove_shortcode( 'team_member' );
	add_shortcode( 'team_member', 'team_member_child' );
	///
	remove_shortcode( 'custom_featured_products' );
	add_shortcode( 'custom_featured_products', 'shortcode_custom_featured_products_child' );
	///
	remove_shortcode( 'empty_separator' );
	add_shortcode( 'empty_separator', 'shortcode_empty_separator_child' );
	///
	remove_shortcode( 'banner_simple' );
	add_shortcode( 'banner_simple', 'banner_simple_child' );
}

// [container]
function shortcode_container_child($params = array(), $content = null) {
	
	$content = do_shortcode($content);
	$container = '<div id="full-width-wrapper"><div class="shortcode_container cf">'.$content.'</div></div>';
	return $container;
}

// [empty_separator]
function shortcode_empty_separator_child($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'top_space' => '10px',
		'bottom_space' => '30px'
	), $params));
	$empty_separator = '
		<div class="empty_separator cf" style="padding-top:'.$top_space.';padding-bottom:'.$bottom_space.'"></div>
	';
	return $empty_separator;
}

// [banner_simple]
function banner_simple_child($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'title' => 'Title',
		'subtitle' => '',
		'link_url' => '',
		'title_color' => '#fff',
		'subtitle_color' => '#fff',
		'border_color' => '#000',
		'inner_stroke' => '2px',
		'inner_stroke_color' => '#fff',
		'bg_color' => '#000',
		'bg_image' => '',
		'h_padding' => '20px',
		'v_padding' => '20px',
		'sep_padding' => '5px',
		'sep_color' => '#fff',
		'with_bullet' => 'no',
		'bullet_text' => '',
		'bullet_bg_color' => '',
		'bullet_text_color' => ''
	), $params));
	
	$content = do_shortcode($content);
	$banner_simple = '
		<div class="shortcode_banner_simple" onclick="location.href=\''.$link_url.'\';" style="background-color:'.$border_color.'; background-image:url('.$bg_image.')">
			<div class="shortcode_banner_simple_inside" style="padding:'.$v_padding.' '.$h_padding.'; background-color:'.$bg_color.'; border: '.$inner_stroke.' solid '.$inner_stroke_color.'">
				<div><h3 style="color:'.$title_color.'">'.$title.'</h3></div>
			</div>';
	if ($with_bullet == 'yes') {
		$banner_simple .= '<div class="shortcode_banner_simple_bullet" style="background:'.$bullet_bg_color.'; color:'.$bullet_text_color.'"><span>'.$bullet_text.'</span></div>';
	}
	$banner_simple .= '</div>';
	return $banner_simple;
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
			
			if(!Modernizr.mq('(max-width: 479px)')) {
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
			}
			
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
		'id' => '',
		'link_url' => '',
		'title_color' => '#fff',
		'subtitle_color' => '#fff',
		'border_color' => '#000',
		'bg_color' => '#000',
		'h_padding' => '20px',
		'v_padding' => '20px',
		'sep_padding' => '5px',
		'sep_color' => '#fff',
		'sep_width' => '50%',
		'with_bullet' => 'no',
	), $params));
	
	$content = do_shortcode($content);
	$imageFolder = "/wp-content/themes/ps-retailer/images/";
	$banner_full_width = '
		<div id="'.$id.'" class="shortcode_banner_full_width" onclick="location.href=\''.$link_url.'\';" style="background-color:'.$border_color.';">
			<div class="content_grid_12 shortcode_banner_full_width_inside">
				<div class="shortcode_banner_full_width_package"><img src="'.$imageFolder.'shipping_banner_package.png" srcset="'.$imageFolder.'shipping_banner_package@2x.png 2x"/></div>
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
			
			if(!Modernizr.mq('(max-width: 479px)')) {
				
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
					autoSlide: true,
					autoSlideTimer: 4000,
					autoSlideHoverPause: true,
					infiniteSlider:true,
					navNextSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_next'),
					navPrevSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_previous'),
					onSliderLoaded: update_height_products_slider,
					onSlideChange: update_height_products_slider,
					onSliderResize: update_height_products_slider
				});
				
				// need to update the slider to get the image widths working correctly
				$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').iosSlider('update');
			}
			
			function update_height_products_slider(args) {
			
				/* update height of the first slider */

				$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_item').unbind('mouseenter mouseleave');

				setTimeout(function() {
					var setHeight = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider_item:eq(' + (args.currentSlideNumber-1) + ')').outerHeight(true);
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider').css({ visibility: "visible" });
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .products_slider').stop().animate({ height: setHeight+20 }, 300);
				},0);
			
			}
			
	   });
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
							$imgUrl = str_replace("&#215;", "x", trim($matches[5][$i]));			
							$imgUrlRetina = str_replace(".jpg", "@2x.jpg 2x", $imgUrl);
							$output .= '<li class="products_slider_item custom_images_slider_item">
											<div class="products_slider_content">
												<div class="products_slider_images_wrapper">
													<div class="products_slider_images"><img src="' . $imgUrl .'" srcset="'.$imgUrlRetina.'"/></div>                                
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
	   $(window).load(function(){
			
			if(!Modernizr.mq('(max-width: 479px)')) {
				
				var $slider = $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider');
				
				/* items_slider */
				$slider.iosSlider({
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
					autoSlide: true,
					autoSlideTimer: 4000,
					autoSlideHoverPause: true,
					infiniteSlider:true,
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
				
				$slider.iosSlider('update');
			
				//vimeo player listeners
				$slider.find(".media_slider_video iframe").each(function(index){
					var player = $f(this);
					player.addEvent('ready', function() {
					    player.addEvent('pause',  onPause);
					    player.addEvent('finish',  onPause);
					    player.addEvent('play', onPlay);
					});
				});
			}
			
		
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
			function onPause(id) {
				$slider.iosSlider('autoSlidePlay');
			}
			function onPlay(id) {
				$slider.iosSlider('autoSlidePause');
			}
			
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
		
	$imgUrlRetina = str_replace(".jpg", "@2x.jpg 2x", $src);
	
   return '<div class="products_slider_images media_slider_image">'.
			'<a href="'.esc_attr($url).'">'.
			'<span class="text-box"><span>'.$content.'</span></span><img src="'.esc_attr($src).'" srcset="'.$imgUrlRetina.'"/>'.
			'</a>'.
			'</div>';
}

//[media_slider_video]
function shortcode_media_slider_video( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'videoid' => ''
		), $atts ) );
   return '<div class="products_slider_images media_slider_video">'.
			'<iframe src="//player.vimeo.com/video/'.esc_attr($videoid).'?title=0&amp;byline=0&amp;portrait=0&amp;color=05597a&api=1&player_id=video-'.esc_attr($videoid).'" width="738" height="416" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen id="video-'.esc_attr($videoid).'"></iframe>'.
			'</div>';
}



// [custom_featured_by_category]
function shortcode_custom_featured_by_category($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		"category" => '',
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
			
			if(!Modernizr.mq('(max-width: 479px)')) {
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
				$slider.find('.product_item').each(function(){
					var $productItem = $(this);
					var $infoOverlay = $productItem.find('.info-overlay');
					var boxHeight = $productItem.find(".image_container").height();
					var startY = boxHeight - $infoOverlay.outerHeight();
					$infoOverlay.css("top", boxHeight + "px");
				
					$productItem.on({
						mouseenter: function(e){
							$infoOverlay.show().stop().animate({top:startY}, 250);
						},
						mouseleave: function(e){
							$infoOverlay.stop().animate({top:boxHeight}, 250);
						}
					});
				});
			}
			
		
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
            <div class="gbtr_items_slider <?php if(esc_attr($category) == 'coffee') {echo 'featured_coffees';} ?>">
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
						'product_cat' => esc_attr($category)
                    );
                    
                    $products = new WP_Query( $args );
                    
                    if ( $products->have_posts() ) : ?>
                                
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                            <?php 
								//coffee categorie gets something special
								if(esc_attr($category) == 'coffee'){
									woocommerce_get_template_part( 'content', 'coffee-product' );
								}else {
									woocommerce_get_template_part( 'content', 'product' );
								}
							?>
                
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


// [custom_featured_products_large]
function shortcode_custom_featured_products_large($atts, $content = null) {
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
			
			if(!Modernizr.mq('(max-width: 479px)')) {
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
					onSliderLoaded: custom_best_sellers_UpdateSliderHeight,
					//onSlideChange: custom_best_sellers_UpdateSliderHeight,
					//onSliderResize: custom_best_sellers_UpdateSliderHeight
				});
			}
			
			
		
			function custom_best_sellers_UpdateSliderHeight(args) {
								
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
            <div class="gbtr_items_slider featured-large">
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
                    
                            <?php woocommerce_get_template_part( 'content', 'large-product' ); ?>
                
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

//[wholesale_category_listing]
function shortcode_wholesale_category_listing($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"category" => '',
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
		<div id="cat-<?php echo esc_attr($category); ?>" class="wholesale-category">
			<!--<h4 class="wholesale-category-title widget-title"><?php echo esc_attr($title); ?></h4>-->
			<ul>
				<?php
			    $args = array(
			        'post_status' => 'publish',
			        'post_type' => 'product',
					'ignore_sticky_posts'   => 1,
			        'posts_per_page' => $per_page,
					'orderby' => $orderby,
					'order' => $order,
					'product_cat' => esc_attr($category)
			    );
    
			    $products = new WP_Query( $args );
    
			    if ( $products->have_posts() ) : ?>
                
			        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
    
			            <?php 
							woocommerce_get_template_part( 'content', 'wholesale-product' );
						?>

			        <?php endwhile; // end of the loop. ?>
        
			    <?php
			    endif; 
			    ?>
			</ul>
		</div>
	
    <?php } ?>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


// [from_the_blog_ps]
function shortcode_from_the_blog_ps($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"title" => '',
		"posts" => '2',
		"category" => ''
	), $atts));
	ob_start();
	?> 
    
    <script>
	(function($){
		$(window).load(function(){
			
			if(!Modernizr.mq('(max-width: 479px)')) {
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
					onSliderLoaded: gbtr_items_slider_UpdateSliderHeight,
				});
			}
			
	
			function gbtr_items_slider_UpdateSliderHeight(args) {
		
				/* update height of the first slider */
		
				var t = 0; // the height of the highest element (after the function runs)
				var t_elem;  // the highest element (after the function runs)
				$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .from_the_blog_item').each(function () {
					$this = $(this);
					if ( $this.outerHeight() > t ) {
						t_elem = this;
						t = $this.outerHeight();
					}
				});

				setTimeout(function() {
					$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').css({
						height: t+30,
						visibility: "visible"
					});
				});
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
            <div class="gbtr_items_slider from_the_blog">
                <ul class="slider">
					
					<?php
            
                    $args = array(
                        'post_status' => 'publish',
                        'post_type' => 'post',
						'category_name' => $category,
                        'posts_per_page' => $posts
                    );
                    
                    $recentPosts = new WP_Query( $args );
                    
                    if ( $recentPosts->have_posts() ) : ?>
                                
                        <?php while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?>
                    
                            <?php $post_format = get_post_format(get_the_ID()); ?>
                            
                            <li class="from_the_blog_item <?php echo $post_format; ?> <?php if ( !has_post_thumbnail()) : ?>no_thumb<?php endif; ?>">
                                
                                <a class="from_the_blog_img" href="<?php the_permalink() ?>">
                                    <?php if ( has_post_thumbnail()) : ?>
                                    	<?php the_post_thumbnail('recent_posts_shortcode') ?>
                                    <?php else : ?>
                                    	<span class="from_the_blog_noimg"></span>
                                    <?php endif; ?>
                                    <span class="from_the_blog_date">
										<span class="from_the_blog_date_day"><?php echo get_the_time('d', get_the_ID()); ?></span>
                                        <span class="from_the_blog_date_month"><?php echo get_the_time('M', get_the_ID()); ?></span>
                                    </span>
                                    <?php if ($post_format != "") : ?>
                                    <span class="post_format_icon"></span>
                                    <?php endif ?>
                                </a>
                                
                                <div class="from_the_blog_content">
                                
                                    <?php if ( ($post_format == "") || ($post_format == "video") ) : ?>
                                    	<a class="from_the_blog_title" href="<?php the_permalink() ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                    <?php endif ?>	

                                    <div class="from_the_blog_excerpt">
										<?php											
											$limit_words = 20;
											if ( ($post_format == "status") || ($post_format == "quote") || ($post_format == "aside") ) {
												$limit_words = 40;
											}
											$content = get_the_excerpt();
											$customExcerpt = get_post_meta(get_the_ID(), "Custom Excerpt", true);
											if($customExcerpt != ""){
												$content = $customExcerpt;
											}
											$link = get_permalink(get_the_ID());
											$readmore = ' <a class="from_the_blog_readmore" href="'.$link.'">Read more</a>';
                                            echo string_limit_words($content, $limit_words).$readmore;
                                        ?>
                                    </div>

                                </div>
                                
                            </li>
                
                        <?php endwhile; // end of the loop. ?>
                        
                    <?php

                    endif;
					//wp_reset_query();
                    
                    ?>
                </ul>     
            </div>
        </div>
    
    </div>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}



// [text_block_bold]
function shortcode_text_block_bold($params = array(), $content = null) {
	$content = do_shortcode($content);
	$text_block = '		
		<div class="shortcode_text_block_bold">
			<p>'.$content.'</p>
		</div>
	';
	return $text_block;
}

// [text_block_big_letter]
function shortcode_text_block_big_letter($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'indent' => '',
	), $params));
	$content = do_shortcode($content);
	$class = 'shortcode_text_block_big_letter';
	if($indent == "true"){
		$class = 'shortcode_text_block_big_letter indent';
	}
	$text_block = '<p class="'.$class.'">'.$content.'</p>';
	return $text_block;
}

// [text_block_with_left_image]
function shortcode_text_block_with_left_image($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'src' => '',
		'title' => '',
		'subtitle' => ''
	), $params));
	$text_block = '	
		<div class="shortcode_text_block_with_left_image">
			<span class="text-image"><img src="'.esc_attr($src).'" /></span>
			<h1>'.esc_attr($title).'</h1>
			<h5>'.$subtitle.'</h5>
			<p>'.$content.'</p>
		</div>
	';
	return $text_block;
}

// [text_block_with_list]
function shortcode_text_block_with_list($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $params));
	$text_block = '	
		<div class="shortcode_text_block_with_list">
			<h4>'.esc_attr($title).'</h4>
			<ul>'.$content.'</ul>
		</div>
	';
	return $text_block;
}



// [approach_content_container]
function shortcode_approach_content_container($params = array(), $content = null) {
	
	$content = do_shortcode($content);
	$container = '<div><div class="shortcode_approach_content_container">'.$content.'</div></div>';
	return $container;
}

// [three_col_container]
function shortcode_three_col_container($params = array(), $content = null){
	$content = do_shortcode($content);
	$container = '<div class="shortcode_three_col_container cf">'.$content.'</div>';
	return $container;
}

// [one_third_custom_with_image]
function shortcode_one_third_custom_with_image($params = array(), $content = null){
	extract(shortcode_atts(array(
		'src' => '',
		'title' => '',
		'lastcol' => ''
	), $params));
	$lastClass = "";
	if($lastcol == 'true') { $lastClass = "last-col"; };
	$text_block = '	
		<div class="shortcode_one_third_custom_with_image content_grid_4 '.$lastClass.'">
			<span class="text-image"><img src="'.esc_attr($src).'" /></span>
			<h2><span>'.esc_attr($title).'</span></h2>
			<p>'.do_shortcode($content).'</p>
		</div>
	';
	return $text_block;
}



// [full_custom_with_left_image]
function shortcode_full_custom_with_left_image($params = array(), $content = null){
	extract(shortcode_atts(array(
		'src' => '',
		'title' => ''
	), $params));
	$text_block = '	
		<div class="shortcode_full_custom_with_left_image cf content_grid_12">
			<div class="text-image"><img src="'.esc_attr($src).'" /></div>
			<div class="text-box">
				<h2><span>'.esc_attr($title).'</span></h2>
				<p>'.do_shortcode($content).'</p>
			</div>
		</div>
	';
	return $text_block;
}





add_shortcode('banner_full_width', 'banner_full_width');
add_shortcode('wood_plank_triplet', 'wood_plank_triplet');
add_shortcode("custom_images_slider", "shortcode_custom_images_slider");
add_shortcode("media_slider", "shortcode_media_slider");
add_shortcode("media_slider_image", "shortcode_media_slider_image");
add_shortcode("media_slider_video", "shortcode_media_slider_video");
add_shortcode("custom_featured_by_category", "shortcode_custom_featured_by_category");
add_shortcode("wholesale_category_listing", "shortcode_wholesale_category_listing");
add_shortcode("custom_featured_products_large", "shortcode_custom_featured_products_large");
add_shortcode("from_the_blog_ps", "shortcode_from_the_blog_ps");
add_shortcode("text_block_bold", "shortcode_text_block_bold");
add_shortcode("text_block_big_letter", "shortcode_text_block_big_letter");
add_shortcode("text_block_with_left_image", "shortcode_text_block_with_left_image");
add_shortcode("text_block_with_list", "shortcode_text_block_with_list");
add_shortcode("approach_content_container", "shortcode_approach_content_container");
add_shortcode("three_col_container", "shortcode_three_col_container");
add_shortcode("one_third_custom_with_image", "shortcode_one_third_custom_with_image");
add_shortcode("full_custom_with_left_image", "shortcode_full_custom_with_left_image");


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

/**********************************************/
/************ Helpers **********/
/**********************************************/
function is_wholesale_template(){
	return is_page_template('page-wholesale-orders.php');
}




function tribe_events_before_html_custom($content){
	return do_shortcode($content);
}

add_filter('tribe_events_before_html', 'tribe_events_before_html_custom');

add_filter('woocommerce_variable_price_html','custom_from',10);
add_filter('woocommerce_grouped_price_html','custom_from',10);
add_filter('woocommerce_variable_sale_price_html','custom_from',10);
function custom_from($price){
	$newText = substr($price, strrpos($price, "-"), strlen($price));
	
	return $newText;
}



add_filter( 'get_terms', 'get_category_terms', 10, 3 );

/**
 * Hide the ticket category from the sidebar
 */ 
function get_category_terms( $terms, $taxonomies, $args ) {
 
  $new_terms = array();
 
  // if a product category and on the shop page
  if ( in_array( 'product_cat', $taxonomies ) ) {
 
    foreach ( $terms as $key => $term ) {
 
      if ( ! in_array( $term->slug, array( 'ticket' ) ) ) {
        $new_terms[] = $term;
      }
 
    }
 
    $terms = $new_terms;
  }
 
  return $terms;
}


// Modify the default WooCommerce orderby dropdown
//
// Options: menu_order, popularity, rating, date, price, price-desc
// In this example I'm removing price & price-desc but you can remove any of the options
function my_woocommerce_catalog_orderby( $orderby ) {
	unset($orderby["menu_order"]);
	return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20 );





/**********************************************/
/************ EVENTS HELPERS **********/
/**********************************************/

function tribe_has_wootickets($post_id = null) {
	global $wpdb;
	$id = TribeEvents::postIdHelper($post_id);

	$result = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %d LIMIT 1",
		'_tribe_wooticket_for_event', $id
	));

	return (is_numeric($result) and $result > 0);
}

/**
 * Returns an array of all WooTicket products associated with the event.
 *
 * @param null $post_id
 * @return array
 */
function get_wooticket_products($post_id = null) {
	global $wpdb;
	$id = TribeEvents::postIdHelper($post_id);
	$products = array();

	$product_ids = $wpdb->get_col($wpdb->prepare(
		"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %d",
		'_tribe_wooticket_for_event', $id
	));

	if ($product_ids) foreach ($product_ids as $id)
		$products[] = new WC_Product_Simple($id);

	return $products;
}

/**
 * This solution adds a piece of text reading "Sold out!" just after the event title
 * in list view.
 *
 * @uses tribe_has_wootickets() 
 * @see http://pastebin.com/hPS9nwft
 *
 * @uses get_wooticket_products()
 * @see http://pastebin.com/csuqeikG
 */
function wootickets_list_view_sold_out() {
	global $post;

	if (TribeEvents::POSTTYPE !== $post->post_type) return;
	if (!tribe_has_wootickets($post->ID)) return;

	$tickets = get_wooticket_products($post->ID);
	$stock = 0;

	foreach ($tickets as $ticket)
		$stock += $ticket->get_stock_quantity();

	if (0 === $stock) echo '<span class="wootickets-sold-out"> - Sold out! </span>';
}

// Hook up so it fires during the event list loop
add_action('tribe_events_after_the_event_title', 'wootickets_list_view_sold_out');




/**
 * Echos the single recurring event page's other events in the series.
 *
 * @param mixed $tag The specific tags you want it relating to.
 * @param mixed $category The specific categories you want it relating to.
 * @param int $count The number of related events to find.
 * @return void.
 */
function tribe_single_events_in_series( $count = 10 ) {
	global $currentPost;
	$posts = tribe_get_related_posts( $count );
	if ( is_array( $posts ) && !empty( $posts ) ) {
		echo '<ul class="tribe-related-events tribe-events-in-series tribe-clearfix hfeed vcalendar">';
		foreach ( $posts as $post ) {
			//if(tribe_is_recurring_event($post->ID) && get_the_title( $currentPost->ID ) == get_the_title( $post->ID )){
			if(get_the_title( $currentPost->ID ) == get_the_title( $post->ID )){
				echo '<li>';
					echo '<div class="tribe-related-event-info">';
						//echo '<h3 class="tribe-related-events-title summary"><a href="'. tribe_get_event_link( $post ) .'" class="url" rel="bookmark">'. get_the_title( $post->ID ) .'</a></h3>';
						if ( $post->post_type == TribeEvents::POSTTYPE ) {
							echo tribe_events_event_schedule_details( $post , '<a href="'.tribe_get_event_link( $post->ID ).'">', '</a>'); //make the event date/time clickable
						}
					echo '</div>';
				echo '</li>';
			}
		}
		echo '</ul>';
	}
}