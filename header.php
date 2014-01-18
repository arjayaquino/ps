<?php
global $woo_options;
global $woocommerce;
global $theretailer_theme_options;
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]--><head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- ******************************************************************** -->
<!-- ******************** Custom Retina Favicon ************************* -->
<!-- ******************************************************************** -->

<link rel="apple-touch-icon-precomposed" href="<?php if ($theretailer_theme_options['favicon_retina']) { echo wp_make_link_relative($theretailer_theme_options['favicon_retina']); ?>
<?php } else { ?><?php echo wp_make_link_relative(get_template_directory_uri()); ?>/apple-touch-icon-precomposed.png<?php } ?>" />

<!-- ******************************************************************** -->
<!-- ************************ Custom Favicon **************************** -->
<!-- ******************************************************************** -->

<link rel="shortcut icon" href="<?php if ($theretailer_theme_options['favicon_image']) { echo wp_make_link_relative($theretailer_theme_options['favicon_image']); ?>
<?php } else { ?><?php echo wp_make_link_relative(get_template_directory_uri()); ?>/favicon.png<?php } ?>" />

<!-- ******************************************************************** -->
<!-- *********************** Custom Javascript ************************** -->
<!-- ******************************************************************** -->

<?php echo $theretailer_theme_options['custom_js_header']; ?>

<!-- ******************************************************************** -->
<!-- *********************** WordPress wp_head() ************************ -->
<!-- ******************************************************************** -->
	
<?php wp_head(); ?>

<!-- *********************** cloud fonts ******************************** -->
<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6070052/774662/css/fonts.css" />

</head>

<!-- *********************************************************************** -->
<!-- ********************* EVERYTHING STARTS HERE ************************** -->
<!-- *********************************************************************** -->

<body <?php body_class(); ?>>
    
    <div id="global_wrapper">

        <div class="gbtr_header_wrapper">
            <?php if ( (!$theretailer_theme_options['hide_topbar']) || ($theretailer_theme_options['hide_topbar'] == 0) ) { ?>
                <?php include_once('header_topbar.php'); ?>    
            <?php } ?>
            
            <?php include_once('header_style_default.php'); ?>
        </div>
        <div class="main_content_wrap">
  


