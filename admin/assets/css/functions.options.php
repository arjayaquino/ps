<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();
$url =  ADMIN_DIR . 'assets/images/';

// General tab

$of_options[] = array( "name" => "General",
					"type" => "heading");
					
$of_options[] = array( "name" => "Main Layout Style",
					"desc" => "Select the layout style for your site. Choose a <strong><em>Full Width</em></strong> or <strong><em>Boxed</em></strong> layout.",
					"id" => "gb_layout",
					"std" => "fullscreen",
					"type" => "images",
					"options" => array(
						'fullscreen' => $url . '1col.png',
						'boxed' => $url . '3cm.png')
					);
					
/*$of_options[] = array( "name" => "Boxed Layout Width",
					"desc" => "The Width of the boxed layout in px.",
					"id" => "boxed_layout_width",
					"std" => "1100",
					"type" => "text");*/
					
$of_options[] = array( 	"name" 		=> "'<em>Boxed</em>' Layout Width",
						"desc" 		=> "Slide to adjust the width of the <strong><em>Boxed</em></strong> layout (if selected above).",
						"id" 		=> "boxed_layout_width",
						"std" 		=> "1100",
						"min" 		=> "980",
						"step"		=> "1",
						"max" 		=> "1600",
						"type" 		=> "sliderui"
				);
				
/*$of_options[] = array( 	"name" 		=> "[BETA] Responsive Behaviour",
						"desc" 		=> "Enable / Disable the Responsive Behaviour",
						"id" 		=> "gb_responsive",
						"std" 		=> 1,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);*/
					
$of_options[] = array( "name" => "Favicon",
					"desc" => "Upload your custom Favicon image. <br /><strong>16</strong>&times;<strong>16</strong>px <strong>.ico</strong> or <strong>.png</strong> file required.",
					"id" => "favicon_image",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Favicon - Retina",
					"desc" => "The retina version of your Favicon. <strong>144</strong>&times;<strong>144</strong>px <strong>.png</strong> file required.",
					"id" => "favicon_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
										
/*$of_options[] = array( "name" => "Revolution Slider",
					"desc" => "Check to turn off the Revolution Slider in mobile phones.",
					"id" => "revolution_slider_in_mobile_phones",
					"std" => 0,
					"type" => "checkbox");*/
				
$of_options[] = array( "name" => "Revolution Slider on Mobile Devices",
					"desc" => "To improve the experience, you can choose not to display the Revolution Sliders on mobile devices.",
					"id" => "revolution_slider_in_mobile_phones",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'rev_slider_mobiles_with.png',
						'1' => $url . 'rev_slider_mobiles_without.png')
					);
					
/*$of_options[] = array( "name" => "Comments on Pages",
					"desc" => "Check to display comments form on pages.",
					"id" => "page_comments",
					"std" => 0,
					"type" => "checkbox");*/
					
$of_options[] = array( 	"name" 		=> "Comments on Pages",
						"desc" 		=> "<strong>Enable</strong> / <strong>Disable</strong> comments on pages.",
						"id" 		=> "page_comments",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);




// Header tab			
			
$of_options[] = array( "name" => "Header",
                    "type" => "heading");
					
					
/*$of_options[] = array( "name" => "Top Bar",
					"desc" => "Check to hide the Top Bar.",
					"id" => "hide_topbar",
					"std" => 0,
					"type" => "checkbox");*/
				
$of_options[] = array( "name" => "Top Bar",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the <strong><em>Top Bar</em></strong>.",
					"id" => "hide_topbar",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'top_bar_with.png',
						'1' => $url . 'top_bar_without.png')
					);
					
$of_options[] = array( "name" => "Header Options",
					"desc" => "Select the <strong><em>Header</em></strong> layout style.",
					"id" => "gb_header_style",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'header_1.png',
						'1' => $url . 'header_2.png',
						'2' => $url . 'header_3.png')
					);
					
/*$of_options[] = array( "name" => "Main Navigation - Top Spacing",
					"desc" => "Set the spacing above the main navigation to adjust the size of your header.",
					"id" => "menu_header_top_padding",
					"std" => array('size' => '30px'),
					"type" => "typography");*/

