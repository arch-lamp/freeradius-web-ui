<?php

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	header( 'Location: ./' );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	header( 'Location: ./' );
	exit;
}

switch ( $_POST['action'] ) {
	case 'verifyConnection':
		if ( empty( $_POST['host'] ) || empty( $_POST['user'] ) || empty( $_POST['pass'] ) || empty( $_POST['email'] ) || empty( $_POST['port'] ) || empty( $_POST['secure'] ) || empty( $_POST['action'] ) ) {
			echo 'Empty';
			exit;
		} else {
			$hostname = $_POST['host'];
			$email    = $_POST['email'];
			$username = $_POST['user'];
			$password = $_POST['pass'];
			$port     = $_POST['port'];
			$secure   = $_POST['secure'];
		}

		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			echo 'InvalidEmail';
			exit;
		}

		if ( ! filter_var( $username, FILTER_VALIDATE_EMAIL ) ) {
			echo 'UsernameInvalidEmail';
			exit;
		}

		if ( ! filter_var( $port, FILTER_VALIDATE_INT ) ) {
			echo 'InvalidPort';
			exit;
		}
		require '../core/includes/class.phpmailer.php';
		require '../core/includes/class.smtp.php';
		$Mail = new PHPMailer();
		$Mail->isSMTP();
		$Mail->SMTPAuth   = true;
		$Mail->Host       = $hostname;
		$Mail->SMTPSecure = $secure;
		$Mail->Port       = $port;
		$Mail->Username   = $username;
		$Mail->Password   = $password;
		$Mail->From       = $username;
		$Mail->FromName   = 'Radius Manager';
		$Mail->isHTML( true );
		$Mail->XMailer = 'Radius Manager';

		$Mail->addAddress( $email );
		$Mail->Subject = 'Radius Manager: Verify Connection';

		$emailHeading = 'Connection Verified';
		$emailContent = "Hi,<br/><br/>Congratulations!<br/>Your SMTP connection is successfully verified with radius manager application which you are trying to install on your server.<br/><br/>Thanks";
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
                        <td style='color:#ffffff !important; font-size:24px; font-family: Arial, Verdana, sans-serif; padding-left:10px;' height='40'>Radius Manager</td>
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
			require '../includes/config.php';
			try {
				$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
			} catch ( PDOException $Exception ) {
				die( $Exception->getMessage() );
			}

			$insertSMTP = $link->prepare( "INSERT INTO rmsettings (vkey,data) VALUES('mail_send','enable'),('mail_hostname',:mailhost),('mail_username',:username),('mail_password',:password),('mail_port',:port),('mail_secure',:secure)" );
			$insertSMTP->bindParam( ':mailhost', $hostname );
			$insertSMTP->bindParam( ':username', $username );
			$insertSMTP->bindParam( ':password', $password );
			$insertSMTP->bindParam( ':port', $port );
			$insertSMTP->bindParam( ':secure', $secure );
			$insertSMTP->execute();
			if ( $insertSMTP->rowCount() > 0 ) {
				echo 'TestMailSent';
				exit;
			} else {
				echo 'ErrorDBInsert';
				exit;
			}
		} else {
			echo 'TestEmailError';
			exit;
		}
		break;


	case 'withoutSMTP':
		require '../includes/config.php';
		try {
			$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
		} catch ( PDOException $Exception ) {
			die( $Exception->getMessage() );
		}

		$insertSMTP = $link->prepare( "INSERT INTO rmsettings (vkey,data) VALUES('mail_send','disable'),('mail_hostname',NULL),('mail_username',NULL),('mail_password',NULL ),('mail_port',NULL),('mail_secure',NULL )" );
		$insertSMTP->execute();
		if ($insertSMTP->rowCount() > 0) {
			echo 'Inserted';
			exit;
		} else {
			echo 'Error';
			exit;
		}
		break;

	default:
		echo 'Empty';
		exit;
		break;
}