<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<div class="featured-intro animated fadeIn">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8">
					<?php the_archive_title( '<h2>', '</h2>' ); ?>
					<?php the_archive_description( '<p>', '</p>' ); ?>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.featured intro -->

	<div class="container">
		<div class="row">
			<div class="<?php pine_main_classes(); ?>">
				<div class="post-list animated bounceInUp" id="main">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					?>

					<?php endwhile; ?>

					<?php pine_posts_navigation(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>
				</div><!-- /.post list -->
			</div><!-- /.col -->

			<?php get_sidebar(); ?>
		</div><!-- /.row -->
	</div><!-- /.container -->

<?php get_footer();
