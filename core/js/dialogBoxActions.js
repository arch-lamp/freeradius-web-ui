/**
 * Created by peeyush.budhia on 08-01-2015.
 */

/**
 * Change Password
 */
function changePassword() {

	var removeClass = 'text-danger text-success text-info';
	$('#loading').removeClass(removeClass).show().html('<img src="../img/loading.gif" alt="Loading..."/>');
	var currentPass = Base64Encode($.trim($('#currentPass').val()));
	var newPass = Base64Encode($.trim($('#newPass').val()));
	var confPass = Base64Encode($.trim($('#confPass').val()));

	if (currentPass.length == 0 || newPass.length == 0 || confPass.length == 0) {
		$('#loading').removeClass(removeClass).addClass('text-danger').html('All fields must be filled.');
	} else {
		var data = 'currPass=' + currentPass + '&newPass=' + newPass + '&confPass=' + confPass;
		var info = '';
		var addClass = '';
		$.ajax({
				   type: 'POST',
				   cache: false,
				   url: 'changePassword.php',
				   async: true,
				   data: data,
				   success: function(response) {
					   if ($.trim(response) == 'Empty') {
						   info = 'All fields must be filled.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Wrong') {
						   info = 'Incorrect current password supplied.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'LowLength') {
						   info = 'Minimum 8 characters are required for new password';
						   addClass = 'text-info';
					   }

					   if ($.trim(response) == 'NotMatched') {
						   info = 'New password and confirm password not matched.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Same') {
						   info = 'Current password and new password must be different.';
						   addClass = 'text-info';
					   }

					   if ($.trim(response) == 'NotChanged') {
						   info = 'Error while changing the password, please try again later.';
						   addClass = 'text-info';
					   }
					   if ($.trim(response) == 'Changed') {
						   info = 'Password successfully changed.';
						   addClass = 'text-success';
					   }

					   $('#loading').removeClass(removeClass).addClass(addClass).html(info);

					   if ($.trim(response) == 'Changed') {
						   $('#currentPass').val('');
						   $('#newPass').val('');
						   $('#confPass').val('');
					   }

				   }
			   });
	}
}

/**
 * Add New User
 */

function addNewUser() {
	var removeClass = 'text-danger text-success text-info';
	$('#loading').removeClass(removeClass).show().html('<img src="../img/loading.gif" alt="Loading..."/>');

	var fullname = $('#fullname').val();
	var username = $('#username').val();
	var email = $('#email').val();
	var passwordType = $('input[name=passwordType]:checked').val();

	if (!passwordType || fullname.length == 0 || username.length == 0 || email.length == 0) {
		$('#loading').removeClass(removeClass).addClass('text-danger').show().html('All fields must be filled.');
	} else {
		var data = 'fullname=' + fullname + '&username=' + username + '&email=' + email + '&passwordType=' + passwordType;
		var addClass = '';
		var info = '';
		$.ajax({
				   type: 'POST',
				   cache: false,
				   url: 'addUser.php',
				   async: true,
				   data: data,
				   success: function(response) {
					   if ($.trim(response) == 'Empty') {
						   info = 'All fields must be filled.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'InvalidEmail') {
						   info = 'Invalid email address.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'UsernameRegistered') {
						   info = 'Username already exists, please choose different username.';
						   addClass = 'text-info';
					   }

					   if ($.trim(response) == 'EmailRegistered') {
						   info = 'Email already exists.';
						   addClass = 'text-info';
					   }

					   if ($.trim(response) == 'Error') {
						   info = 'Error while adding the new user, please try again later.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Registered') {
						   info = 'User added successfully.';
						   addClass = 'text-success';
					   }

					   if ($.trim(response) == 'MailSent') {
						   info = 'User added successfully.<br>Password sent to the user on ' + email;
						   addClass = 'text-success';
					   }

					   if ($.trim(response) == 'EmailError') {
						   info = 'Error while sending the email to the user on ' + email;
						   addClass = 'text-info';
					   }

					   $('#loading').removeClass(removeClass).addClass(addClass).html(info);
					   $('#fullname').val('');
					   $('#email').val('');
					   $('#username').val('');
					   $("#passwordType").prop("checked", false);
				   }
			   });
	}

}


