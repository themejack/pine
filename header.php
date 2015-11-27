<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pine
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pine' ); ?></a>

	<div class="offcanvas">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'main-nav', 'container' => false ) ); ?>
	</div><!-- /.offcanvas -->

	<header class="header animated bounceInDown">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<?php pine_logo(); ?>
				</div><!-- /.col -->

				<div class="col-xs-6">
					<button class="offcanvas-toggle">
						<span></span>
						<span></span>
						<span></span>
					</button><!-- /.main nav toggle -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</header><!-- /.header -->

	<?php if ( ! is_404() ) : ?>
	<div class="header-spacer"></div><!-- /.header spacer -->
	<?php endif; ?>

	<div id="content">
