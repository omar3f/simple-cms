
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/validation_functions.php'); ?>

<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>

<!--checks if it's a subject, a page or neither-->
<?php //check_subject_or_page(); ?>

<?php 
	if (isset($_POST['submit'])) {
		set_admins_vars(); 
		field_present(["admin_name", "password"]);
	}	
?>
<div id='main'>
	<div id='navigation'>
	</div>
	<div id='page'><br>
	<?php 
		if (empty($errors)) { 
			if (isset($_POST['submit'])) {
				insert_admin();
				redirect_to("manage_admins.php");	
			}
		} else { ?>
		<div class="new_admin_errors">
			You have the following errors:
			<ul> 
			<?php echo list_iterate($errors); ?>
			</ul>
		</div>
	<?php } ?>
	<form action="new_admin.php" method="post">
		Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<input type="text" name="admin_name"><br><br>
		Password: 
		<input type="password" name="password"><br><br>
		<input type="submit" name="submit" value="Create Admin"><br><br>
	</form>
	</div>
</div>
<?php include('../includes/layouts/footer.php'); ?>