/*$of_options[] = array( "name" => "Main Navigation - Bottom Spacing",
					"desc" => "Set the spacing below the main navigation to adjust the size of your header.",
					"id" => "menu_header_bottom_padding",
					"std" => array('size' => '30px'),
					"type" => "typography");*/

				
$of_options[] = array( 	"name" 		=> "The '<em>Mini Shopping Bag</em>'",
						"desc" 		=> "<strong>Enable</strong> / <strong>Disable</strong> the <strong><em>Mini Shopping Bag</em></strong> drop-down in Header.",
						"id" 		=> "shopping_bag_in_header",
						"std" 		=> 1,
						"folds"		=> 1,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);
				
$of_options[] = array( "name" => "'<em>Mini Shopping Bag</em>' Style",
					"desc" => "Styling options for the <strong><em>Mini Shopping Bag</em></strong> drop-down in Header.",
					"id" => "shopping_bag_style",
					"std" => "style1",
					"type" => "images",
					"fold" 		=> "shopping_bag_in_header",
					"options" => array(
						'style1' => $url . 'bag_1.png',
						'style2' => $url . 'bag_2.png')
					);



// Footer tab					
					
$of_options[] = array( "name" => "Footer",
					"type" => "heading");
					
/*$of_options[] = array( "name" => "Light Footer on All Site",
					"desc" => "Check to hide the Light Footer on All Site.",
					"id" => "light_footer_all_site",
					"std" => 0,
					"type" => "checkbox");*/
				
$of_options[] = array( "name" => "The '<em>Light Footer</em>'",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the <strong><em>Light Footer</em></strong> for all site pages.",
					"id" => "light_footer_all_site",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'light_footer_with.png',
						'1' => $url . 'light_footer_without.png')
					);
				
$of_options[] = array( "name" => "'<em>Light Footer</em>' Layout Options",
					"desc" => "Select the layout for your <strong><em>Light Footer</em></strong>.",
					"id" => "light_footer_layout",
					"std" => "4col",
					"type" => "images",
					"options" => array(
						'4col' => $url . 'light_footer_4_col.png',
						'3col' => $url . 'light_footer_3_col.png')
					);
					
/*$of_options[] = array( "name" => "Dark Footer on All Site",
					"desc" => "Check to hide the Dark Footer on All Site.",
					"id" => "dark_footer_all_site",
					"std" => 0,
					"type" => "checkbox");*/
				
$of_options[] = array( "name" => "The '<em>Dark Footer</em>'",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the <strong><em>Dark Footer</em></strong> for all site pages.",
					"id" => "dark_footer_all_site",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'dark_footer_with.png',
						'1' => $url . 'dark_footer_without.png')
					);
				
$of_options[] = array( "name" => "'<em>Dark Footer</em>' Layout Options",
					"desc" => "Select the layout for your <strong><em>Dark Footer</em></strong>.",
					"id" => "dark_footer_layout",
					"std" => "4col",
					"type" => "images",
					"options" => array(
						'4col' => $url . 'dark_footer_4_col.png',
						'3col' => $url . 'dark_footer_3_col.png')
					);
					
$of_options[] = array( "name" => "Footer Copyright Text",
					"desc" => "Enter your copyright information here.",
					"id" => "copyright_text",
					"std" => "&copy;2013 Phil &amp; Sebastian Coffee Roasters. All rights reserved",
					"type" => "text");		

$of_options[] = array( "name" => "Footer Supplemental Copyright Text",
					"desc" => "Enter your supplemental copyright information here.",
					"id" => "copyright_supplemental_text",
					"std" => "design & Branding by: Jonathan Herman",
					"type" => "text");		






// Shop tab
$of_options[] = array( "name" => "Shop",
                    "type" => "heading");
					
/*$of_options[] = array( "name" => "Catalog Mode",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> <em><strong>the Catalog Mode</em></strong> feature. This option will turn off the shopping functionality of WooCommerce.",
					"id" => "catalog_mode",
					"std" => 0,
					"type" => "checkbox");*/
					
