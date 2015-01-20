<?php
if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	header( 'Location: ./' );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	header( 'Location: ./' );
	exit;
}

if ( empty( $_POST['usr'] ) || empty( $_POST['pwd'] ) ) {
	echo 'Empty';
	exit;
} else {
	$username = base64_decode( $_POST['usr'] );
	$password = sha1( base64_decode( $_POST['pwd'] ) );
}

require_once 'includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$chkLogin = $link->prepare( 'SELECT * FROM rmadmin WHERE username=:username AND password=:password' );

$chkLogin->bindParam( ':username', $username, PDO::PARAM_STR );
$chkLogin->bindParam( ':password', $password, PDO::PARAM_STR );

$chkLogin->execute();

if ( $chkLogin->rowCount() != 1 ) {
	echo 'Invalid';
	exit;
}

$adminInfo = $chkLogin->fetch( PDO::FETCH_ASSOC );

require 'includes/class.SessionManagement.php';
session_name('admin');
$Session = new SessionManagement('admin');
$Session->sessionOpen();

require_once 'includes/functions.php';

$_SESSION['USERNAME']    = $adminInfo['username'];
$_SESSION['EMAIL']       = $adminInfo['email'];
$_SESSION['FULLNAME']    = $adminInfo['fullname'];
$_SESSION['SITE_NAME']   = getSetting('site_name');
$_SESSION['PRODUCT_URL'] = getSetting('product_url');
$_SESSION['ADMIN']       = true;

$_SESSION['MAIL_SEND'] = getSetting('mail_send');

if ($_SESSION['MAIL_SEND'] == 'enable') {
	$_SESSION['MAIL_HOSTNAME'] = getSetting('mail_hostname');
	$_SESSION['MAIL_USERNAME'] = getSetting('mail_username');
	$_SESSION['MAIL_PASSWORD'] = getSetting('mail_password');
	$_SESSION['MAIL_PORT'] = (int)getSetting('mail_port');
	$_SESSION['MAIL_SECURE'] = getSetting('mail_secure');
}

echo trim('Login');
exit;