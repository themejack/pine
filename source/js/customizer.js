/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

/* global less:true */

( function( $ ) {
	'use strict';

	var $header = $( '.header' );
	var $headerSpacer = $( '.header-spacer' );
	var $headerLogo = $( '.logo', $header );
	var $footerLogo = $( '.logo', '.footer' );
	var $offcanvas = $( '.offcanvas' );

	var adaptHeaderSpacerTimeout = null;
	var nothing = null;
	var $headerHeight = $header.outerHeight();
	var adaptHeaderSpacer = function() {
		if ( adaptHeaderSpacerTimeout !== null ) {
			clearTimeout( adaptHeaderSpacerTimeout );
		}

		setTimeout( function() {
			nothing = $header[0].offsetHeight;
			$headerHeight = $header.outerHeight();
			$headerSpacer.css( 'height', $headerHeight + 'px' );
			$offcanvas.css( 'top', $headerHeight + 'px' );
		}, 400 );
	};

	adaptHeaderSpacer();

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( 'a', $headerLogo.filter( '.site-title' ) ).text( to );
			$( '> a', $footerLogo ).text( to );
			adaptHeaderSpacer();
		} );
	} );

	function handleHeader() {
		$headerLogo.hide();
		if ( 'logo' === wp.customize( 'pine_header' ).get() ) {
			$headerLogo.filter( '.site-logo' ).show();
		} else {
			$headerLogo.filter( '.site-title' ).show();
		}

		adaptHeaderSpacer();
	}

	// Header
	wp.customize( 'pine_header', function( value ) {
		handleHeader();
		value.bind( handleHeader );
	} );

	// Header logo.
	wp.customize( 'pine_header_logo', function( value ) {
		value.bind( function( to ) {
			var $logo = $headerLogo.filter( '.site-logo' );
			$( 'img', $logo ).hide();
			if ( to ) {
				$( 'img:not(.default)', $logo ).attr( 'src', to ).show();
			}
			else {
				$( 'img.default', $logo ).show();
			}

			adaptHeaderSpacer();
		} );
	} );

	// Social buttons.
	wp.customize( 'pine_footer_social_buttons', function( value ) {
		value.bind( function( to ) {
			var socialButtons = '';
			$.each( to, function( i, socialButton ) {
				socialButtons += '<li class="' + socialButton.cssClass + '-ico social-nav__item btn--transition"><a class="social-nav__link" href="' + socialButton.url + '" title="' + socialButton.social + '" target="_blank"><i class="fa fa-' + ( socialButton.social + '' ).toLowerCase() + '"></i></a></li>\n';
			} );

			$( '.footer ul.social-nav' ).html( socialButtons );
		} );
	} );

	// Layout
	var getPageLayout = function() {
		var classes = $( 'body' ).attr( 'class' ).split( /\s+/ );
		var name = 'global';

		if ( $.inArray( 'archive', classes ) > -1 ) {
			name = 'archive';
		}

		if ( $.inArray( 'category', classes ) > -1 ) {
			name = 'category_archive';
		}

		if ( $.inArray( 'search', classes ) > -1 ) {
			name = 'search';
		}

		if ( $.inArray( 'error404', classes ) > -1 ) {
			name = '404';
		}

		if ( $.inArray( 'single', classes ) > -1 ) {
			name = 'single';
		}

		if ( $.inArray( 'page', classes ) > -1 ) {
			name = 'page';
		}

		if ( ( $.inArray( 'blog', classes ) > -1 && 'page' === wp.customize( 'show_on_front' ).get() ) || ( $.inArray( 'home', classes ) > -1 && 'page' !== wp.customize( 'show_on_front' ).get() ) ) {
			name = 'blog';
		}

		return wp.customize( 'pine_' + name + '_layout' ).get();
	};

	var $main = $( '.pine-main-class' ),
			$sidebar = $( '.pine-sidebar-class' );

	var handleLayout = function() {
		if ( ! $main.length || !$sidebar.length ) {
			return;
		}

		var pageLayout = getPageLayout();

		if ( pageLayout === 'disabled' ) {
			pageLayout = wp.customize( 'pine_global_layout' ).get();
		}

		$main.removeClass( 'col-md-12 col-md-8 col-md-push-4' );
		$sidebar.removeClass( 'col-md-pull-8' );

		if ( 'none' === pageLayout ) {
			$main.addClass( 'col-md-12' );
			$sidebar.hide();
		}
		else {
			$main.addClass( 'col-md-8' );
			if ( 'left' === pageLayout ) {
				$main.addClass( 'col-md-push-4' );
				$sidebar.addClass( 'col-md-pull-8' );
			}

			$sidebar.show();
		}

		$( window ).trigger( 'resize' );
	};

	var handleLayoutChange = function( value ) {
		value.bind( handleLayout );
	};

	wp.customize( 'pine_global_layout', handleLayoutChange );
	wp.customize( 'pine_blog_layout', handleLayoutChange );
	wp.customize( 'pine_archive_layout', handleLayoutChange );
	wp.customize( 'pine_category_archive_layout', handleLayoutChange );
	wp.customize( 'pine_search_layout', handleLayoutChange );
	wp.customize( 'pine_404_layout', handleLayoutChange );
	wp.customize( 'pine_single_layout', handleLayoutChange );
	wp.customize( 'pine_pageLayout', handleLayoutChange );

	wp.customize( 'show_on_front', handleLayoutChange );

	$( document ).on( 'ready', handleLayout );
	$( document ).on( 'click', 'a', handleLayout );


	/* Colors */
	/*function lighten( color, amount ) {
		color = new less.tree.Color( color.replace( '#', '' ) );
		amount = new(less.tree.Dimension)( amount, '%' );

		return less.functions.functionRegistry._data.lighten( color, amount ).toRGB();
	}*/

	function darken( color, amount ) {
		amount = new(less.tree.Dimension)( amount, '%' );
		return less.functions.functionRegistry._data.darken( color, amount );
	}

	function fade( color, amount ) {
		amount = new(less.tree.Dimension)( amount, '%' );

		return less.functions.functionRegistry._data.fade( color, amount );
	}

	function LessToRGBA( color ) {
		return 'rgba(' + Math.round( color.rgb[0] ) + ',' + Math.round( color.rgb[1] ) + ',' + Math.round( color.rgb[2] ) + ',' + color.alpha + ')';
	}

	function HexToLess( color ) {
		return new less.tree.Color( color.replace( '#', '' ) );
	}

	var schemes = {
		'red': '#e74c3c',
		'blue': '#2980b9',
		'green': '#27ae60',
		'orange': '#e67e22',
		'purple': '#9b59b6',
		'yellow': '#f1c40f'
	};

	function updateStyle() {
		var currentScheme = wp.customize( 'pine_scheme' ).get();
		if ( ! schemes[ currentScheme ] ) {
			currentScheme = 'red';
		}

		var styleOutput;
		var styles = [];

		var color = schemes[ currentScheme ];

		/* ----- Links ----- */
		styles.push( 'a{ color: ' + color + '; }' );
		styles.push( 'a:hover, a:focus{ color: ' + color + '; }' );

		/* ----- Projects category toggle ----- */
		styles.push( '.projects-cat-toggle li:focus, .projects-cat-toggle li:hover{ color: ' + color + '; }' );
		styles.push( '.projects-cat-toggle li.tabs-nav__item--active{ color: ' + color + '; border-color: ' + color + '; }' );

		/* ----- Project list ----- */
		styles.push( '.project-block:hover .project-block__content, .project-block:focus .project-block__content{ background-color: ' + LessToRGBA( darken( fade( HexToLess( color ), 70 ), 13 ) ) + '; }' );

		/* ----- Post formats ----- */
		styles.push( '.mejs-container, .mejs-embed, .mejs-embed body, .mejs-container .mejs-controls{ background: ' + color + ' !important; }' );

		/* ----- Sticky post ----- */
		styles.push( '.sticky:after{ background-color: ' + color + '; }' );

		/* ----- Comments ----- */
		styles.push( '.bypostauthor, .bypostauthor .comment-meta{ border-color: ' + color + '; }' );


		styleOutput = styles.join( '\n' );

		$( 'style#customize-preview-style' ).html( styleOutput );
	}

	$( document ).on( 'ready', updateStyle );
	wp.customize( 'pine_scheme', function( value ) {
		value.bind( updateStyle );
	} );
} )( jQuery );
