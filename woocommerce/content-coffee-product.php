<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop, $theretailer_theme_options;

$attachment_ids = $product->get_gallery_attachment_ids();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

?>

	
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

        <li class="product_item">
        
        	<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
            
            <?php if ( !$product->is_in_stock() ) : ?>            
            	<div class="out_of_stock_badge_loop <?php if (!$product->is_on_sale()) : ?>first_position<?php endif; ?>"><?php _e( 'Out of stock', 'theretailer' ); ?></div>            
			<?php endif; ?>
        
            <div class="image_container">
                <a href="<?php the_permalink(); ?>">

                    <div class="loop_products_thumbnail_img_wrapper"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?></div>
                    
					<div class="info-overlay">
						<h4>Tasting Notes</h4>
						<?php
						$tastingNotes = explode(',', get_post_meta($post->ID, 'Tasting Notes', true));

						foreach($tastingNotes as $tastingNote){
						?>
							<span><?php echo $tastingNote; ?></span>
						<?php } ?>	
					</div>

                </a>
                <div class="clr"></div>
				
                <?php if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) { ?>
				
                <div class="product_button"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                <?php } ?>
            </div>
            
            <?php if ( (!$theretailer_theme_options['category_listing']) || ($theretailer_theme_options['category_listing'] == 0) ) { ?>
            <!-- Show only the first category-->
            <?php $gbtr_product_cats = strip_tags($product->get_categories('|||', '', '')); //Categories without links separeted by ||| ?>
            <h3><a href="<?php the_permalink(); ?>"><?php list($firstpart) = explode('|||', $gbtr_product_cats); echo $firstpart; ?></a></h3>
            <?php } ?>
            
            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
            
            <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_price - 10
                 */
                 
                do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        
        </li>
