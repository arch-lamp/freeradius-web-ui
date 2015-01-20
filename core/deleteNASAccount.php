<?php

require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['nasname'] ) || empty( $_POST['id'] ) ) {
	exit;
} else {
	$id = $_POST['id'];
	$nasname   = $_POST['nasname'];
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$deleteNAS = $link->prepare("DELETE FROM nas WHERE id=:id AND nasname=:nasname");
$deleteNAS->bindParam(':id',$id);
$deleteNAS->bindParam(':nasname',$nasname);
$deleteNAS->execute();

if ($deleteNAS->rowCount() == 1) {
	echo 'Deleted';
	exit;
} else {
	echo 'Error';
	exit;
}