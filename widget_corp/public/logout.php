<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>

<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php 
	check_authorization();
	$_SESSION['success_username'] = null;
?>
<div id='main'>
	<div id='navigation'>
		&nbsp;
	</div>
	<div id='page'>
		<p>You are currently logged out</p>
		<a href="login.php">login?</a>
	</div>
<?php include('../includes/layouts/footer.php'); ?>
