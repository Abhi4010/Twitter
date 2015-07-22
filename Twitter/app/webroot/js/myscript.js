$(function()
{
	//register
	$('#name_error').hide();
	$('#user_id_error').hide();
	$('#password_error').hide();
	$('#mail_error').hide();
	$('#retype_password_error').hide();
	$('#tweet_error').hide();
	$('#tweet_error').html("tweet must be within 140 characters");


	//login
	$('#login_user_id_error').hide();
	$('#login_password_error').hide();

	$('#content').css('background-image', 'url("' + "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRo6RggG5apcoBlpxVxe-znSy5DlzCmHp70iXxFs-YYT_kw5ftejczqqQ" + '")'
		);
	function setHeight() {
	   				  	windowHeight = $(window).innerHeight();
					       $('#content').css('min-height', windowHeight);
					 };
	 setHeight();

	

	var error_name = false;
	var error_user_id  = false;
	var error_password  = false;
	var error_mail  = false;
	var error_retype_password = false;
	//login
	var error_login_user_id  = false;
	var error_login_password = false;
	var tweet_word_count =0;
	var max_tweet_size = 140;
	//tweet
	var error_tweet = false;


	$("#tweet").keyup(
		function()
	{
			console.log($('#tweet').val().length);

		if( $('#tweet').val().length  > max_tweet_size)
		{
			$("#tweet_error").show();
			error_tweet = true;
		}
		if( $('#tweet').val().length  <= max_tweet_size)
		{
			$("#tweet_error").hide();
			error_tweet = false;
		}

	});



	$("#name").focusout(
		function()
		{
			check_name();
		}
	);
	
	
	$("#user_id").focusout(
		function()
		{
			check_user_id();
		}
	);
	$("#password").focusout(
		function()
		{
			check_password();
		}
	);
	$("#mail").focusout(
		function()
		{
			check_mail();
		}
	);
	$("#retype_password").focusout(
		function()
		{
			check_retype_password();
		}
	);  

	//log in

	$("#login_password").focusout(
		function()
		{
			check_login_password();
		}
	);  
	$("#login_user_id").focusout(
		function()
		{
			check_login_user_id();
		}
	);  

	function check_tweet()
	{
			if( $('#tweet').val().length  > max_tweet_size)
		{
			$("#tweet_error").show();
			error_tweet = true;

		}
		if( $('#tweet').val().length  <= max_tweet_size)
		{
			$("#tweet_error").hide();
			error_tweet = false;
		}
		console.log(error_tweet);

	}

	function check_name()
	{
		
		var name_length = $("#name").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9_-]{4,20}$/i);
		if(!pattern.test($("#name").val()))
		{
			$("#name_error").html("Name must be between 4 to 20 characters and can contain a-z, A-z, 0-9, _,- ");
				$("#name_error").show();
				error_name = true;
			

		}
		else
		{
			$("#name_error").hide();
				error_name = false;

		}

	}

	function check_login_user_id()
	{
		
		var name_length = $("#login_user_id").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9_-]{4,20}$/i);
		if(!pattern.test($("#login_user_id").val()))
		{
			$("#login_user_id_error").html("User Id must be between 4 to 20 characters and can contain a-z, A-z, 0-9, _,- ");
				$("#login_user_id_error").show();
				error_login_user_id = true;
			

		}
		else
		{
			$("#login_user_id_error").hide();
				error_login_user_id = false;

		}


	}
	function check_user_id()
	{
		
		var name_length = $("#user_id").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9_-]{4,20}$/i);
		if(!pattern.test($("#user_id").val()))
		{
			$("#user_id_error").html("User name must be between 4 to 20 characters and can contain a-z, A-z, 0-9, _,- ");
				$("#user_id_error").show();
				error_user_id = true;
			

		}
		else
		{
			$("#user_id_error").hide();
				error_user_id = false;

		}


	}
	function check_password()
	{
		
		var name_length = $("#password").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9]{4,8}$/i);
		if(!pattern.test($("#password").val()))
		{
			$("#password_error").html("Password must be between 4 to 8 characters and can contain a-z, A-z, 0-9");
				$("#password_error").show();
				error_password = true;
			

		}
		else
		{
			$("#password_error").hide();
				error_password = false;

		}


	}

	//login
	function check_login_password()
	{
		
		var name_length = $("#login_password").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9]{4,8}$/i);
		if(!pattern.test($("#login_password").val()))
		{
			$("#login_password_error").html("Password must be between 4 to 8 characters and can contain a-z, A-z, 0-9");
				$("#login_password_error").show();
				error_login_password = true;
			

		}
		else
		{
			$("#login_password_error").hide();
				error_login_password = false;

		}


	}

	function check_mail()
	{
		
		var name_length = $("#mail").val().length;
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		if(!pattern.test($("#mail").val()))
		{
			$("#mail_error").html("Invalid email");
				$("#mail_error").show();
				error_password = true;
			

		}
		else
		{
			$("#mail_error").hide();
				error_mail = false;

		}


	}
	function check_retype_password()
	{


		var password = $("#password").val();
		var retype_password = $("#retype_password").val();
		
		if(password !=  retype_password) {
			$("#retype_password_error").html("Passwords don't match");
			$("#retype_password_error").show();
			error_retype_password = true;
		} 
		else {
				console.log(retype_password);
	

			$("#retype_password_error").hide();
			error_retype_password = false;
		}


	}

	$("#reg_form").submit(function() {

	 error_name = false;
	 error_user_id  = false;
	 error_password  = false;
	 error_mail  = false;
	 error_retype_password = false;


											
		check_user_id();
		check_password();
		check_retype_password();
		check_mail();
		check_name();

		console.log(error_name);

		
		if(error_name == false && error_user_id == false && error_password == false && error_retype_password == false && error_mail == false) {
			return true;
		} else {
			return false;	
		}

	});

	$("#login_form").submit(function() {

	 error_login_user_id  = false;
	 error_login_password = false;


											
		check_login_user_id();
		check_login_password();
		
		
		if(error_login_user_id == false && error_login_password == false ) {
			return true;
		} else {
			return false;	
		}

	});

	$('#tweet_form').submit(
		function()
		{
			error_tweet = false;
			check_tweet();
			if(error_tweet)
				return false;
			else
				return true;
		}
		);






});