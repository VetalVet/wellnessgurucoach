<?php
	  /*
        Template Name: New password
    */
	 session_start();
	 ob_start(); 
    get_header();

	 require_once('functions/connect.php');

	 if (!$mysql) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$data = $_GET;

	if(isset($_SESSION['user'])){
		ob_end_clean();
		header('Location: /');
		exit();
	}

	if($data['key'] == NULL)header('Location: /');

	$query = "SELECT * FROM user WHERE change_key = '{$data['key']}'";

	if(!$query)header('Location: /');

	
	if(isset($data['сhange'])){
		$result = mysqli_query($mysql, $query);
	
		if (mysqli_num_rows($result) > 0) {
			
			$user = mysqli_fetch_assoc($result);
			$user['password'] = md5($data['password']."mentorpass");
			$user['change_key'] = NULL;

			$update_query = "UPDATE user SET password = '{$user['password']}', change_key = '{$user['change_key']}' WHERE id = '{$user['id']}'";
       	mysqli_query($mysql, $update_query);

			header('Location: http://localhost/login/');
		}
	}
	

?>

<section class="new-password">
	<div class="container">
		<div class="new-password__form">

			<form action="/new-password/" method="get" class="new-password__sign-form">
				<h2 class="new-password__title">
					New password
				</h2>
				<input type="hidden" name="key" value="<?php echo $data['key'];?>">
				<div class="new-password__form-group">
					<input class="new-password__form-control" type="password" name="password" placeholder="Password">
				</div>
				<!-- <div class="new-password__form-group">
					<input class="new-password__form-control" type="password" name="password_2" placeholder="Repeat the password">
				</div> -->
				<button type="submit" name="сhange">Change password</button>
			</form>

		</div>
	</div>
</section>

<?php
	get_footer();
?>