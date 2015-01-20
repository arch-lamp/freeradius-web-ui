<?php
if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	header( 'Location: ./' );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	header( 'Location: ./' );
	exit;
}

if ( empty( $_POST['dbHost'] ) || empty( $_POST['dbUser'] ) || empty( $_POST['dbName'] ) ) {
	echo 'Empty';
	exit;
} else {
	$dbHost = $_POST['dbHost'];
	$dbUser = $_POST['dbUser'];
	$dbPass = $_POST['dbPass'];
	$dbName = $_POST['dbName'];
}

try {
	$link = new PDO( "mysql:host=$dbHost", $dbUser, $dbPass );
} catch ( PDOException $Exception ) {
	echo 'Invalid';
}


if ( $_POST['action'] == 'createDb' ) {
	try {
		$link->exec( "CREATE DATABASE IF NOT EXISTS `$dbName`" );
		echo 'dbCreated';
		exit;
	} catch ( PDOException $Exception ) {
		echo 'ErrorCreateDb';
		exit;
	}
}


if ( $_POST['action'] == 'populateTables' ) {

	require_once 'tables.php';
	$tableResult = array();
	try {
		foreach ( $dbTable as $tabName => $structure ) {
			$link->exec( "USE $dbName" );
			$link->exec( $structure );
			$tableResult[ $tabName ] = 'true';
		}
	} catch ( PDOException $Exception ) {
		$tableResult[ $tabName ] = 'false';
	}

	if ( in_array( 'false', $tableResult ) ) {
		echo 'TableError';
		exit;
	} else {
		$configuration  = "<?php
if ( preg_match( '/config.php/', \$_SERVER['SCRIPT_NAME'] ) ) {
	header( 'Location: ../' );
	exit;
}
?>";
		$configuration .= "\n<?php\n\ndefine( 'RAD_DB_DRIVER', 'mysql' );\n\ndefine( 'RAD_DB_HOST', '$dbHost' );\n\ndefine( 'RAD_DB_NAME', '$dbName' );\n\ndefine( 'RAD_DB_USER', '$dbUser' );\n\ndefine( 'RAD_DB_PASS', '$dbPass' );\n\n?>";
		$handler       = fopen( '../includes/config.php', 'w' );
		fwrite( $handler, $configuration );
		fclose( $handler );
		echo 'TableSuccess';
		exit;
	}
}

/**
 * check database exists
 */

$checkDatabase = $link->prepare( "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname" );
$checkDatabase->bindParam( ':dbname', $dbName, PDO::PARAM_STR );
$checkDatabase->execute();

if ( $checkDatabase->rowCount() == 1 ) {
	echo 'dbExists';
	exit;
} else {
	echo 'dbNotExists';
	exit;
}
