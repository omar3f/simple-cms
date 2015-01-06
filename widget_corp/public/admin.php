<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>

<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>
<div id='main'>
	<div id='navigation'>
		&nbsp;
	</div>
	<div id='page'>
		<h2>Admin Menu</h2>
		<p>Welcome <?php echo $success_username; ?>.</p>
		<ul>
			<li><a href='manage_content.php'>Manage Website Content</a></li>
			<li><a href='manage_admins.php'>Manage Admin Users</a></li>
			<li><a href='Logout.php'>Logout</a></li>
		</ul>
	</div>
<?php include('../includes/layouts/footer.php'); ?>
