<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package theretailer
 * @since theretailer 1.0
 */

get_header(); ?>
<div class="container_12">

    <div class="grid_12">

		<section id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'theretailer' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php theretailer_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title gbtr_post_title_listing"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'theretailer' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>      
                        </header><!-- .entry-header -->
                        
   						<div class="search-thumbnail">
				            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
				        </div>
				
                        <div class="search-excerpt">
							<?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Read More</a>
						</div><!-- .entry-content -->
						
                    </article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>
				
				<?php  
					if (function_exists("emm_paginate")) {
                        emm_paginate();
                    }
				?>
				<?php theretailer_content_nav( 'nav-below' ); ?>

			<?php else : ?>
				
				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

	</div>
    
</div>

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>