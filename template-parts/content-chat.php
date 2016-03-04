<?php
/**
 * Template part for displaying post format Chat.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pine
 */

add_filter( 'the_excerpt', 'pine_parse_chat_content', 1, 1 );
add_filter( 'the_content', 'pine_parse_chat_content', 1, 1 );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="post-item__image"<?php pine_thumbnail_src( 'pine-column-full' ); ?>></a>
	<?php
	endif; ?>

	<?php the_title( sprintf( '<h2 class="post-item__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php if ( 'post' === get_post_type() ) : ?>
		<?php pine_posted_on(); ?>
	<?php endif; ?>

	<div class="post-item__content">
		<?php the_content( sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Read more %s', 'pine' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) ); ?>
	</div>

	<?php wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pine' ),
		'after'  => '</div>',
	) ); ?>
</article><!-- #post-## -->
<?php

remove_filter( 'the_excerpt', 'pine_parse_chat_content', 1 );
remove_filter( 'the_content', 'pine_parse_chat_content', 1 );
