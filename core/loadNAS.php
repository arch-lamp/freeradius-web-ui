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

$loadNASQuery = "SELECT * FROM nas ORDER BY id DESC  LIMIT $startPage, $recordPerPage";

$loadNAS = $link->prepare( $loadNASQuery );
$loadNAS->execute();

if ( $loadNAS->rowCount() < 1 ) {
	echo 'NotFound';
	exit;
}
?>

<table class="table bordered hovered">
	<thead>
	<tr>
		<td class="text-bold">IP/Host</td>
		<td class="text-bold">Short Name</td>
		<td class="text-bold">Type</td>
		<td class="text-bold">Port</td>
		<td class="text-bold">Server</td>
		<td class="text-bold">Actions</td>
	</tr>
	</thead>
	<tbody>
	<?php
	while ( $nasInfo = $loadNAS->fetch( PDO::FETCH_OBJ ) ) {
		?>
		<tr>
			<td><?php echo $nasInfo->nasname; ?></td>
			<td><?php echo $nasInfo->shortname; ?></td>
			<td><?php echo $nasInfo->type; ?></td>
			<td><?php echo $nasInfo->ports; ?></td>
			<td><?php echo $nasInfo->server; ?></td>

			<td id="action-<?php echo $nasInfo->id ?>">
				<a id="info<?php echo $nasInfo->id; ?>" href="javascript:void(0);" onclick="javascript:viewNASInfo(<?php echo $nasInfo->id; ?>);" data-hint="View Full Information" class="text-info">
					<i class="icon-info-2"></i>
				</a>
				&nbsp;&nbsp;
				<a id="edit<?php echo $nasInfo->id; ?>" href="javascript:void(0);" onclick="javascript:updateNASDialog(<?php echo $nasInfo->id; ?>);" data-hint="Edit Information" class="text-primary">
					<i class="icon-pencil"></i>
				</a>
				&nbsp;&nbsp;
				<a id="delete<?php echo $nasInfo->id; ?>" href="javascript:void(0);" onclick="javascript:confirmNASDelete(<?php echo $nasInfo->id; ?>,'<?php echo $nasInfo->nasname; ?>');" class="text-warning" id="delete<?php echo $userInfo->id; ?>" data-hint="Delete NAS">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>