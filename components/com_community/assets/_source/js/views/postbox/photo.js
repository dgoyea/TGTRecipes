// -----------------------------------------------------------------------------
// views/postbox/photo
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'app',
	'views/postbox/default',
	'views/postbox/photo-preview',
	'views/inputbox/photo',
	'views/dropdown/mood',
	'views/widget/select',
	'utils/constants',
	'utils/language',
	'utils/uploader'
],

// definition
// ----------
function(
	$,
	App,
	DefaultView,
	PreviewView,
	InputboxView,
	MoodView,
	SelectWidget,
	constants,
	language,
	Uploader
) {

	return DefaultView.extend({

		subviews: {
			mood: MoodView
		},

		template: joms.jst[ 'html/postbox/photo' ],

		events: $.extend({}, DefaultView.prototype.events, {
			'click .joms-postbox-photo-upload': 'onPhotoAdd',
			'click li[data-tab=upload]': 'onPhotoAdd'
		}),

		initialize: function() {
			this.enableMood = +constants.get('conf.enablemood');
			if ( !this.enableMood )
				this.subviews = $.omit( this.subviews, 'mood' );

			DefaultView.prototype.initialize.apply( this );
		},

		render: function() {
			DefaultView.prototype.render.apply( this );

			this.$initial = this.$('.joms-postbox-inner-panel');
			this.$main = this.$('.joms-postbox-photo');

			this.$inputbox = this.$('.joms-postbox-inputbox');
			this.$preview = this.$('.joms-postbox-preview');
			this.$tabupload = this.$tabs.find('[data-tab=upload]');
			this.$tabmood = this.$tabs.find('[data-tab=mood]');

			if ( !this.enableMood )
				this.$tabmood.remove();

			this.$uploader = this.$('#joms-postbox-photo-upload');
			this.$uploaderParent = this.$uploader.parent();

			// inputbox
			this.inputbox = new InputboxView({ attachment: true, charcount: true });
			this.assign( this.$inputbox, this.inputbox );
			this.listenTo( this.inputbox, 'focus', this.onInputFocus );

			// initialize uploader
			var url = 'index.php?option=com_community&view=photos&task=ajaxPreview',
				settings = constants.get('settings') || {};

			if ( settings.isGroup )
				url += '&no_html=1&tmpl=component&groupid=' + ( constants.get('groupid') || '' );

			if ( $.ie ) {
				this.$uploader.appendTo( document.body );
				this.$uploader.show();
			}

			var upConfig = {
				container: 'joms-postbox-photo-upload',
				browse_button: 'joms-postbox-photo-upload-btn',
				url: url,
				filters: [{ title: 'Image files', extensions: 'jpg,jpeg,png,gif' }]
			};

			// resizing on mobile cause errors on android stock browser!
			if ( !$.mobile )
				upConfig.resize = { width: 2100, height: 2100, quality: 90 };

			this.uploader = new Uploader( upConfig );
			this.uploader.onAdded = $.bind( this.onPhotoAdded, this );
			this.uploader.onError = $.bind( this.onPhotoError, this );
			this.uploader.onProgress = $.bind( this.onPhotoProgress, this );
			this.uploader.onUploaded = $.bind( this.onPhotoUploaded, this );
			this.uploader.init();

			if ( $.ie ) {
				this.$uploader.hide();
				this.$uploader.appendTo( this.$uploaderParent );
			}

			return this;
		},

		showInitialState: function() {
			this.$main.hide();
			this.$initial.show();
			$.ie && ($.ieVersion < 10) && this.ieUploadButtonFix( true );
			this.inputbox && this.inputbox.single();
			this.preview && this.preview.remove();
			this.preview = false;
			this.showMoreButton();
			DefaultView.prototype.showInitialState.apply( this );
		},

		showMainState: function() {
			DefaultView.prototype.showMainState.apply( this );
			this.$action.hide();
			this.$initial.hide();
			this.$main.show();
			this.$save.show();
			$.ie && ($.ieVersion < 10) && this.ieUploadButtonFix();

			if ( App.postbox && App.postbox.value && App.postbox.value.length ) {
				this.inputbox.set( App.postbox.value[0] );
				App.postbox.value = false;
			}
		},

		showMoreButton: function() {
			this.$tabupload.show();
			this.$tabupload.css({ visibility: '' });
		},

		hideMoreButton: function() {
			this.subviews.mood ? this.$tabupload.hide() : this.$tabupload.css({ visibility: 'hidden' });
		},

		// ---------------------------------------------------------------------
		// Data validation and retrieval.
		// ---------------------------------------------------------------------

		reset: function() {
			DefaultView.prototype.reset.apply( this );
			this.inputbox && this.inputbox.reset();
			this.preview && this.preview.remove();
			this.preview = false;
		},

		value: function() {
			this.data.text = this.inputbox.value() || '';
			this.data.attachment = {};

			this.data.text = this.data.text.replace( /\n/g, '\\n' );

			var value;
			for ( var prop in this.subflags )
				if ( value = this.subviews[ prop ].value() )
					this.data.attachment[ prop ] = value;

			if ( this.preview )
				$.extend( this.data.attachment, this.preview.value() );

			return DefaultView.prototype.value.apply( this, arguments );
		},

		validate: function() {
			var value = this.value( true ),
				attachment = value[1] || {};

			if ( !attachment.id && attachment.id.length )
				return 'No image selected.';
		},

		// ---------------------------------------------------------------------
		// Photo preview event handlers.
		// ---------------------------------------------------------------------

		onPhotoAdd: function() {
			if ( this.uploading )
				return;

			var conf = constants.get('conf') || {},
				limit = +conf.limitphoto,
				uploaded = +conf.uploadedphoto;

			// max 8 images for 1 batch upload
			if ( this.preview && this.preview.pics && this.preview.pics.length >= 8 ) {
				window.alert( language.get('photo.batch_notice') );
				return;
			}

			// daily limit checking
			if ( this.preview && this.preview.pics && this.preview.pics.length )
				uploaded += this.preview.pics.length;

			if ( uploaded >= limit ) {
				window.alert( language.get('photo.upload_limit_exceeded') || 'You have reached the upload limit.' );
				return;
			}

			// Opera 12 and lower (Presto engine), and IE 10, cannot open File Dialog without clicking the input[type=file] element.
			if ( window.opera || ($.ie && $.ieVersion === 10) )
				this.$('#joms-postbox-photo-upload').find('input[type=file]').click();
			else
				this.uploader.open();
		},

		onPhotoAdded: function( up, files ) {
			if ( this.uploading )
				return;

			if ( !(files && files.length) )
				return;

			// max 8 images for 1 batch upload
			var curr = 0;
			if ( this.preview && this.preview.pics && this.preview.pics.length )
				curr = this.preview.pics.length;

			if ( curr + files.length > 8 ) {
				curr = curr + files.length - 8;
				files.splice( 0 - curr, curr );
				up.splice( 0 - curr, curr );
			}

			// daily limit checking
			var conf = constants.get('conf') || {},
				limit = +conf.limitphoto,
				uploaded = +conf.uploadedphoto;

			if ( this.preview && this.preview.pics && this.preview.pics.length )
				uploaded += this.preview.pics.length;

			var removed;
			if ( uploaded + files.length > limit ) {
				removed = uploaded + files.length - limit;
				files.splice( 0 - removed, removed );
				up.splice( 0 - removed, removed );
			}

			var div;
			if ( !this.preview ) {
				div = $('<div>').appendTo( this.$preview );
				this.preview = new PreviewView();
				this.assign( div, this.preview );
				this.listenTo( this.preview, 'update', function( num ) {
					if ( !num || num <= 0 ) {
						this.showInitialState();
						this.inputbox.single();
						this.uploading = 0;
						return;
					} else if ( num >= 8 ) {
						this.hideMoreButton();
					} else {
						this.showMoreButton();
					}

					this.inputbox[ num > 1 ? 'multiple' : 'single' ]();
				} );
			}

			this.showMainState();
			for ( var i = 0; i < files.length; i++ )
				this.preview.add( files[i] );

			this.uploading = files.length;
			this.$action.hide();

			up.start();
			up.refresh();
		},

		onPhotoError: function( up, file ) {
			if ( +file.code === +plupload.FILE_EXTENSION_ERROR ) {
				window.alert( 'Selected file type is not permitted.' );
			}
		},

		onPhotoProgress: function( up, file ) {
			this.preview.updateProgress( file );
		},

		onPhotoUploaded: function( up, file, info ) {
			var json;
			try {
				json = JSON.parse( info.response );
			} catch ( e ) {}

			json || (json = {});

			// onerror
			if ( !json.thumbnail ) {
				up.stop();
				up.splice();
				window.alert( json && json.msg || 'Undefined error.' );
				this.uploading = 0;
				this.$action.show();
				this.preview && this.preview.removeFailed();
				return;
			}

			this.uploading--;
			if ( this.uploading <= 0 )
				this.$action.show();

			if ( this.preview )
				this.preview.setImage( file, json );
		},

		// ---------------------------------------------------------------------
		// Dropdowns event handlers.
		// ---------------------------------------------------------------------

		onMoodSelect: function( mood ) {
			this.inputbox.updateAttachment( mood );
		},

		onMoodRemove: function() {
			this.inputbox.updateAttachment( false );
		},

		// ---------------------------------------------------------------------
		// Helper functions.
		// ---------------------------------------------------------------------

		getTemplate: function() {
			var html = this.template({
				juri: constants.get('juri'),
				language: {
					postbox: language.get('postbox') || {},
					status: language.get('status') || {},
					photo: language.get('photo') || {}
				}
			});

			return $( html ).hide();
		},

		getStaticAttachment: function() {
			if ( this.staticAttachment )
				return this.staticAttachment;

			this.staticAttachment = $.extend({},
				constants.get('postbox.attachment') || {},
				{ type: 'photo' }
			);

			return this.staticAttachment;
		},

		ieUploadButtonFix: function( initialState ) {
			if ( !this.ieUploadButtonFix.init ) {
				this.ieUploadButtonFix.init = true;
				this.$uploader.css({
					display: 'block',
					position: 'absolute',
					opacity: 0,
					width: '',
					height: ''
				}).children('button,form').css({
					display: 'block',
					position: 'absolute',
					width: '',
					height: '',
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				}).children('input').css({
					cursor: 'pointer',
					height: '100%'
				});
			}

			if ( initialState ) {
				this.$uploader.appendTo( this.$uploaderParent );
				this.$uploader.css({
					top: 12,
					right: 12,
					bottom: 12,
					left: 12
				}).children('form').css({
					width: '100%',
					height: '100%'
				});
			} else {
				this.$uploader.appendTo( this.$tabupload );
				this.$uploader.css({
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				});
			}
		}

	});

});
