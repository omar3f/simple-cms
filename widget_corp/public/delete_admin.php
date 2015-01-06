<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>

<?php 
	$id = $_GET['admin'];
	if(!isset($_GET['admin']) || !search_for_admin($id)) {
		redirect_to('manage_admins.php');
	}


	delete_admin(); 
	redirect_to("manage_admins.php");
?>

<div id='main'>
	<div id='navigation'>
	</div>
	<div id='page'>
		
	</div>
</div>

<?php include('../includes/layouts/footer.php'); ?>
