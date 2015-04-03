// -----------------------------------------------------------------------------
// app
// -----------------------------------------------------------------------------

// definition
// ----------
define(function() {
	var staticUrl;

	staticUrl = window.joms_assets_url || '';
	staticUrl = staticUrl.replace( /js\/$/, '' );

	return {
		staticUrl: staticUrl,
		legacyUrl: staticUrl + '../../'
	};

});
