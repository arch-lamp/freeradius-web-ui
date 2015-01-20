/**
 * Created by peeyush.budhia on 12-01-2015.
 */


function loading() {
	$('#loading').html('<img src="../img/loading.gif"/>');
}

function showSMTPConf() {
	$('#loading').html('');
	$('#databaseConf').hide();
	$('#siteAdministration').hide();
	$('#smtpConf').show();
}

function showDatabaseConf() {
	$('#loading').html('');
	$('#smtpConf').hide();
	$('#siteAdministration').hide();
	$('#databaseConf').show();
}

function showSiteAdministration() {
	$('#loading').html('');
	$('#smtpConf').hide();
	$('#databaseConf').hide();
	$('#siteAdministration').show();
}

function removeClass() {
	$('#loading').removeClass('text-danger text-success text-info');
}

function checkDatabase(action) {
	loading();
	var dbHost = $('#dbHost').val();
	var dbUser = $('#dbUser').val();
	var dbPass = $('#dbPass').val();
	var dbName = $('#dbName').val();
	removeClass();
	if (action == 'createDb') {
		var data = 'dbHost=' + dbHost + '&dbUser=' + dbUser + '&dbPass=' + dbPass + '&dbName=' + dbName + '&action=createDb';
		$('#loading').addClass('text-info').html("<img src=\"../img/loading.gif\"/> Please wait while we are creating database for your server...");
	} else if (action == 'populateTables') {
		var data = 'dbHost=' + dbHost + '&dbUser=' + dbUser + '&dbPass=' + dbPass + '&dbName=' + dbName + '&action=populateTables';
		$('#loading').addClass('text-info').html("<img src=\"../img/loading.gif\"/> Please wait while we are populating tables in database. Please don't refresh the page, it will take some time.");
	} else {
		var data = 'dbHost=' + dbHost + '&dbUser=' + dbUser + '&dbPass=' + dbPass + '&dbName=' + dbName + '&action=none';
	}

	if (dbHost.length == 0 || dbUser.length == 0 || dbName.length == 0) {
		$('#loading').addClass('text-danger').html('Fields marked with * are mandatory');
	} else {
		var message = '';
		var addClass = '';
		$.ajax({
				   type: 'POST',
				   cache: false,
				   async: true,
				   data: data,
				   url: 'checkDatabase.php',
				   success: function(response) {
					   if ($.trim(response) == 'Empty') {
						   message = 'Fields marked with * are mandatory';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Invalid') {
						   message = 'Invalid database credentials';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'dbExists') {
						   $('#checkDatabaseButton').hide();
						   message = 'Database ' + dbName + ' already exists.<button class="button primary place-right" onclick="checkDatabase(\'populateTables\')">Populate Tables!</button>';
						   addClass = 'text-success';
					   }

					   if ($.trim(response) == 'dbNotExists') {
						   $('#checkDatabaseButton').hide();
						   message = 'Database ' + dbName + ' not yet exists.<button class="button primary place-right" onclick="checkDatabase(\'createDb\')">Create Now!</button>';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'dbCreated') {
						   $('#checkDatabaseButton').hide();
						   message = 'Database ' + dbName + ' created successfully.<button class="button primary place-right" onclick="checkDatabase(\'populateTables\')">Populate Tables!</button>';
						   addClass = 'text-success';
					   }

					   if ($.trim(response) == 'TableError') {
						   $('#checkDatabaseButton').hide();
						   message = 'Error while populating table into the database';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'TableSuccess') {
						   $('#checkDatabaseButton').hide();
						   message = 'Tables successfully populated into the database. <button class="button primary place-right" onclick="javascript:showSMTPConf();">Proceed to next step</button>';
						   addClass = 'text-success';
					   }
					   removeClass();
					   $('#loading').html(message).addClass(addClass);

				   }
			   });
	}

}

