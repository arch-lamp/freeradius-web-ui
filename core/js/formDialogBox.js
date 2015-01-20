/**
 * Created by peeyush.budhia on 07-01-2015.
 */

function changePasswordDialog() {
	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 draggable: true,
				 padding: 20,
				 width: 500,
				 height: 400,
				 content: '<fieldset>' +
				 '<legend>Change Password</legend>' +
				 '<span style="font-size: medium; display: none;" id="loading"></span>' +
				 '<label>Current Password</label>' +
				 '<div class="input-control password">' +
				 '<input type="password" id="currentPass"> ' +
				 '<button class="btn-reveal"></button>' +
				 '</div> ' +

				 '<label>New Password</label>' +
				 '<div class="input-control password">' +
				 '<input type="password" id="newPass"> ' +
				 '<button class="btn-reveal"></button>' +
				 '</div> ' +

				 '<label>Confirm Password</label>' +
				 '<div class="input-control password">' +
				 '<input type="password" id="confPass"> ' +
				 '<button class="btn-reveal"></button>' +
				 '</div> ' +

				 '<div class="place-right" style="margin-bottom: 30px;">' +
				 '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> ' +
				 '<button class="button dark" onclick="javascript:changePassword();">Change</button> ' +
				 '</div>' +
				 '</fieldset>'

			 });
}

function addNewUserDialog() {
	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 width: 500,
				 height: 500,
				 draggable: true,
				 padding: 20,
				 content: '<fieldset>' +
				 '<legend>New User</legend>' +
				 '<span style="font-size: medium; display: none;" id="loading"></span>' +

				 '<label>Full Name</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="fullname"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +

				 '<label>Email</label>' +
				 '<div class="input-control email">' +
				 '<input type="email" id="email"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +

				 '<label>Username</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="username"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +

				 '<label>Password Type</label>' +

				 '<div class="input-control radio margin5">' +
				 '<label>' +
				 '<input type="radio" class="" name="passwordType" value="MD5"/>' +
				 '<span class="check"></span>' +
				 'MD5' +
				 '</label>' +
				 '</div>' +

				 '<div class="input-control radio margin5">' +
				 '<label>' +
				 '<input type="radio" class="" name="passwordType" value="SHA1"/>' +
				 '<span class="check"></span>' +
				 'SHA1' +
				 '</label>' +
				 '</div>' +

				 '<div class="place-right" style="margin-bottom: 30px;">' +
				 '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> ' +
				 '<button class="button dark" onclick="javascript:addNewUser();">Add</button> ' +
				 '</div>' +
				 '</fieldset>'
			 });
}


function addNewNasDialog() {
	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 width: 500,
				 draggable: true,
				 padding: 20,
				 content: '<fieldset>' +
				 '<legend>New NAS</legend>' +
				 '<span style="font-size: medium; display: none;" id="loading"></span>' +

				 '<label>* Host/IP</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasHost"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +

				 '<div class="grid">' +

				 '<div class="row">' +
				 '<div class="span3">' +
				 '<label>* Type</label>' +
				 '<div class="input-control select">' +
				 '<select class="form-control input-sm" id="nasType">' +
				 '<option value="">-- Select NAS Type --</option>' +
				 '<option value="other">other</option>' +
				 '<option value="cisco">cisco</option>' +
				 '<option value="livingston">livingston</option>' +
				 '<option value="computon">computon</option>' +
				 '<option value="max40xx">max40xx</option>' +
				 '<option value="multitech">multitech</option>' +
				 '<option value="natserver">natserver</option>' +
				 '<option value="pathras">pathras</option>' +
				 '<option value="patton">patton</option>' +
				 '<option value="portslave">portslave</option>' +
				 '<option value="tc">tc</option>' +
				 '<option value="usrhiper">usrhiper</option>' +
				 '</select>' +
				 '</div> ' +
				 '</div>' +

				 '<div class="span2">' +
				 '<label>*Secret</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasSecret"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +
				 '</div>' +
				 '</div>' +

				 '<div class="row">' +

				 '<div class="span3">' +
				 '<label>Short Name</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasShortName"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +
				 '</div>' +

				 '<div class="span2">' +
				 '<label>Port</label>' +
				 '<div class="input-control number">' +
				 '<input type="number" id="nasPort"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +
				 '</div>' +
				 '</div>' +
				 '<div class="row">' +

				 '<div class="span3">' +
				 '<label>Server</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasServer"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +
				 '</div> ' +

				 '<div class="span2">' +
				 '<label>Community</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasCommunity"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +
				 '</div> ' +
				 '</div> ' +
				 '</div>' + /*grid*/

				 '<label>Description</label>' +
				 '<div class="input-control text">' +
				 '<input type="text" id="nasDescription"> ' +
				 '<button tabindex="-1" class="btn-clear" type="button"></button>' +
				 '</div> ' +

				 '<div class="place-right" style="margin-bottom: 30px;">' +
				 '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> ' +
				 '<button class="button dark" onclick="javascript:addNewNAS();">Add</button> ' +
				 '</div>' +
				 '</fieldset>'
			 });
}

