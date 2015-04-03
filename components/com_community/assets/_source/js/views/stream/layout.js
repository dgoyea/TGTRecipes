// -----------------------------------------------------------------------------
// views/stream/layout
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/base',
	'views/stream/filterbar',
	'views/stream/item',
	'views/stream/wall'
],

// definition
// ----------
function(
	$,
	BaseView,
	FilterbarView,
	ItemView,
	WallView
) {

	return BaseView.extend({

		initialize: function() {
			this.filterbar = new FilterbarView();
			this.item = new ItemView();
			this.wall = new WallView();
		},

		render: function() {
			this.filterbar.render();
			this.item.render();
			this.wall.render();

			$( document ).on( 'click', '.dropdown-menu li a', function() {
				var el = $( this ),
					ct = el.closest('.joms-privacy-dropdown'),
					icon = ct.find('.dropdown-toggle').find('i'),
					span = ct.prev('.joms-share-privacy');

				if ( icon && icon.length )
					icon.attr( 'class', el.find('i').attr('class') );

				if ( span && span.length )
					span.html( el.find('span').html() );
			});
		}

	});

});
