// -----------------------------------------------------------------------------
// application initialization
// -----------------------------------------------------------------------------

// requirements
// ------------
require([
   'sandbox',
   'views/postbox/layout',
   'views/stream/layout',
   'views/header/layout',
   'utils/constants'
],

// description
// -----------
function( $, PostboxView, StreamView, HeaderView, constants ) {

	function initPostbox() {
		var el = $('.joms-postbox'),
			postbox;

		if ( el.length ) {
			postbox = new PostboxView({ el: el });
			postbox.render();
			postbox.show();
		}
	}

	function initStream() {
		var stream = new StreamView();
		stream.render();
	}

	function initHeader() {
		var header = new HeaderView();
		header.render();
	}

	function fetchAllFriends() {
		var url 	 = 'index.php?option=com_community&view=friends&task=ajaxAutocomplete&allfriends=1',
			settings = constants.get('settings') || {},
			data 	 = [];

		constants.set( 'friends', 'fetching' );
		if ( settings.isGroup ) url += '&groupid=' + constants.get('groupid');
		else if ( settings.isEvent ) url += '&eventid=' + constants.get('eventid');

		$.ajax({
			url: url,
			dataType: 'json',
			success: function( json ) {
				var uniques = [],
					id, i;

				if ( json && json.suggestions && json.suggestions.length ) {
					for ( i = 0; i < json.suggestions.length; i++ ) {
						id = '' + json.data[i];
						if ( uniques.indexOf(id) >= 0 ) continue;
						uniques.push( id );
						data.push({
							id: id,
							name: json.suggestions[i],
							avatar: json.img[i].replace( /^.+src="([^"]+)".+$/ , '$1'),
							type: 'contact'
						});
					}
				}
			},
			complete: function() {
				constants.set( 'friends', data );
			}
		});
	}

	$(function() {
		initPostbox();
		initStream();
		initHeader();

		if ( +window.js_viewerId )
			fetchAllFriends();

	});

});