$of_options[] = array( "name" 		=> "Catalog Mode",
						"desc" 		=> "<strong>Enable</strong> / <strong>Disable</strong> the <em><strong>Catalog Mode</em></strong>. When enabled, the feature <em>Turns Off</em> the shopping functionality of WooCommerce.",
						"id" 		=> "catalog_mode",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);
					
/*$of_options[] = array( "name" => "Shop With Sidebar",
					"desc" => "Check to enable the left sidebar on shop.",
					"id" => "sidebar_listing",
					"std" => 0,
					"type" => "checkbox");*/
				
$of_options[] = array( "name" => "Shop / Shop w. Sidebar",
					"desc" => "Select the layout style for the Shop catalog pages. The second option will enable the <strong><em>Shop Sidebar</em></strong> for the WooCommerce widgets.",
					"id" => "sidebar_listing",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'shop_layout_no_sidebar.png',
						'1' => $url . 'shop_layout_sidebar.png')
					);
					
/*$of_options[] = array( "name" => "Flipping Products Animation",
					"desc" => "Check to turn off the flipping animation.",
					"id" => "flip_product",
					"std" => 0,
					"type" => "checkbox");*/
					
$of_options[] = array( "name" => "Flipping Products Animation",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the flipping animation.",
					"id" => "flip_product",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'flip_product_enabled.png',
						'1' => $url . 'flip_product_disabled.png')
					);
					
/*$of_options[] = array( "name" => "",
					"desc" => "Check to turn off the flipping animation on mobiles only.",
					"id" => "flip_product_mobiles",
					"std" => 0,
					"type" => "checkbox");*/
					
$of_options[] = array( "name" => "Flipping Products Animation on Mobile Devices",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the flipping animation only for mobile devices.",
					"id" => "flip_product_mobiles",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'flip_product_mobiles_enabled.png',
						'1' => $url . 'flip_product_mobiles_disabled.png')
					);
					
/*$of_options[] = array( "name" => "Category in Product Listing",
					"desc" => "Check to hide the Category in Product Listing",
					"id" => "category_listing",
					"std" => 0,
					"type" => "checkbox");*/
					
$of_options[] = array( "name" => "Parent Category on Catalog Pages",
					"desc" => "<strong>Enable</strong> / <strong>Disable</strong> the parent category text label from catalog pages.",
					"id" => "category_listing",
					"std" => "0",
					"type" => "images",
					"options" => array(
						'0' => $url . 'category_listing_enabled.png',
						'1' => $url . 'category_listing_disabled.png')
					);
					
/*$of_options[] = array( "name" => "Products/Page in Product Listing",
					"desc" => "Enter the Number of Products per Page in Product Listing.",
					"id" => "products_per_page",
					"std" => "12",
					"type" => "text");	*/
					
$of_options[] = array( 	"name" 		=> "Number of Products per Catalog Page",
						"desc" 		=> "Drag the slider to set the number of products to be listed on the shop page and catalog pages.",
						"id" 		=> "products_per_page",
						"std" 		=> "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "48",
						"type" 		=> "sliderui"
				);
				
$of_options[] = array( "name" 		=> "Ratings on Catalog Pages",
						"desc" 		=> "<strong>Show</strong> / <strong>Hide</strong> the ratings meter on the products listed on shop pages.",
						"id" 		=> "ratings_on_product_listing",
						"std" 		=> 0,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);
				
$of_options[] = array( "name" 		=> "Product Reviews",
						"desc" 		=> "This option will globally <strong>Enable</strong> / <strong>Disable</strong> the product reviews feature on your shop.",
						"id" 		=> "reviews_on_product_page",
						"std" 		=> 1,
						"on" 		=> "Enabled",
						"off" 		=> "Disabled",
						"type" 		=> "switch"
				);
					
									


// My Account
$of_options[] = array( "name" => "My Account",
                    "type" => "heading");
					
$of_options[] = array( "name" => "Registration &#8212; Content",
					"desc" => "The registration text block displayed on the right side of the form.",
					"id" => "registration_content",
					"std" => "<h3>Your text here</h3>
<ul>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
</ul>",
					"type" => "textarea");
					
/*$of_options[] = array( "name" => "Register Button",
					"desc" => "The text on your registration button.",
					"id" => "registration_button",
					"std" => "Create an account",
					"type" => "text");*/
					
