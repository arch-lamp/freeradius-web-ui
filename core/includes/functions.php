<?php
if ( preg_match( "/functions.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../../" );
	exit;
}
?>

<?php


/**
 * @return mixed
 * @description displays total number of users
 */
function totalUsers() {
	global $link;
	$totalUsers = $link->prepare( "SELECT COUNT(username) AS total_users FROM radcheck" );
	$totalUsers->execute();
	$count = $totalUsers->fetch( PDO::FETCH_OBJ );

	return $count->total_users;
}

/**
 * @return mixed
 * @description displays total number of banned users
 */
function bannedUsers() {
	global $link;
	$totalUsers = $link->prepare( "SELECT COUNT(username) AS total_users FROM radusergroup WHERE groupname='freeRADIUS-Disabled-Users'" );
	$totalUsers->execute();
	$count = $totalUsers->fetch( PDO::FETCH_OBJ );

	return $count->total_users;
}

/**
 * @return string
 * @description displays server's hostname
 */
/*function hostname() {
	$hostnameFile = '/proc/sys/kernel/hostname';

	if ( $handler = fopen( $hostnameFile, 'r' ) ) {
		$hostname = trim( fgets( $handler, filesize( $hostnameFile ) ) );
		fclose( $handler );
	} else {
		$hostname = 'Not Identified';
	}

	return $hostname;
}*/


function hostname() {
	$hostnameFile = '/proc/sys/kernel/hostname';
	if ( $handler = fopen( $hostnameFile, "r" ) ) {
		$hostname = trim( fread( $handler, 4096 ) );

		if ( $hostname == '' ) {
			$hostname = 'Not Identified';
		}

		return $hostname;
	} else {
		return 'Not Identified';
	}
}

/**
 * @return bool|string
 * @description displays date and time
 */
function dateTime() {
	if ( $today = date( 'd-m-Y' ) ) {
		return $today;
	} else {
		return 'Not Identified';
	}
}

/**
 * @return string
 * @description displays server's uptime
 */
function uptime() {
	$uptimeFile = "/proc/uptime";

	$handler = fopen( $uptimeFile, 'r' );
	$buffer  = explode( ' ', fgets( $handler, 4096 ) );
	fclose( $handler );

	$sys_ticks = trim( $buffer[0] );
	$min       = $sys_ticks / 60;
	$hours     = $min / 60;
	$days      = floor( $hours / 24 );
	$hours     = floor( $hours - ( $days * 24 ) );
	$min       = floor( $min - ( $days * 60 * 24 ) - ( $hours * 60 ) );
	$result    = "";

	if ( $days != 0 ) {
		if ( $days > 1 ) {
			$result = "$days " . " days ";
		} else {
			$result = "$days " . " day ";
		}
	}

	if ( $hours != 0 ) {
		if ( $hours > 1 ) {
			$result .= "$hours " . " hours ";
		} else {
			$result .= "$hours " . " hour ";
		}
	}

	if ( $min > 1 || $min == 0 ) {
		$result .= "$min " . " minutes ";
	} elseif ( $min == 1 ) {
		$result .= "$min " . " minute ";
	}

	return $result;
}

/**
 * @param $kbValue
 *
 * @return float
 *
 * @description convert kB to MB
 */
function kbToMb( $kbValue ) {
	return round( $kbValue / 1024 );
}

/**
 * @param $string
 *
 * @return mixed
 * @description remove white spaces from string
 */
function removeSpaces( $string ) {
	return preg_replace( "/\s+/", '', $string );
}

/**
 * @return array
 *
 * @description check memory on server
 */
function memory() {
	$memoryFile = '/proc/meminfo';

	$memory = array();

	$list = file( $memoryFile );

	foreach ( $list as $info ) {
		$stringBuffer         = rtrim( removeSpaces( $info, 'kB' ) );
		$buffer               = explode( ':', $stringBuffer );
		$memory[ $buffer[0] ] = kbToMb( preg_replace( '/kB/', '', $buffer[1] ) );
	}

	return $memory;
}

/**
 * @param $size
 *
 * @return string
 * @description convert bytes to gb
 */
function bytesToGB( $size ) {
	$counter = 0;
	while ( $size > 1024 ) {
		$size /= 1024;
		$counter ++;
	}
	$buffer = strpos( $size, '.' ) + 3;

	return substr( $size, 0, $buffer );
}

/**
 * @return string
 * @description check total disk size
 */
function totalDisk() {
	return bytesToGB( disk_total_space( '/' ) );
}

/**
 * @return string
 * @description check free disk size
 */
function freeDisk() {
	return bytesToGB( disk_free_space( '/' ) );
}
