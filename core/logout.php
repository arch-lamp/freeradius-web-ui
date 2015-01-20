<?php
require_once 'includes/chkLogin.php';

if (isset($_GET['action']) && $_GET['action'] == 'true') {
	if ($Session->sessionClose()) {
		header("Location: $_SESSION[PRODUCT_URL]?logout=true");
		exit;
	}
}

header('Location: ./');
exit;