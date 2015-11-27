<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pine
 */

$sidebar_classes = pine_sidebar_classes( array(), false );

if ( ! is_active_sidebar( 'sidebar-1' ) || null === $sidebar_classes ) {
	return;
}
?>

<div class="<?php echo esc_attr( join( ' ', $sidebar_classes ) ); ?>">
	<div class="sidebar animated bounceInUp">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- /.sidebar -->
</div><!-- /.col -->
