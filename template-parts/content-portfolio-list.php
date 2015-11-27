<?php
/**
 * Template part for displaying portfolio posts as list.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

$post_classes = array( 'col-sm-6', 'col-md-4', 'project-block' );
$portfolio_types = wp_get_post_terms( get_the_id(), 'jetpack-portfolio-type' );

if ( ! empty( $portfolio_types ) && ! is_wp_error( $portfolio_types ) ) {
	foreach ( $portfolio_types as $type ) {
		$post_classes[] = 'cat-' . $type->slug;
	}
}

?>

<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?><?php pine_thumbnail_src(); ?>>
	<div class="project-block__content">
		<div class="project-block__inner">
			<?php the_title( '<h2>', '</h2>' ); ?>
			<?php the_excerpt(); ?>
		</div><!-- /.inner -->
	</div><!-- /.content -->
</a><!-- #post-## -->
