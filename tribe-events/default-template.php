<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template' 
 * is selected in Events -> Settings -> Template -> Events Template.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

get_header(); ?>

<div id="tribe-events-pg-template" class="container_12">
	
    <div class="grid_12">

		<?php tribe_events_before_html(); ?>
		<?php tribe_get_view(); ?>
		<?php tribe_events_after_html(); ?>
	</div>
	
</div> <!-- #tribe-events-pg-template -->

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>