<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['nasId'] ) || empty( $_POST['nasType'] ) || empty( $_POST['nasSecret'] ) ) {
	echo 'Empty';
	exit;
} else {
	$nasId     = (int)$_POST['nasId'];
	$nasType   = $_POST['nasType'];
	$nasSecret = $_POST['nasSecret'];

	$nasShortName   = $_POST['nasShortName'];
	$nasPort        = (int) $_POST['nasPort'];
	$nasServer      = $_POST['nasServer'];
	$nasCommunity   = $_POST['nasCommunity'];
	$nasDescription = $_POST['nasDescription'];
}


require_once '../includes/config.php';
try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

if ( empty ( $nasShortName ) || $nasShortName == 'null' ) {
	$nasShortName = null;
}
if ( empty( $nasPort ) || $nasPort == 'null' ) {
	$nasPort = null;
}
if ( empty( $nasServer ) || $nasServer == 'null' ) {
	$nasServer = null;
}
if ( empty( $nasCommunity ) || $nasCommunity == 'null' ) {
	$nasCommunity = null;
}
if ( empty( $nasDescription ) || $nasDescription == 'null' ) {
	$nasDescription = 'freeRADIUS Client';
}

$updateInfo = $link->prepare( 'UPDATE nas SET type = :type, secret = :secret, shortname = :shortname, ports = :port, server = :server, community = :community, description = :description WHERE id = :id');

$updateInfo->bindParam(':type',$nasType);
$updateInfo->bindParam(':secret',$nasSecret);
$updateInfo->bindParam(':shortname',$nasShortName);
$updateInfo->bindParam(':port',$nasPort);
$updateInfo->bindParam(':server',$nasServer);
$updateInfo->bindParam(':community',$nasCommunity);
$updateInfo->bindParam(':description',$nasDescription);
$updateInfo->bindParam(':id',$nasId);

try
{
	$updateInfo->execute();
	if ($updateInfo->rowCount() == 1) {
		echo 'Updated';
		exit;
	} else {
		echo 'NoChanges';
		exit;
	}
} catch (Exception $Exception) {
	echo 'Error';
	exit;
}