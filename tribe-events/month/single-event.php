<?php 
/**
 * Month Single Event
 *
 * Customized to add WooCommerce Tickets (WooTickets) "Sold out!" notices. Builds on a number of functions (below)
 * which should already be added to functions.php if this is to work.
 * 
 * Essentially just adds a wootickets_list_view_sold_out() call within h3.tribe-events-month-event-title.summary,
 * otherwise it is untouched from the original.
 *
 * @uses tribe_has_wootickets()
 * @see http://pastebin.com/hPS9nwft
 *
 * @uses get_wooticket_products()
 * @see http://pastebin.com/csuqeikG
 *
 * @uses wootickets_list_view_sold_out()
 * @see http://pastebin.com/A64F10uC
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 

global $post;
$day = tribe_events_get_current_month_day();
$event_id = "{$post->ID}-{$day['daynum']}";
$start = tribe_get_start_date( $post, FALSE, 'U' );
$end = tribe_get_end_date( $post, FALSE, 'U' );

?>

<div id="tribe-events-event-<?php echo $event_id ?>" class="<?php tribe_events_event_classes() ?>">
	<h3 class="tribe-events-month-event-title summary">
		<a href="<?php tribe_event_link( $post ); ?>" class="url">
			<?php the_title() ?>
		</a> 
		<?php wootickets_list_view_sold_out() ?>
	</h3>
	</h3>
	<div id="tribe-events-tooltip-<?php echo $event_id; ?>" class="tribe-events-tooltip">
		<h4 class="summary"><?php the_title() ?> <?php echo wootickets_list_view_sold_out() ?> </h4>
		<div class="tribe-events-event-body">

			<?php echo tribe_events_event_schedule_details() ?>
			
			<?php if (has_post_thumbnail() ) : ?>
				<div class="tribe-events-event-thumb"><?php echo the_post_thumbnail(array(90,90));?></div>
			<?php endif; ?>

			<p class="entry-summary description">
				<?php echo get_the_excerpt() ?>
			</p><!-- .entry-summary -->

		</div><!-- .tribe-events-event-body -->
		<span class="tribe-events-arrow"></span>
	</div><!-- .tribe-events-tooltip -->
</div><!-- #tribe-events-event-# -->