/*! JomSocial AppLoader v1.0 | (c) 2014 iJoomla, Inc. */
(function( root ) {

var relpath;

function url( src ) {
	if ( typeof relpath === 'undefined' )
		relpath = root.joms_assets_url || '';

	return relpath + src;
}

// Script loading sequence.
joms.jQuery(function() {
	$LAB.script( url('toolkit.js') )
		.script( url('templates/jst.js') ).wait()
		.script( url('bundle.js') );
});

})( this );
