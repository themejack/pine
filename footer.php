<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pine
 */

?>

	</div><!-- #content -->
<?php if ( ! is_404() ) : ?>

	<footer class="footer">
		<div class="container">
			<div class="row">
				<?php $social_icons = pine_get_social_icons();
					$copyright_class = ! empty( $social_icons ) ? 'col-sm-6' : 'col-sm-12';
				?>
				<div class="<?php echo sanitize_html_class( $copyright_class ); ?>">
					<h1 class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						<p><?php printf( esc_html__( '%1$s &copy; %2$s. - Created by %3$s.', 'pine' ), esc_html( get_bloginfo( 'name' ) ), esc_html( date( 'Y' ) ), '<a href="http://slicejack.com" rel="designer">Slicejack</a>' ); ?></p>
					</h1><!-- /.logo -->
				</div><!-- /.col -->

				<?php if ( ! empty( $social_icons ) ) : ?>
				<div class="col-sm-6">
					<?php pine_social_icons( $social_icons ); ?>
				</div><!-- /.col -->
				<?php endif; ?>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</footer><!-- /.footer -->

<div class="gradient"></div><!-- /.gradient -->

<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
