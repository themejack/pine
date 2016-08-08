<?php
/**
 * Template part for displaying portfolio posts as list.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

$post_classes = array( 'col-sm-6', 'col-md-4', 'project-block' );
$portfolio_taxonomies = pine_get_portfolio_taxonomy();

foreach ( $portfolio_taxonomies as $tax ) {
	$portfolio_types = get_the_terms( get_the_id(), $tax );

	if ( ! empty( $portfolio_types ) && ! is_wp_error( $portfolio_types ) ) {
		foreach ( $portfolio_types as $type ) {
			$post_classes[] = 'cat-' . $type->slug;
		}
	}
}

?>

<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?><?php pine_thumbnail_src( 'pine-project-list' ); ?>>
	<div class="project-block__content">
		<div class="project-block__inner">
			<?php the_title( '<h2>', '</h2>' ); ?>
			<?php the_excerpt(); ?>
		</div><!-- /.inner -->
	</div><!-- /.content -->
</a><!-- #post-## -->
