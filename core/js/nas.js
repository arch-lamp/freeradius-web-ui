/**
 * Created by peeyush.budhia on 28-12-2014.
 */

function notification(heading, message) {
	$.Notify({
				 caption: heading,
				 content: message,
				 timeout: 5000,
				 width: '10',
				 style: {
					 background: '#333333', color: '#ffffff'
				 }
			 });
}

function loadNASList(pageNum) {
	loadDisplay('loadNAS');
	$.ajax({
			   type: 'POST',
			   cache: false,
			   async: true,
			   url: 'loadNAS.php',
			   data: 'page=' + pageNum,
			   success: function(response) {
				   if ($.trim(response) == 'NotFound') {
					   $('#loadNAS').addClass('text-danger').html('No records found');
				   }

				   if ($.trim(response) != 'NotFound') {
					   $('#loadNAS').removeClass('text-danger').html(response);
					   $("a[id^='info']").hint();
					   $("a[id^='delete']").hint();
					   $("a[id^='edit']").hint();
				   }
			   }
		   });
}

function loadNextNAS() {
	loadDisplay('loadNAS');
	var currentPage = parseInt($('#currentPage').val());
	var maxPages = parseInt($('#totalPages').val());

	if (maxPages > currentPage) {
		var newPage = ++currentPage;
		$('#previous').show();
	} else {
		var newPage = currentPage;
	}

	if (currentPage == maxPages) {
		$('#next').hide();
	}

	$('#currentPage').val(newPage);
	$.ajax({
			   type: 'POST',
			   cache: false,
			   url: 'loadNAS.php',
			   async: true,
			   data: 'page=' + newPage,
			   success: function(response) {
				   if ($.trim(response) == 'NotFound') {
					   $('#loadNAS').addClass('text-danger').html('No records found');
				   } else {
					   $('#loadNAS').html(response);
					   $("a[id^='info']").hint();
					   $("a[id^='delete']").hint();
					   $("a[id^='edit']").hint();
				   }
			   }
		   });
}

function loadPreviousNAS() {
	loadDisplay('loadNAS');
	var currentPage = parseInt($('#currentPage').val());
	var maxPages = parseInt($('#totalPages').val());
	if (currentPage > 1) {
		var newPage = --currentPage;
	} else {
		var newPage = currentPage;
	}

	$('#next').show();
	$('#currentPage').val(newPage);
	$.ajax({
			   type: 'POST',
			   cache: false,
			   url: 'loadNAS.php',
			   async: true,
			   data: 'page=' + newPage,
			   success: function(response) {
				   if (currentPage == 1) {
					   $('#previous').hide();
				   }
				   $('#loadNAS').html(response);
				   $("a[id^='info']").hint();
				   $("a[id^='delete']").hint();
				   $("a[id^='edit']").hint();
			   }
		   });
}

function viewNASInfo(nasId) {
	if (nasId != '') {
		$.ajax({
				   type: 'POST',
				   cache: false,
				   url: 'loadNASInfo.php',
				   async: true,
				   data: 'id=' + nasId,
				   success: function(response) {
					   if ($.trim(response) != 'ErrorNASCount') {
						   var info = jQuery.parseJSON(response);
						   var content =

							   '<div class="grid">' +
							   '<div class="row">' +
							   '<table class="table">' +
							   '<tr>' +
							   '<td class="span2"><span style="font-weight: bold;">Short Name</span></td>' +
							   '<td>' + info.shortname + '</td>' +

							   '</tr><tr>' +

							   '<td><span style="font-weight: bold;">Type</span></td>' +
							   '<td>' + info.type + '</td></tr>' +

							   '<tr></tr><td><span style="font-weight: bold;">Port</span></td>' +
							   '<td>' + info.ports + '</td></tr>' +

							   '<tr></tr><td><span style="font-weight: bold;">Server</span></td>' +
							   '<td>' + info.server + '</td></tr>' +

							   '<tr></tr><td><span style="font-weight: bold;">Community</span></td>' +
							   '<td>' + info.community + '</td></tr>' +

							   '<tr></tr><td><span style="font-weight: bold;">Description</span></td>' +
							   '<td>' + info.description + '</td></tr>' +
							   '</table>' +
							   '</div>' +
							   '</div>';

						   $.Dialog({
										overlay: true,
										title: '<span class="text-bold">NAS IP/Host: ' + info.nasname + '</span>',
										shadow: true,
										width: 500,
										flat: true,
										draggable: true,
										padding: 20,
										content: content
									});
					   }

				   }
			   });
	}
}

function deleteNASAccount(id, nasname) {
	loadDisplay('action-' + id);
	var currentPage = parseInt($('#currentPage').val());
	var data = 'nasname=' + nasname + '&id=' + id;
	var heading = '';
	var message = '';

	$.ajax({
			   type: 'POST',
			   cache: false,
			   data: data,
			   url: 'deleteNASAccount.php',
			   async: true,
			   success: function(response) {
				   if ($.trim(response) == 'Deleted') {
					   heading = 'Success!';
					   message = 'NAS Client ' + nasname + ' is permanently deleted from freeRADIUS Server.';
				   }

				   if ($.trim(response) == 'Error') {
					   heading = 'Error!';
					   message = 'Something went wrong while deleting NAS Client ' + nasname + ' from freeRadius Server. Please try again later.';
				   }

				   notification(heading, message);

				   setTimeout(function() {
					   $('#loadNAS').fadeOut('slow').load(loadNASList(currentPage)).fadeIn('slow');
				   }, 500);

			   }
		   });

}