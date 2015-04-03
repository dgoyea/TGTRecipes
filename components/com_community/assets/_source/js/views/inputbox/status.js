// -----------------------------------------------------------------------------
// views/inputbox/status
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/inputbox/base',
	'utils/constants',
	'utils/language'
],

// definition
// ----------
function( $, InputboxView, constants, language ) {

	return InputboxView.extend({

		template: joms.jst[ 'html/inputbox/status' ],

		initialize: function() {
			var hash, item, id, i;

			InputboxView.prototype.initialize.apply( this, arguments );

			this.moods = constants.get('moods');
			hash = {};
			if ( this.moods && this.moods.length ) {
				for ( i = 0; i < this.moods.length; i++ ) {
					id = this.moods[i].id;
					item = [ id, this.moods[i].description ];
					if ( this.moods[i].custom ) {
						item[2] = this.moods[i].image;
					}
					hash[ id ] = item;
				}
			}
			this.moods = hash;
		},

		render: function() {
			var div = this.getTemplate();
			this.$el.replaceWith( div );
			this.setElement( div );
			InputboxView.prototype.render.apply( this, arguments );
		},

		set: function( value ) {
			this.resetTextntags( this.$textarea, value );
			this.flags.attachment && this.updateAttachment( false, false );
			this.flags.charcount && this.updateCharCounterProxy();
			this.onKeydownProxy();
		},

		reset: function() {
			this.resetTextntags( this.$textarea, '' );
			this.flags.attachment && this.updateAttachment( false, false );
			this.flags.charcount && this.updateCharCounterProxy();
			this.onKeydownProxy();
		},

		value: function() {
			return this.textareaValue;
		},

		updateInput: function() {
			InputboxView.prototype.updateInput.apply( this, arguments );
			var that = this;
			this.$textarea.textntags( 'val', function( text ) {
				that.textareaValue = text;
			});
		},

		updateAttachment: function( mood, location ) {
			var attachment = [];

			this.mood = mood || mood === false ? mood : this.mood;
			this.location = location || location === false ? location : this.location;

			if ( this.location && this.location.name ) {
				attachment.push( '<b>' + language.get('at') + ' ' + this.location.name + '</b>' );
			}

			if ( this.mood && this.moods[this.mood] ) {
				if ( typeof this.moods[this.mood][2] !== 'undefined' ) {
					attachment.push(
						'<img class="joms-emoticon" src="' + this.moods[this.mood][2] + '"> ' +
						'<b>' + this.moods[this.mood][1] + '</b>'
					);
				} else {
					attachment.push(
						'<i class="joms-emoticon joms-emo-' + this.mood + '"></i> ' +
						'<b>' + this.moods[this.mood][1] + '</b>'
					);
				}
			}

			if ( !attachment.length ) {
				this.$attachment.html('');
				this.$textarea.attr( 'placeholder', this.placeholder );
				return;
			}

			this.$attachment.html( ' &nbsp;&mdash; ' + attachment.join(' and ') + '.' );
			this.$textarea.removeAttr('placeholder');
		},

		getTemplate: function() {
			var hint = language.get('status.status_hint') || '',
				html = this.template({ placeholder: hint });

			return $( html );
		}

	});

});