$of_options[] = array( "name" => "Login &#8212; Content",
					"desc" => "The login text block displayed on the right side of the form.",
					"id" => "login_content",
					"std" => "<h3>Your text here</h3>
<ul>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
</ul>",
					"type" => "textarea");
					
					





// Styling tab

$of_options[] = array( "name" => "Styling",
					"type" => "heading");
					
$of_options[] = array( "name" => "Logo",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Logo</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Upload Your Logo",
					"desc" => "The canvas for the logo is 270 x 100 px. <br />A retina ready image is double the size 540 x 200 px.",
					"id" => "site_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
									
$of_options[] = array( "name" => "Colors",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Colors</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Main Theme Color / Accent Color",
					"desc" => "Define the main/accent color for your theme. Several elements on the theme will automatically inherit the styling defined here.",
					"id" => "accent_color",
					"std" => "#b39964",
					"type" => "color");
					
$of_options[] = array( "name" => "Primary Font Color",
					"desc" => "Select a color for your Primary Font selected in the Typography section.",
					"id" => "primary_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "Header",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Header</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "<em>Header</em> &#8212; Background Color",
					"desc" => "The background color of the <em>Header</em>.",
					"id" => "header_bg_color",
					"std" => "#f4f4f4",
					"type" => "color");
					
$of_options[] = array( "name" => "<em>Main Navigation</em> &#8212; Text Color",
					"desc" => "The text color for the <em>Main Navigation</em>.",
					"id" => "primary_menu_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "<em>Secondary Navigation</em> &#8212; Text Color",
					"desc" => "The text color for the <em>Secondary Navigation</em>.",
					"id" => "secondary_menu_color",
					"std" => "#777",
					"type" => "color");
					
$of_options[] = array( "name" => "Footer",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Footer</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "'<em>Light Footer</em>' &#8212; Background Color",
					"desc" => "The background color of the <em>Light Footer</em>.",
					"id" => "primary_footer_bg_color",
					"std" => "#f4f4f4",
					"type" => "color");
					
$of_options[] = array( "name" => "'<em>Dark Footer</em> &#8212; Background Color",
					"desc" => "The background color of the <em>Dark Footer</em>.",
					"id" => "secondary_footer_bg_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "'<em>Dark Footer</em> &#8212; Text Color",
					"desc" => "The text color on the <em>Dark Footer</em>.",
					"id" => "secondary_footer_color",
					"std" => "#fff",
					"type" => "color");

					
$of_options[] = array( "name" => "'<em>Dark Footer</em> &#8212; Widget Title Border",
					"desc" => "Styles for the separator/line under the widget titles on the <em>Dark Footer</em>.",
					"id" => "secondary_footer_title_border",
					"std" => array('width' => '2','style' => 'solid','color' => '#3d3d3d'),
					"type" => "border");
					
$of_options[] = array( "name" => "'<em>Dark Footer</em> &#8212; List separators and borders",
					"desc" => "The color for list separators and borders on the <em>Dark Footer</em>.",
					"id" => "secondary_footer_borders_color",
					"std" => "#3d3d3d",
					"type" => "color");
					
$of_options[] = array( "name" => "<em>Copyright Bar</em> &#8212;  Background Color",
					"desc" => "The background color of the '<em>Copyright Bar'</em>, the area under the <em>Dark Footer</em>.",
					"id" => "copyright_bar_bg_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "<em>Dark Footer</em> / <em>Copyright Bar</em> &#8212; Separator Styles",
					"desc" => "Styles for the separator/line between the <em>Dark Footer</em> and the <em>Copyright Bar</em>.",
					"id" => "copyright_bar_top_border",
					"std" => array('width' => '2','style' => 'solid','color' => '#3d3d3d'),
					"type" => "border");
					
$of_options[] = array( "name" => "<em>Copyright Bar</em> &#8212;  Text Color",
					"desc" => "The text color on the <em>Copyright Bar</em>.",
					"id" => "copyright_text_color",
					"std" => "#a8a8a8",
					"type" => "color");	
					

$of_options[] = array( "name" => "Main Background",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Site Background Options</h4> * The following background options are available only if the <em>Main Layout</em> is set to use the <em>Boxed</em> layout option. This layout option can be enabled by navigationg to the <em>General</em> options tab.",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Background Color (<em>*for Boxed layout only</em>)",
					"desc" => "The main background color of the site if the <em>Boxed</em> layout style is enabled.",
					"id" => "main_bg_color",
					"std" => "#fff",
					"type" => "color");
					
$of_options[] = array( "name" => "Background Image (<em>*for Boxed layout only</em>)",
					"desc" => "Upload a background image or specify an image URL. Used if the <em>Boxed</em> layout style is enabled.",
					"id" => "main_bg",
					"std" => "",
					"type" => "media");					
					
					
$of_options[] = array( "name" => "Icons",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Icons</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Site Icons &#8212; Sprite",
					"desc" => "Upload your custom icons sprite.",
					"id" => "icons_sprite_normal",
					"std" => "",
					"mod" => "min",
					"type" => "upload");
					
$of_options[] = array( "name" => "Site Icons &#8212; Sprite (Retina)",
					"desc" => "Upload the retina version for your custom icons sprite.",
					"id" => "icons_sprite_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
					
					
					
					
					
					
// Typography tab
// removed
					


// Custom Code tab

$of_options[] = array( "name" => "Custom Code",
					"type" => "heading");
					
$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Paste your custom <strong>CSS</strong> code here.",
					"id" => "custom_css",
					"std" => ".add-your-own-classes-here {

}",
					"type" => "textarea"); 
					
