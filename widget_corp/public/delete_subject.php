<?php require_once('../includes/connect.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>

<?php check_subject_or_page(); ?>
<?php
	if(isset($selected_subject_id)) {
		$pages = find_pages_for_subject($selected_subject_id);
		$pages_array = array();
		while ($row_pages = $pages->fetch(PDO::FETCH_ASSOC)) {
			$pages_array[] = $row_pages['id'];
		}
		if(count($pages_array) > 0) {
			$_SESSION['message'] = "Can't delete subject with pages inside"; 
			redirect_to("manage_content.php");
		}
		$query1 = "SELECT * FROM subject WHERE id = ? LIMIT 1";
		$stmt = $connect->prepare($query1);
	  	$result = $stmt->execute(array($selected_subject_id));
		if ($result) {
			$query2 = "DELETE FROM subject WHERE id = ? LIMIT 1";
			$stmt2 = $connect->prepare($query2);
			$result2 = $stmt2->execute(array($selected_subject_id));
			if ($result2) {
				$message = "<div class=\"message\">Subject deleted!</div>";
				
			}else {
				$message = "<div class=\"message\">Subject deletion failed!</div>";
				
			}
		}
	}else {
		redirect_to("manage_content.php");
	}
?>

<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
		<a href="new_subject.php">+Add a new subject</a>
	</div>
	<div id='page'>
		<?php echo $message; ?>
		<a href="manage_content.php">Back</a>
	</div>
</div>
<?php include('../includes/layouts/footer.php'); ?>
