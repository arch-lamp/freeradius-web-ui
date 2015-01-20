<?php
if ( preg_match( "/chkApplication.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( 'Location: ./' );
	exit;
}
?>

<?php

if ( GetProductURL() != getSetting( 'product_url' ) ) {
	?>

	<div class="container">
		<div class="grid">
			<div class="row">
				<div class="panel">
					<div class="panel-header text-clear bg-darkRed">
						Domain Mismatch
					</div>

					<div class="panel-content">
						Your domain does not match with the domain name which was traced when you installed the application.
						<br/><br/>
						This issue mostly occurs if: <br/>
						<ul>
							<li>You had migrated the application and it's database from one server to another.</li>
							<li>Wrong database configuration in config.php file.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	require 'footer.php';
	exit;
}