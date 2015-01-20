<?php
require_once 'includes/chkLogin.php';

if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	exit;
}


require_once '../includes/config.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

if ( isset( $_POST['page'] ) ) {
	$page = $_POST['page'];
} else {
	$page = 1;
}

$recordPerPage = 10;
$startPage     = ( $page - 1 ) * $recordPerPage;

$loadUsersQuery = "SELECT rc.id, rc.username, rc.attribute, rc.fullname, rc.email, rug.groupname FROM radcheck rc LEFT OUTER JOIN radusergroup rug ON(rc.username = rug.username) ORDER BY id DESC  LIMIT $startPage, $recordPerPage";

$loadUsers = $link->prepare( $loadUsersQuery );
$loadUsers->execute();

if ( $loadUsers->rowCount() < 1 ) {
	echo 'NotFound';
	exit;
}
?>


<table class="table bordered hovered">
	<thead>
	<tr>
		<td class="text-bold">Full Name</td>
		<td class="text-bold">Username</td>
		<td class="text-bold">Email</td>
		<td class="text-bold">Account Status</td>
		<td class="text-bold">Actions</td>
	</tr>
	</thead>
	<tbody>
	<?php
	while ( $userInfo = $loadUsers->fetch( PDO::FETCH_OBJ ) ) {
		?>
		<tr>
			<td><?php echo $userInfo->fullname; ?></td>
			<td><?php echo $userInfo->username; ?></td>
			<td><?php echo $userInfo->email; ?></td>
			<td class="">
				<?php
				if ( $userInfo->groupname == 'freeRADIUS-Disabled-Users' ) {
					?>
					<span class="label danger">
						Disable
					</span>
				<?php
				} else {
					?>
					<span class="label success">
						Enable
					</span>
				<?php
				}
				?>
			</td>

			<td id="action-<?php echo $userInfo->id ?>">
				<?php
				if ( $userInfo->groupname == 'freeRADIUS-Disabled-Users' ) {
					?>
					<a href="javascript:void(0);" onclick="javascript:confirmUserChangeStatus(<?php echo $userInfo->id ?>,'<?php echo $userInfo->username; ?>','enable');" class="text-success" id="enable<?php echo $userInfo->id; ?>" data-hint="Enable User Account">
						<i class="icon-unlocked"></i>
					</a>
				<?php
				} else {
					?>
					<a href="javascript:void(0);" onclick="javascript:confirmUserChangeStatus(<?php echo $userInfo->id ?>,'<?php echo $userInfo->username; ?>','disable');" class="text-danger" id="disable<?php echo $userInfo->id; ?>" data-hint="Disable User Account">
						<i class="icon-locked"></i>
					</a>
				<?php
				}
				?>
				&nbsp;&nbsp;
				<a href="javascript:void(0);" onclick="javascript:confirmUserPasswordReset(<?php echo $userInfo->id ?>,'<?php echo $userInfo->username; ?>','<?php echo $userInfo->attribute; ?>');" class="text-primary" id="resetPass<?php echo $userInfo->id; ?>" data-hint="Reset Password">
					<i class="icon-key-2"></i>
				</a>
				&nbsp;&nbsp;
				<a href="javascript:void(0);" onclick="javascript:confirmUserDelete(<?php echo $userInfo->id ?>,'<?php echo $userInfo->username; ?>');" class="text-warning" id="delete<?php echo $userInfo->id; ?>" data-hint="Delete User">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
