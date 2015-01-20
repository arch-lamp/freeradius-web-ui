<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Radius Manager:: Setup</title>
	<?php
	require_once '../includes/functions.php';
	$GetURL = GetProductURL( 'setup/' );
	session_start();
	$_SESSION['PRODUCT_URL'] = $GetURL;
	require_once '../includes/css-js.php';
	?>

	<script type="text/javascript" src="setup.js"></script>

</head>
<body>
<header class="bg-dark">
	<div class="navigation-bar dark">
		<div class="navigation-bar-content container">
			<a href="javascript:void(0);" class="element">
				<span class="icon-grid-view"></span>
				Radius Manager Setup
			</a>
			<span class="element-divider"></span>
		</div>
	</div>
</header>

<div class="container">
	<div class="panel" style="margin-top: 10px;">
		<div class="panel-header bg-dark text-clear">Setup</div>
		<div class="panel-content" id="setupForm">
			<div id="loading"></div>
			<div id="databaseConf">
				<legend>Database Configuration</legend>
				<label for="dbHost">* Database Host</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter database hostname/ip address" id="dbHost">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>
				<label for="dbUser">* Database Username</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter database username" id="dbUser">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<label for="dbPass">Database Password</label>

				<div data-role="input-control" class="input-control password">
					<input type="password" placeholder="Enter database password" id="dbPass">
					<button tabindex="-1" class="btn-reveal" type="button"></button>
				</div>

				<label for="dbName">* Database Name</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter database name" id="dbName">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<div data-role="input-control" class="input-control text-right">
					<button class="button primary" id="checkDatabaseButton" onclick="javascript:checkDatabase('false');">Check Database</button>
				</div>
			</div>

			<div id="smtpConf" style="display: none;">
				<script type="text/javascript">
					$(document).ready(function() {
						$('#smtpDetails').show();
						$('#checkSMTPButton').show().html('<button class="button primary" onclick="javascript:SMTPSettings(\'verifyConnection\');">Verify Connection</button>');
						$('input[type="radio"]').click(function() {
							if ($(this).attr('value') == 'yes') {
								$('#smtpDetails').show();
								$('#checkSMTPButton').show().html('<button class="button primary" onclick="javascript:SMTPSettings(\'verifyConnection\');">Verify Connection</button>');

							} else {
								$('#smtpDetails').hide();
								$('#checkSMTPButton').show().html('<button class="button primary" onclick="javascript:withoutSMTPSettings();">Proceed to next step</button>');
							}
						});
					});
				</script>
				<div id="serviceSMTP">
					<legend>SMTP Server</legend>
					<label>Do you want to enable SMTP service?</label>

					<div class="input-control radio">
						<div class="text-danger" style="font-size: 12px;">It is recommended to use this service. If not, email will not sent to users after adding new user account or password reset. 
						</div>
						<label>
							<input type="radio" name="useSMTP" value="yes" id="showSMTPForm" checked/>
							<span class="check"></span>
							Yes
						</label>
						<label>
							<input type="radio" name="useSMTP" value="no" id="hideSMTPForm"/>
							<span class="check"></span>
							No
						</label>
					</div>
				</div>
				<div id="smtpDetails" style="display: none;">
					<div class="grid">
						<div class="row">
							<div class="span6">
								<label for="smtpHost">* SMTP Host</label>

								<div data-role="input-control" class="input-control text">
									<input type="text" placeholder="Enter SMTP hostname/ip address" id="smtpHost">
									<button tabindex="-1" class="btn-clear" type="button"></button>
								</div>
							</div>

							<div class="span6">
								<label for="smtpEmail">* Email Address</label>

								<div data-role="input-control" class="input-control text">
									<input type="text" placeholder="Enter valid email address (will be used to send test email)" id="smtpEmail">
									<button tabindex="-1" class="btn-clear" type="button"></button>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="span6">
								<label for="smtpUser">* SMTP Username</label>

								<div data-role="input-control" class="input-control text">
									<input type="text" placeholder="Enter SMTP username (must be a valid email address)" id="smtpUser">
									<button tabindex="-1" class="btn-clear" type="button"></button>
								</div>
							</div>

							<div class="span6">
								<label for="smtpPass">* SMTP Password</label>

								<div data-role="input-control" class="input-control password">
									<input type="password" placeholder="Enter SMTP password" id="smtpPass">
									<button tabindex="-1" class="btn-reveal" type="button"></button>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="span6">
								<label for="smtpPort">* SMTP Port</label>

								<div data-role="input-control" class="input-control text">
									<input type="text" placeholder="Enter SMTP port number" id="smtpPort">
									<button tabindex="-1" class="btn-clear" type="button"></button>
								</div>
							</div>

							<div class="span6">
								<label for="smtpConnection">* SMTP Connection Type</label>

								<div data-role="input-control" class="input-control select">
									<select id="smtpConnection">
										<option value="" selected>-- Please Select --</option>
										<option value="nonssl">Non SSL</option>
										<option value="tls">TLS</option>
										<option value="ssl">SSL</option>
										<option value="sslv2">SSL v2</option>
										<option value="sslv3">SSL v3</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="checkSMTPButton" style="display: none;" data-role="input-control" class="input-control text-right"></div>
			</div>

			<div id="siteAdministration" style="display: none;">
				<legend>Site Administration</legend>
				<label for="siteURL">* Your Product URL</label>

				<div data-role="input-control" class="input-control text">
					<input type="url" id="siteURL" value="<?php echo $GetURL; ?>" readonly>
				</div>

				<label for="siteName">* Site Name</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter site name" id="siteName" value="Radius Manager">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<label for="siteFullname">* Admin Fullname</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter Fullname" id="siteFullname">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<label for="siteEmail">* Admin Email</label>

				<div data-role="input-control" class="input-control email">
					<input type="email" placeholder="Enter email address" id="siteEmail">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<label for="siteUsername">* Admin Username</label>

				<div data-role="input-control" class="input-control text">
					<input type="text" placeholder="Enter username" id="siteUsername">
					<button tabindex="-1" class="btn-clear" type="button"></button>
				</div>

				<div class="grid">
					<div class="row">
						<div class="span6">
							<label for="sitePass">* Admin Password</label>

							<div data-role="input-control" class="input-control password">
								<input type="password" placeholder="Enter password" id="sitePass">
								<button tabindex="-1" class="btn-clear" type="button"></button>
							</div>
						</div>
						<div class="span6">
							<label for="siteConfPass">* Confirm Password</label>

							<div data-role="input-control" class="input-control password">
								<input type="password" placeholder="Re-enter password" id="siteConfPass">
								<button tabindex="-1" class="btn-clear" type="button"></button>
							</div>
						</div>
					</div>
				</div>

				<div data-role="input-control" class="input-control text-right">
					<button class="button primary" id="checkDatabaseButton" onclick="javascript:siteAdminDetails();">Finish</button>
				</div>
			</div>


		</div>
	</div>
</div>

</body>
</html>
