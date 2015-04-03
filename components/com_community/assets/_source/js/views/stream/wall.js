// -----------------------------------------------------------------------------
// views/stream/item
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/base',
	'utils/constants',
	'utils/language',
	'utils/uploader'
],

// definition
// ----------
function( $, BaseView, constants, language, Uploader ) {

	return BaseView.extend({

		el: '#community-walls',

		events: {
			'click [data-type=wall-newcomment] [data-action=save]': 'onWallAdd',
			'start [data-type=wall-newcomment] [data-action=save]': 'onWallAddStart',
			'click [data-type=wall-newcomment] [data-action=attach]': 'onWallAddAttach',
			'click [data-type=wall-newcomment] [data-action=remove-attach]': 'onWallAddRemoveAttach',
			'click [data-type=wall-comment] [data-action=edit]': 'onWallEdit',
			'start [data-type=wall-comment] [data-action=edit]': 'onWallEditStart',
			'click [data-type=wall-comment] [data-action=attach]': 'onWallAddAttach',
			'click [data-type=wall-comment] [data-action=remove-attach]': 'onWallAddRemoveAttach',
			'click [data-type=wall-comment] [data-action=cancel]': 'onWallEditCancel',
			'click [data-type=wall-comment] [data-action=save]': 'onWallEditSave',
			'click [data-type=wall-comment] [data-action=remove-preview]': 'onWallRemovePreview',
			'click [data-type=wall-comment] [data-action=remove-thumbnail]': 'onWallRemoveThumbnail',
			'click .joms-stream-thumb': 'onPreviewThumbnail'
		},

		render: function() {
			this._render();
		},

		_render: function() {
			this.$textarea = this.$('.cWall-Form [name=comment], .cMail-Compose [name=comment], .cInbox-Write [name=comment]').eq( 0 );
			this.url = this.$('[name=autocomplete_url]').val() || '';
			this.uniqueId = this.$('[name=unique_id]').val() || '';
			this.addFunction = this.$('[name=add_function]').val() || '';
			this.isPhotoAlbum = this.isPhoto = this.isVideo = this.isDiscussion = this.isInbox = false;

			var fn = this.addFunction.toLowerCase();
			if ( fn.indexOf('album') > -1 ) {
				this.isPhotoAlbum = true;
			} else if ( fn.indexOf('photo') > -1 ) {
				this.isPhoto = true;
			} else if ( fn.indexOf('video') > -1 ) {
				this.isVideo = true;
			} else if ( fn.indexOf('discussion') > -1 ) {
				this.isDiscussion = true;
			} else if ( fn.indexOf('inbox') > -1 ) {
				this.isInbox = true;
			}

			var initialized = this.$textarea.data('initialized');
			if ( !initialized ) {
				this.$textarea.data( 'original', this.$textarea.val() );
				this.$textarea.data( 'initialized', 1 );
				this.initTextntags( this.$textarea );
			}

			this.$textarea.textntags( 'val', this.$textarea.data('original') );
			this.initUploader();
		},

		// ---------------------------------------------------------------------
		// Add comment.
		// ---------------------------------------------------------------------

		onWallAdd: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				that = this;

			if ( this.$textarea.data('saving') )
				return;

			this.$textarea.data( 'saving', 1 );
			el.data( 'label', el.text() );
			el.html( language.get('saving') );
			el.prop( 'disabled', 'disabled' );
			el.attr( 'disabled', 'disabled' );

			this.$textarea.textntags( 'val', function( value ) {
				var photo = false,
					attachment = el.closest('form, .cStream-Form').find('.joms-stream-attachment');

				if ( attachment.is(':visible') ) {
					photo = attachment.find('.joms-thumbnail').find('img');
					photo = photo.data('photo_id');
				}

				value = value.replace( /^\s+|\s+$/g, '' );

				if ( !value && photo === false ) {
					that.$textarea.removeData( 'saving' );
					el.text( el.data( 'label' ) );
					el.prop( 'disabled', false );
					return;
				}

				jax.doneLoadingFunction = function() {
					jax.doneLoadingFunction = $.noop;
					that.$textarea.removeData( 'saving' );
					el.html( el.data('label') );
					el.prop( 'disabled', false );
					that.$textarea.textntags( 'reset' );
					attachment.hide();
				};

				if ( that.isVideo || that.isDiscussion ) {
					jax.call( 'community', that.addFunction, value, that.uniqueId, photo || '' );
				} else if ( that.isInbox ) {
					jax.call( 'community', that.addFunction, that.uniqueId, value, photo || '' );
				} else {
					jax.call( 'community', that.addFunction, value, that.uniqueId, '', photo || '' );
				}

			});

		},

		onWallAddStart: function() {
			this._render();
		},

		onWallAddAttach: function( e ) {
			e.preventDefault();

			this.uploader || this.initUploader();
			this.uploaderButton.click();
			this.uploaderTarget = $( e.target );
			this.uploaderAttachment = this.uploaderTarget.closest('form, .cStream-Form').find('.joms-stream-attachment');
		},

		onWallAddRemoveAttach: function( e ) {
			var target = $( e.target ),
				form = target.closest('form, .cStream-Form'),
				ct = form.find('.joms-stream-attachment');

			ct.find('.joms-thumbnail img').replaceWith( '<img>' );
			ct.hide();
		},

		onAdded: function( up ) {
			up.start();
			up.refresh();

			var ct = this.uploaderAttachment;
			var loading = ct.find('.joms-loading');
			var siblings = loading.siblings();

			siblings.find('img').replaceWith( '<img>' );
			siblings.hide();
			loading.show();
			ct.show();
		},

		onError: function() {
			this.uploaderAttachment.hide();
		},

		onPhotoUploaded: function( up, file, info ) {
			var json;
			try {
				json = JSON.parse( info.response );
			} catch ( e ) {}

			json || (json = {});

			if ( json.error ) {
				window.cWindowShow( null, 'Error', 450, 100 );
				window.cWindowAddContent( '<div>' + json.error + '</div>', '' );
			}

			var ct = this.uploaderAttachment;
			if ( !json.thumb_url || !json.photo_id ) {
				ct.hide();
				return;
			}

			var img = ct.find('.joms-thumbnail img');
			img.attr( 'src', json.thumb_url );
			img.data( 'photo_id', json.photo_id );
			ct.find('.joms-loading').hide().siblings().show();
		},

		// ---------------------------------------------------------------------
		// Edit comment.
		// ---------------------------------------------------------------------

		onWallEdit: function( e ) {
			e.preventDefault();

			var params = $( e.target ).attr('rel') || '';
			params = params.split('::');

			// editableFunc
			var ct = $( e.target ).closest('[data-type=wall-comment]');
			ct.data( 'fn', params[1] );

			jax.call(
				'community',
				'system,ajaxEditWall',
				params[0],
				params[1]
			);
		},

		onWallEditStart: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = el.closest('[data-type=wall-comment]'),
				textarea = ct.find('textarea');

			textarea.data( 'original', textarea.val() );
			this.initTextntags( textarea );
			textarea.textntags( 'val', textarea.data('original') );
		},

		onWallEditCancel: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				editor = el.closest('[data-type=wall-editor]'),
				content = editor.siblings('[data-type=wall-message]');

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.hide();
			content.show();
		},

		onWallEditSave: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				editor = el.closest('[data-type=wall-editor]'),
				content = editor.siblings('[data-type=wall-message]'),
				textarea;

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.data( 'saving', 1 );
			el.data( 'label', el.text() );
			el.html( language.get('saving') );
			el.prop( 'disabled', 'disabled' );
			el.attr( 'disabled', 'disabled' );

			textarea = editor.find('textarea');
			textarea.textntags( 'val', function( value ) {
				var attachment = editor.find('.joms-stream-attachment'),
					photo;

				if ( attachment.is(':visible') ) {
					photo = attachment.find('.joms-thumbnail').find('img');
					photo = photo.data('photo_id');
				} else if ( attachment.data('no_thumb') ) {
					photo = '0';
				} else {
					photo = '-1';
				}

				value = value.replace( /^\s+|\s+$/g, '' );

				var ct = el.closest('[data-type=wall-comment]'),
					id = ct.data('id'),
					fn = ct.data('fn');

				if ( !value && photo === '-1' ) {
					editor.hide();
					editor.removeData( 'saving' );
					el.text( el.data( 'label' ) );
					el.prop( 'disabled', false );
					if ( typeof window.wallRemove === 'function' )
						window.wallRemove( id );
					return;
				}

				jax.doneLoadingFunction = function() {
					jax.doneLoadingFunction = $.noop;
					editor.removeData( 'saving' );
					el.html( el.data('label') );
				};

				jax.call(
					'community',
					'system,ajaxUpdateWall',
					id,
					value,
					fn,
					photo
				);
			});

			editor.hide();
			content.show();
		},

		onWallRemovePreview: function( e ) {
			var el = $( e.target ).closest('[data-action=remove-preview]');
			if ( el.data('removing') ) return;
			el.data( 'removing', 1 );

			var ct = el.closest('[data-type=wall-comment]'),
				id = ct.data('id'),
				fn = 'system,ajaxRemoveWallPreview';

			if ( this.isInbox ) {
				fn = 'inbox,ajaxRemovePreview';
			}

			jax.call(
				'community',
				fn,
				id
			);

			return false;
		},

		onWallRemoveThumbnail: function( e ) {
			var el = $( e.target ).closest('[data-action=remove-thumbnail]');
			if ( el.data('removing') ) return;
			el.data( 'removing', 1 );

			var ct = el.closest('[data-type=wall-comment]'),
				id = ct.data('id'),
				fn = '';

			if ( this.isInbox ) {
				fn = 'inbox,ajaxRemoveThumbnail';
			}

			jax.call(
				'community',
				fn,
				id
			);

			return false;
		},


		// ---------------------------------------------------------------------
		// Preview thumbnail.
		// ---------------------------------------------------------------------

		onPreviewThumbnail: function( e ) {
			var elem = e.currentTarget,
				src = elem.src;

			src = src.replace( 'thumb_', '' );
			window.cWindowShow( null, '', 450, 0 );
			window.cWindowAddContent( '<div style="text-align:center"><img src="' + src + '"></div>' );
		},

		// ---------------------------------------------------------------------
		// Helper functions.
		// ---------------------------------------------------------------------

		initTextntags: function( textarea ) {
			var that = this;
			textarea.textntags({
				triggers: { '@': {
					uniqueTags: true,
					minChars: 1
				} },
				onDataRequest: function( mode, query, triggerChar, callback ) {
					if ( !(that.isPhotoAlbum || that.isPhoto || that.isVideo || that.isDiscussion || that.isInbox ))
						return;

					var uniqueId   = that.uniqueId,
						sep        = that.url.indexOf('?') > -1 ? '&' : '?',
						album      = that.isPhotoAlbum,
						photo      = that.isPhoto,
						video      = that.isVideo,
						discussion = that.isDiscussion,
						inbox      = that.isInbox,
						url        = that.url + sep,
						data       = ( inbox ? [] : (constants.get('friends') || []) ),
						filter, union, timer, result;

					union = function( base, items ) {
						var map, item;
						map = $.map( base, function( val ) { return '' + val.id; });
						items = items.slice(0);
						while ( items.length ) {
							item = items.shift();
							if ( map.indexOf( '' + item.id ) < 0 )
								base.push( item );
						}
						return base;
					};

					filter = function() {
						that.friends || (that.friends = {});
						data = data.slice(0);

						if ( that.friends[ uniqueId ] ) {
							data = union( data, that.friends[ uniqueId ]);
						}

						query = query.toLowerCase();
						result = $.filter( data, function( item ) { return item.name.toLowerCase().indexOf( query ) > -1; });
						callback( result );

						if ( !that.friends[ uniqueId ] ) {
							if ( album ) {
								url = url + 'albumid=' + that.uniqueId;
							} else if ( photo ) {
								url = url + 'photoid=' + that.uniqueId + '&rule=photo-comment';
							} else if ( video ) {
								url = url + 'videoid=' + that.uniqueId;
							} else if ( discussion ) {
								url = url + 'discussionid=' + that.uniqueId;
							} else if ( inbox ) {
								url = url + 'msgid=' + that.uniqueId;
							} else {
								return false;
							}

							if ( that.fetchTextntags )
								that.fetchTextntags.abort();

							that.fetchTextntags = $.ajax({
								url: url,
								dataType: 'json',
								success: function( json ) {
									var i, friends = [];

									if ( json && json.suggestions && json.suggestions.length ) {
										for ( i = 0; i < json.suggestions.length; i++ ) {
											friends.push({
												id: json.data[i],
												name: json.suggestions[i],
												avatar: json.img[i].replace( /^.+src="([^"]+)".+$/ , '$1'),
												type: 'contact'
											});
										}

										if ( inbox && friends.length < 3 ) {
											friends = [];
										}

										that.friends[ uniqueId ] = friends;

										data = union( data, that.friends[ uniqueId ]);
										result = $.filter( data, function( item ) { return item.name.toLowerCase().indexOf( query ) > -1; });
										callback( result );
									}
								},
								complete: function() {
									that.fetchTextntags = false;
								}
							});
						}
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
			});
		},

		initUploader: function() {
			var config = {},
				that, timer;

			if ( !this.uploader ) {
				this.uploaderContainer = $( '<div id="joms-wall-photo-uploader" style="width: 1px; height: 1px; overflow: hidden">' ).insertBefore( $( '#community-walls' ) );
				this.uploaderButton = $( '<button>' ).appendTo( this.uploaderContainer );
				config.url = 'index.php?option=com_community&view=photos&task=ajaxPreviewComment';
				config.filters = [{ title: 'Image files', extensions: 'jpg,jpeg,png,gif' }];
				config.browse_button = this.uploaderButton;
				config.container = this.uploaderContainer;
				config.multi_selection = false;
				this.uploader = new Uploader( config );
				if ( window.plupload ) {
					this.initUploaderDelay();
				} else {
					that = this;
					timer = window.setInterval(function() {
						if ( window.plupload ) {
							window.clearInterval( timer );
							that.initUploaderDelay();
						}
					}, 100 );
				}
			}
		},

		initUploaderDelay: function() {
			this.uploader.onAdded = $.bind( this.onAdded, this );
			this.uploader.onError = $.bind( this.onError, this );
			this.uploader.onUploaded = $.bind( this.onPhotoUploaded, this );
			this.uploader.init();
			this.uploaderButton = this.uploaderContainer.find('input[type=file]');
			this.uploaderAttachment = $('[data-type=wall-newcomment]').eq(0).find('.joms-stream-attachment');
		}

	});

});
