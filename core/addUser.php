<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['fullname'] ) || empty( $_POST['username'] ) || empty( $_POST['passwordType'] ) || empty( $_POST['email'] ) ) {
	echo 'Empty';
	exit;
} else {
	$fullname     = ucwords($_POST['fullname']);
	$username     = strtolower($_POST['username']);
	$email        = strtolower($_POST['email']);
	$passwordType = $_POST['passwordType'];
	require_once 'includes/class.RandomPassword.php';

	$op            = ':==';
	$Password      = new RandomPassword();
	$plainPassword = $Password->getPassword();

	if ( $passwordType == 'MD5' ) {
		$password  = md5( $plainPassword );
		$attribute = 'MD5-Password';
	}

	if ( $passwordType == 'SHA1' ) {
		$password  = sha1( $plainPassword );
		$attribute = 'SHA-Password';
	}
}

if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
	echo 'InvalidEmail';
	exit;
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$chkUserName = $link->prepare( 'SELECT * FROM radcheck WHERE username = :username' );
$chkUserName->bindParam( ':username', $username );
$chkUserName->execute();
if ( $chkUserName->rowCount() == 1 ) {
	echo 'UsernameRegistered';
	exit;
}

$chkEmail = $link->prepare( 'SELECT * FROM radcheck WHERE email = :email' );
$chkEmail->bindParam( ':email', $email );
$chkEmail->execute();
if ( $chkEmail->rowCount() == 1 ) {
	echo 'EmailRegistered';
	exit;
}

$registerUser = $link->prepare( 'INSERT INTO radcheck(username, attribute, op, value, fullname, email)  VALUES(:username, :attribute, :op, :password,:fullname,:email)' );

$registerUser->bindParam( ':username', $username );
$registerUser->bindParam( ':attribute', $attribute );
$registerUser->bindParam( ':op', $op );
$registerUser->bindParam( ':password', $password );
$registerUser->bindParam( ':fullname', $fullname );
$registerUser->bindParam( ':email', $email );

$registerUser->execute();

if ( $registerUser->rowCount() != 1 ) {
	echo 'Error';
	exit;
}

if ( $_SESSION['MAIL_SEND'] != 'enable' ) {
	echo 'Registered';
	exit;
}


require 'includes/class.phpmailer.php';
require 'includes/class.smtp.php';
require 'includes/mailSettings.php';


$Mail->addAddress( $email, $fullname );
$Mail->Subject = $_SESSION['SITE_NAME'] . ':: Account Created';

$emailHeading = 'Account Created';
$emailContent = "Hi $fullname,<br/><br/>
				 Admin has created your account on FreeRADIUS server. To connect to FreeRadius server use the following details.<br/><br/>
				 Username: $username<br/>
				 Password: $plainPassword<br/><br/>
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

if ( $Mail->send() ) {
	echo 'MailSent';
	exit;
} else {
	echo 'EmailError';
	exit;
}