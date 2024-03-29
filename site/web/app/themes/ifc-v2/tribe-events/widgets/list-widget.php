<?php
/**
 * Events List Widget Template
 * This is the template for the output of the events list widget.
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is needed.
 *
 * This view contains the filters required to create an effective events list widget view.
 *
 * You can recreate an ENTIRELY new events list widget view by doing a template override,
 * and placing a list-widget.php file in a tribe-events/widgets/ directory
 * within your theme directory, which will override the /views/widgets/list-widget.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @return string
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

//Check if any posts were found
if ( $posts ) {
	?>
		<ul class="list-unstyled">
			<?php foreach ($posts as $post): setup_postdata($post); ?>
				<li class="tribe-events-list-widget-events <?php tribe_events_event_classes() ?>">
					<article>
						<span class="text-muted">[<?php echo tribe_get_start_date($post->ID, false, 'd/m/Y'); ?>]</span>&nbsp;
						<?php
							$terms = get_the_terms($post->ID, 'tribe_events_cat');
							if ( $terms && ! is_wp_error( $terms ) ) : 
								$categories = array();
							
								foreach ( $terms as $term ) {
									$categories[] = '<span class="label label-default"><a href="' . get_term_link($term) . '">' . $term->name . '</a></span>';
								}
													
								$notice_categories = join('&nbsp;', $categories);
							endif;
							echo $notice_categories;
						?>&nbsp;       
					
						<h2><a href="<?php echo tribe_get_event_link(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					</article>
				</li>
			<?php endforeach; ?>
		</ul><!-- .hfeed -->
	<?php
} else {
	?>
		<p>Sem eventos cadastradas.</p>
	<?php
}
?>
