// -----------------------------------------------------------------------------
// views/dropdown/location
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/dropdown/base',
	'utils/language'
],

// definition
// ----------
function( $, BaseView, language ) {

	// placeholders language setting.
	var langs = language.get('geolocation') || {};

	return BaseView.extend({

		template: {
			div: joms.jst[ 'html/dropdown/location' ],
			list: joms.jst[ 'html/dropdown/location-list' ]
		},

		placeholders: {
			loading: langs.loading || '',
			loaded: langs.loaded || '',
			error: langs.error || ''
		},

		initialize: function() {
			BaseView.prototype.initialize.apply( this );

			this.locations = [];
			this.location = false;
			this.listenTo( $, 'postbox:tab:change', this.onRemove );
		},

		events: {
			'keyup input.joms-postbox-keyword': 'onKeyup',
			'click li': 'onSelect',
			'click button.joms-add-location': 'onAdd',
			'click button.joms-remove-location': 'onRemove'
		},

		render: function() {
			this.$el.html( this.getTemplate() );
			this.$keyword = this.$('.joms-postbox-keyword');
			this.$list = this.$('.joms-postbox-locations');
			this.$map = this.$('.joms-postbox-map');
			this.$btnadd = this.$('.joms-add-location').hide();
			this.$btnremove = this.$('.joms-remove-location').hide();

			this.$keyword.attr( 'placeholder', this.placeholders.loading );
			this.detectLocation();

			return this;
		},

		show: function() {
			this.$el.show();
			this.trigger('show');
		},

		hide: function() {
			this.$el.hide();
			this.trigger('hide');
		},

		toggle: function() {
			var hidden = this.el.style.display === 'none';
			hidden ? this.show() : this.hide();
		},

		filter: function() {
			var keyword = this.$keyword.val().replace( /^\s+|\s+$/, '' ),
				filtered = this.locations;

			if ( keyword.length ) {
				keyword = new RegExp( keyword, 'i' );
				filtered = [];
				for ( var i = 0, item; i < this.locations.length; i++ ) {
					item = this.locations[i];
					item = [ item.name, item.vicinity ].join(' ');
					if ( item.match(keyword) )
						filtered.push( this.locations[i] );
				}
			}

			this.draw( filtered );
		},

		draw: function( items ) {
			var html = this.template.list({
				language: { geolocation: language.get('geolocation') },
				items: items
			});

			this.filtered = items;

			if ( $.mobile ) {
				this.$list.html( html ).css({
					height: '160px',
					overflowY: 'auto'
				});
			} else {
				this.$list.html( html ).slimScroll({
					height: '150px',
					alwaysVisible: true
				});
			}
		},

		select: function( index ) {
			var data = this.filtered[ index ];
			if ( data ) {
				this.location = data;
				this.$map.show();
				this.$keyword.val( data.name );
				this.map && this.marker && this.marker.setMap( this.map );
				this.showMap( data.latitude, data.longitude );
				this.$btnadd.show();
				this.$btnremove.hide();
			}
		},

		value: function() {
			var data = [];

			if ( this.location ) {
				data.push( this.location.name );
				data.push( this.location.latitude );
				data.push( this.location.longitude );
				return data;
			}

			return false;
		},

		reset: function() {
			this.location = false;
			this.marker && this.marker.setMap( null );
			this.$keyword.val('');
			this.$btnadd.hide();
			this.$btnremove.hide();
			this.trigger('reset');
		},

		// ---------------------------------------------------------------------
		// Event handlers.
		// ---------------------------------------------------------------------

		onKeyup: $.debounce(function() {
			this.filter();
		}, 100 ),

		onSelect: function( e ) {
			var el = $( e.currentTarget ),
				index = el.attr('data-index');

			this.select( +index );
		},

		onAdd: function() {
			if ( this.location ) {
				this.trigger( 'select', this.location );
				this.$btnadd.hide();
				this.$btnremove.show();
				this.hide();
			}
		},

		onRemove: function() {
			this.reset();
			this.trigger('remove');
			this.hide();
			this.filter();
		},

		// ---------------------------------------------------------------------
		// Map functions.
		// ---------------------------------------------------------------------

		initMap: function( position ) {
			var el = $('<div>').prependTo( this.$map );
			el.css( 'height', 110 );

			var options = {
				center: position,
				zoom: 14,
				mapTypeId: google.maps.MapTypeId.ROADMAD,
				mapTypeControl: false,
				disableDefaultUI: true,
				draggable: false,
				scaleControl: false,
				scrollwheel: false,
				navigationControl: false,
				streetViewControl: false,
				disableDoubleClickZoom: true
			};

			this.map = new google.maps.Map( el[0], options );
			this.marker = new google.maps.Marker({
				draggable: false,
				map: this.map
			});
			this.marker.setAnimation( null );
		},

		showMap: function( lat, lng ) {
			var position = $.isUndefined( lng ) ? lat : new google.maps.LatLng( lat, lng );

			if ( !this.map ) {
				this.initMap( position );
			}

			this.marker.setPosition( position );
			this.map.panTo( position );
		},

		// ---------------------------------------------------------------------
		// Location detection.
		// ---------------------------------------------------------------------

		detectLocation: function() {
			this.sensor = false;

			var that = this;
			joms.map.execute(function() {
				navigator.geolocation.getCurrentPosition(
					$.bind( that.detectLocationSuccess, that ),
					$.bind( that.detectLocationFallback, that ),
					{ timeout: 10000 }
				);
			});
		},

		detectLocationSuccess: function( position ) {
			var coords = position && position.coords || {},
				lat = coords.latitude,
				lng = coords.longitude;

			if ( !lat || !lng ) {
				this.detectLocationFailed();
				return;
			}

			this.sensor = true;
			this.detectLocationNearby( lat, lng );
		},

		// If HTML5 geolocation failed to detect my current location, attempt to use IP-based geolocation.
		detectLocationFallback: function () {
			var success = false,
				that = this;

			$.ajax({
				url: '//freegeoip.net/json/',
				dataType: 'jsonp',
				success: function( json ) {
					var lat = json.latitude,
						lng = json.longitude;

					if ( lat && lng ) {
						success = true;
						that.detectLocationNearby( lat, lng );
					}
				},
				complete: function() {
					if ( !success )
						that.detectLocationFailed();
				}
			});
		},

		detectLocationFailed: function() {
			this.$keyword.attr( 'placeholder', this.placeholders.error );
		},

		detectLocationNearby: function( lat, lng ) {
			var position = $.isUndefined( lng ) ? lat : new google.maps.LatLng( lat, lng );
			this.initMap( position );

			var service = new google.maps.places.PlacesService( this.map );
			var request = {
				location: new google.maps.LatLng( lat, lng ),
				radius: 2000,
				sensor: this.sensor
			};

			this.locations = [];

			var that = this;
			service.nearbySearch( request, function( results, status ) {
				if ( status !== google.maps.places.PlacesServiceStatus.OK ) {
					that.detectLocationFailed();
					return;
				}

				if ( !$.isArray(results) ) {
					that.detectLocationFailed();
					return;
				}

				var excludeTypes = [
					'administrative_area_level_1',
					'administrative_area_level_2',
					'administrative_area_level_3',
					'colloquial_area',
					'country',
					'floor',
					'geocode',
					'intersection',
					'locality',
					'natural_feature',
					'neighborhood',
					'political',
					'point_of_interest',
					'post_box',
					'postal_code',
					'postal_code_prefix',
					'postal_town',
					'premise',
					'room',
					'route',
					'street_address',
					'street_number',
					'sublocality',
					'sublocality_level_4',
					'sublocality_level_5',
					'sublocality_level_3',
					'sublocality_level_2',
					'sublocality_level_1',
					'subpremise',
					'transit_station'
				];

				for ( var i = 0, loc, types, exclude; i < results.length; i++ ) {
					loc = results[i];
					types = loc && loc.types || [];
					exclude = false;

					while ( !exclude && types && types.length )
						if ( excludeTypes.indexOf( types.shift() ) >= 0 )
							exclude = true;

					if ( !exclude ) {
						that.locations.push({
							name: loc.name,
							latitude: loc.geometry.location.lat(),
							longitude: loc.geometry.location.lng(),
							vicinity: loc.vicinity
						});
					}
				}

				that.$keyword.attr( 'placeholder', that.placeholders.loaded );
				that.filter();
			});
		},

		// ---------------------------------------------------------------------
		// Helper functions.
		// ---------------------------------------------------------------------

		getTemplate: function() {
			var html = this.template.div({
				language: {
					geolocation: language.get('geolocation') || {}
				}
			});

			return html;
		}

	});

});
