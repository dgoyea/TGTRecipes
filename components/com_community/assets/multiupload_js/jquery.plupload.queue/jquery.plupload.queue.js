!function(a){function b(a){return plupload.translate(a)||a}function c(c,d){d.contents().each(function(b,c){c=a(c),c.is(".plupload")||c.remove()}),d.prepend('<div class="plupload_wrapper plupload_scroll"><div id="'+c+'_container" class="plupload_container"><div class="plupload"><div class="plupload_header"><div class="plupload_header_content"><div class="plupload_header_title">'+b("Select files")+'</div><div class="plupload_header_text">'+b("Add files to the upload queue and click the start button.")+'</div></div></div><div class="plupload_content"><div class="plupload_filelist_header"><div class="plupload_file_name">'+b("Filename")+'</div></div><ul id="'+c+'_filelist" class="plupload_filelist"></ul><div class="plupload_filelist_footer"><div class="plupload_file_name"><div class="plupload_buttons"><a href="#" class="plupload_button plupload_add">'+b("Add files")+'</a><a href="#" class="plupload_button plupload_start">'+e.start_upload+'</a></div><span class="plupload_upload_status"></span></div><div class="plupload_file_status"><span class="plupload_total_status">0%</span></div><div class="plupload_progress"><div class="plupload_progress_container"><div class="plupload_progress_bar"></div></div></div><div class="plupload_clearer">&nbsp;</div></div></div></div></div><input type="hidden" id="'+c+'_count" name="'+c+'_count" value="0" /></div>')}var d={},e={size:"Size",status:"Status",drag_files:"Drag files here.",start_upload:"Start upload"};a.extend(e,joms&&joms.language&&joms.language.multiupload||{}),a.fn.pluploadQueue=function(f){return f?(this.each(function(){function g(b){var c;b.status==plupload.DONE&&(c="plupload_done"),b.status==plupload.FAILED&&(c="plupload_failed"),b.status==plupload.QUEUED&&(c="plupload_delete"),b.status==plupload.UPLOADING&&(c="plupload_uploading");var d=a("#"+b.id).attr("class",c).find("a").css("display","block");b.hint&&d.attr("title",b.hint)}function h(){a("span.plupload_total_status",k).html(j.total.percent+"%"),a("div.plupload_progress_bar",k).css("width",j.total.percent+"%"),a("span.plupload_upload_status",k).html(b("Uploaded %d/%d files").replace(/%d\/%d/,j.total.uploaded+"/"+j.files.length))}function i(){var c,d=a("ul.plupload_filelist",k).html(""),f=0;a.each(j.files,function(b,h){c="",h.status==plupload.DONE&&(h.target_name&&(c+='<input type="hidden" name="'+l+"_"+f+'_tmpname" value="'+plupload.xmlEncode(h.target_name)+'" />'),c+='<input type="hidden" name="'+l+"_"+f+'_name" value="'+plupload.xmlEncode(h.name)+'" />',c+='<input type="hidden" name="'+l+"_"+f+'_status" value="'+(h.status==plupload.DONE?"done":"failed")+'" />',f++,a("#"+l+"_count").val(f)),d.append('<li id="'+h.id+'"><div class="plupload_file_action"><a href="#"></a></div><div class="plupload_file_name"><span>'+h.name+'</span></div><div class="plupload_file_size">'+e.size+": "+plupload.formatSize(h.size)+'</div><div class="plupload_file_status">'+e.status+": "+h.percent+"%</div>"+c+"</li>"),g(h),a("#"+h.id+".plupload_delete a").click(function(b){a("#"+h.id).remove(),j.removeFile(h),b.preventDefault()})}),a("span.plupload_total_file_size",k).html(plupload.formatSize(j.total.size)),a("span.plupload_add_text",k).html(0===j.total.queued?b("Add files."):j.total.queued+" files queued."),a("a.plupload_start",k).toggleClass("plupload_disabled",j.files.length==j.total.uploaded+j.total.failed),d[0].scrollTop=d[0].scrollHeight,h(),!j.files.length&&j.features.dragdrop&&j.settings.dragdrop&&a("#"+l+"_filelist").append('<li class="plupload_droptext">'+e.drag_files+"</li>")}var j,k,l;k=a(this),l=k.attr("id"),l||(l=plupload.guid(),k.attr("id",l)),j=new plupload.Uploader(a.extend({dragdrop:!0,container:l},f)),d[l]=j,j.bind("UploadFile",function(b,c){a("#"+c.id).addClass("plupload_current_file")}),j.bind("Init",function(b,d){c(l,k),!f.unique_names&&f.rename&&k.on("click","#"+l+"_filelist div.plupload_file_name span",function(c){var d,e,f,g=a(c.target),h="";d=b.getFile(g.parents("li")[0].id),f=d.name,e=/^(.+)(\.[^.]+)$/.exec(f),e&&(f=e[1],h=e[2]),g.hide().after('<input type="text" />'),g.next().val(f).focus().blur(function(){g.show().next().remove()}).keydown(function(b){var c=a(this);-1!==a.inArray(b.keyCode,[13,27])&&(b.preventDefault(),13===b.keyCode&&(d.name=c.val()+h,g.html(d.name)),c.blur())})}),a("a.plupload_add",k).attr("id",l+"_browse"),b.settings.browse_button=l+"_browse",b.features.dragdrop&&b.settings.dragdrop&&(b.settings.drop_element=l+"_filelist",a("#"+l+"_filelist").append('<li class="plupload_droptext">'+e.drag_files+"</li>")),a("#"+l+"_container").attr("title","Using runtime: "+d.runtime),a("a.plupload_start",k).click(function(b){a(this).hasClass("plupload_disabled")||j.start(),b.preventDefault()}),a("a.plupload_stop",k).click(function(a){a.preventDefault(),j.stop()}),a("a.plupload_start",k).addClass("plupload_disabled");var g,h,i=navigator.userAgent.toLowerCase(),m=!1;window.opera?m=!0:(g=!!i.match(/msie/i),h=g&&+i.match(/msie (\d+)\./i)[1],g&&10===h&&(m=!0)),m&&a("#"+l+"_browse").click(function(b){b.preventDefault(),b.stopPropagation(),a("#"+l+" .plupload input[type=file]").click()})}),j.init(),j.bind("Error",function(c,d){var e,f=d.file;f&&(e=d.message,d.details&&(e+=" ("+d.details+")"),d.code==plupload.FILE_SIZE_ERROR&&alert(b("Error: File too large: ")+f.name),d.code==plupload.FILE_EXTENSION_ERROR&&alert(b("Error: Invalid file extension: ")+f.name),f.hint=e,a("#"+f.id).attr("class","plupload_failed").find("a").css("display","block").attr("title",e))}),j.bind("StateChanged",function(){j.state===plupload.STARTED?(a("li.plupload_delete a,div.plupload_buttons",k).hide(),a("span.plupload_upload_status,div.plupload_progress,a.plupload_stop",k).css("display","block"),a("span.plupload_upload_status",k).html("Uploaded "+j.total.uploaded+"/"+j.files.length+" files"),f.multiple_queues&&a("span.plupload_total_status,span.plupload_total_file_size",k).show()):(i(),a("a.plupload_stop,div.plupload_progress",k).hide(),a("a.plupload_delete",k).css("display","block"))}),j.bind("QueueChanged",i),j.bind("FileUploaded",function(a,b,c){var d={};try{d=JSON.parse(c.response)}catch(e){}d&&d.error&&(window.alert(d.msg||"Undefined error."),b.status=plupload.FAILED),g(b)}),j.bind("UploadProgress",function(b,c){a("#"+c.id+" div.plupload_file_status",k).html(c.percent+"%"),g(c),h(),f.multiple_queues&&j.total.uploaded+j.total.failed==j.files.length&&(a(".plupload_buttons,.plupload_upload_status",k).css("display","inline"),a(".plupload_start",k).addClass("plupload_disabled"),a("span.plupload_total_status,span.plupload_total_file_size",k).hide())}),f.setup&&f.setup(j)}),this):d[a(this[0]).attr("id")]}}(joms.jQuery);