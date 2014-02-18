<?php
/*
Template Name: PS Login page
*/

global $theretailer_theme_options;
global $woocommerce;
global $wp_query;

$archive_product_sidebar = 'no';

if ( ($theretailer_theme_options['sidebar_listing']) && ($theretailer_theme_options['sidebar_listing'] == 1) ) { $archive_product_sidebar = 'yes'; };

if (isset($_GET["product_listing_sidebar"])) { $archive_product_sidebar = $_GET["product_listing_sidebar"]; }

get_header('shop'); 

?>

<div class="global_content_wrapper">

<div id="login-page" class="container_12">

    <div class="grid_12">
		
	    <header class="entry-header">
			<?php if (!is_front_page()) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
	        <?php endif ?>        
		</header>
		
		
	    <div class="entry-content">
			<div class="content_wrapper">
				<div class="woocommerce">

					<div class="gbtr_login_register_wrapper">

					    <div class="gbtr_login_register_slider">    

							<div class='gbtr_login_register_slide_1'>

					            <h2><?php _e( 'Login', 'theretailer' ); ?></h2>
								
								<?php
									$redirectUrl = home_url();
									if(!empty($_GET['loginredirect'])){
										$redirectUrl = $_GET['loginredirect'];
									}
									$args = array(
									        'echo'           => true,
									        'redirect'       => $redirectUrl,
									        'form_id'        => 'ps-loginform',
									        'label_username' => __( 'Username' ),
									        'label_password' => __( 'Password' ),
									        'label_remember' => __( 'Remember Me' ),
									        'label_log_in'   => __( 'Log In' ),
									        'id_username'    => 'user_login',
									        'id_password'    => 'user_pass',
									        'id_remember'    => 'rememberme',
									        'id_submit'      => 'wp-submit',
									        'remember'       => true,
									        'value_username' => NULL,
									        'value_remember' => false
									);
									wp_login_form( $args ); 
								?>
								
					        </div>

							<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

					        <div class='gbtr_login_register_slide_2'>

					            <h2><?php _e( 'Register', 'theretailer' ); ?></h2>

					            <form method="post" class="register">

					                <?php do_action( 'woocommerce_register_form_start' ); ?>

					                <?php if ( get_option( 'woocommerce_registration_generate_username' ) == 'no' ) : ?>

					                    <p class="form-row form-row-wide">
					                        <label for="reg_username"><?php _e( 'Username', 'theretailer' ); ?> <span class="required">*</span></label>
					                        <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) esc_attr_e($_POST['username']); ?>" />
					                    </p>

					                <?php endif; ?>

					                <p class="form-row form-row-wide">
					                    <label for="reg_email"><?php _e( 'Email address', 'theretailer' ); ?> <span class="required">*</span></label>
					                    <input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) esc_attr_e($_POST['email']); ?>" />
					                </p>

					                <p class="form-row form-row-wide">
					                    <label for="reg_password"><?php _e( 'Password', 'theretailer' ); ?> <span class="required">*</span></label>
					                    <input type="password" class="input-text" name="password" id="reg_password" value="<?php if ( ! empty( $_POST['password'] ) ) esc_attr_e( $_POST['password'] ); ?>" />
					                </p>

					                <!-- Spam Trap -->
					                <div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'theretailer' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

					                <?php do_action( 'woocommerce_register_form' ); ?>
					                <?php do_action( 'register_form' ); ?>

					                <p class="form-row">
					                    <?php wp_nonce_field( 'woocommerce-register', 'register') ?>
					                    <input type="submit" class="button" name="register" value="<?php _e( 'Register', 'theretailer' ); ?>" />
					                </p>

					                <?php do_action( 'woocommerce_register_form_end' ); ?>

					            </form>

					        </div>

					        <?php endif; ?>

						</div>

					</div> <!-- gbtr_login_register_wrapper -->
				
				
					<div class="gbtr_login_register_switch">
					    <div class="gbtr_login_register_label_slider">
					        <div class="gbtr_login_register_reg">
					        	<h2><?php _e('Register', 'theretailer'); ?></h2>
					            <?php echo $theretailer_theme_options['registration_content']; ?>
					            <input type="submit" class="button" name="create_account" value="<?php _e('Register', 'theretailer'); ?>">
					        </div>
					        <div class="gbtr_login_register_log">
					        	<h2><?php _e("I'm a Returning Customer", "theretailer"); ?></h2>
					            <?php echo $theretailer_theme_options['login_content']; ?>
					            <input type="submit" class="button" name="create_account" value="<?php _e('Login', 'theretailer'); ?>">
					        </div>
					    </div>
					</div><!-- gbtr_login_register_switch -->

					<div class="clr"></div>
				
				</div>
			</div>
		</div>	
	</div>

</div>

</div>


<?php if ( isset($_POST["gbtr_login_register_section_name"]) && $_POST["gbtr_login_register_section_name"] == "register") { ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery(document).ready(function($) {
	 $('.gbtr_login_register_slider').animate({
		left: '-500',
	 }, 0, function() {
		// Animation complete.
	 });
	 
	 $('.gbtr_login_register_wrapper').animate({
		height: $('.gbtr_login_register_slide_2').height() + 100
	 }, 0, function() {
		// Animation complete.
	 });
	 
	 $('.gbtr_login_register_label_slider').animate({
		top: '-500',
	 }, 0, function() {
		// Animation complete.
	 });
});
//--><!]]>
</script>

<?php } ?>

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<?php get_footer('shop'); ?>