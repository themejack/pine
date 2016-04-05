<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>
	<?php wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pine' ),
		'after'  => '</div>',
	) ); ?>
	<?php edit_post_link( esc_html__( 'Edit', 'pine' ), '<span class="edit-link">', '</span>' ); ?>
</article><!-- #post-## -->
