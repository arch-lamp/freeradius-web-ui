<?php
if ( preg_match( "/css-js.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../../" );
	exit;
}
?>

<script type="text/javascript">
	var plugins = [
		'global',
		'core',
		//'locale',
		//'touch-handler',
		//'accordion',
		'button-set',
		//'date-format',
		//'calendar',
		//'datepicker',
		//'carousel',
		//'countdown',
		'dropdown',
		'input-control',
		//'live-tile',
		//'progressbar',
		//'rating',
		//'slider',
		//'tab-control',
		'table',
		//'times',
		'dialog',
		'notify',
		//'listview',
		//'treeview',
		//'fluentmenu',
		'hint',
		//'streamer',
		//'stepper',
		//'drag-tile',
		//'scroll',
		'pull',
		//'wizard',
		'panel',
		//'tile-transform',
		'initiator'
	];

	$.each(plugins, function(i, plugin) {
		$("<script/>").attr('src', '../js/metro/metro-' + plugin + '.js').appendTo($('head'));
	});

</script>

<script type="text/javascript">
	function loadDisplay(div) {
		$('#' + div).fadeIn(900, 0).html('<img src="../img/loading.gif" />');
	}
</script>

<script type="text/javascript" src="<?php echo $_SESSION['PRODUCT_URL'] ?>core/js/formDialogBox.js"></script>
<script type="text/javascript" src="<?php echo $_SESSION['PRODUCT_URL'] ?>core/js/dialogBoxActions.js"></script>
