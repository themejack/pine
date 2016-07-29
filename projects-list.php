<?php
/**
 * Template Name: Projects list
 *
 * @package Pine
 */

get_header();

if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
?>

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) :
		the_post();

		$page_title = get_the_title();
		$page_content = get_the_content();
	?>

	<?php if ( has_post_thumbnail() || ! empty( $page_title ) || ! empty( $page_content ) ) : ?>
	<div class="<?php if ( has_post_thumbnail() ) : ?>hero-subheader <?php endif; ?>animated fadeIn"<?php pine_thumbnail_src(); ?>>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8">
					<div class="featured-intro">
						<?php the_title( '<h2>', '</h2>' ); ?>
						<?php the_content(); ?>
					</div><!-- /.featured intro -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="hero-subheader__overlay"></div><!-- /.overlay -->
		<?php endif; ?>
	</div><!-- /.hero subheader -->
	<?php endif; ?>

	<?php endwhile; ?>

	<div class="projects-list animated bounceInUp">
		<div class="projects-list-options">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<ul class="projects-cat-toggle clearfix">
							<li data-filter="*" class="tabs-nav__item--active"><?php esc_html_e( 'All', 'pine' ); ?></li>
							<?php
							$pine_terms = get_terms( pine_get_portfolio_taxonomy() );

							if ( ! empty( $pine_terms ) && ! is_wp_error( $pine_terms ) ) :

								foreach ( $pine_terms as $term ) : ?>
							<li data-filter="<?php echo esc_attr( '.cat-' . $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></li>
							<?php endforeach;

							endif; ?>
						</ul><!-- /.projects cat toggle -->

						<ul class="projects-type-nav hidden-xs hidden-sm">
							<li class="projects-type-nav__item--active project-type-nav__grid"><i class="fa fa-th-large"></i></li>
							<li class="project-type-nav__list"><i class="fa fa-list-ul"></i></li>
						</ul><!-- /.projects type nav -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div>

		<div class="container">
			<div class="projects-block__list">
				<div class="col-lg-12" id="main">
				<?php
					$pine_args = array(
						// Type Parameters.
						'post_type' 			=> pine_get_portfolio_post_type(),

						// Pagination Parameters.
						'posts_per_page' 	=> pine_get_portfolio_posts_per_page(),
						'paged' 					=> $paged,

						// Permission Parameters.
						'perm' 						=> 'readable',

						// Parameters relating to caching.
						'no_found_rows' 	=> false,
						'cache_results' 	=> true,
					);

					$wp_query = new WP_Query( $pine_args );

					add_filter( 'excerpt_length', 'pine_excerpt_length', 999 );

					if ( have_posts() ) :

						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'portfolio-list' );

						endwhile;

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;

					remove_filter( 'excerpt_length', 'pine_excerpt_length' );
				?>
				</div><!-- /.col -->
			</div><!-- /.projects block list -->
			<?php if ( have_posts() ) : ?>
			<div class="row">
				<div class="col-lg-12">
					<?php pine_posts_pagination(); ?>
				</div><!-- /.col -->
			</div><!-- /.row -->
			<?php endif; ?>
		</div><!-- /.container -->
	</div><!-- /.projects list -->

	<?php wp_reset_postdata(); ?>

<?php get_footer();
