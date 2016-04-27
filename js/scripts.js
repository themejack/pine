( function( $ ) {
	var $body = $( 'body' );
	var $header = $( '.header', $body );
	var $header_spacer = $( '.header-spacer', $body );
	var $offcanvas = $( '.offcanvas', $body );
	var $adminbar = $( '#wpadminbar', $body );

	$( document ).on ( 'ready', function() {
		$adminbar = $( '#wpadminbar', $body );
	} );

	var adapt_header_spacer;
	var adapt_header_spacer_timeout = null;
	var nothing = null;
	var $header_height = $header.outerHeight();
	( adapt_header_spacer = function() {
		if ( adapt_header_spacer_timeout !== null )
			clearTimeout( adapt_header_spacer_timeout );

		setTimeout( function() {
			nothing = $header[0].offsetHeight;
			$header_height = $header.outerHeight();
			$header_spacer.css( 'height', $header_height + 'px' );
			if ( $body.hasClass( 'admin-bar' ) && $adminbar.length ) {
				$offcanvas.css( 'top', ( $header_height + $adminbar.outerHeight() ) + 'px' );
			}
			else {
				$offcanvas.css( 'top', $header_height + 'px' );
			}
		}, 400 );
	} () );

	$( 'img', $header ).on( 'load', adapt_header_spacer );
	$( document ).on( 'ready', adapt_header_spacer );
	$( window ).on( 'resize orientationchange', adapt_header_spacer );

	// Full-screen navigation
	$offcanvas_toggle = $( '.offcanvas-toggle' );
	$offcanvas = $( '.offcanvas' );
	$offcanvas_toggle.on( 'click', function() {
		$offcanvas.toggleClass( 'offcanvas--active' );
		$offcanvas_toggle.toggleClass( 'offcanvas-toggle--active' );
	} );

	// Project list category masonry and isotope
	var grid = $( '.projects-block__list' ).isotope( {
		itemSelector: '.project-block'
	} );

	var gridMasonry = $( '.projects-block__list' ).masonry( {
		itemSelector: '.project-block'
	} );

	$projects_cat_toggle = $( '.projects-cat-toggle' );
	$projects_cat_toggle.on( 'click', 'li', function() {
		var filterValue = $( this ).attr( 'data-filter' );
		grid.isotope( { filter: filterValue } );

		$( '.tabs-nav__item--active', $projects_cat_toggle ).removeClass( 'tabs-nav__item--active' );
		$( this ).addClass( 'tabs-nav__item--active' );
	} );

	// Project list type toggle
	$projects_block_list = $( '.projects-block__list' );
	$( '.project-type-nav__list' ).on( 'click', function() {
		$projects_block_list.addClass('projects-block__list--list');
		grid.isotope( 'layout' );
	} );

	$( '.project-type-nav__grid' ).on( 'click', function() {
		$projects_block_list.removeClass( 'projects-block__list--list' );
		grid.isotope( 'layout' );
	} );

	$projects_type_nav = $( '.projects-type-nav' );
	$projects_type_nav.on( 'click', 'li', function() {
		$( '.projects-type-nav__item--active', $projects_type_nav ).removeClass( 'projects-type-nav__item--active' );
		$( this ).addClass( 'projects-type-nav__item--active' );
	} );

	// Front page hero background check
	var $hero_subheader = $( '.hero-subheader' );
	if ( $hero_subheader.length ) {
		BackgroundCheck.init( {
			targets: '.hero-subheader > .container',
			images: '.hero-subheader',
			changeParent: true,
			windowEvents: false
		} );
	}

	// Post hero background check
	var $post_hero = $( '.post-hero--has-background' );
	if ( $post_hero.length ) {
		BackgroundCheck.init( {
			targets: '.post-hero--has-background > .container',
			images: '.post-hero--has-background',
			changeParent: true,
			windowEvents: false
		} );
	}
} ( jQuery ) );