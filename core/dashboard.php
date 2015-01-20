<?php

require_once 'includes/chkLogin.php';
if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( $_POST['action'] != 'true' ) {
	exit;
}

require_once '../includes/config.php';
try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}
require_once 'includes/functions.php';

$totalUsers = totalUsers();
$bannedUsers = bannedUsers();
$activeUsers = $totalUsers - $bannedUsers;

$date = dateTime();
$hostname = hostname();
$uptime = uptime();

$memory = memory();
$totalMem = $memory['MemTotal'];
$freeMem = $memory['MemFree'];
$usedMem = $totalMem-$freeMem;

$totalDisk = totalDisk();
$freeDisk = freeDisk();
$usedDisk = $totalDisk - $freeDisk;



$info = array(
	'totalUsers'=>$totalUsers,
	'bannedUsers'=>$bannedUsers,
	'activeUsers'=>$activeUsers,

	'date'=>$date,
	'uptime'=>$uptime,
	'hostname'=>$hostname,

	'totalMem'=>$totalMem,
	'freeMem'=>$freeMem,
	'usedMem'=>$usedMem,

    'totalDisk'=>$totalDisk,
    'freeDisk'=>$freeDisk,
    'usedDisk'=>$usedDisk,
);

print json_encode($info);
exit;