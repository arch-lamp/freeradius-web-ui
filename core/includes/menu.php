<?php
if ( preg_match( '/menu.php/', $_SERVER['SCRIPT_NAME'] ) ) {
	header( 'Location: ../../' );
	exit;
}
?>

<header class="bg-dark">
	<div class="navigation-bar dark">
		<div class="navigation-bar-content container">
			<a href="javascript:void(0);" class="element">
				<span class="icon-grid-view"></span>
				<?php echo $_SESSION['SITE_NAME']; ?>
			</a>
			<span class="element-divider"></span>
			<a class="element1 pull-menu" href="#"></a>
			<ul class="element-menu navbar-mobile-collapse">
				<li>
					<a href="javascript:void(0);" onclick="redirect('./')">
						<span class="icon-dashboard"></span>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="element-divider"></li>
				<li>
					<a class="dropdown-toggle" href="javascript:void(0);">
						<span class="icon-user-2"></span>
						<span>Manage Users</span>
					</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<li>
							<a href="javascript:addNewUserDialog();">
								<span>New User</span>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="javascript:void(0);" onclick="javascript:redirect('./users.php')">
								<span>List Users</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="element-divider"></li>
				<li>
					<a class="dropdown-toggle" href="javascript:void(0);">
						<span class="icon-monitor-2"></span>
						<span>Manage NAS</span>
					</a>
					<ul class="dropdown-menu" data-role="dropdown">
						<li>
							<a href="javascript:void(0);" onclick="javascript:addNewNasDialog();">
								<span>New NAS</span>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="javascript:void(0);" onclick="javascript:redirect('./nas.php')">
								<span>List NAS</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>



			<div class="no-tablet-portrait">
				<div class="element place-right">
					<a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-cog"></span></a>
					<ul class="dropdown-menu place-right" data-role="dropdown">
						<li><a href="javascript:void(0);" onclick="changePasswordDialog();">Change Password</a></li>
						<li class="divider"></li>
						<li><a href="javascript:void(0);" onclick="javascript:redirect('./logout.php?action=true');">Sign Out</a></li>
					</ul>
				</div>
				<span class="element-divider place-right"></span>
			<span class="element place-right">
				<i class="icon-user-3"></i>
				<span><?php echo $_SESSION['FULLNAME']; ?></span>
			</span>
			</div>
		</div>
	</div>
</header>