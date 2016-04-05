<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

get_header(); ?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<div class="post-hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php the_title( '<h2>', '</h2>' ); ?>

					<?php pine_posted_on(); ?>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->

		<div class="post-hero__overlay"></div><!-- /.overlay -->
	</div><!-- /.post hero -->

	<div class="container animated fadeIn">
		<div class="row">
			<div class="<?php pine_main_classes(); ?>">

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div><!-- /.col -->

			<?php get_sidebar(); ?>
		</div><!-- /.row -->
	</div><!-- /.container -->

<?php endwhile; ?>

<?php get_footer();
