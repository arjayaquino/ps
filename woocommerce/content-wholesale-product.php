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

        <li class="wholesale-product cf">
            <div class="product-info bbs">
                <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
	            <?php
					//show price only for cafe
					if(current_user_can("order_wholesale_cafe")){
			            do_action( 'woocommerce_after_shop_loop_item_title' );
					}
	            ?>
            </div>
        	
			<div class="product-actions bbs">
				<?php do_action( 'woocommerce_' . $product->product_type . '_add_to_cart'  ); ?>
				
			</div>
        </li>