function updateNASDialog(nasId) {
	if (nasId != '') {
		$.ajax({
				   type: 'POST',
				   cache: false,
				   url: 'loadNASInfo.php',
				   async: true,
				   data: 'id=' + nasId,
				   success: function(response) {
					   if ($.trim(response) != 'ErrorNASCount') {
						   var info = jQuery.parseJSON(response);
						   var content = '<fieldset>' +
							   '<legend>Update Info</legend>' +
							   '<span style="font-size: medium; display: none;" id="loading"></span>' +
							   '<input type="hidden" id="nasId" readonly value="'+info.id+'"> ' +

							   '<div class="grid">' +

							   '<div class="row">' +
							   '<div class="span3">' +
							   '<label>* Type</label>' +
							   '<div class="input-control text">' +
							   '<input list="nasList" id="nasType" value="'+info.type+'">' +
							   '<datalist id="nasList">' +
							   '<option value="">-- Select NAS Type --</option>' +
							   '<option value="other">other</option>' +
							   '<option value="cisco">cisco</option>' +
							   '<option value="livingston">livingston</option>' +
							   '<option value="computon">computon</option>' +
							   '<option value="max40xx">max40xx</option>' +
							   '<option value="multitech">multitech</option>' +
							   '<option value="natserver">natserver</option>' +
							   '<option value="pathras">pathras</option>' +
							   '<option value="patton">patton</option>' +
							   '<option value="portslave">portslave</option>' +
							   '<option value="tc">tc</option>' +
							   '<option value="usrhiper">usrhiper</option>' +
							   '</datalist>' +
							   '</div> ' +
							   '</div>' +

							   '<div class="span2">' +
							   '<label>*Secret</label>' +
							   '<div class="input-control text">' +
							   '<input type="text" id="nasSecret" value="'+info.secret+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +
							   '</div>' +
							   '</div>' +

							   '<div class="row">' +

							   '<div class="span3">' +
							   '<label>Short Name</label>' +
							   '<div class="input-control text">' +
							   '<input type="text" id="nasShortName" value="'+info.shortname+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +
							   '</div>' +

							   '<div class="span2">' +
							   '<label>Port</label>' +
							   '<div class="input-control number">' +
							   '<input type="number" id="nasPort" value="'+info.ports+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +
							   '</div>' +
							   '</div>' +
							   '<div class="row">' +

							   '<div class="span3">' +
							   '<label>Server</label>' +
							   '<div class="input-control text">' +
							   '<input type="text" id="nasServer" value="'+info.server+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +
							   '</div> ' +

							   '<div class="span2">' +
							   '<label>Community</label>' +
							   '<div class="input-control text">' +
							   '<input type="text" id="nasCommunity" value="'+info.community+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +
							   '</div> ' +
							   '</div> ' +
							   '</div>' + /*grid*/

							   '<label>Description</label>' +
							   '<div class="input-control text">' +
							   '<input type="text" id="nasDescription" value="'+info.description+'"> ' +
							   '<button tabindex="-1" class="btn-clear" type="button"></button>' +
							   '</div> ' +

							   '<div class="place-right" style="margin-bottom: 30px;">' +
							   '<button class="button" id="closeBtn" type="button" onclick="$.Dialog.close()">Cancel</button> ' +
							   '<button class="button dark" onclick="javascript:updateNASAccount();">Update</button> ' +
							   '</div>' +
							   '</fieldset>';


						   $.Dialog({
										overlay: true,
										title: '<span class="text-bold">NAS IP/Host: '+info.nasname+'</span>' ,
										shadow: true,
										width: 500,
										flat: true,
										draggable: true,
										padding: 20,
										content: content
									});
					   }

				   }
			   });
	}
}