function SMTPSettings(action) {
	loading();
	var smtpHost = $('#smtpHost').val();
	var smtpEmail = $('#smtpEmail').val();
	var smtpUser = $('#smtpUser').val();
	var smtpPass = $('#smtpPass').val();
	var smtpPort = $('#smtpPort').val();
	var smtpConnection = $('#smtpConnection').val();

	if (smtpHost.length == 0 || smtpUser.length == 0 || smtpPass.length == 0 || smtpPort.length == 0 || smtpConnection.length == 0 || smtpEmail.length == 0) {
		$('#loading').addClass('text-danger').html('Fields marked with * are mandatory');
	} else {
		if (!($.isNumeric(smtpPort))) {
			$('#loading').addClass('text-danger').html('SMTP Port must be integer, usually it is 25');
		} else {
			removeClass();
			$('#loading').addClass('text-info').html("<img src=\"../img/loading.gif\"/> Please wait while we are verifying connection...");
			if (action == 'verifyConnection') {
				var data = 'host=' + smtpHost + '&email=' + smtpEmail + '&user=' + smtpUser + '&pass=' + smtpPass + '&port=' + smtpPort + '&secure=' + smtpConnection + '&action=verifyConnection';
			}
			var message = '';
			var addClass = '';
			$.ajax({
					   type: 'POST',
					   cache: false,
					   async: true,
					   data: data,
					   url: 'checkSMTP.php',
					   success: function(response) {
						   if ($.trim(response) == 'Empty') {
							   message = 'Fields marked with * are mandatory.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'InvalidEmail') {
							   message = 'Invalid email address supplied.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'UsernameInvalidEmail') {
							   message = 'SMTP username must be an email address.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'InvalidPort') {
							   message = 'SMTP Port must be integer, usually it is 25.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'TestEmailError') {
							   message = 'There is some issue while connecting with your SMTP Server, please cross check all the details and try to verify the connection again.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'TestMailSent') {
							   $('#checkSMTPButton').hide();
							   message = 'SMTP Connection successfully verified.<button class="button primary place-right" onclick="javascript:showSiteAdministration();">Proceed to next step</button>';
							   addClass = 'text-success';
						   }

						   if ($.trim(response) == 'ErrorDBInsert') {
							   message = 'Something went wrong, please try again later. If same error persist again, please contact us.';
							   addClass = 'text-danger';
						   }
						   removeClass();
						   $('#loading').addClass(addClass).html(message);

					   }
				   });
		}
	}

}


function withoutSMTPSettings() {
	$('#loading').addClass('text-info').html("<img src=\"../img/loading.gif\"/> Please wait while we are saving your preference...");
	var message = '';
	var addClass = '';
	$.ajax({
			   type: 'POST',
			   cache: false,
			   async: true,
			   data: 'action=withoutSMTP',
			   url: 'checkSMTP.php',
			   success: function(response) {
				   if ($.trim(response) == 'Inserted') {
					   $('#checkSMTPButton').hide();
					   message = 'Prefrence successfully saved.<button class="button primary place-right" onclick="javascript:showSiteAdministration();">Proceed to next step</button>';
					   addClass = 'text-success';
				   }

				   if ($.trim(response) == 'Error') {
					   message = 'Error while saving your preference, please try again later.';
					   addClass = 'text-danger';
				   }

				   removeClass();
				   $('#loading').addClass(addClass).html(message);
			   }
		   });
}

function siteAdminDetails() {
	loading();
	var siteURL = $('#siteURL').val();
	var siteName = $('#siteName').val();
	var siteFullname = $('#siteFullname').val();
	var siteEmail = $('#siteEmail').val();
	var siteUsername = $('#siteUsername').val();
	var sitePass = $('#sitePass').val();
	var siteConfPass = $('#siteConfPass').val();

	if (siteURL.length == 0 || siteName.length == 0 || siteEmail.length == 0 || siteUsername.length == 0 || sitePass.length == 0 || siteConfPass.length == 0 || siteFullname.length == 0) {
		removeClass();
		$('#loading').addClass('text-danger').html('Fields marked with * are mandatory.');
	} else {

		if (siteConfPass != sitePass) {
			removeClass();
			$('#loading').addClass('text-danger').html('Password and confirm password not matched.');
		} else {
			var message = '';
			var addClass = '';
			var data = 'siteURL=' + siteURL + '&siteName=' + siteName + '&siteEmail=' + siteEmail + '&siteUsername=' + siteUsername + '&sitePass=' + sitePass + '&siteConfPass=' + siteConfPass+'&siteFullname='+siteFullname;

			$.ajax({
					   type: 'POST',
					   cache: false,
					   async: true,
					   data: data,
					   url: 'siteAdministration.php',
					   success: function(response) {
						   if ($.trim(response) == 'Empty') {
							   message = 'Fields marked with * are mandatory.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'PasswordNotMatch') {
							   message = 'Password and confirm password not matched.';
							   addClass = 'text-danger';
						   }

						   if ($.trim(response) == 'InvalidURL') {
							   message = 'Site URL is not valid.';
							   addClass = 'text-danger';
						   }
						   if ($.trim(response) == 'InvalidEmail') {
							   message = 'Invalid email address provided.';
							   addClass = 'text-danger';
						   }
						   if ($.trim(response) == 'Error') {
							   message = 'Error while setting up administrator details, please try again later.';
							   addClass = 'text-danger';
						   }

						   removeClass();
						   $('#loading').addClass(addClass).html(message);

						   if ($.trim(response) == 'Inserted') {
							   $('#databaseConf').hide();
							   $('#smtpConf').hide();
							   $('#siteAdministration').hide();

							   $('#loading').html('<span class="text-success">Congratulations!<br/>Radius Manager successfully installed.<br/><br/>' +
												  '</span><span class="text-danger">For security reasons, please delete the setup directory immediately.<br/><br/></span>' +
												  '<span class="text-success">Click on the following link to use your Radius Manager:<br/><br/></span>' +
												  '<a href="'+siteURL+'">'+siteURL+'</a>');
						   }
					   }
				   });
		}

	}


}