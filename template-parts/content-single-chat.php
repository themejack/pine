<?php
/**
 * Template part for displaying single post format Chat.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

add_filter( 'the_excerpt', 'pine_parse_chat_content', 1, 1 );
add_filter( 'the_content', 'pine_parse_chat_content', 1, 1 );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>

	<?php wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pine' ),
		'after'  => '</div>',
	) ); ?>
</article><!-- #post-## -->
<?php

remove_filter( 'the_excerpt', 'pine_parse_chat_content', 1 );
remove_filter( 'the_content', 'pine_parse_chat_content', 1 );
