<?php

require_once 'includes/chkLogin.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	exit;
}

if (empty($_POST['currPass']) || empty($_POST['newPass']) || empty($_POST['confPass'])) {
	echo 'Empty';
	exit;
} else {
	$currPass = sha1(base64_decode($_POST['currPass']));
	$newPass  = sha1(base64_decode($_POST['newPass']));
	$confPass = sha1(base64_decode($_POST['confPass']));
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$checkPassword = $link->prepare('SELECT password FROM rmadmin WHERE username = :username');
$checkPassword->bindParam(':username', $_SESSION['USERNAME']);
$checkPassword->execute();
$userPass = $checkPassword->fetch(PDO::FETCH_ASSOC);

if ($userPass['password'] != $currPass) {
	echo 'Wrong';
	exit;
}

if (strlen($_POST['newPass']) < 8) {
	echo 'LowLength';
	exit;
}


if ($newPass != $confPass) {
	echo 'NotMatched';
	exit;
}

if ($userPass['password'] == $newPass) {
	echo 'Same';
	exit;
}

$changePass = $link->prepare('UPDATE rmadmin SET password = :password WHERE username = :username');
$changePass->bindParam(':username', $_SESSION['USERNAME']);
$changePass->bindParam(':password', $newPass);
$changePass->execute();
if ($changePass->rowCount() != 1) {
	echo 'NotChanged';
	exit;
} else {
	echo 'Changed';
	exit;
}