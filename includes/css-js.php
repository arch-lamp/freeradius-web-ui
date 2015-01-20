<?php
if ( preg_match( "/css-js.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../" );
	exit;
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link href="<?php echo $_SESSION['PRODUCT_URL'] ?>css/metro-bootstrap.css" rel="stylesheet">
<link href="<?php echo $_SESSION['PRODUCT_URL'] ?>css/iconFont.css" rel="stylesheet">
<link href="<?php echo $_SESSION['PRODUCT_URL'] ?>css/metro-bootstrap-responsive.css" rel="stylesheet">

<script src="<?php echo $_SESSION['PRODUCT_URL'] ?>js/jquery/jquery.min.js"></script>
<script src="<?php echo $_SESSION['PRODUCT_URL'] ?>js/jquery/jquery.widget.min.js"></script>
<script src="<?php echo $_SESSION['PRODUCT_URL'] ?>js/metro.min.js"></script>
<script src="<?php echo $_SESSION['PRODUCT_URL'] ?>js/global.js"></script>
<script src="<?php echo $_SESSION['PRODUCT_URL'] ?>js/encodeDecode.js"></script>