$of_options[] = array( "name" => "Header JavaScript Code",
					"desc" => "Paste your custom <strong>JS</strong> code here. The code will be added to the header of your site.",
					"id" => "custom_js_header",
					"std" => '<script type="text/javascript">
					
//JavaScript goes here

</script>',
					"type" => "textarea");
					
$of_options[] = array( "name" => "Footer JavaScript Code",
					"desc" => "Here is the place to paste your <br /><strong>Google Analytics</strong> code or any other <strong>JS</strong> code you might want to add to be loaded in the footer of your website.",
					"id" => "custom_js_footer",
					"std" => '<script type="text/javascript">
					
//JavaScript goes here

</script>',
					"type" => "textarea");
					
					
					
					
// Backup Options tab
$of_options[] = array( "name" => "Backup",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
					
					
					
					
					
					
// Documentation tab
$of_options[] = array( "name" => "Help and Support",
					"type" => "heading");

$of_options[] = array( "name" => "Documentation Info",
					"desc" => "",
					"id" => "doc_info",
					"std" => "<p class=\"theretailer_theme_options_info_paragraph\"><img src='../wp-content/themes/theretailer/admin/assets/images/support_icon.png' /></p>",
					"icon" => true,
					"type" => "info");					
					
$of_options[] = array( "name" => "Theme Documentation",
					"desc" => "",
					"id" => "theme_documentation",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Theme Documentation</h4><p>Knowledge is Power! You can rely on the online <a href=\"http://theretailer.getbowtied.com/docs/\" target=\"_blank\">Theme Documentation &rarr;</a> as you move further with building your site. It covers all the steps of configuring the navigation, importing the dummy data, building the pages and so on.</p><p>Always feel free to get back to it. We update it as much as we can with valuable information whenever is needed. <a href=\"http://theretailer.getbowtied.com/docs/\" target=\"_blank\">theretailer.getbowtied.com/docs/ &rarr;</a></p>",
					"icon" => true,
					"type" => "info");	
									
$of_options[] = array( "name" => "Customer Support",
					"desc" => "",
					"id" => "customer_support",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Customer Support Forum</h4><p>If you cannot find your answer in the documentation file or if you have any problem while installing and configuring your theme, you can open ticket on our dedicated <a href=\"http://getbowtiedsupport.ticksy.com/\" target=\"_blank\">Support Forum</a>. Be descriptive about the issues you're experiencing and always provide a link to your site.</p><p>* <em>The ThemeForest purchase code is needed to access the Support Forum. <br />**Please note that we do not provide support for any custom changes and/or integration with 3rd party plugins or extensions.</em></p>",
					"icon" => true,
					"type" => "info");		
			
	}
}
?>
