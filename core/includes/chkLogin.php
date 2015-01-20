<?php
if ( preg_match( "/chkLogin.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../../" );
	exit;
}
?>

<?php
session_name('admin');
require_once '../includes/class.SessionManagement.php';
$Session = new SessionManagement('admin');
if (!$Session->checkSession() or $_SESSION['ADMIN'] != true) {
	header("Location: ../?login=false");
	exit;
}