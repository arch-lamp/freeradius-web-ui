<?php
if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	header( 'Location: ./' );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	header( 'Location: ./' );
	exit;
}

if (empty($_POST['siteURL']) || empty($_POST['siteName']) || empty($_POST['siteEmail']) || empty($_POST['siteUsername']) || empty($_POST['sitePass']) ||empty($_POST['siteConfPass']) || empty($_POST['siteFullname'])) {
	echo 'Empty';
	exit;
} else {
	$siteURL = $_POST['siteURL'];
	$siteName = $_POST['siteName'];
	$siteFullname = ucwords($_POST['siteFullname']);
	$siteEmail = $_POST['siteEmail'];
	$siteUsername = $_POST['siteUsername'];
	$sitePass = sha1($_POST['sitePass']);
	$siteConfPass = sha1($_POST['siteConfPass']);
}

if ($sitePass != $siteConfPass) {
	echo 'PasswordNotMatch';
	exit;
}
if (!filter_var($siteURL,FILTER_VALIDATE_URL)) {
	echo 'InvalidURL';
	exit;
}
if (!filter_var($siteEmail,FILTER_VALIDATE_EMAIL)) {
	echo 'InvalidEmail';
	exit;
}

require_once '../includes/config.php';
try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$insertSettings = $link->prepare("INSERT INTO rmsettings(vkey,data)VALUES('product_url',:productURL),('site_name',:siteName)");
$insertSettings->bindParam(':productURL',$siteURL);
$insertSettings->bindParam(':siteName',$siteName);
$insertSettings->execute();

if ($insertSettings->rowCount() > 0) {
	$insertAdmin = $link->prepare("INSERT INTO rmadmin (fullname,email,username,password) VALUES(:fullname,:email,:username,:password)");
	$insertAdmin->bindParam(':fullname',$siteFullname);
	$insertAdmin->bindParam(':email',$siteEmail);
	$insertAdmin->bindParam(':username',$siteUsername);
	$insertAdmin->bindParam(':password',$sitePass);

	$insertAdmin->execute();
	if ($insertAdmin->rowCount() > 0) {
		echo 'Inserted';
		exit;
	} else {
		echo 'Error';
		exit;
	}

}
