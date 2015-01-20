<?php

require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['nasHost'] ) || empty( $_POST['nasType'] ) || empty( $_POST['nasSecret'] ) ) {
	echo 'Empty';
	exit;
} else {
	$nasHost   = $_POST['nasHost'];
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

if ( empty ( $nasShortName ) ) {
	$nasShortName = null;
}
if ( empty( $nasPort ) ) {
	$nasPort = null;
}
if ( empty( $nasServer ) ) {
	$nasServer = null;
}
if ( empty( $nasCommunity ) ) {
	$nasCommunity = null;
}
if ( empty( $nasDescription ) ) {
	$nasDescription = 'freeRADIUS Client';
}

$insertNAS = $link->prepare( 'INSERT INTO nas (nasname, shortname, type, ports, secret, server , community, description) VALUES (:nasname, :shortname, :type, :ports, :secret, :server, :community, :description)' );

$insertNAS->bindParam(':nasname',$nasHost);
$insertNAS->bindParam(':shortname',$nasShortName);
$insertNAS->bindParam(':type',$nasType);
$insertNAS->bindParam(':ports',$nasPort);
$insertNAS->bindParam(':secret',$nasSecret);
$insertNAS->bindParam(':server',$nasServer);
$insertNAS->bindParam(':community',$nasCommunity);
$insertNAS->bindParam(':description',$nasDescription);

$insertNAS->execute();
if ($insertNAS->rowCount() == 1) {
	echo 'Inserted';
	exit;
} else {
	echo 'Error';
	exit;
}