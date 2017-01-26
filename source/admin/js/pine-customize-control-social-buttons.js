( function( wp, $ ) {
	'use strict';

	wp.customize.SocialButtonsControl = wp.customize.Control.extend({
		ready: function() {
			var control = this,
				socialButtonsContainer = $( '.social-buttons', this.container ),
				addButton = $( '.add-social-button', this.container ),
				socialButtons = this.setting.get(),
				socialNetworks = this.params.socials,
				template = wp.template( 'social-button' );

			$.each( socialButtons, function( i, socialButton ) {
				var social,
					socialValue = socialButton.social,
					url = socialButton.url,
					cssClass = socialButton.cssClass;

				social = 'custom';
				if ( socialNetworks[ socialValue ] ) {
					social = socialValue;
				}

				socialButtonsContainer.append( template( {
					social: social,
					socialValue: socialValue,
					url: url,
					cssClass: cssClass,
					editing: false
				} ) );
			} );

			addButton.on( 'click', function( event ) {
				event.preventDefault();
				var socialButtonsContainer = $( '.social-buttons', $( this ).closest( '.customize-control-content' ) );
				var socialButton = $( template( { social: '', socialValue: '', url: '', cssClass: '', editing: true } ) );

				socialButton.appendTo( socialButtonsContainer ).find( '.fields select.social' ).trigger( 'change' );

				$( '.wp-full-overlay-sidebar-content' ).animate( { scrollTop: $( '.social-button:last-of-type', socialButtonsContainer ).offset().top }, 500 );
			} );

			socialButtonsContainer.on( 'change', '.social-button select.social', function() {
				var $self = $( this ),
					customSocial = $( '.custom-social', $self.closest( '.social-button' ) );

				customSocial.hide();

				if ( 'custom' === $self.val() ) {
					customSocial.show();
				}
			} );

			function socialButtonsUpdateSetting( container ) {
				var newSetting = [];
				$( '.social-button', container ).each( function() {
					var url, social, cssClass;

					social = $( 'select.social', this ).val();
					if ( 'custom' === social ) {
						social = $( '.custom-social input', this ).val();
					}

					cssClass = $( 'input.css-class', this ).val();

					url = $( 'input.url', this ).val();

					newSetting.push( { social: social, cssClass: cssClass, url: url } );
				} );

				control.setting.set( newSetting );
			}

			socialButtonsContainer.on( 'change', 'select, input', function() {
				var socialButton = $( this ).closest( '.social-button' ),
						socialButtonsContainer = socialButton.closest( '.social-buttons' ),
						social,
						socialValue = $( '.fields select.social', socialButton ).val(),
						url = $( '.fields input.url', socialButton ).val(),
						cssClass;

				social = 'custom';
				if ( socialNetworks[socialValue] ) {
					social = socialValue;
				}

				if ( 'custom' === social ) {
					cssClass = $( '.custom-social input', socialButton ).val();
				} else {
					cssClass = social;
				}

				cssClass.replace(/[^a-z0-9]/g, function(s) {
					var c = s.charCodeAt(0);

					if ( c === 32 ) {
						return '-';
					}

					if ( c >= 65 && c <= 90 ) {
						return s.toLowerCase();
					}

					return '__' + ( '000' + c.toString(16) ).slice(-4);
				});

				socialButton.replaceWith( template( {
					social: social,
					socialValue: socialValue,
					url: url,
					cssClass: cssClass,
					editing: true
				} ) );

				socialButtonsUpdateSetting( socialButtonsContainer );
			} );

			socialButtonsContainer.on( 'click', '.social-button .preview .social-button-preview', function( event ) {
				event.preventDefault();

				var socialButton = $( this ).closest( '.social-button' ),
						fields = $( '.fields', socialButton );

				fields.toggle();
			} );

			socialButtonsContainer.on( 'click', '.social-button .preview .remove-button', function( event ) {
				event.preventDefault();

				var socialButton = $( this ).closest( '.social-button' ),
						socialButtonsContainer = socialButton.closest( '.social-buttons' );

				socialButton.remove();

				socialButtonsUpdateSetting( socialButtonsContainer );
			} );

			socialButtonsContainer.on( 'click', '.social-button .preview .reorder-button', function( event ) {
				event.preventDefault();

				var socialButton = $( this ).closest( '.social-button' ),
					isUp = $( this ).hasClass( 'move-up' ) ? true : false,
					socialButtonsContainer = socialButton.closest( '.social-buttons' );

				if ( ( isUp && socialButton.is( ':first-of-type' ) ) || ( !isUp && socialButton.is( ':last-of-type' ) ) ) {
					return;
				}

				if ( isUp ) {
					var beforeElement = socialButton.prev( '.social-button' );
					beforeElement.before( socialButton.clone() );
				}
				else {
					var afterElement = socialButton.next( '.social-button' );
					afterElement.after( socialButton.clone() );
				}

				socialButton.remove();

				socialButtonsUpdateSetting( socialButtonsContainer );
			} );
		}
	});

	$.extend( wp.customize.controlConstructor, {
		'social-buttons': wp.customize.SocialButtonsControl,
	} );

} )( wp, jQuery );