<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/validation_functions.php'); ?>

<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>


<?php
$updated = False;
$id =  $_GET['admin'];


if(!isset($_GET['admin']) || !search_for_admin($id)) {
	redirect_to('manage_admins.php');
}


if (isset($_POST['edit_submit'])) {
	set_edit_admins_vars();
	edit_admin(); 	
}
$last_update = get_last_update();
$last_name = $last_update['username'];


?>

<div id='main'>
	<div id='navigation'>
	</div>
	<div id='page'><br>
	<form action="edit_admin.php?admin=<?php echo $id; ?>" method="post">
		Edit Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<input type="text" name="edit_admin_name" value=<?php echo $last_name; ?>><br><br>
		Edit Password: 
		<input type="password" name="edit_password" value=""><br><br>
		<input type="submit" name="edit_submit" value="Edit Admin"><br><br>
	</form>
	<?php 
		if ($updated) {
			echo "<div class=\"error\">Updated Successfully</div>";
		}
	?>
	</div>
</div>

<?php include('../includes/layouts/footer.php'); ?>
