// -----------------------------------------------------------------------------
// views/inputbox/base
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/base',
	'utils/constants'
],

// definition
// ----------
function( $, BaseView, constants ) {

	return BaseView.extend({

		events: {
			'focus textarea': 'onFocus',
			'keydown textarea': 'onKeydownProxy',
			'input textarea': 'onInput',
			'paste textarea': 'onPaste',
			'blur textarea': 'onBlur'
		},

		initialize: function( options ) {
			if ( !$.mobile ) {
				this.onInput = this.onKeydown;
				this.onKeydownProxy = this.onKeydown;
				this.updateCharCounterProxy = this.updateCharCounter;
			}

			// flags
			options || (options = {});
			this.flags = {};
			this.flags.attachment = options.attachment;
			this.flags.charcount = options.charcount;

			this.listenTo( $, 'postbox:tab:change', this.reset );
		},

		render: function() {
			this.$mirror = this.$('span.input');
			this.$textarea = this.$('textarea.input');
			this.placeholder = this.$textarea.attr('placeholder');

			if ( this.flags.attachment )
				this.$attachment = $('<span class=attachment>').insertAfter( this.$mirror );

			this.reset();
		},

		set: function( value ) {
			this.$textarea.val( value );
			this.flags.attachment && this.updateAttachment();
			this.flags.charcount && this.updateCharCounterProxy();
			this.onKeydownProxy();
		},

		reset: function() {
			this.$textarea.val('');
			this.flags.attachment && this.updateAttachment();
			this.flags.charcount && this.updateCharCounterProxy();
			this.onKeydownProxy();
		},

		value: function() {
			return this.$textarea[0].value;
		},

		// ---------------------------------------------------------------------
		// Event handlers.
		// ---------------------------------------------------------------------

		onFocus: function() {
			this.trigger('focus');
		},

		onKeydown: function( e ) {
			if ( typeof this.maxchar === 'undefined' )
				this.maxchar = +constants.get('conf.statusmaxchar') || 0;

			var value = this.value();
			if ( value.length >= this.maxchar ) {
				if ( this.isPrintable( e ) ) {
					e.preventDefault();
					return;
				}
			}

			var that = this;
			$.defer(function() {
				that.updateInput( e );
			});
		},

		onKeydownProxy: $.debounce(function( e ) {
			this.onKeydown( e );
		}, 10 ),

		// Keydown event not always triggered on mobile browsers, so we listen both `keydown` and `input` events.
		// http://stackoverflow.com/questions/14194247/key-event-doesnt-trigger-in-firefox-on-android-when-word-suggestion-is-on
		onInput: function() {
			this.onKeydownProxy();
		},

		onPaste: function() {
			var that = this;
			this.onKeydownProxy(function() {
				that.trigger( 'paste', that.$textarea[0].value, 13 );
			});
		},

		onBlur: function() {
			this.trigger( 'blur', this.$textarea[0].value, 13 );
		},

		// ---------------------------------------------------------------------
		// Input renderer.
		// ---------------------------------------------------------------------

		updateInput: function( e ) {
			var keyCode  = e && e.keyCode || false,
				textarea = this.$textarea[0],
				value    = textarea.value,
				isEmpty  = value.replace( /^\s+|\s+$/g, '' ) === '';

			if ( isEmpty )
				textarea.value = value = '';

			if ( typeof this.maxchar === 'undefined' )
				this.maxchar = +constants.get('conf.statusmaxchar') || 0;

			if ( value.length > this.maxchar ) {
				textarea.value = value = value.substr( 0, this.maxchar );
			}

			this.$mirror.html( this.normalize( value ) + '.' );
			this.$textarea.css( 'height', this.$mirror.height() );
			this.flags.charcount && this.updateCharCounterProxy();
			this.trigger( 'keydown', value, keyCode );
			if ( typeof e === 'function' )
				e();
		},

		updateAttachment: $.noop,

		updateCharCounterProxy: $.debounce(function() {
			this.updateCharCounter();
		}, 300 ),

		updateCharCounter: function() {
			if ( typeof this.maxchar === 'undefined' )
				this.maxchar = +constants.get('conf.statusmaxchar') || 0;

			if ( !this.$charcount )
				this.$charcount = this.$('.charcount');

			if ( !this.maxchar || this.maxchar <= 0 ) {
				this.$charcount.hide();
				return;
			}

			this.$charcount.html( this.maxchar - this.$textarea[0].value.length ).show();
		},

		// ---------------------------------------------------------------------
		// Helper functions.
		// ---------------------------------------------------------------------

		isPrintable: function( e ) {
			if ( !e ) return false;
			if ( ( e.crtlKey || e.metaKey ) && !e.altKey && !e.shiftKey ) return false;

			var code = e && e.keyCode;
			var printable =
				(code === 13)                  || // return key
				(code === 32)                  || // spacebar key
				(code  >  47  && code  <  58)  || // number keys
				(code  >  64  && code  <  91)  || // letter keys
				(code  >  95  && code  <  112) || // numpad keys
				(code  >  185 && code  <  193) || // ;=,-./` (in order)
				(code  >  218 && code  <  223);   // [\]' (in order)

			return printable;
		},

		normalize: function( text ) {
			return text
				.replace( /&/g, '&amp;' )
				.replace( /</g, '&lt;' )
				.replace( />/g, '&gt;' )
				.replace( /\n/g, '<br>' );
		},

		resetTextntags: function( textarea, value ) {
			var that = this;

			textarea = $( textarea );

			if ( !textarea.data('initialized') ) {
				textarea.data( 'initialized', 1 );
				textarea.textntags({
					triggers: { '@': {
						uniqueTags: true,
						minChars: 1
					} },
					onDataRequest: function( mode, query, triggerChar, callback ) {
						var data = constants.get('friends') || [],
							filter, timer;

						filter = function() {
							query = query.toLowerCase();
							data = $.filter( data, function( item ) { return item.name.toLowerCase().indexOf( query ) > -1; });
							callback( data );
						};

						if ( data !== 'fetching' ) {
							filter();
						} else {
							timer = setInterval(function() {
								data = constants.get('friends') || [];
								if ( data !== 'fetching' ) {
									clearInterval( timer );
									filter();
								}
							}, 100 );
						}
					}
				})
				.bind( 'tagsAdded.textntags', function() { that.updateInput(); })
				.bind( 'tagsRemoved.textntags', function() { that.updateInput(); });
			}

			textarea.textntags( 'val', value );

		}

	});

});
