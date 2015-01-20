<?php
if ( preg_match( "/mailSettings.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../../" );
	exit;
}
?>

<?php
$Mail = new PHPMailer();
$Mail->isSMTP();
$Mail->SMTPAuth   = true;
$Mail->Host       = $_SESSION['MAIL_HOSTNAME'];
$Mail->SMTPSecure = $_SESSION['MAIL_SECURE'];
$Mail->Port       = $_SESSION['MAIL_PORT'];
$Mail->Username   = $_SESSION['MAIL_USERNAME'];
$Mail->Password   = $_SESSION['MAIL_PASSWORD'];
$Mail->From       = $_SESSION['MAIL_USERNAME'];
$Mail->FromName   = $_SESSION['SITE_NAME'];;
$Mail->addReplyTo($Mail->From, $Mail->FromName);
$Mail->isHTML(true);
$Mail->XMailer = $_SESSION['SITE_NAME'];