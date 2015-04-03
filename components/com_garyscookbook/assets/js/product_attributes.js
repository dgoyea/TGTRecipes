/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */




function newProperty(attribute_id)
{
	var d = document;

	// get field labels
    var lbl_property      = d.adminForm.js_lbl_property.value;
    var lbl_amount        = d.adminForm.js_lbl_amount.value;
	var lbl_amountname    = d.adminForm.js_lbl_amountname.value;
	var lbl_delete		  = d.adminForm.js_lbl_delete.value;

	var table = document.getElementById("attributeX_table_"+attribute_id);
	var tbody = table.getElementsByTagName('tbody')[0];
	var tr_id = table.getElementsByTagName('tr').length + 1;

	// create new HTML elements
	var tr = d.createElement('tr');
	    tr.id = "attributeX_tr_"+attribute_id+"_"+tr_id;

	var td_01 = d.createElement('td');
	    td_01.style.width = '5%';
	    td_01.align = 'right';
	    td_01.innerHTML = lbl_amount;

	var td_02 = d.createElement('td');
	    td_02.style.width = '5%';
	    td_02.align = 'left';
	    td_02.innerHTML = "<input type='text' name='attributeX["+attribute_id+"][amount][]' value='' size='3'/>";

	var td_03 = d.createElement('td');
	    td_03.style.width = '10%';
	    td_03.align = 'right';
	    td_03.innerHTML = lbl_amountname;

	var td_04 = d.createElement('td');
	    td_04.style.width = '5%';
	    td_04.align = 'left';
	    td_04.innerHTML = "<input type='text' name='attributeX["+attribute_id+"][amountname][]' value='' size='4'/>";

   	var td_05 = d.createElement('td');
	    td_05.style.width = '10%';
	    td_05.align = 'right';
	    td_05.innerHTML = lbl_property;


	var td_06 = d.createElement('td');
	    td_06.style.width = '65%';
	    td_06.align = 'left';
	    td_06.innerHTML = "<input type='text' name='attributeX["+attribute_id+"][value][]' size='45' value=''/><a href='javascript:deleteProperty("+attribute_id+",\""+attribute_id+"_"+tr_id+"\");'> "+lbl_delete+"</a>";

	// append new elements
	tbody.appendChild(tr);
	   tr.appendChild(td_01);
	   tr.appendChild(td_02);
	   tr.appendChild(td_03);
	   tr.appendChild(td_04);
	   tr.appendChild(td_05);
	   tr.appendChild(td_06);
}


function deleteProperty(attribute_id, property_id)
{
	var d     = document;
	var table = document.getElementById("attributeX_table_"+attribute_id);
	var tbody = table.getElementsByTagName('tbody')[0];
	var tr    = d.getElementById("attributeX_tr_"+property_id);

	tbody.removeChild(tr);
}
