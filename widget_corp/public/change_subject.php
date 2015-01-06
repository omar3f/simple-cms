<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>


<!--checks if it's a subject, a page or neither-->
<?php check_subject_or_page(); ?>
<!--puts all subjects' names in an array-->
<?php 
	$subjects_result = find_all_subjects(False);
	$subjects_name_array = array();
    while($subjects_rows = $subjects_result->fetch(PDO::FETCH_ASSOC)) {
 		$subjects_name_array[] = $subjects_rows['menu_name'];
 	}
 ?>

<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
	</div>
	<div id='page'>
		&nbsp To which subject?:
		<form action="new_page.php" method="post">
			<select name="subject_name">
				
				<?php for ($i = 0; $i < count($subjects_name_array); $i++) { ?> 
					<option value="<?php echo $subjects_name_array[$i]; ?>"><?php echo $subjects_name_array[$i]; ?>
					</option>
				<?php } ?>
			</select>
			<input name="submit_button_name" type="submit" value="Confirm">
		</form>

	</div>

</div>
<?php include('../includes/layouts/footer.php'); ?>
