<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['username'] ) || empty( $_POST['encryption'] ) ) {
	exit;
} else {
	$username   = $_POST['username'];
	$encryption = $_POST['encryption'];
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

require_once './includes/class.RandomPassword.php';
$Password          = new RandomPassword();
$plainTextPassword = $Password->getPassword();

if ( $encryption == 'SHA-Password' ) {
	$encryptedPassword = sha1( $plainTextPassword );
} else if ( $encryption == 'MD5-Password' ) {
	$encryptedPassword = md5( $plainTextPassword );
} else {
	$encryptedPassword = '';
}

if ( $encryptedPassword == '' ) {
	echo 'EncryptionError';
	exit;
}

function currentPassword() {
	global $link, $username;
	$fetchPassword = $link->prepare( "SELECT value FROM radcheck WHERE username = :username" );
	$fetchPassword->bindParam( ':username', $username, PDO::PARAM_STR );
	$fetchPassword->execute();
	$currentPassword = $fetchPassword->fetch( PDO::FETCH_OBJ );

	return $currentPassword->password;
}

function userFullName() {
	global $link, $username;
	$fetchName = $link->prepare( "SELECT fullname FROM radcheck WHERE username = :username" );
	$fetchName->bindParam( ':username', $username, PDO::PARAM_STR );
	$fetchName->execute();
	$fullname = $fetchName->fetch( PDO::FETCH_OBJ );

	return $fullname->fullname;
}

function userEmail() {
	global $link, $username;
	$fetchEmail = $link->prepare( "SELECT email FROM radcheck WHERE username = :username" );
	$fetchEmail->bindParam( ':username', $username, PDO::PARAM_STR );
	$fetchEmail->execute();
	$email = $fetchEmail->fetch( PDO::FETCH_OBJ );

	return $email->email;
}

$resetPassword = $link->prepare( 'UPDATE radcheck SET value = :password WHERE username = :username' );
$resetPassword->bindParam( ':password', $encryptedPassword, PDO::PARAM_STR );
$resetPassword->bindParam( ':username', $username, PDO::PARAM_STR );

require 'includes/class.phpmailer.php';
require 'includes/class.smtp.php';
require 'includes/mailSettings.php';

$fullname = userFullName();

$Mail->addAddress( userEmail(), $fullname );
$Mail->Subject = $_SESSION['SITE_NAME'] . ':: Password Reset';

$emailHeading = 'Account Password Reset';
$emailContent = "Hi $fullname,<br/><br/>
				 Due to security, admin has reset your password for FreeRADIUS Server. To connect to FreeRadius server with new credentials use the following details.<br/><br/>
				 Username: $username<br/>
				 Password: $plainTextPassword<br/><br/>
				 For other information you can contact admin at: <a href=\"mailto:$_SESSION[EMAIL]\">$_SESSION[EMAIL]</a><br/><br/>
				 Thanks
				";

$Mail->Body = "
<!doctype html>
<html lang='en-US'>
<head>
	<meta charset='UTF-8'>
	<title></title>

	<style type='text/css'> #outlook a { padding: 0; }
        body { width: 100% !important; -webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;margin: 0;padding: 0;}.ExternalClass {width: 100%;}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }
        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .image_fix {
            display: block;
        }
        p {
            margin: 1em 0;
        }
        h1, h2, h3, h4, h5, h6 {
            color: black !important;
        }

        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
            color: blue !important;
        }

        h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important;
        }

        h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: purple !important;
        }
        table td {
            border-collapse: collapse;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        @media only screen and (max-device-width: 480px) {

            a[href^='tel'], a[href^='sms'] {
                text-decoration: none;
                color: blue;
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^='tel'], .mobile_link a[href^='sms'] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }

        }
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {

            a[href^='tel'], a[href^='sms'] {
                text-decoration: none;
                color: blue;
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^='tel'], .mobile_link a[href^='sms'] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
    </style>

</head>
<body>
<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#333333'>
    <tr>
        <td align='center'>
            <center>
                <table border='0' width='600' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td style='color:#ffffff !important; font-size:24px; font-family: Arial, Verdana, sans-serif; padding-left:10px;' height='40'>$_SESSION[SITE_NAME]</td>
                        <td align='right' width='50' height='45'></td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>

<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#ffffff'>
    <tr>
        <td align='center'>
            <center>
                <table border='0' width='600' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td style='color:#333333 !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;'
                            height='40'>
                            <h3 style='font-weight:normal; margin: 20px 0;'>$emailHeading</h3>

                            <p style='font-size:12px; line-height:18px;'>
								$emailContent
                            </p>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>

<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#333333'>
    <tr>
        <td align='center'>
            <center>
                <table border='0' width='600' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td style='color:#ffffff !important; font-size:24px; font-family: Arial, Verdana, sans-serif; padding-left:10px;' height='40'></td>
                        <td align='right' width='50' height='45'></td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
";

$resetPassword->execute();

if ($resetPassword->rowCount() == 1) {
	if ($Mail->send()) {
		echo 'PasswordReset';
		exit;
	} else {
		$lastPassword = $link->prepare("UPDATE radcheck SET password = :password WHERE username = :username");
		$lastPassword->bindParam(':password',currentPassword(),PDO::PARAM_STR);
		$lastPassword->bindParam(':username',$username,PDO::PARAM_STR);
		$lastPassword->execute();
		if ($lastPassword->rowCount() == 1) {
			echo 'ErrorPasswordReset';
			exit;
		} else {
			echo 'Error';
			exit;
		}
	}
} else {
	echo 'ErrorUpdatePassword';
	exit;
}



