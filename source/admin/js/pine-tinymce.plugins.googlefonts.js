( function() {
	tinymce.create( 'tinymce.plugins.googlefonts', {
		init: function( editor, url ) {
			editor.on( 'PreInit', function( event ) {
				var ed = event.target;
				var doc = ed.getDoc();

				var jscript = "WebFontConfig = {google: {families: [ 'Lato:400,300,300italic,400italic,700,700italic,900,900italic:latin' ]},active: function() {document.dispatchEvent( new Event( 'resize' ) );}};( function() {var wf = document.createElement('script');wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';wf.type = 'text/javascript';wf.async = 'true';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(wf, s);} )();";
				var script  = doc.createElement( 'script' );
				script.type = 'text/javascript';
				script.appendChild( doc.createTextNode( jscript ) );

				doc.getElementsByTagName( 'head' )[0].appendChild( script );
			});
		},
		getInfo: function() {
			return {
				longname:  'Pine Google fonts',
				author:    'Slicejack',
				authorurl: 'http://slicejack.com',
				infourl:   'http://slicejack.com',
				version:   '1.1'
			};
		}
	});

	tinymce.PluginManager.add( 'pine_googlefonts', tinymce.plugins.googlefonts );
} ());