/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	var $header = $( '.header' );
	var $header_spacer = $( '.header-spacer' );
	var $header_logo = $( '.logo', $header );
	var $footer_logo = $( '.logo', '.footer' );
	var $offcanvas = $( '.offcanvas' );

	var adapt_header_spacer_timeout = null;
	var nothing = null;
	var $header_height = $header.outerHeight();
	var adapt_header_spacer = function() {
		if ( adapt_header_spacer_timeout !== null )
			clearTimeout( adapt_header_spacer_timeout );

		setTimeout( function() {
			nothing = $header[0].offsetHeight;
			$header_height = $header.outerHeight();
			$header_spacer.css( 'height', $header_height + 'px' );
			$offcanvas.css( 'top', $header_height + 'px' );
		}, 400 );
	};

	adapt_header_spacer();

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( 'a', $header_logo.filter( '.site-title' ) ).text( to );
			$( '> a', $footer_logo ).text( to );
			adapt_header_spacer();
		} );
	} );

	function handle_header() {
		$header_logo.hide();
		if ( wp.customize( 'pine_header' ).get() == 'logo' )
			$header_logo.filter( '.site-logo' ).show();
		else
			$header_logo.filter( '.site-title' ).show();

		adapt_header_spacer();
	}

	// Header
	wp.customize( 'pine_header', function( value ) {
		handle_header();
		value.bind( handle_header );
	} );

	// Header logo.
	wp.customize( 'pine_header_logo', function( value ) {
		value.bind( function( to ) {
			var $_logo = $header_logo.filter( '.site-logo' );
			$( 'img', $_logo ).hide();
			if ( to ) {
				$( 'img:not(.default)', $_logo ).attr( 'src', to ).show();
			}
			else {
				$( 'img.default', $_logo ).show();
			}

			adapt_header_spacer();
		} );
	} );

	// Social buttons.
	wp.customize( 'pine_footer_social_buttons', function( value ) {
		value.bind( function( to ) {
			var social_buttons = '';
			$.each( to, function( i, social_button ) {
				social_buttons += '<li class="' + social_button.css_class + '-ico social-nav__item btn--transition"><a class="social-nav__link" href="' + social_button.url + '" title="' + social_button.social + '" target="_blank"><i class="fa fa-' + ( social_button.social + '' ).toLowerCase() + '"></i></a></li>\n';
			} );

			$( '.footer ul.social-nav' ).html( social_buttons );
		} );
	} );

	// Layout
	var get_page_layout = function() {
		var classes = $( 'body' ).attr( 'class' ).split( /\s+/ );
		var name = 'global';

		if ( $.inArray( 'archive', classes ) > -1 )
			name = 'archive';

		if ( $.inArray( 'category', classes ) > -1 )
			name = 'category_archive';

		if ( $.inArray( 'search', classes ) > -1 )
			name = 'search';

		if ( $.inArray( 'error404', classes ) > -1 )
			name = '404';

		if ( $.inArray( 'single', classes ) > -1 )
			name = 'single';

		if ( $.inArray( 'page', classes ) > -1 )
			name = 'page';

		if ( ( $.inArray( 'blog', classes ) > -1 && 'page' == wp.customize( 'show_on_front' ).get() ) || ( $.inArray( 'home', classes ) > -1 && 'page' !== wp.customize( 'show_on_front' ).get() ) )
			name = 'blog';

		return wp.customize( 'pine_' + name + '_layout' ).get();
	};

	var $main = $( '.pine-main-class' ),
			$sidebar = $( '.pine-sidebar-class' );

	var handle_layout = function() {
		if ( ! $main.length || !$sidebar.length )
			return;

		var page_layout = get_page_layout();

		if ( page_layout == 'disabled' )
			page_layout = wp.customize( 'pine_global_layout' ).get();

		$main.removeClass( 'col-md-12 col-md-8 col-md-push-4' );
		$sidebar.removeClass( 'col-md-pull-8' );

		if ( page_layout == 'none' ) {
			$main.addClass( 'col-md-12' );
			$sidebar.hide();
		}
		else {
			$main.addClass( 'col-md-8' );
			if ( page_layout == 'left' ) {
				$main.addClass( 'col-md-push-4' );
				$sidebar.addClass( 'col-md-pull-8' );
			}

			$sidebar.show();
		}

		$( window ).trigger( 'resize' );
	};

	var handle_layout_change = function( value ) {
		value.bind( handle_layout );
	};

	wp.customize( 'pine_global_layout', handle_layout_change );
	wp.customize( 'pine_blog_layout', handle_layout_change );
	wp.customize( 'pine_archive_layout', handle_layout_change );
	wp.customize( 'pine_category_archive_layout', handle_layout_change );
	wp.customize( 'pine_search_layout', handle_layout_change );
	wp.customize( 'pine_404_layout', handle_layout_change );
	wp.customize( 'pine_single_layout', handle_layout_change );
	wp.customize( 'pine_page_layout', handle_layout_change );

	wp.customize( 'show_on_front', handle_layout_change );

	$( document ).on( 'ready', handle_layout );
	$( document ).on( 'click', 'a', handle_layout );


	/* Colors */
	function lighten( color, amount ) {
		var color = new less.tree.Color( color.replace( '#', '' ) );
		var amount = new(less.tree.Dimension)( amount, '%' );

		return less.functions.functionRegistry._data.lighten( color, amount ).toRGB();
	}

	function darken( color, amount ) {
		var amount = new(less.tree.Dimension)( amount, '%' );
		return less.functions.functionRegistry._data.darken( color, amount );
	}

	function fade( color, amount ) {
		var amount = new(less.tree.Dimension)( amount, '%' );

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

	var colors_timeout = null;

	function update_style() {
		var current_scheme = wp.customize( 'pine_scheme' ).get();
		if ( ! schemes[ current_scheme ] ) current_scheme = 'red';

		var style_output;
		var styles = [];

		var color = schemes[ current_scheme ];

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


		style_output = styles.join( '\n' );

		$( 'style#customize-preview-style' ).html( style_output );
	}

	$( document ).on( 'ready', update_style );
	wp.customize( 'pine_scheme', function( value ) {
		value.bind( update_style );
	} );
} )( jQuery );
