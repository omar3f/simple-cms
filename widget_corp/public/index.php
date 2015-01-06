
<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	if (isset($_SESSION['success_username'])) {
		redirect_to('admin.php');
	}
?>

<!--checks if it's a subject, a page or neither-->
<?php check_subject_or_page(True); ?>

<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/public_navigation.php'; ?>
	</div>
	<div id='page'>
	<?php 
		//echoes the menu name of the subject if the query for $subject_by_id is set,
		if ($page_by_id) {	?>
			<h2><?php echo nl2br(htmlentities($page_by_id['menu_name'])); ?></h2>
			<p id="page_content"><?php echo nl2br(htmlentities($page_by_id['content'])); ?></p>
			<?php 
		} else {
		//..or prompts the user to choose a page or subject if neither is selected.
			echo "Welcome<br>Are you an admin? ";
			echo "<a href=\"login.php\">Log in</a>";
		}
		
	?>

	</div>
</div>
<?php include('../includes/layouts/footer.php'); ?>
