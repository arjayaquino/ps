<?php
/*
Template Name: Wholesale Order Page
*/

global $theretailer_theme_options;
global $woocommerce;
global $wp_query;

$archive_product_sidebar = 'no';

if ( ($theretailer_theme_options['sidebar_listing']) && ($theretailer_theme_options['sidebar_listing'] == 1) ) { $archive_product_sidebar = 'yes'; };

if (isset($_GET["product_listing_sidebar"])) { $archive_product_sidebar = $_GET["product_listing_sidebar"]; }

get_header('shop'); 


$wholesaleCategoriesEnabled = explode(',', preg_replace('/\s+/', '', get_post_meta($post->ID, 'wholesale_orders_categories', true)));
$args = array(
    'number'     => $number,
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
    'include'    => $ids
);

$product_categories = get_terms('product_cat', $args );

$checkout_url = $woocommerce->cart->get_checkout_url();

?>

<div id="wholesale-content" class="container_12" data-checkouturl="<?php echo $checkout_url; ?>">
	
		<!-- CATEGORY SIDE MENU -->
        <div class="grid_3">
            <div class="gbtr_aside_column_left">
				<div class="widget woocommerce widget_product_categories">
					<h4 class="widget-title">Categories</h4>
					<ul class="product-categories">
						<?php
						foreach($product_categories as $cat ) {
							if(in_array($cat->slug, $wholesaleCategoriesEnabled)){
								echo '<li class="cat-item">'.
									'<input type="checkbox" name="'. $cat->slug .'" id="'. $cat->slug .'"/>'.
									'<label for="'. $cat->slug .'" >'. $cat->name . '</label>'.
									'</li>';
							}
						}
						?>
					</ul>	
				</div>
            </div>
        </div>            
		
		<!-- MAIN AREA -->
		<div class="grid_9">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>				
                <div class="hr padding30 fixbottom10"></div>
			</header>
			
			<div id="wholesale-category-container">
				
				<?php
				foreach($product_categories as $cat ) {
					if(in_array($cat->slug, $wholesaleCategoriesEnabled)){
						echo do_shortcode('[wholesale_category_listing category="'. $cat->slug .'" title="'. $cat->name .'"]');
					}
				}
				?>
				
			</div>
			
			<p class="form-button-bar">
				<button type="submit" class="button" id="placeorder">Place Order</button>
			</p>
		</div>
	
</div>

<?php get_footer('shop'); ?>