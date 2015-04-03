/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */



function GCBVoting(id,i,total,total_count,counter){
	var currentURL = window.location;
	var live_site = currentURL.protocol+'//'+currentURL.host+sfolder;
	var lsXmlHttp = '';

	var div = document.getElementById('gcbvote_'+id);
	if (div.className != 'gcbvote-count voted') {
		div.innerHTML='<img src="'+live_site+'/components/com_garyscookbook/assets/images/loading.gif" border="0" align="absmiddle" /> '+'<small>'+gcbvote_text[1]+'</small>';
		try	{
			lsXmlHttp=new XMLHttpRequest();

		} catch (e) {
			try	{ lsXmlHttp=new ActiveXObject("Msxml2.XMLHTTP");

			} catch (e) {
				try { lsXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					alert(gcbvote_text[0]);
					return false;
				}
			}
		}
	}

	div.className = 'gcbvote-count voted';
	if ( lsXmlHttp != '' ) {
		lsXmlHttp.onreadystatechange=function() {
			var response;

			if(lsXmlHttp.readyState==4){
				setTimeout(function(){
					response = lsXmlHttp.responseText;

					if(response=='thanks') div.innerHTML='<small>'+gcbvote_text[2]+'</small>';
					if(response=='login') div.innerHTML='<small>'+gcbvote_text[3]+'</small>';
					if(response=='voted') {
						div.innerHTML='<small>'+gcbvote_text[4]+'</small>';
						alert(gcbvote_text[4]);
					}
				},1000);

				setTimeout(function(){

					if(response=='thanks'){
						var newtotal = total_count+1;
						var percentage = ((total + i)/(newtotal));
						document.getElementById('rating_'+id).style.width=parseInt(percentage*20)+'%';

					}

					if(counter!=0){
						if(response=='thanks'){
							if(newtotal!=1)
								var newvotes=newtotal+' '+gcbvote_text[5];
							else
								var newvotes=newtotal+' '+gcbvote_text[6];
							div.innerHTML='<small>( '+newvotes+' )</small>';
						} else {
							if(total_count!=0 || counter!=-1) {
								if(total_count!=1)
									var votes=total_count+' '+gcbvote_text[5];
								else
									var votes=total_count+' '+gcbvote_text[6];
								div.innerHTML='<small>( '+votes+' )</small>';
							} else {
								div.innerHTML='';
							}
						}
					} else {
						div.innerHTML='';
					}
				},2000);
			}
		}
		lsXmlHttp.open("GET",live_site+"/components/com_garyscookbook/assets/scripts/gcbajax.php?task=vote&user_rating="+i+"&cid="+id,true);
		lsXmlHttp.send(null);
	}
}