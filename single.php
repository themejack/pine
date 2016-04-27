<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Pine
 */

get_header(); ?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<div class="post-hero<?php if ( has_post_thumbnail() ) : ?> post-hero--has-background<?php endif; ?>"<?php pine_thumbnail_src(); ?>>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php the_title( '<h2 class="post-hero__title">', '</h2>' ); ?>

					<?php pine_posted_on(); ?>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->

		<div class="post-hero__overlay"></div><!-- /.overlay -->
	</div><!-- /.post hero -->

	<div class="container animated fadeIn">
		<div class="row">
			<div class="<?php pine_main_classes(); ?>">

				<?php get_template_part( 'template-parts/content-single', get_post_format() ); ?>

				<?php the_post_navigation(); ?>

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

	<?php if ( in_array( get_post_type(), pine_get_portfolio_post_type() ) ) : ?>
	<div class="container project-back-container">
		<div class="row">
			<div class="col-lg-12">
				<a class="project-back-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to homepage', 'pine' ); ?></a>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container -->
	<?php endif; ?>

<?php endwhile; ?>

<?php get_footer();
