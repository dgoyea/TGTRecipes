// -----------------------------------------------------------------------------
// views/dropdown/datepicker
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/dropdown/base',
	'views/widget/select',
	'utils/constants',
	'utils/language'
],

// definition
// ----------
function( $, BaseView, SelectWidget, constants, language ) {

	return BaseView.extend({

		template: joms.jst[ 'html/dropdown/event' ],

		events: {
			'click .joms-postbox-done': 'onSave'
		},

		initialize: function() {
			BaseView.prototype.initialize.apply( this );

			var categories = constants.get('eventCategories') || [],
				options = [];

			this.categoriesMap = {};
			if ( categories && categories.length ) {
				for ( var i = 0, id = categories[i].id, name = categories[i].name; i < categories.length; i++ ) {
					id = categories[i].id;
					name = categories[i].name;
					this.categoriesMap[ id ] = name;
					options.push([ id, name ]);
				}
			}

			this.category = new SelectWidget({ options: options });
		},

		render: function() {
			var div = this.getTemplate(),
				ampm = +constants.get('conf.eventshowampm'),
				firstDay = +constants.get('conf.firstday'),
				timeFormatLabel = ampm ? 'h:i A' : 'H:i',
				translations = {},
				i;

			// Translations.
			translations.monthsFull = [
				language.get('datepicker.january'),
				language.get('datepicker.february'),
				language.get('datepicker.march'),
				language.get('datepicker.april'),
				language.get('datepicker.may'),
				language.get('datepicker.june'),
				language.get('datepicker.july'),
				language.get('datepicker.august'),
				language.get('datepicker.september'),
				language.get('datepicker.october'),
				language.get('datepicker.november'),
				language.get('datepicker.december')
			];

			translations.monthsShort = [];
			for ( i = 0; i < translations.monthsFull.length; i++ )
				translations.monthsShort[i] = translations.monthsFull[i].substr( 0, 3 );

			translations.weekdaysFull = [
				language.get('datepicker.sunday'),
				language.get('datepicker.monday'),
				language.get('datepicker.tuesday'),
				language.get('datepicker.wednesday'),
				language.get('datepicker.thursday'),
				language.get('datepicker.friday'),
				language.get('datepicker.saturday')
			];

			translations.weekdaysShort = [];
			for ( i = 0; i < translations.weekdaysFull.length; i++ )
				translations.weekdaysShort[i] = translations.weekdaysFull[i].substr( 0, 3 );

			translations.today = language.get('datepicker.today');
			translations['clear'] = language.get('datepicker.clear');

			translations.firstDay = firstDay;

			this.$el.replaceWith( div );
			this.setElement( div );
			this.$category = this.$('.joms-event-category');
			this.$location = this.$('[name=location]').val('');
			this.$startdate = this.$('.joms-pickadate-startdate').pickadate( $.extend({}, translations, { min: new Date(), format: 'd mmmm yyyy', klass: { frame: 'picker__frame startDate' } }) );
			this.$starttime = this.$('.joms-pickadate-starttime').pickatime({ interval: 15, format: timeFormatLabel, formatLabel: timeFormatLabel, klass: { frame: 'picker__frame startTime' } });
			this.$enddate = this.$('.joms-pickadate-enddate').pickadate( $.extend({}, translations, { format: 'd mmmm yyyy', klass: { frame: 'picker__frame endDate' } }) );
			this.$endtime = this.$('.joms-pickadate-endtime').pickatime({ interval: 15, format: timeFormatLabel, formatLabel: timeFormatLabel, klass: { frame: 'picker__frame endTime' } });
			this.$done = this.$('.joms-event-done');

			this.assign( this.$category, this.category );
			this.startdate = this.$startdate.pickadate('picker');
			this.starttime = this.$starttime.pickatime('picker');
			this.enddate = this.$enddate.pickadate('picker');
			this.endtime = this.$endtime.pickatime('picker');

			this.startdate.on({ set: $.bind( this.onSetStartDate, this ) });
			this.starttime.on({ set: $.bind( this.onSetStartTime, this ) });
			this.enddate.on({ set: $.bind( this.onSetEndDate, this ) });
			this.endtime.on({ set: $.bind( this.onSetEndTime, this ) });

			return this;
		},

		show: function() {
			this.category && this.category.reset();
			return BaseView.prototype.show.apply( this, arguments );
		},

		// ---------------------------------------------------------------------

		value: function() {
			return this.data;
		},

		reset: function() {
			this.$location.val('');
			this.$startdate.val('');
			this.$starttime.val('');
			this.$enddate.val('');
			this.$endtime.val('');
		},

		// ---------------------------------------------------------------------

		onSetStartDate: function( o ) {
			var ts = o.select;
			this.enddate.set({ min: new Date(ts) }, { muted: true });
			this._checkTime();
		},

		onSetEndDate: function( o ) {
			var ts = o.select;
			this.startdate.set({ max: new Date(ts) }, { muted: true });
			this._checkTime();
		},

		onSetStartTime: function() {
			this._checkTime('start');
		},

		onSetEndTime: function() {
			this._checkTime('end');
		},

		onSave: function() {
			var category = this.category.value(),
				startdate = this.startdate.get('select'),
				starttime = this.starttime.get('select'),
				enddate = this.enddate.get('select'),
				endtime = this.endtime.get('select'),
				error;

			// get start date and time
			startdate && (startdate = [ this.startdate.get('select', 'yyyy-mm-dd'), this.startdate.get('value') ]);
			starttime && (starttime = [ this.starttime.get('select', 'HH:i'), this.starttime.get('value') ]);

			// get end date and time
			enddate && (enddate = [ this.enddate.get('select', 'yyyy-mm-dd'), this.enddate.get('value') ]);
			endtime && (endtime = [ this.endtime.get('select', 'HH:i'), this.endtime.get('value') ]);

			// data
			this.data = {
				category  : category ? [ category, this.categoriesMap[ category ] ] : false,
				location  : this.$location.val(),
				startdate : startdate,
				starttime : starttime,
				enddate   : enddate,
				endtime   : endtime,
				allday    : false
			};

			// check values
			if ( !this.data.category ) {
				error = 'Category is not selected.';
			} else if ( !this.data.location ) {
				error = 'Location is not selected.';
			} else if ( !this.data.startdate ) {
				error = 'Start date is not selected.';
			} else if ( !this.data.starttime ) {
				error = 'Start time is not selected.';
			} else if ( !this.data.enddate ) {
				error = 'End date is not selected.';
			} else if ( !this.data.endtime ) {
				error = 'End time is not selected.';
			}

			if ( error ) {
				window.alert( error );
				return;
			}

			this.trigger( 'select', this.data );
			this.hide();
		},

		// ---------------------------------------------------------------------
		// Helper functions.
		// ---------------------------------------------------------------------

		getTemplate: function() {
			var html = this.template({
				language: {
					event: language.get('event') || {}
				}
			});

			return $( html ).hide();
		},

		_checkTime: function() {
			var startdate = this.startdate.get('select'),
				enddate = this.enddate.get('select'),
				starttime, endtime;

			if ( !startdate || !enddate )
				return;

			if ( enddate.year <= startdate.year && enddate.month <= startdate.month && enddate.date <= startdate.date ) {
				starttime = this.starttime.get('select');
				endtime = this.endtime.get('select');

				if ( !starttime ) {
					this.endtime.set({ min: false }, { muted: true });
				} else {
					this.endtime.set({ min: [ starttime.hour, starttime.mins ] }, { muted: true });
					if ( endtime && endtime.time < starttime.time )
						this.endtime.set({ select: [ starttime.hour, starttime.mins ] }, { muted: true });
				}

				if ( !endtime ) {
					this.starttime.set({ max: false }, { muted: true });
				} else {
					this.starttime.set({ max: [ endtime.hour, endtime.mins ] }, { muted: true });
					if ( starttime && starttime.time > endtime.time )
						this.starttime.set({ select: [ endtime.hour, endtime.mins ] }, { muted: true });
				}
			} else {
				this.starttime.set({ max: false }, { muted: true });
				this.endtime.set({ min: false }, { muted: true });
			}
		}

	});

});
