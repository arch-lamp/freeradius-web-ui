/**
 * Created by peeyush.budhia on 28-12-2014.
 */

function notification(heading, message) {
	$.Notify({
		caption: heading,
		content: message,
		timeout: 5000,
		width: '10',
		style: {
			background: '#333333', color: '#ffffff'
		}
			 });
}

function loadUsersList(pageNum) {
	loadDisplay('loadUsers');
	$.ajax({
			   type: 'POST',
			   cache: false,
			   async: true,
			   url: 'loadUsers.php',
			   data: 'page=' + pageNum,
			   success: function(response) {
				   if ($.trim(response) == 'NotFound') {
					   $('#loadUsers').addClass('text-danger').html('No records found');
				   }

				   if ($.trim(response) != 'NotFound') {
					   $('#loadUsers').removeClass('text-danger').html(response);
					   $("a[id^='delete']").hint();
					   $("a[id^='resetPass']").hint();
					   $("a[id^='enable']").hint();
					   $("a[id^='disable']").hint();
				   }
			   }
		   });
}

function loadNextUser() {
	loadDisplay('loadUsers');
	var currentPage = parseInt($('#currentPage').val());
	var maxPages = parseInt($('#totalPages').val());

	if (maxPages > currentPage) {
		var newPage = ++currentPage;
		$('#previous').show();
	} else {
		var newPage = currentPage;
	}

	if (currentPage == maxPages) {
		$('#next').hide();
	}

	$('#currentPage').val(newPage);
	$.ajax({
			   type: 'POST',
			   cache: false,
			   url: 'loadUsers.php',
			   async: true,
			   data: 'page=' + newPage,
			   success: function(response) {
				   if ($.trim(response) == 'NotFound') {
					   $('#loadUsers').addClass('text-danger').html('No records found');
				   }

				   if ($.trim(response) != 'NotFound') {
					   $('#loadUsers').removeClass('text-danger').html(response);
					   $("a[id^='delete']").hint();
					   $("a[id^='resetPass']").hint();
					   $("a[id^='enable']").hint();
					   $("a[id^='disable']").hint();
				   }
			   }
		   });
}

function loadPreviousUser() {
	loadDisplay('loadUsers');
	var currentPage = parseInt($('#currentPage').val());
	var maxPages = parseInt($('#totalPages').val());
	if (currentPage > 1) {
		var newPage = --currentPage;
	} else {
		var newPage = currentPage;
	}

	$('#next').show();
	$('#currentPage').val(newPage);
	$.ajax({
			   type: 'POST',
			   cache: false,
			   url: 'loadUsers.php',
			   async: true,
			   data: 'page=' + newPage,
			   success: function(response) {
				   if (currentPage == 1) {
					   $('#previous').hide();
				   }
				   $('#loadUsers').html(response);
				   $("a[id^='delete']").hint();
				   $("a[id^='resetPass']").hint();
				   $("a[id^='enable']").hint();
				   $("a[id^='disable']").hint();
			   }
		   });
}

function enableDisableUserAccount(id, username, statusTo) {
	loadDisplay('action-' + id);
	var currentPage = parseInt($('#currentPage').val());
	var data = 'username=' + username + '&status=' + statusTo;
	var heading = '';
	var message = '';
	$.ajax({
			   type: 'POST',
			   cache: false,
			   data: data,
			   url: 'changeUserStatus.php',
			   async: true,
			   success: function(response) {
				   switch (statusTo) {

					   case 'disable':
						   if ($.trim(response) == 'AlreadyDisabled') {
							   heading = 'Info!';
							   message = 'Account for user ' + username + ' is already disabled.';
						   }

						   if ($.trim(response) == 'Disabled') {
							   heading = 'Success!';
							   message = 'Account for user ' + username + ' is successfully disabled. Now, User will not able to connect with freeRADIUS Server.';
						   }

						   if ($.trim(response) == 'ErrorDisable') {
							   heading = 'Error!';
							   message = 'Error while disabling the account for user ' + username + '. Please try again later.';
						   }
						   break;

					   case 'enable':
						   if ($.trim(response) == 'AlreadyEnabled') {
							   heading = 'Info!';
							   message = 'Account for user ' + username + ' is already enabled.';
						   }

						   if ($.trim(response) == 'Enabled') {
							   heading = 'Success!';
							   message = 'Account for user ' + username + ' is successfully enabled. Now, user will able to connect with freeRADIUS Server.';
						   }

						   if ($.trim(response) == 'ErrorDisable') {
							   heading = 'Error!';
							   message = 'Error while enabling the account for user ' + username + '. Please try again later.';
						   }
						   break;

					   default:
						   heading = 'Invalid Request!';
						   message = 'You tried to make an invalid action.';
						   break;
				   }

				   notification(heading, message);

				   setTimeout(function() {
					   $('#loadUsers').fadeOut('slow').load(loadUsersList(currentPage)).fadeIn('slow');
				   }, 500);
			   }

		   });
}


function deleteUserAccount(id, username) {
	loadDisplay('action-' + id);
	var currentPage = parseInt($('#currentPage').val());
	var data = 'username=' + username;
	var heading = '';
	var message = '';

	$.ajax({
			   type: 'POST',
			   cache: false,
			   data: data,
			   url: 'deleteUserAccount.php',
			   async: true,
			   success: function(response) {
				   if ($.trim(response) == 'Deleted') {
					   heading = 'Success!';
					   message = 'Account of user ' + username + ' is permanently deleted from freeRADIUS Server.';
				   }

				   if ($.trim(response) == 'ErrorGroup' || $.trim(response) == 'ErrorDelete') {
					   heading = 'Error!';
					   message = 'Something went wrong while deleting account of user ' + username + ' from freeRadius Server. Please try again later.\\\\';
				   }

				   notification(heading, message);

				   setTimeout(function() {
					   $('#loadUsers').fadeOut('slow').load(loadUsersList(currentPage)).fadeIn('slow');
				   }, 500);

			   }
		   });

}

function resetUserAccountPassword(id, username, encryption) {
	loadDisplay('action-' + id);
	var currentPage = parseInt($('#currentPage').val());
	var data = 'username=' + username + '&encryption=' + encryption;
	var heading = '';
	var message = '';
	$.ajax({
			   type: 'POST',
			   cache: false,
			   data: data,
			   url: 'resetUserPassword.php',
			   async: true,
			   success: function(response) {
				   if ($.trim(response) == 'EncryptionError') {
					   heading = 'Error!';
					   message = 'Password encryption not matched, password will not be reset for user ' + username;
				   }

				   if ($.trim(response) == 'PasswordReset') {
					   heading = 'Success!';
					   message = 'Password for user ' + username + ' is successfully reset. Email has already been sent to user on his/her registered email address.';
				   }

				   if ($.trim(response) == 'ErrorPasswordReset' || $.trim(response) == 'ErrorUpdatePassword') {
					   heading = 'Error!';
					   message = 'Error while resetting password for user ' + username + '. Please try again after sometime.';
				   }

				   if ($.trim(response) == 'Error') {
					   heading = 'Error!';
					   message = 'Something went wrong while resetting password for user ' + username + '. Might be user will not able to access the server. Please look into the matter urgently';
				   }

				   notification(heading, message);

				   setTimeout(function() {
					   $('#loadUsers').fadeOut('slow').load(loadUsersList(currentPage)).fadeIn('slow');
				   }, 500);

			   }
		   });
}