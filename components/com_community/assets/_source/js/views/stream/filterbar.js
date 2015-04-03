// -----------------------------------------------------------------------------
// views/stream/filterbar
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/base'
],

// definition
// ----------
function(
	$,
	BaseView
) {

	return BaseView.extend({

		render: function() {
			this.$btn = $('.joms-activity-filter-action');
			this.$list = $('.joms-activity-filter-dropdown');

			this.$btn.on( 'click', $.bind( this.toggle, this ) );
			this.$list.on( 'click', 'li', $.bind( this.select, this ) );
			this.listenTo( $, 'click', this.onDocumentClick );
		},

		toggle: function() {
			var collapsed = this.$list[0].style.display === 'none';
			collapsed ? this.expand() : this.collapse();
		},

		expand: function() {
			this.$list.show();
		},

		collapse: function() {
			this.$list.hide();
		},

		select: function( e ) {
			var li = $( e.currentTarget ),
				url = li.data('url') || '/';

			this.toggle();
			window.location = url;
		},

		onDocumentClick: function( elem ) {
			if ( elem.closest('.joms-activity-filter').length )
				return;

			this.collapse();
		}

	});

});
