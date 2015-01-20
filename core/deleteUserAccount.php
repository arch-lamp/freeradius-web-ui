<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if (empty($_POST['username'])) {
	exit;
} else {
	$username = $_POST['username'];
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

function deleteUser() {
	global $link, $username;
	$deleteUser = $link->prepare("DELETE FROM radcheck WHERE username = :username");
	$deleteUser->bindParam(':username',$username,PDO::PARAM_STR);
	$deleteUser->execute();
	if ($deleteUser->rowCount()==1) {
		return 'Deleted';
	} else {
		return 'ErrorDelete';
	}
}

$chkGroup = $link->prepare('SELECT * FROM radusergroup WHERE username = :username');
$chkGroup->bindParam(':username',$username,PDO::PARAM_STR);
$chkGroup->execute();
if ($chkGroup->rowCount() == 0) {
	print deleteUser();
	exit;
} else {
	$deleteUserFromGroup = $link->prepare('DELETE FROM radusergroup WHERE username = :username');
	$deleteUserFromGroup->bindParam(':username',$username,PDO::PARAM_STR);
	$deleteUserFromGroup->execute();
	if ($deleteUserFromGroup > 0) {
		print deleteUser();
		exit;
	} else {
		echo 'ErrorGroup';
		exit;
	}
}