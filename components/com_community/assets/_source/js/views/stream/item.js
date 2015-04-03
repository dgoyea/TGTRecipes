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

		el: '#activity-stream-container',

		events: {
			'click .dropdown-menu a[data-action=edit]': 'onEditStream',
			'click .dropdown-menu a[data-action=remove-tag]': 'onRemoveStreamTag',
			'click [data-type=stream-editor] [data-action=cancel]': 'onEditStreamCancel',
			'click [data-type=stream-editor] [data-action=save]': 'onEditStreamSave',
			'click [data-type=stream-action] [data-action=comment]': 'onCommentStreamAdd',
			'click [data-type=stream-comments] [data-action=reply]': 'onCommentStreamAdd',
			'click [data-type=stream-newcomment] [data-action=attach]': 'onCommentStreamAddAttach',
			'click [data-type=stream-newcomment] [data-action=remove-attach]': 'onCommentStreamAddRemoveAttach',
			'click [data-type=stream-newcomment] [data-action=cancel]': 'onCommentStreamAddCancel',
			'click [data-type=stream-newcomment] [data-action=save]': 'onCommentStreamAddSave',
			'click [data-type=stream-comment] [data-action=edit]': 'onCommentStreamEdit',
			'click [data-type=stream-comment] [data-action=attach]': 'onCommentStreamAddAttach',
			'click [data-type=stream-comment] [data-action=remove-attach]': 'onCommentStreamAddRemoveAttach',
			'click [data-type=stream-comment] [data-action=cancel]': 'onCommentStreamEditCancel',
			'click [data-type=stream-comment] [data-action=save]': 'onCommentStreamEditSave',
			'click [data-type=stream-comment] [data-action=remove]': 'onCommentStreamRemove',
			'click [data-type=stream-comment] [data-action=remove-tag]': 'onCommentStreamRemoveTag',
			'click [data-type=stream-comment] [data-action=remove-preview]': 'onCommentStreamRemovePreview',
			'click .joms-stream-thumb': 'onPreviewThumbnail'
		},

		render: function() {
			this.initUploader();
		},

		// ---------------------------------------------------------------------
		// Edit stream events.
		// ---------------------------------------------------------------------

		onEditStream: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( el ),
				content = ct.children('[data-type=stream-content]'),
				editor = ct.children('[data-type=stream-editor]');

			if ( editor.is(':visible') )
				return;

			content.hide();
			editor.show();
			this.resetStreamEditor( editor );
			this.focusTextarea( editor );
		},

		onEditStreamCancel: function( e ) {
			e.preventDefault();

			var ct = this.getContainer( e.target ),
				content = ct.children('[data-type=stream-content]'),
				editor = ct.children('[data-type=stream-editor]');

			if ( !editor.is(':visible') )
				return;

			editor.hide();
			content.show();
		},

		onEditStreamSave: function( e ) {
			e.preventDefault();

			var ct = this.getContainer( e.target ),
				content = ct.children('[data-type=stream-content]'),
				editor = ct.children('[data-type=stream-editor]'),
				that = this,
				textarea;

			if ( !editor.is(':visible') )
				return;

			textarea = editor.find('textarea');
			textarea.textntags( 'val', function( value ) {
				value = value.replace( /^\s+|\s+$/g, '' );
				if ( value ) {
					joms.stream.ajaxSaveStatus( that.getStreamId( ct ), value );
					editor.hide();
				} else {
					editor.hide();
					content.show();
				}
			});
		},

		// ---------------------------------------------------------------------
		// Add stream comment events.
		// ---------------------------------------------------------------------

		onCommentStreamAdd: function( e ) {
			e.preventDefault();

			var ct = this.getContainer( e.target ),
				editor = ct.find('[data-type=stream-newcomment]');

			if ( editor.is(':visible') )
				return;

			editor.show();
			this.resetStreamEditor( editor, true );
			this.focusTextarea( editor );
			this.hideAddCommentButton( ct );
			this.uploaderAttachment = ct.find('[data-type=stream-newcomment]').find('.joms-stream-attachment');
			this.uploaderAttachment.hide();
		},

		onCommentStreamAddAttach: function( e ) {
			e.preventDefault();

			this.uploader || this.initUploader();
			this.uploaderButton.click();
			this.uploaderTarget = $( e.target );
			this.uploaderAttachment = this.uploaderTarget.closest('form, .cStream-Form').find('.joms-stream-attachment');
		},

		onCommentStreamAddRemoveAttach: function( e ) {
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

		onCommentStreamAddCancel: function( e ) {
			e.preventDefault();

			var ct = this.getContainer( e.target ),
				editor = ct.find('[data-type=stream-newcomment]');

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.hide();
			this.showAddCommentButton( ct );
		},

		onCommentStreamAddSave: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( e.target ),
				editor = ct.find('[data-type=stream-newcomment]'),
				that = this,
				textarea;

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.data( 'saving', 1 );
			el.data( 'label', el.text() );
			el.html( language.get('saving') );
			el.prop( 'disabled', true );

			textarea = editor.find('textarea');
			textarea.textntags( 'val', function( value ) {
				var photo = false,
					attachment = editor.find('.joms-stream-attachment');

				if ( attachment.is(':visible') ) {
					photo = attachment.find('.joms-thumbnail').find('img');
					photo = photo.data('photo_id');
				}

				value = value.replace( /^\s+|\s+$/g, '' );

				if ( !value && photo === false ) {
					editor.hide();
					editor.removeData( 'saving' );
					el.text( el.data( 'label' ) );
					el.prop( 'disabled', false );
					that.showAddCommentButton( ct );
					return;
				}

				jax.doneLoadingFunction = function() {
					jax.doneLoadingFunction = $.noop;
					editor.removeData( 'saving' );
					el.html( el.data('label') );
					el.prop('disabled',false);
				};

				jax.call( 'community', 'system,ajaxStreamAddComment', that.getStreamId( ct ), value || '', photo || '' );
			});
		},

		// ---------------------------------------------------------------------
		// Edit stream comment events.
		// ---------------------------------------------------------------------

		onCommentStreamEdit: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( e.target ),
				content = el.closest('[data-type=stream-comment-content]'),
				editor = content.siblings('[data-type=stream-comment-editor]'),
				newCommentEditor = ct.find('[data-type=stream-newcomment]');

			if ( editor.is(':visible') )
				return;

			this.uploaderAttachment = editor.find('.joms-stream-attachment');

			newCommentEditor.hide();
			content.hide();
			editor.show();
			this.resetStreamEditor( editor, true );
			this.focusTextarea( editor );
			this.hideAddCommentButton( ct );
		},

		onCommentStreamEditCancel: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( e.target ),
				editor = el.closest('[data-type=stream-comment-editor]'),
				content = editor.siblings('[data-type=stream-comment-content]');

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.hide();
			content.show();
			this.showAddCommentButton( ct );
		},

		onCommentStreamEditSave: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( e.target ),
				editor = el.closest('[data-type=stream-comment-editor]'),
				content = editor.siblings('[data-type=stream-comment-content]'),
				that = this,
				textarea;

			if ( !editor.is(':visible') )
				return;

			if ( editor.data('saving') )
				return;

			editor.data( 'saving', 1 );
			el.data( 'label', el.text() );
			el.html( language.get('saving') );

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

				if ( !value && photo === '-1' ) {
					editor.hide();
					editor.removeData( 'saving' );
					el.text( el.data( 'label' ) );
					el.prop( 'disabled', false );
					that.showAddCommentButton( ct );
					that.onCommentStreamRemove( e );
					return;
				}

				var id = editor.closest('[data-type=stream-comment]').data('commentid');
				jax.doneLoadingFunction = function() {
					jax.doneLoadingFunction = $.noop;
					editor.removeData( 'saving' );
					el.html( el.data('label') );
				};

				jax.call( 'community', 'system,ajaxeditComment', id, value || '', photo );
			});

			editor.hide();
			content.show();
			this.showAddCommentButton( ct );
		},

		// ---------------------------------------------------------------------
		// Remove stream comment events.
		// ---------------------------------------------------------------------

		onCommentStreamRemove: function( e ) {
			e.preventDefault();

			var that = this,
				actions;

			actions = $([
				'<div><button class="btn" onclick="cWindowHide();">', language.get('no'),
				'</button><button class="btn btn-primary pull-right">', language.get('yes'),
				'</button></div>'
			].join(''));

			actions.on( 'click', '.btn-primary', function() {
				that.onCommentStreamRemoveConfirm( e );
				window.cWindowHide();
			});

			window.cWindowShow( null, language.get('stream.remove_comment'), 450, 100 );
			window.cWindowAddContent( '<div>' + language.get('stream.remove_comment_message') + '</div>', actions );
		},

		onCommentStreamRemoveConfirm: function( e ) {
			var ct = this.getContainer( e.target ),
				that = this;

			jax.loadingFunction = $.noop;
			jax.doneLoadingFunction = function() {
				jax.doneLoadingFunction = $.noop;

				var more = ct.find('[data-type=stream-more]'),
					counter = more.find('.wall-cmt-count'),
					n;

				if ( more && more.length ) {
					n = +counter.text();
					if ( n > 1 )
						counter.text( n - 1 );
					else
						more.remove();
				}

				that.showAddCommentButton( ct );
			};

			var el = $( e.target );

			jax.call(
				'community',
				'system,ajaxStreamRemoveComment',
				el.data('id') || el.closest('[data-type=stream-comment]').data('commentid')
			);
		},

		// ---------------------------------------------------------------------
		// Remove tag.
		// ---------------------------------------------------------------------

		onRemoveStreamTag: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				ct = this.getContainer( el ),
				editor = ct.children('[data-type=stream-editor]'),
				textarea = editor.find('textarea'),
				text = textarea.data('original') || textarea.val(),
				uid = constants.get('uid'),
				tag;

			if ( !uid )
				return;

			tag = this.getTagFromUid( text, uid );
			if ( !tag )
				return;

			jax.call(
				'community',
				'activities,ajaxRemoveUserTag',
				this.getStreamId( ct ),
				tag,
				'post'
			);
		},

		onCommentStreamRemoveTag: function( e ) {
			e.preventDefault();

			var el = $( e.target ),
				content = el.closest('[data-type=stream-comment-content]'),
				editor = content.siblings('[data-type=stream-comment-editor]'),
				textarea = editor.find('textarea'),
				text = textarea.data('original') || textarea.val(),
				uid = constants.get('uid'),
				tag;

			if ( !uid )
				return;

			tag = this.getTagFromUid( text, uid );
			if ( !tag )
				return;

			jax.call(
				'community',
				'activities,ajaxRemoveUserTag',
				editor.closest('[data-type=stream-comment]').data('commentid'),
				tag,
				'comment'
			);
		},

		onCommentStreamRemovePreview: function( e ) {
			e.preventDefault();

			var el = $( e.target ).closest('[data-action=remove-preview]');
			if ( el.data('removing') ) return;
			el.data( 'removing', 1 );

			jax.call(
				'community',
				'system,ajaxRemoveCommentPreview',
				el.closest('[data-type=stream-comment]').data('commentid')
			);
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

		getStreamId: function( el ) {
			return $( el )
				.closest('li[data-streamid]')
				.data('streamid');
		},

		getContainer: function( el ) {
			return $( el )
				.closest('li[data-streamid]')
				.children('.joms-stream-content');
		},

		getTagFromUid: function( text, uid ) {
			if ( !text || !uid )
				return false;

			var re = new RegExp( '@\\[\\[' + uid + ':contact:[^\\]]+\\]\\]' ),
				matches = text.match( re );

			return matches && matches[0];
		},

		focusTextarea: function( editor ) {
			var textarea, length;
			textarea = editor.find('textarea').focus();
			textarea = textarea[0];
			if ( textarea && textarea.setSelectionRange ) {
				length = textarea.value.length;
				textarea.setSelectionRange( length, length );
			}
		},

		hideAddCommentButton: function( ct ) {
			var comment = ct.find('[data-type=stream-action] [data-action=comment]'),
				reply = ct.find('[data-type=stream-reply]');

			comment.hide();
			reply.hide();
		},

		showAddCommentButton: function( ct ) {
			var comment = ct.find('[data-type=stream-action] [data-action=comment]'),
				reply = ct.find('[data-type=stream-reply]'),
				counter = reply.siblings('[data-type=stream-comment]').length,
				more = reply.siblings('[data-type=stream-more]').length;

			comment[ counter || more ? 'hide' : 'show' ]();
			reply[ counter || more ? 'show' : 'hide' ]();
		},

		resetStreamEditor: function( el, isComment ) {
			var textarea = $( el ).find('textarea'),
				initialized = textarea.data('initialized');

			if ( !initialized ) {
				textarea.data( 'original', textarea.val() );
				textarea.data( 'initialized', 1 );
				this.initTextntags( textarea, isComment );
			}

			textarea.textntags( 'val', textarea.data('original') );
		},

		initTextntags: function( textarea, isComment ) {
			var that = this;
			textarea.textntags({
				triggers: { '@': {
					uniqueTags: true,
					minChars: 1
				} },
				onDataRequest: function( mode, query, triggerChar, callback ) {
					var streamId = that.getStreamId( textarea ),
						data = constants.get('friends') || [],
						filter, union, timer, url, settings, result;

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

						if ( isComment && that.friends[ streamId ] ) {
							data = union( data, that.friends[ streamId ]);
						}

						query = query.toLowerCase();
						result = $.filter( data, function( item ) { return item.name.toLowerCase().indexOf( query ) > -1; });
						callback( result );

						if ( isComment && !that.friends[ streamId ] ) {
							url = 'index.php?option=com_community&view=friends&task=ajaxAutocomplete&type=comment&streamid=' + streamId;
							settings = constants.get('settings') || {};

							if ( settings.isGroup )
								url += '&groupid=' + constants.get('groupid');
							else if ( settings.isEvent )
								url += '&eventid=' + constants.get('eventid');

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

										that.friends[ streamId ] = friends;

										data = union( data, that.friends[ streamId ]);
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
			var config = {};
			if ( !this.uploader ) {
				this.uploaderContainer = $( '<div id="joms-comment-photo-uploader" style="width: 1px; height: 1px; overflow: hidden">' ).insertBefore( $( '#activity-stream-container' ) );
				this.uploaderButton = $( '<button>' ).appendTo( this.uploaderContainer );
				config.url = 'index.php?option=com_community&view=photos&task=ajaxPreviewComment';
				config.filters = [{ title: 'Image files', extensions: 'jpg,jpeg,png,gif' }];
				config.browse_button = this.uploaderButton;
				config.container = this.uploaderContainer;
				config.multi_selection = false;
				this.uploader = new Uploader( config );
				this.uploader.onAdded = $.bind( this.onAdded, this );
				this.uploader.onError = $.bind( this.onError, this );
				this.uploader.onUploaded = $.bind( this.onPhotoUploaded, this );
				this.uploader.init();
				this.uploaderButton = this.uploaderContainer.find('input[type=file]');
			}
		}

	});

});
