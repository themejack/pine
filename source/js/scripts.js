/* global BackgroundCheck:true */
( function( $ ) {
	'use strict';

	var $body = $( 'body' );
	var $header = $( '.header', $body );
	var $headerSpacer = $( '.header-spacer', $body );
	var $offcanvas = $( '.offcanvas', $body );
	var $adminbar = $( '#wpadminbar', $body );

	$( document ).on( 'ready', function() {
		$adminbar = $( '#wpadminbar', $body );
	} );

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
			if ( $body.hasClass( 'admin-bar' ) && $adminbar.length ) {
				$offcanvas.css( 'top', ( $headerHeight + $adminbar.outerHeight() ) + 'px' );
			}
			else {
				$offcanvas.css( 'top', $headerHeight + 'px' );
			}
		}, 400 );
	};
	adaptHeaderSpacer();

	$( 'img', $header ).on( 'load', adaptHeaderSpacer );
	$( document ).on( 'ready', adaptHeaderSpacer );
	$( window ).on( 'resize orientationchange', adaptHeaderSpacer );

	// Full-screen navigation
	var $offcanvasToggle = $( '.offcanvas-toggle' );
	$offcanvas = $( '.offcanvas' );
	$offcanvasToggle.on( 'click', function() {
		$offcanvas.toggleClass( 'offcanvas--active' );
		$offcanvasToggle.toggleClass( 'offcanvas-toggle--active' );
	} );

	// Project list category masonry and isotope
	var grid = $( '.projects-block__list' ).isotope( {
		itemSelector: '.project-block'
	} );

	$( '.projects-block__list' ).masonry( {
		itemSelector: '.project-block'
	} );

	var $projectsCatToggle = $( '.projects-cat-toggle' );
	$projectsCatToggle.on( 'click', 'li', function() {
		var filterValue = $( this ).attr( 'data-filter' );
		grid.isotope( { filter: filterValue } );

		$( '.tabs-nav__item--active', $projectsCatToggle ).removeClass( 'tabs-nav__item--active' );
		$( this ).addClass( 'tabs-nav__item--active' );
	} );

	// Project list type toggle
	var $projectsBlockList = $( '.projects-block__list' );
	$( '.project-type-nav__list' ).on( 'click', function() {
		$projectsBlockList.addClass('projects-block__list--list');
		grid.isotope( 'layout' );
	} );

	$( '.project-type-nav__grid' ).on( 'click', function() {
		$projectsBlockList.removeClass( 'projects-block__list--list' );
		grid.isotope( 'layout' );
	} );

	var $projectsTypeNav = $( '.projects-type-nav' );
	$projectsTypeNav.on( 'click', 'li', function() {
		$( '.projects-type-nav__item--active', $projectsTypeNav ).removeClass( 'projects-type-nav__item--active' );
		$( this ).addClass( 'projects-type-nav__item--active' );
	} );

	// Front page hero background check
	var $heroSubheader = $( '.hero-subheader' );
	if ( $heroSubheader.length ) {
		BackgroundCheck.init( {
			targets: '.hero-subheader > .container',
			images: '.hero-subheader',
			changeParent: true,
			windowEvents: false
		} );
	}

	// Post hero background check
	var $postHero = $( '.post-hero--has-background' );
	if ( $postHero.length ) {
		BackgroundCheck.init( {
			targets: '.post-hero--has-background > .container',
			images: '.post-hero--has-background',
			changeParent: true,
			windowEvents: false
		} );
	}
} ( jQuery ) );