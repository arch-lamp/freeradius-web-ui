/**
 * Created by peeyush.budhia on 31-12-2014.
 */

function dashboard() {

	loadDisplay('totalUsers');
	loadDisplay('activeUsers');
	loadDisplay('bannedUsers');
	loadDisplay('date');
	loadDisplay('hostname');
	loadDisplay('uptime');
	loadDisplay('totalMem');
	loadDisplay('freeMem');
	loadDisplay('usedMem');
	loadDisplay('totalDsk');
	loadDisplay('freeDsk');
	loadDisplay('usedDsk');


	$.ajax({
			   type: 'POST',
			   cache: false,
			   url: 'dashboard.php',
			   async: true,
			   data: 'action=true',
			   success: function(response) {
				   var users = jQuery.parseJSON(response);
				   $('#totalUsers').html(users.totalUsers);
				   $('#activeUsers').html(users.activeUsers);
				   $('#bannedUsers').html(users.bannedUsers);

				   $('#date').html(users.date);
				   $('#hostname').html(users.hostname);
				   $('#uptime').html(users.uptime);

				   $('#totalMem').html(users.totalMem + ' MB');
				   $('#freeMem').html(users.freeMem + ' MB');
				   $('#usedMem').html(users.usedMem + ' MB');

				   $('#totalDsk').html(users.totalDisk + ' GB');
				   $('#freeDsk').html(users.freeDisk + ' GB');
				   $('#usedDsk').html(users.usedDisk + ' GB');
			   }
		   });
}
