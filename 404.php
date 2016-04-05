<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Pine
 */

get_header(); ?>

	<div class="error-404">
		<div class="error-404__outer">
			<div class="error-404__middle">
				<h2><?php esc_html_e( 'Don\'t fall down!', 'pine' ); ?><br /><?php printf( esc_html__( 'Come back to %s.', 'pine' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Homepage', 'pine' ) . '</a>' ); ?></h2>

				<p><?php esc_html_e( 'It\'s looking like you may have taken a wrong turn.', 'pine' ); ?><br /><?php esc_html_e( 'Don\'t worry, it happens to the best of us.', 'pine' ); ?></p>
			</div><!-- /.middle -->
		</div><!-- /.outer -->

		<div class="error-404__overlay"></div><!-- /.overlay -->
	</div><!-- /.error 404 -->

<?php get_footer();
