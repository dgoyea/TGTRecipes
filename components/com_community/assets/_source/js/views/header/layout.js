// -----------------------------------------------------------------------------
// views/header/layout
// -----------------------------------------------------------------------------

// dependencies
// ------------
define([
	'sandbox',
	'views/base',
	'utils/ajax'
],

// definition
// ----------
function( $, BaseView, ajax ) {

	return BaseView.extend({

		render: function() {
			var showCoverButtons = $.mobile;
			if ( showCoverButtons )
				this.showCoverButtons();

			this.updateNotification();
		},

		showCoverButtons: function() {
			var cover = $( '.js-focus-cover' );
			if ( !cover.length )
				return;

			var narrowScreen = cover.width() <= 480,
				buttons = $( '.js-focus-change-cover' );

			if ( narrowScreen )
				buttons.find('span').remove();

			buttons.css({
				display: 'block',
				zIndex: 20000
			});
		},

		updateNotification: function() {
			var that = this;
			ajax({
				fn: 'activities,ajaxGetTotalNotifications',
				data: [ '_dummy_' ],
				success: function( json ) {
					json || (json = {});

					if ( typeof json.newNotificationCount !== 'undefined' ) {
						that.updateGlobalNotification( +json.newNotificationCount );
						that.updateModuleGlobalNotification( +json.newNotificationCount );
					}

					if ( typeof json.newFriendInviteCount !== 'undefined' ) {
						that.updateFriendInviteNotification( +json.newFriendInviteCount );
						that.updateModuleFriendInviteNotification( +json.newFriendInviteCount );
					}

					if ( typeof json.newMessageCount !== 'undefined' ) {
						that.updateNewMessageNotification( +json.newMessageCount );
						that.updateModuleNewMessageNotification( +json.newMessageCount );
					}

					if ( json.nextPingDelay ) {
						window.setTimeout(function() {
							that.updateNotification();
						},  +json.nextPingDelay );
					}
				}
			});
		},

		updateGlobalNotification: function( count ) {
			try {
				if ( !( this.$globalnotif && this.$globalnotif.length ) )
					this.$globalnotif = $( '.joms-toolbar-global-notif' );

				var element = this.$globalnotif,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).remove();
					element.data( 'count', count );
					if ( count ) {
						element.append( '<span class="js-counter joms-rounded">' + count + '</span>' );
					}
				}

				// update title bar
				var regex = /^\(\d+\)\s/,
					oldTitle = '' + document.title,
					newTitle;

				count = count ? '(' + count + ') ' : '';
				newTitle = count + oldTitle.replace( regex, '' );
				if ( newTitle !== oldTitle )
					document.title = newTitle;

			} catch (e) {}
		},

		updateModuleGlobalNotification: function( count ) {
			try {
				if ( !( this.$globalnotifmod && this.$globalnotifmod.length ) )
					this.$globalnotifmod = $( '.joms-module-global-notif' );

				var element = this.$globalnotifmod,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).html( count || '' );
					element.data( 'count', count );
				}
			} catch (e) {}
		},

		updateFriendInviteNotification: function( count ) {
			try {
				if ( !( this.$friendnotif && this.$friendnotif.length ) )
					this.$friendnotif = $( '.joms-toolbar-friend-invite-notif' );

				var element = this.$friendnotif,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).remove();
					element.data( 'count', count );
					if ( count ) {
						element.append( '<span class="js-counter joms-rounded">' + count + '</span>' );
					}
				}
			} catch (e) {}
		},

		updateModuleFriendInviteNotification: function( count ) {
			try {
				if ( !( this.$friendnotifmod && this.$friendnotifmod.length ) )
					this.$friendnotifmod = $( '.joms-module-friend-invite-notif' );

				var element = this.$friendnotifmod,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).html( count || '' );
					element.data( 'count', count );
				}
			} catch (e) {}
		},

		updateNewMessageNotification: function( count ) {
			try {
				if ( !( this.$messagenotif && this.$messagenotif.length ) )
					this.$messagenotif = $( '.joms-toolbar-new-message-notif' );

				var element = this.$messagenotif,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).remove();
					element.data( 'count', count );
					if ( count ) {
						element.append( '<span class="js-counter joms-rounded">' + count + '</span>' );
					}
				}
			} catch (e) {}
		},

		updateModuleNewMessageNotification: function( count ) {
			try {
				if ( !( this.$messagenotifmod && this.$messagenotifmod.length ) )
					this.$messagenotifmod = $( '.joms-module-new-message-notif' );

				var element = this.$messagenotifmod,
					counter = +element.data( 'count' );

				if ( counter !== count ) {
					element.find( 'span' ).html( count || '' );
					element.data( 'count', count );
				}
			} catch (e) {}
		}

	});

});
