<?php
global $theretailer_theme_options;
global $woocommerce;
?>

<script type="text/javascript">// <![CDATA[
jQuery(function($){
	favicon.badge(<?php echo $woocommerce->cart->cart_contents_count; ?>);
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
</body>
</html>