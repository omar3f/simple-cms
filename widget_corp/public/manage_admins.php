<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>

<!--checks if it's a subject, a page or neither-->
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>

<div id='main'>
	<div id='navigation'>
		<a href="admin.php">Main Menu</a>
	</div>
	<div id='page'><br>
		<h1>Welcome <?php echo $success_username; ?></h1>
		<h2>Manage Admins</h2>
		<p class="admin_table1">Username</p>
		<p class="admin_table2">Actions</p>
		<div class="admin-wrapper">
		<!--<div class="admins_names">-->
			<?php
				$the_admins = get_all_admins();
				print_admins($the_admins, "<br>");
			?>
		<!--</div>	-->
		</div>
		<a href="new_admin.php">+Add new admin</a><br>
		<?php 
			if(isset($_SESSION['delete_admin'])) {
				$deleted = $_SESSION['delete_admin'];
				if($deleted) {
					echo "Deleted Succesfuly";
					$_SESSION['delete_admin'] = False;
				}
			}
			if(isset($_SESSION['inserted'])) {
				$inserted = $_SESSION['inserted'];
				if($inserted) {
					echo "Added Succesfuly";
					$_SESSION['inserted'] = False;
				}
			}
		?>


	</div>
</div>
<?php include('../includes/layouts/footer.php'); ?>
