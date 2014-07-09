<?php
global $theretailer_theme_options;
global $woocommerce;
?>

<script type="text/javascript">// <![CDATA[
jQuery(function($){
	<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
		//favicon.badge(<?php echo $woocommerce->cart->cart_contents_count; ?>);
	<?php endif; ?>
});// ]]>
</script>
    
    <div class="gbtr_footer_wrapper">
        
        <div class="container_12">
            <div class="grid_12 bottom_wrapper">
                <div class="gbtr_footer_widget_copyrights">
                    <?php echo $theretailer_theme_options['copyright_text']; ?>
                </div>
                <div class="gbtr_footer_widget_copyrights_supplemental"><?php echo $theretailer_theme_options['copyright_supplemental_text']; ?></div>
                <div class="clr"></div>
            </div>
        </div>
        
    </div>
    
    </div><!-- /global_wrapper -->

    <!-- ******************************************************************** -->
    <!-- *********************** Custom Javascript ************************** -->
    <!-- ******************************************************************** -->
    
    <?php echo $theretailer_theme_options['custom_js_footer']; ?>
    
    <!-- ******************************************************************** -->
    <!-- ************************ WP Footer() ******************************* -->
    <!-- ******************************************************************** -->
	
<?php wp_footer(); ?>


<?php if(is_wholesale_template()){ ?>
	<script src="<?php echo wp_make_link_relative(get_stylesheet_directory_uri()); ?>/js/wholesaleorders.js"></script>
<?php } ?>	

<script src="<?php echo wp_make_link_relative(get_stylesheet_directory_uri()); ?>/js/srcset.min.js"></script>
<script src="<?php echo wp_make_link_relative(get_stylesheet_directory_uri()); ?>/js/ps.js"></script>


</body>
</html>