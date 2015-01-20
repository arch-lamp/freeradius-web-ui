<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if (empty($_POST['id'])) {
	exit;
} else {
	$id = $_POST['id'];
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$NASInfo = $link->prepare('SELECT * FROM nas WHERE id = :id');
$NASInfo->bindParam(':id',$id,PDO::PARAM_INT);
$NASInfo->execute();
if ($NASInfo->rowCount() != 1) {
	echo 'ErrorNASCount';
	exit;
}

$info = $NASInfo->fetch(PDO::FETCH_OBJ);
print json_encode($info);
exit;