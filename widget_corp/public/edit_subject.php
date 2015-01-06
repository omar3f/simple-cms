
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


<!--checks if it's a subject, a page or neither-->
<?php check_subject_or_page(); ?>
<?php
if (!isset($_GET['subject'])) {
	redirect_to("manage_content.php");
}
if (isset($_POST['submit'])) {

	//Checking errors
	$required_fields = array("menu_name", "position", "visible");
	field_present($required_fields);
	$_SESSION['errors'] = $errors;
	if (empty($errors)) {
		$id = $subject_by_id['id'];
		$menu_name = $_POST['menu_name'];
		$position = $_POST['position'];
		$visible = $_POST['visible'];

		$query = "UPDATE subject
				  SET 
					  menu_name  = ?,
					  position = ?,
					  visible = ?
				  WHERE id = ?
				  LIMIT 1;
				  ";
		$stmt = $connect->prepare($query);
		$result = $stmt->execute(array($menu_name, $position, $visible, $id));
	
		if ($result) {
			$message = "Subject edited";
			redirect_to("edit_subject.php?subject={$selected_subject_id}");
		}else {
			$message = "Subject edit failed";
		}
	}



}else {
	//This is probably a GET request
}
?>
<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
	</div>
	<div id='page'>
	<?php
		if (isset($message)) {
			echo "<div class=\"message\">{$message}</div>";
		}
	?>
		<h2>Edit Subject: <?php echo $subject_by_id['menu_name']?></h2>
		<form action = 'edit_subject.php?subject=<?php echo $subject_by_id['id']; ?>' method = 'post'>
			<p> Edit Subject:
				<input type = 'text' name = 'menu_name' value = "<?php echo $subject_by_id['menu_name']; ?>">
			</p>
			<p>Position:
				<select name = 'position'>
					<?php
						$subject_set = find_all_subjects();
						$subject_count = count($subject_set->fetchAll());
						for ($count = 1; $count <= $subject_count; $count++) {
							echo "<option value = \"{$count}\"";
							if ((int) $subject_by_id['position'] === $count) {
								echo " selected";
							}
							echo ">{$count}</option>";
						}
					?>
					
				</select>
			</p>
			<p>Visible:
				<input type = 'radio' name = 'visible' value = '0' <?php if ((int) $subject_by_id['visible'] === 0) { echo "checked"; } ?>>No
				&nbsp
				<input type = 'radio' name = 'visible' value = '1' <?php if ((int) $subject_by_id['visible'] === 1) { echo "checked"; } ?>>Yes

			</p>
			<input type = 'submit' name = 'submit' value = 'Edit Subject'>
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
		<a href="delete_subject.php?subject=<?php echo $selected_subject_id?>" onclick="return confirm('Are you sure?');">Delete</a>

	</div>
</div>
<?php include('../includes/layouts/footer.php'); ?>
