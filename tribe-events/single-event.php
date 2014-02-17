<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_id = get_the_ID();

?>
<div itemscope itemtype="http://schema.org/Product" class="product">	
	
	<?php while ( have_posts() ) :  the_post(); ?>
		
	<!-- main infos -->
    <div class="product_main_infos">
		
		<div class="product_navigation mobiles">
			<div class="nav-back">&lsaquo;&nbsp;&nbsp;&nbsp;Back to <a href="<?php echo tribe_get_events_link() ?>"><?php _e( 'All Events', 'tribe-events-calendar' ) ?></a></div>
			<div class="nav-next-single"><?php tribe_the_next_event_link( '&nbsp;' ); ?></div>
			<div class="nav-previous-single"><?php tribe_the_prev_event_link( '&nbsp;' ); ?></div>
			<div class="clr"></div>
		</div>
		
		
        <div class="gbtr_poduct_details_left_col">
			<?php echo tribe_event_featured_image(); ?>
        </div>
		
        <div class="gbtr_poduct_details_right_col">
            <div class="product_navigation desktops">
				<div class="nav-back">&lsaquo;&nbsp;&nbsp;&nbsp;Back to <a href="<?php echo tribe_get_events_link() ?>"><?php _e( 'All Events', 'tribe-events-calendar' ) ?></a></div>
				<div class="nav-next-single"><?php tribe_the_next_event_link( '&nbsp;' ); ?></div>
				<div class="nav-previous-single"><?php tribe_the_prev_event_link( '&nbsp;' ); ?></div>
				<div class="clr"></div>
			</div>
			
            <div class="summary">
	
				<?php tribe_events_the_notices() ?>
				
				<div class="grtr_product_header_desktops">
				    <?php the_title( '<h1 itemprop="name" class="product_title entry-title">', '</h1>' ); ?>
			    </div>
			
				<h3><?php echo tribe_events_event_schedule_details(); ?></h3
					>
				<div itemprop="description" class="entry-content gbtr_product_description">
					<?php the_content(); ?>
				</div>
				
				<!-- TICKETS -->
				<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
			</div>
		</div>
		
		<div class="clr"></div>
		
	</div><!-- /main infos -->
	
	<div class="clr"></div>
	
	<div class="event-info-bar cf">
		<?php echo tribe_get_meta_group( 'tribe_event_details' ); ?>
		<?php echo tribe_get_meta_group( 'tribe_event_venue' ); ?>
		<?php echo tribe_get_meta_group( 'tribe_event_organizer' ); ?>
	</div>
	
	<div class="event-map-bar">
	<?php
		if(tribe_embed_google_map( $event_id )){
			echo tribe_get_meta( 'tribe_venue_map' );
		}
	?>
	</div>
	
	<?php endwhile; ?>
	
</div>
