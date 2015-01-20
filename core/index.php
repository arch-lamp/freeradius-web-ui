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
	<title><?php echo $_SESSION['SITE_NAME'] ?>::Dashboard</title>

	<script type="text/javascript" src="<?php echo $_SESSION['PRODUCT_URL'] ?>core/js/dashboard.js"></script>

	<script type="text/javascript">
		$('#usersCount').ready(function() {
			dashboard();
			setInterval(function() {
				dashboard();
			},60000);
		});
	</script>
</head>
<body>
<?php require_once 'includes/menu.php'; ?>
<div class="container">
	<div class="row">
		<h1>
			<i class="icon-dashboard fg-darker smaller"></i>
			Dashboard
		</h1>
	</div>

	<div class="grid">
		<div class="row">
			<!--User Info Start-->
			<div class="span6">
				<div class="panel">
					<div class="panel-header bg-dark text-clear">
						<span class="icon-user"></span>
						<span>User</span>
					</div>
					<div class="panel-content">
						<table class="table">
							<tbody>
							<tr>
								<td><span class="text-bold">Total Users</span></td>
								<td><span id="totalUsers"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Active Users</span></td>
								<td><span id="activeUsers"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Banned Users</span></td>
								<td><span id="bannedUsers"></span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--User Info End-->

			<!--Server Info Start-->
			<div class="span6">
				<div class="panel">
					<div class="panel-header bg-dark text-clear">
						<span class="icon-monitor"></span>
						<span>Server</span>
					</div>
					<div class="panel-content">
						<table class="table">
							<tbody>
							<tr>
								<td><span class="text-bold">Date</span></td>
								<td><span id="date"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Hostname</span></td>
								<td><span id="hostname"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Up Time</span></td>
								<td><span id="uptime"></span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--Server Info End-->
		</div>

		<div class="row">
			<!--Memory Info Start-->
			<div class="span6">
				<div class="panel">
					<div class="panel-header bg-dark text-clear">
						<span class="icon-meter-medium"></span>
						<span>Memory</span>
					</div>
					<div class="panel-content">
						<table class="table">
							<tbody>
							<tr>
								<td><span class="text-bold">Total Memory</span></td>
								<td><span id="totalMem"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Free Memory</span></td>
								<td><span id="freeMem"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Used Memory</span></td>
								<td><span id="usedMem"></span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--Memory Info End-->

			<!--Disk Info Start-->
			<div class="span6">
				<div class="panel">
					<div class="panel-header bg-dark text-clear">
						<span class="icon-floppy"></span>
						<span>Storage</span>
					</div>
					<div class="panel-content">
						<table class="table">
							<tbody>
							<tr>
								<td><span class="text-bold">Total Disk</span></td>
								<td><span id="totalDsk"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Free Disk</span></td>
								<td><span id="freeDsk"></span></td>
							</tr>
							<tr>
								<td><span class="text-bold">Used Disk</span></td>
								<td><span id="usedDsk"></span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!--Server Info End-->
		</div>
	</div>
</div>
<?php
require '../includes/footer.php';
?>
</body>
</html>