this["joms"] = this["joms"] || {};
this["joms"]["jst"] = this["joms"]["jst"] || {};
this["joms"]["jst"]["html/dropdown/event"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div class="joms-postbox-dropdown event-dropdown"> <div style="clear:both"> <div class=event-time-column> <span>' +((__t = ( data.language.event.category )) == null ? '' : __t) +' <span style="color:red">*</span></span> <div class="joms-event-category joms-select"></div> </div> <div class=event-time-column> <span>' +((__t = ( data.language.event.location )) == null ? '' : __t) +' <span style="color:red">*</span></span> <input type=text class=input-block-level name=location placeholder="' +((__t = ( data.language.event.location_hint )) == null ? '' : __t) +'"> </div> </div> <div style="clear:both"> <div class=event-time-column> <span>' +((__t = ( data.language.event.start )) == null ? '' : __t) +' <span style="color:red">*</span></span> <input type=text class="input-block-level joms-pickadate-startdate" placeholder="' +((__t = ( data.language.event.start_date_hint )) == null ? '' : __t) +'"> <input type=text class="input-block-level joms-pickadate-starttime" placeholder="' +((__t = ( data.language.event.start_time_hint )) == null ? '' : __t) +'"> <span class="event-all-day joms-event-allday" style="margin-left:0;visibility:hidden"> <span>All Day Event</span> <span style="position:relative"><i class=joms-icon-check-empty></i></span></span> </div> <div class=event-time-column> <span>' +((__t = ( data.language.event.end )) == null ? '' : __t) +' <span style="color:red">*</span></span> <input type=text class="input-block-level joms-pickadate-enddate" placeholder="' +((__t = ( data.language.event.end_date_hint )) == null ? '' : __t) +'"> <input type=text class="input-block-level joms-pickadate-endtime" placeholder="' +((__t = ( data.language.event.end_time_hint )) == null ? '' : __t) +'"> </div> </div> <nav class="joms-postbox-tab selected"> <div class="joms-postbox-action event-action"> <button class=joms-postbox-done>' +((__t = ( data.language.event.done_button )) == null ? '' : __t) +'</button> </div> </nav> </div>';return __p};
this["joms"]["jst"]["html/dropdown/location-list"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') } if ( data && data.items && data.items.length ) for ( var i = 0; i < data.items.length; i++ ) { ;__p += ' <li data-index="' +((__t = ( i )) == null ? '' : __t) +'"> <p class=reset-gap>' +((__t = ( data.items[i].name )) == null ? '' : __t) +'</p> <span>' +((__t = ( data.items[i].vicinity || data.language.geolocation.near_here )) == null ? '' : __t) +'</span> </li> '; } else { ;__p += ' <li><em>' +((__t = ( data.language.geolocation.empty )) == null ? '' : __t) +'</em></li> '; } ;return __p};
this["joms"]["jst"]["html/dropdown/location"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div class="joms-postbox-dropdown location-dropdown"> <div class=joms-postbox-map></div> <div class="joms-postbox-action joms-location-action"> <button class=joms-add-location><i class=joms-icon-map-marker></i>' +((__t = ( data.language.geolocation.select_button )) == null ? '' : __t) +'</button> <button class=joms-remove-location><i class=joms-icon-remove></i>' +((__t = ( data.language.geolocation.remove_button )) == null ? '' : __t) +'</button> </div> <input class=joms-postbox-keyword type=text> <ul class=joms-postbox-locations></ul> </div>';return __p};
this["joms"]["jst"]["html/dropdown/mood"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div class="joms-postbox-dropdown mood-dropdown"> <ul class="joms-postbox-emoticon unstyled clearfix"> '; if ( data && data.items && data.items.length ) for ( var i = 0; i < data.items.length; i++ ) { ;__p += ' <li data-mood="' +((__t = ( data.items[i][0] )) == null ? '' : __t) +'"> '; if ( typeof data.items[i][2] !== 'undefined') { ;__p += ' <div><img class=joms-emoticon src="' +((__t = ( data.items[i][2] )) == null ? '' : __t) +'"><span>' +((__t = ( data.items[i][1] )) == null ? '' : __t) +'</span></div> '; } else { ;__p += ' <div><i class="joms-emoticon joms-emo-' +((__t = ( data.items[i][0] )) == null ? '' : __t) +'"></i><span>' +((__t = ( data.items[i][1] )) == null ? '' : __t) +'</span></div> '; } ;__p += ' </li> '; } ;__p += ' <li class=joms-remove-button>' +((__t = ( data.language.status.remove_mood_button )) == null ? '' : __t) +'</li> </ul> </div>';return __p};
this["joms"]["jst"]["html/dropdown/privacy"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div class="joms-postbox-dropdown privacy-dropdown"> <ul class=unstyled> '; if ( data && data.items && data.items.length ) for ( var i = 0; i < data.items.length; i++ ) { ;__p += ' <li data-priv="' +((__t = ( data.items[i][0] )) == null ? '' : __t) +'"> <p class=reset-gap><i class="joms-icon-' +((__t = ( data.items[i][1] )) == null ? '' : __t) +'"></i>' +((__t = ( data.items[i][2] )) == null ? '' : __t) +'</p> <span>' +((__t = ( data.items[i][3] )) == null ? '' : __t) +'</span> </li> '; } ;__p += ' </ul> </div>';return __p};
this["joms"]["jst"]["html/inputbox/eventdesc"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class=input placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> <div class="charcount joms-postbox-charcount"></div> </div>';return __p};
this["joms"]["jst"]["html/inputbox/eventtitle"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox" style="padding:0; border-bottom:0; min-height:0"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class=input placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> </div>';return __p};
this["joms"]["jst"]["html/inputbox/photo"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class="input input-photo-desc" placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> <div class="charcount joms-postbox-charcount"></div> </div>';return __p};
this["joms"]["jst"]["html/inputbox/status"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class="input input-status" placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> <div class="charcount joms-postbox-charcount"></div> </div>';return __p};
this["joms"]["jst"]["html/inputbox/video"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class="input joms-postbox-video-description" placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> <div class="charcount joms-postbox-charcount"></div> </div>';return __p};
this["joms"]["jst"]["html/inputbox/videourl"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div style="position:relative"> <div class="joms-postbox-input joms-inputbox" style="padding:0; border-bottom:0; min-height:0"> <div class=inputbox> <div style="position:relative"> <span class=input></span> <textarea class="input joms-postbox-video-url" placeholder="' +((__t = ( data && data.placeholder || '' )) == null ? '' : __t) +'" style="min-height:1.4em"></textarea> </div> </div> </div> </div>';return __p};
this["joms"]["jst"]["html/postbox/custom"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div> <div class=joms-postbox-inner-panel> <div class=joms-postbox-double-panel> <ul class="unstyled clearfix"> <li class=joms-postbox-predefined-message><i class=joms-icon-cog></i> ' +((__t = ( data.language.custom.predefined_button )) == null ? '' : __t) +'</li> <li class=joms-postbox-custom-message><i class=joms-icon-pencil></i> ' +((__t = ( data.language.custom.custom_button )) == null ? '' : __t) +'</li> </ul> </div> </div> <div class=joms-postbox-custom> <div class=joms-postbox-custom-state-predefined> <div class=joms-postbox-inner-panel> <span>' +((__t = ( data.language.custom.predefined_label )) == null ? '' : __t) +'</span><br> <select name=predefined style="width: 100%"> '; if ( data && data.messages && data.messages.length ) { ;__p += ' '; for ( var i = 0; i < data.messages.length; i++ ) { ;__p += ' <option value="' +((__t = ( data.messages[i][0] )) == null ? '' : __t) +'">' +((__t = ( data.messages[i][1] )) == null ? '' : __t) +'</option> '; } ;__p += ' '; } ;__p += ' </select> </div> </div> <div class=joms-postbox-custom-state-custom> <div class=joms-postbox-inner-panel> <span>' +((__t = ( data.language.custom.custom_label )) == null ? '' : __t) +'</span><br> <textarea name=custom></textarea> </div> </div> <nav class="joms-postbox-tab selected"> <ul class=unstyled> <li data-tab=privacy><i></i><span class=visible-desktop></span></li> </ul> <div class=joms-postbox-action> <button class=joms-postbox-cancel>' +((__t = ( data.language.postbox.cancel_button )) == null ? '' : __t) +'</button> <button class=joms-postbox-save>' +((__t = ( data.language.postbox.post_button )) == null ? '' : __t) +'</button> </div> <div class=joms-postbox-loading style="display:none;"> <img src="' +((__t = ( data.juri.root )) == null ? '' : __t) +'components/com_community/assets/ajax-loader.gif"> <div </nav> <div class="joms-postbox-dropdown privacy-dropdown"></div> </div> </div>';return __p};
this["joms"]["jst"]["html/postbox/event"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div class=joms-postbox-event> <div class=joms-postbox-inner-panel> <div class=joms-postbox-title></div> <div class=joms-postbox-event-detail> <div class="joms-postbox-event-panel joms-postbox-event-label-category" style="display:none"> <div class=joms-postbox-event-title style="padding-bottom:0;padding-top:8px"> <div class=joms-input-field-name>' +((__t = ( data.language.event.category )) == null ? '' : __t) +'</div> <span class=joms-input-text style="display:inline-block"></span> </div> </div> <div class="joms-postbox-event-panel joms-postbox-event-label-location" style="display:none"> <div class=joms-postbox-event-title style="padding-bottom:0;padding-top:8px"> <div class=joms-input-field-name>' +((__t = ( data.language.event.location )) == null ? '' : __t) +'</div> <span class=joms-input-text style="display:inline-block"></span> </div> </div> <div class="joms-postbox-event-panel joms-postbox-event-label-date" style="display:none"> <div class=joms-postbox-event-title style="padding-bottom:0;padding-top:8px"> <div class=joms-input-field-name>' +((__t = ( data.language.event.date_and_time )) == null ? '' : __t) +'</div> <span class=joms-input-text style="display:inline-block"></span> </div> </div> </div> </div> <div class=joms-postbox-inputbox></div> <nav class="joms-postbox-tab selected"> <ul class=unstyled> <li data-tab=event><i class=joms-icon-cog></i><span class=visible-desktop>' +((__t = ( data.language.event.event_detail )) == null ? '' : __t) +'</span></li> </ul> <div class=joms-postbox-action> <button class=joms-postbox-cancel>' +((__t = ( data.language.postbox.cancel_button )) == null ? '' : __t) +'</button> <button class=joms-postbox-save>' +((__t = ( data.language.postbox.post_button )) == null ? '' : __t) +'</button> </div> <div class=joms-postbox-loading style="display:none;"> <img src="' +((__t = ( data.juri.root )) == null ? '' : __t) +'components/com_community/assets/ajax-loader.gif"> <div </nav> </div>';return __p};
this["joms"]["jst"]["html/postbox/fetcher-video"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div class=joms-fetched-wrapper> '; if ( data.image ) { ;__p += ' <div class=joms-fetched-images> <img src="' +((__t = ( data.image )) == null ? '' : __t) +'"> </div> '; } ;__p += ' <div class="joms-fetched-field joms-fetched-title"> <span style="font-weight:bold">' +((__t = ( data.title || data.titlePlaceholder )) == null ? '' : __t) +'</span> <input type=text value="' +((__t = ( __e( data.title || '' ) )) == null ? '' : __t) +'" > </div> <div class="joms-fetched-field joms-fetched-description"> <span>' +((__t = ( data.description || data.descPlaceholder )) == null ? '' : __t) +'</span> <textarea >' +((__t = ( data.description || '' )) == null ? '' : __t) +'</textarea> </div> <div class=clearfix></div> <span class=joms-fetched-close ><i class=joms-icon-remove></i>' +((__t = ( data.lang.cancel )) == null ? '' : __t) +'</span> <div style="padding-top:10px"> <div class="joms-fetched-category joms-select"></div> </div> </div>';return __p};
this["joms"]["jst"]["html/postbox/fetcher"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div class=joms-postbox-inner-panel> <div style="position:relative"> <div class=joms-fetched-images> '; if ( data.image && data.image.length ) { ;__p += ' <div style="height:120px"> '; for ( var i = 0; i < data.image.length; i++ ) { ;__p += ' <img src="' +((__t = ( data.image[i] )) == null ? '' : __t) +'" style="width:100%;height:100%;' +((__t = ( i ? 'display:none' : '' )) == null ? '' : __t) +'"> '; } ;__p += ' </div> '; if ( data.image.length > 1 ) { ;__p += ' <div class=joms-fetched-nav style="text-align:center"> <span class=joms-fetched-previmg style="cursor:pointer">&laquo; ' +((__t = ( data.lang.prev )) == null ? '' : __t) +'</span> &nbsp;&nbsp; <span class=joms-fetched-nextimg style="cursor:pointer">' +((__t = ( data.lang.next )) == null ? '' : __t) +' &raquo;</span> </div> '; } ;__p += ' '; } else { ;__p += ' <div style="height:120px;width:120px;background-color:#F9F9F9;color:7F8C8D;text-align:center;vertical"> &nbsp;<br>&nbsp;<br>no<br>thumbnail </div> '; } ;__p += ' </div> <div class="joms-fetched-field joms-fetched-title"> <span style="font-weight:bold">' +((__t = ( data.title || data.titlePlaceholder )) == null ? '' : __t) +'</span> <input type=text value="' +((__t = ( __e( data.title || '' ) )) == null ? '' : __t) +'" > </div> <div class="joms-fetched-field joms-fetched-description"> <span>' +((__t = ( data.description || data.descPlaceholder )) == null ? '' : __t) +'</span> <textarea>' +((__t = ( data.description || '' )) == null ? '' : __t) +'</textarea> </div> <div class=clearfix></div> <span class=joms-fetched-close style="top:0"><i class=joms-icon-remove></i>' +((__t = ( data.lang.cancel )) == null ? '' : __t) +'</span> </div> </div>';return __p};
this["joms"]["jst"]["html/postbox/photo-item"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<li id="' +((__t = ( data.id )) == null ? '' : __t) +'" class=joms-postbox-photo-item> <div class=img-wrapper> <img src="' +((__t = ( data.src )) == null ? '' : __t) +'" > </div> <div class=joms-postbox-photo-action style="display:none"> <span class=joms-postbox-photo-remove><i class=joms-icon-remove></i></span> </div> <div class=joms-postbox-photo-progressbar> <div class=joms-postbox-photo-progress></div> </div> </li>';return __p};
this["joms"]["jst"]["html/postbox/photo-preview"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div class=joms-postbox-photo-preview> <ul class="unstyled clearfix"></ul> <div class=joms-postbox-photo-form></div> </div>';return __p};
this["joms"]["jst"]["html/postbox/photo"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<div> <div id=joms-postbox-photo-upload style="position:absolute;top:0;left:0;width:1px;height:1px;overflow:hidden"> <button id=joms-postbox-photo-upload-btn>Upload</button> </div> <div class=joms-postbox-inner-panel style="position:relative"> <div class=joms-postbox-photo-upload> <i class=joms-icon-picture></i> ' +((__t = ( data.language.photo.upload_button )) == null ? '' : __t) +' </div> </div> <div class=joms-postbox-photo> <div class=joms-postbox-preview></div> <div class=joms-postbox-inputbox></div> <nav class="joms-postbox-tab selected"> <ul class=unstyled> <li data-tab=upload data-bypass=1><i class=joms-icon-picture></i><span class=visible-desktop>' +((__t = ( data.language.photo.upload_button_more )) == null ? '' : __t) +'</span></li> <li data-tab=mood><i class=joms-icon-smiley></i><span class=visible-desktop>' +((__t = ( data.language.status.mood )) == null ? '' : __t) +'</span></li> </ul> <div class=joms-postbox-action> <button class=joms-postbox-cancel>' +((__t = ( data.language.postbox.cancel_button )) == null ? '' : __t) +'</button> <button class=joms-postbox-save>' +((__t = ( data.language.postbox.post_button )) == null ? '' : __t) +'</button> </div> <div class=joms-postbox-loading style="display:none;"> <img src="' +((__t = ( data.juri.root )) == null ? '' : __t) +'components/com_community/assets/ajax-loader.gif"> </div> </nav> </div> </div>';return __p};
this["joms"]["jst"]["html/postbox/status"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div class=joms-postbox-status> <div class=joms-postbox-fetched></div> <div class=joms-postbox-inputbox></div> <nav class="joms-postbox-tab selected"> <ul class=unstyled> <li data-tab=mood><i class=joms-icon-smiley></i></li> <li data-tab=location><i class=joms-icon-map-marker></i></li> <li data-tab=privacy><i></i></li> '; if ( data.enablephoto ) { ;__p += ' <li data-tab=photo data-bypass=1><i class=joms-icon-picture></i></li> '; } ;__p += ' '; if ( data.enablevideo ) { ;__p += ' <li data-tab=video data-bypass=1><i class=joms-icon-videocam></i></li> '; } ;__p += ' </ul> <div class=joms-postbox-action> <button class=joms-postbox-cancel>' +((__t = ( data.language.postbox.cancel_button )) == null ? '' : __t) +'</button> <button class=joms-postbox-save>' +((__t = ( data.language.postbox.post_button )) == null ? '' : __t) +'</button> </div> <div class=joms-postbox-loading style="display:none;"> <img src="' +((__t = ( data.juri.root )) == null ? '' : __t) +'components/com_community/assets/ajax-loader.gif"> <div> </nav> </div>';return __p};
this["joms"]["jst"]["html/postbox/video-item"] = function(data) {var __t, __p = '', __e = _.escape;__p += '<li class=joms-postbox-photo-item> <img width=128 height=128 src="' +((__t = ( data.src )) == null ? '' : __t) +'"> <div class=joms-postbox-photo-action> <span class=joms-postbox-photo-setting><i class=joms-icon-cog></i></span> <span class=joms-postbox-photo-remove><i class=joms-icon-remove></i></span> </div> </li>';return __p};
this["joms"]["jst"]["html/postbox/video"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<div> <div id=joms-postbox-video-upload style="position:absolute;top:0;left:0;width:1px;height:1px;overflow:hidden"> <button id=joms-postbox-video-upload-btn>Upload</button> </div> '; if ( data && data.enable_upload ) { ;__p += ' <div class="joms-postbox-inner-panel joms-initial-panel"> <div class=joms-postbox-double-panel> <ul class="unstyled clearfix"> <li class=joms-postbox-video-url data-action=share><i class=joms-icon-link></i> ' +((__t = ( data.language.video.share_button )) == null ? '' : __t) +'</li> <li class=joms-postbox-video-upload data-action=upload><i class=joms-icon-cloud-upload></i> ' +((__t = ( data.language.video.upload_button )) == null ? '' : __t) +' '; if ( data && data.video_maxsize > 0 ) { ;__p += ' <span>' +((__t = ( data.language.video.upload_maxsize )) == null ? '' : __t) +' ' +((__t = ( data.video_maxsize )) == null ? '' : __t) +'mb</span> '; } ;__p += ' </li> </ul> </div> </div> '; } ;__p += ' <div class=joms-postbox-video> <div class=joms-postbox-video-state-url style="display:none"> <div class=joms-postbox-inner-panel> <div class=joms-postbox-url></div> <div class=joms-postbox-fetched></div> </div> </div> '; if ( data && data.enable_upload ) { ;__p += ' <div class=joms-postbox-video-state-upload style="display:none"> <div class=joms-postbox-inner-panel> <div class=joms-postbox-url></div> <div style="padding-top: 3px;"> <div class=joms-postbox-photo-progressbar style="position:relative;top:auto;bottom:auto;left:auto;right:auto;background-color:#eee;"> <div class=joms-postbox-photo-progress style="width:0"></div> </div> </div> <div style="padding-top: 10px;"> <div class="joms-fetched-category joms-select"></div> </div> </div> </div> '; } ;__p += ' <div class=joms-postbox-inputbox></div> <nav class="joms-postbox-tab selected"> <ul class=unstyled> <li data-tab=mood><i class=joms-icon-smiley></i><span class=visible-desktop>' +((__t = ( data.language.status.mood )) == null ? '' : __t) +'</span></li> <li data-tab=location><i class=joms-icon-map-marker></i><span class=visible-desktop>' +((__t = ( data.language.video.location )) == null ? '' : __t) +'</span></li> <li data-tab=privacy><i></i><span class=visible-desktop></span></li> </ul> <div class=joms-postbox-action> <button class=joms-postbox-cancel>' +((__t = ( data.language.postbox.cancel_button )) == null ? '' : __t) +'</button> <button class=joms-postbox-save>' +((__t = ( data.language.postbox.post_button )) == null ? '' : __t) +'</button> </div> <div class=joms-postbox-loading style="display:none;"> <img src="' +((__t = ( data.juri.root )) == null ? '' : __t) +'components/com_community/assets/ajax-loader.gif"> <div> </nav> </div> </div>';return __p};
this["joms"]["jst"]["html/widget/select-album"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<span>' +((__t = ( data.placeholder || '' )) == null ? '' : __t) +'</span> <ul class=unstyled style="display:none;"> '; if ( data.options && data.options.length ) for ( var i = 0; i < data.options.length; i++ ) { ;__p += ' <li data-value="' +((__t = ( data.options[i][0] )) == null ? '' : __t) +'"> <p class=reset-gap>' +((__t = ( data.options[i] && data.options[i][1] || '-' )) == null ? '' : __t) +'</p> <small><i class="joms-icon-' +((__t = ( data.options[i] && data.options[i][3] ? '' + data.options[i][3] : 'globe' )) == null ? '' : __t) +'"></i> ' +((__t = ( data.options[i] && data.options[i][2] ? '' + data.options[i][2] : '-' )) == null ? '' : __t) +'</small> </li> '; } ;__p += ' </ul>';return __p};
this["joms"]["jst"]["html/widget/select-form"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<span>' +((__t = ( data.placeholder || '' )) == null ? '' : __t) +'</span> <ul class=unstyled style="display:none;"> '; if ( data.options && data.options.length ) for ( var i = 0; i < data.options.length; i++ ) { ;__p += ' <li data-value="' +((__t = ( data.options[i][0] )) == null ? '' : __t) +'">' +((__t = ( data.options[i][1] )) == null ? '' : __t) +'</li> '; } ;__p += ' </ul> <div>abc</div>';return __p};
this["joms"]["jst"]["html/widget/select"] = function(data) {var __t, __p = '', __e = _.escape, __j = Array.prototype.join;function print() { __p += __j.call(arguments, '') }__p += '<span>' +((__t = ( data.placeholder || '' )) == null ? '' : __t) +'</span> <ul class=unstyled style="display:none;"> '; if ( data.options && data.options.length ) for ( var i = 0; i < data.options.length; i++ ) { ;__p += ' <li data-value="' +((__t = ( data.options[i][0] )) == null ? '' : __t) +'">' +((__t = ( data.options[i][1] )) == null ? '' : __t) +'</li> '; } ;__p += ' </ul>';return __p};