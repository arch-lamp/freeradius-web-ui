/**
 * Created by peeyush.budhia on 25-12-2014.
 */


function chkLogin() {
	$('#loading').show().html('<img src="img/loading.gif" alt="Loading..."/>');

	var usr = Base64Encode($('#usr').val());
	var pwd = Base64Encode($('#pwd').val());


	if (usr.length == 0 || pwd.length == 0) {
		$('#loading').addClass('text-danger').html('Username and password must be filled.');
	} else {
		var data = 'usr='+usr+'&pwd='+pwd;
		var info  ='';
		var addClass = '';
		$.ajax({
				   type: 'POST',
				   cache: false,
				   async: true,
				   url: 'chkLogin.php',
				   data: data,
				   success: function(response) {
					   if ($.trim(response) == 'Empty') {
						   info = 'Username and password must be filled.';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Invalid') {
						   info = 'Invalid username or password';
						   addClass = 'text-danger';
					   }

					   if ($.trim(response) == 'Login') {
						   redirect('./core/');
					   }

					   if ($.trim(response) != 'Login') {
						   $('#loading').addClass(addClass).html(info);
					   }

				   }
			   });
	}
}