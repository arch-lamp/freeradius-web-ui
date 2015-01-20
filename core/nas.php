<?php
require_once 'includes/chkLogin.php';
?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<?php
	require_once '../includes/css-js.php';
	require_once './includes/css-js.php';
	?>
	<title><?php echo $_SESSION['SITE_NAME'] ?>::Users</title>

	<script type="text/javascript" src="<?php echo $_SESSION['PRODUCT_URL'] ?>core/js/nas.js"></script>
	<script type="text/javascript" src="<?php echo $_SESSION['PRODUCT_URL'] ?>core/js/confirmation.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			loadNASList(1);
			$('.pagination').delay(1500).fadeIn(500);
		});
	</script>
</head>
<body>
<?php require_once 'includes/menu.php'; ?>
<div class="container">
	<div class="row">
		<h1>
			<i class="icon-monitor-2 fg-darker smaller"></i>
			NAS
		</h1>
	</div>

	<?php
	/**
	 * Count total number of pages for pagination.
	 */
	require_once '../includes/config.php';

	try {
		$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
	} catch ( PDOException $Exception ) {
		die( $Exception->getMessage() );
	}
	$recordsPerPage = 10;
	$countNAS     = $link->prepare( 'SELECT * FROM nas' );

	$countNAS->execute();

	$totalNAS = $countNAS->rowCount();
	$totalPages = ceil( $totalNAS / $recordsPerPage );
	?>

	<input type="hidden" id="currentPage" value="1"/>
	<input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>"/>

	<div id="loadNAS"></div>
	<?php
	if ( $totalPages > 1 ) {
		?>
		<div class="pagination place-right" style="margin-top: 3%; display: none;">
			<ul>
				<li class="previous" id="previous" style="display: none;">
					<a style="border-radius: 10px;" class="button dark" href="javascript:void(0);" onclick="javascript:loadPreviousNAS();">
						<span aria-hidden="true">&larr;</span> Previous
					</a>
				</li>

				<li class="next" id="next">
					<a style="border-radius: 10px;" class="button dark" href="javascript:void(0);" onclick='javascript:loadNextNAS();'>
						Next <span aria-hidden="true">&rarr;</span>
					</a>
				</li>
			</ul>
		</div>
	<?php
	}
	?>
</div>
</body>
</html>