/**
 * Add New NAS
 */

function addNewNAS() {
	var removeClass = 'text-danger text-success text-info';
	$('#loading').removeClass(removeClass).show().html('<img src="../img/loading.gif" alt="Loading..."/>');

	var nasHost = $('#nasHost').val();
	var nasType = $('#nasType').val();
	var nasSecret = $('#nasSecret').val();

	if (nasHost.length == 0 || nasType.length == 0 || nasSecret.length == 0) {
		$('#loading').removeClass(removeClass).addClass('text-danger').html('Fields marked with * are mandatory.');
	} else {
		var nasShortName = $('#nasShortName').val();
		var nasPort = $('#nasPort').val();
		var nasServer = $('#nasServer').val();
		var nasCommunity = $('#nasCommunity').val();
		var nasDescription = $('#nasDescription').val();

		var data = 'nasHost=' + nasHost + '&nasType=' + nasType + '&nasSecret=' + nasSecret + '&nasShortName=' + nasShortName + '&nasPort=' + nasPort + '&nasServer=' + nasServer + '&nasCommunity=' + nasCommunity + '&nasDescription=' + nasDescription;
		var info = '';
		var addClass = '';
		$.ajax({
				   type: 'POST',
				   cache: false,
				   url: 'addNas.php',
				   async: true,
				   data: data,
				   success: function(response) {

					   if ($.trim(response) == 'Empty') {
						   info = 'Fields marked with * are mandatory.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Error') {
						   info = 'Error while adding new NAS client, please try again later.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Inserted') {
						   info = 'NAS client '+nasHost+' added successfully.';
						   addClass = 'text-success';

						   $('#nasHost').val('');
						   $('#nasType').val('');
						   $('#nasSecret').val('');
						   $('#nasShortName').val('');
						   $('#nasPort').val('');
						   $('#nasServer').val('');
						   $('#nasCommunity').val('');
						   $('#nasDescription').val('');

					   }

					   $('#loading').removeClass(removeClass).addClass(addClass).html(info);

				   }
			   });
	}
}

function updateNASAccount() {
	var removeClass = 'text-danger text-success text-info';
	$('#loading').removeClass(removeClass).show().html('<img src="../img/loading.gif" alt="Loading..."/>');
	var nasType = $('#nasType').val();
	var nasSecret = $('#nasSecret').val();
	var nasId = $('#nasId').val();

	var nasShortName = $('#nasShortName').val();
	var nasPort = $('#nasPort').val();
	var nasServer = $('#nasServer').val();
	var nasCommunity = $('#nasCommunity').val();
	var nasDescription = $('#nasDescription').val();

	var currentPage = parseInt($('#currentPage').val());

	if (nasType.length == 0 || nasSecret.length == 0 || nasId.length == 0) {
		$('#loading').addClass('text-danger').html('Fields marked with * are mandatory');
	} else {
		var info = '';
		var addClass = '';
		var data = 'nasType=' + nasType + '&nasSecret=' + nasSecret + '&nasShortName=' + nasShortName + '&nasPort=' + nasPort + '&nasServer=' + nasServer + '&nasCommunity=' + nasCommunity + '&nasDescription=' + nasDescription+'&nasId='+nasId;
		$.ajax({
				   type: 'POST',
				   cache: false,
				   async: true,
				   url: 'updateNASInfo.php',
				   data: data,
				   success: function(response) {

					   if($.trim(response) == 'Empty') {
						   info = 'Fields marked with * are mandatory';
						   addClass = 'text-danger';
					   }

					   if($.trim(response) == 'Error') {
						   info = 'Something went wrong while updating the information, please try again later';
						   addClass = 'text-danger';
					   }

					   if($.trim(response) == 'NoChanges') {
						   info = 'You have not made any changes';
						   addClass = 'text-info';
					   }


					   if($.trim(response) == 'Updated') {
						   info = 'Information successfully updated';
						   addClass = 'text-success';

					   }

					   $('#loading').removeClass(removeClass).addClass(addClass).html(info);
					   setTimeout(function() {
						   $('#loadNAS').fadeOut('slow').load(loadNASList(currentPage)).fadeIn('slow');
					   }, 500);
				   }
			   });
	}
}