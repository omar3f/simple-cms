<?php require_once '../includes/validation_functions.php'?>
<?php require_once '../includes/functions.php'; ?>
<?php open_session(); ?>
<?php require_once '../includes/connect.php'; ?>
<?php $layout_context = "admin"; ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>

<?php
if (isset($_POST['submit'])) {
	$menu_name = $_POST['menu_name'];
	$position = $_POST['position'];
	$visible = $_POST['visible'];

	$required_fields = array("menu_name", "position", "visible");
	field_present($required_fields);
	$_SESSION['errors'] = $errors;
	if (!empty($errors)) {
			redirect_to("new_subject.php");

	}else {
			$stmt = $connect->prepare('INSERT INTO subject
						   (menu_name, position, visible)
						   VALUES (?, ?, ?);
						');
			$result = $stmt->execute(array($menu_name, $position, $visible));
		

		if ($result) {
			$_SESSION['message'] = "Subject Created";
			redirect_to("manage_content.php");
		}else {
			$$_SESSION['message'] = "Subject creation failed";
			redirect_to("new_subject.php");
		}

	}
		

}else {
	//This is probably a GET request
	redirect_to("new_subject.php");
}




//closing connection
if (isset($connect)) { $connect = null; }
?>