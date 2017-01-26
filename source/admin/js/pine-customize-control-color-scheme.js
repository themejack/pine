( function( wp, $ ) {
	'use strict';

	wp.customize.ColorSchemeControl = wp.customize.Control.extend( {
		ready: function() {
			var control = this,
				radios = $( '.radios', this.container ),
				selection = $( '.selection', this.container ),
				$schemes = $( '.scheme', selection ),
				schemes = control.params.schemes,
				colors = control.setting.get() !== 'custom' ? schemes[ control.setting.get() ].colors : {},
				colorsHandler,
				apply = $( '.apply-scheme', this.container );

			var schemesColors = [];

			var addColorsChangeHandler = function( key ) {
				if ( wp.customize.has( key ) ) {
					wp.customize( key, function( setting ) {
						if ( true !== setting.colorSchemeBinded ) {
							setting.bind( colorsChangeHandler );
							setting.colorSchemeBinded = true;
						}
					} );
				}
			};

			colorsHandler = function( to ) {
				if ( 0 === schemesColors.length ) {
					for ( var scheme in schemes ) {
						schemesColors.push( schemes[scheme].color );

						$.each( schemes[scheme].colors, addColorsChangeHandler );
					}
				}

				if ( 'custom' === to ) {
					return;
				}

				colors = schemes[ to ].colors;
				$.each( colors, function( key, value ) {
					if ( wp.customize.has( key ) ) {
						wp.customize( key, function( setting ) {
							setting.set( value );
						} );
					}
					if ( wp.customize.control.has(key) ) {
						wp.customize.control( key, function( control ) {
							var picker = control.container.find('.color-picker-hex');
							$( picker ).iris( 'color', value );
						} );
					}
				} );
			};

			var changeHandler = function() {
				var scheme = $( '[data-value="' + control.setting.get() + '"]', selection );
				$( '.scheme.selected', selection ).removeClass( 'selected' );

				scheme.addClass( 'selected' );
			};

			var changeTimeout = null;

			var colorsChangeHandler = function() {
				if ( changeTimeout !== null ) {
					clearTimeout( changeTimeout );
				}

				if ( 'custom' === control.setting.get() ) {
					return false;
				}

				var equal = true;
				var isFirst = true;
				var lastColor = '';
				var currentColor = '';
				var allSettings = wp.customize.get();

				for ( var color in colors ) {
					if ( wp.customize.has( color ) ) {
						currentColor = allSettings[ color ];

						if ( ! isFirst ) {
							if ( lastColor !== currentColor ) {
								equal = false;
								break;
							}
						}
						else {
							isFirst = false;
							lastColor = currentColor;
							if ( schemesColors.indexOf( lastColor ) < 0 ) {
								equal = false;
								break;
							}
						}
					}
				}

				if ( false === equal ) {
					changeTimeout = setTimeout( function() {
						control.setting.set( 'custom' );
						changeTimeout = null;
					}, 200 );
				}

				return false;
			};

			radios.hide();
			$( '.scheme[data-value="' + control.setting.get() + '"]', selection ).addClass( 'selected' );

			control.setting.bind( changeHandler );
			colorsHandler( control.setting.get() );
			changeHandler();

			apply.on( 'click', function( event ) {
				event.preventDefault();

				colorsHandler( control.setting.get() );
			} );

			$( '.color', $schemes ).on( 'click', function( event ) {
				event.preventDefault();

				var scheme = $( this ).closest( '.scheme' );
				if ( scheme.hasClass( 'selected' ) ) {
					return;
				}

				control.setting.set( scheme.data( 'value' ) );
			} );
		}
	});

	$.extend( wp.customize.controlConstructor, {
		'color-scheme': wp.customize.ColorSchemeControl,
	} );

} )( wp, jQuery );