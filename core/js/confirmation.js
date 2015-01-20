/**
 * Created by peeyush.budhia on 30-12-2014.
 */

/**
 * Change User Status
 * @param id
 * @param username
 * @param changeTo
 */

function confirmUserChangeStatus(id, username, changeTo) {
	var message = '';
	switch (changeTo) {
		case 'disable':
			message = "Are you sure that you want to " + changeTo + " user: <span style='font-weight:bold;'>" + username + "</span>?<br/><br/>After that user will not able to connect to freeRADIUS Server any more.";
			break;

		case 'enable':
			message = "Are you sure that you want to " + changeTo + " the user: <span style='font-weight:bold;'>" + username + "</span>?<br/><br/>After that user will able to connect to freeRADIUS Server.";
			break;
	}

	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 draggable: true,
				 padding: 20,
				 content: "<p>" + message + "</p>" +
				 "<div class='place-right'>" +
				 "<button class='button' type='button' onclick='$.Dialog.close()'>No</button> " +
				 "<button class='button dark' type='button' onclick='enableDisableUserAccount(" +
				 id + ',"' + username + '","' + changeTo + '"' +
				 "); $.Dialog.close();'>Yes</button> " +
				 "</div>"
			 });
}


/**
 * Delete User
 * @param id
 * @param username
 */
function confirmUserDelete(id, username) {

	var message = "Are you sure that you want to delete the user: <span style='font-weight:bold;'>" + username + "</span>?<br/><br/>Note: This will permanently delete the user's account from freeRADIUS Server.";

	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 draggable: true,
				 padding: 20,
				 content: "<p>" + message + "</p>" +

				 "<div class='place-right'>" +
				 "<button class='button' type='button' onclick='$.Dialog.close()'>No</button> " +
				 "<button class='button dark' type='button' onclick='deleteUserAccount(" +
				 id + ',"' + username + '"' +
				 "); $.Dialog.close();'>Yes</button> " +
				 "</div>"
			 });
}


/**
 * Reset User Password
 * @param id
 * @param username
 * @param encryption
 */
function confirmUserPasswordReset(id, username, encryption) {
	var message = "Are you sure that you want to reset the password for user: <span style='font-weight:bold;'>" + username + "</span>?<br/><br/>After resetting the password user will be notified via email, if your SMTP setting is enabled.";
	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 draggable: true,
				 padding: 20,
				 content: "<p>" + message + "</p>" +

				 "<div class='place-right'>" +
				 "<button class='button' type='button' onclick='$.Dialog.close()'>No</button> " +
				 "<button class='button dark' type='button' onclick='resetUserAccountPassword(" +
				 id + ',"' + username + '","' + encryption + '"' +
				 "); $.Dialog.close();'>Yes</button> " +
				 "</div>"
			 });

}
/**
 * Delete NAS
 * @param id
 */
function confirmNASDelete(id, hostname) {

	var message = "Are you sure that you want to delete the NAS: <span style='font-weight:bold;'>" + hostname + "</span>?<br/><br/>Note: This will permanently delete the NAS Client from freeRADIUS Server and you will not able to use it further.";

	$.Dialog({
				 overlay: true,
				 shadow: true,
				 flat: true,
				 draggable: true,
				 padding: 20,
				 content: "<p>" + message + "</p>" +

				 "<div class='place-right'>" +
				 "<button class='button' type='button' onclick='$.Dialog.close()'>No</button> " +
				 "<button class='button dark' type='button' onclick='deleteNASAccount(" +
				 id + ',"' + hostname + '"' +
				 "); $.Dialog.close();'>Yes</button> " +
				 "</div>"
			 });
}