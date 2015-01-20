<?php

require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}

if ( empty( $_POST['username'] ) || empty( $_POST['status'] ) ) {
	exit;
} else {
	$username = $_POST['username'];
	$status   = $_POST['status'];
}

require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

switch ( $status ) {
	case 'disable':
		$chkUser = $link->prepare('SELECT username FROM radusergroup WHERE groupname=:group AND username=:username');
		$disabledGroup = 'freeRADIUS-Disabled-Users';
		$chkUser->bindParam(':group',$disabledGroup,PDO::PARAM_STR);
		$chkUser->bindParam(':username',$username,PDO::PARAM_STR);
		$chkUser->execute();
		if ($chkUser->rowCount() > 0) {
			echo 'AlreadyDisabled';
			exit;
		} else {
			$disableUser = $link->prepare('INSERT INTO radusergroup (username, groupname) VALUES (:username, :group)');
			$disableUser->bindParam(':username',$username,PDO::PARAM_STR);
			$disableUser->bindParam(':group',$disabledGroup,PDO::PARAM_STR);
			$disableUser->execute();
			if ($disableUser->rowCount() == 1) {
				echo 'Disabled';
				exit;
			} else {
				echo 'ErrorDisable';
				exit;
			}
		}

		break;

	case 'enable':
		$chkUser = $link->prepare('SELECT username FROM radusergroup WHERE groupname=:group AND username=:username');
		$disabledGroup = 'freeRADIUS-Disabled-Users';
		$chkUser->bindParam(':group',$disabledGroup,PDO::PARAM_STR);
		$chkUser->bindParam(':username',$username,PDO::PARAM_STR);
		$chkUser->execute();
		if ($chkUser->rowCount() == 0) {
			echo 'AlreadyEnabled';
			exit;
		} else {
			$enableUser = $link->prepare("DELETE FROM radusergroup WHERE username=:username AND groupname=:group");
			$enableUser->bindParam(':username',$username,PDO::PARAM_STR);
			$enableUser->bindParam(':group',$disabledGroup,PDO::PARAM_STR);
			$enableUser->execute();
			if ($enableUser->rowCount() > 0) {
				echo 'Enabled';
				exit;
			} else {
				echo 'ErrorEnable';
				exit;
			}
		}
		break;

	default:
		echo 'InvalidRequest';
		break;
}