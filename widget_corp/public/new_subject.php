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

<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
	</div>
	<div id='page'>
	<?php if(!empty(message())) { echo message(); } ?>
		<h2>Create Subject</h2>

		<form action = 'create_subject.php' method = 'post'>
			<p> Subject Name:
				<input type = 'text' name = 'menu_name' value = ''>
			</p>
			<p>Position:
				<select name = 'position'>
					<?php
						$subject_set = find_all_subjects();
						$subject_count = count($subject_set->fetchAll());
						for ($count = 1; $count <= $subject_count + 1; $count++) {
							echo "<option value = \"{$count}\">{$count}</option>";
						}
					?>
					
				</select>
			</p>
			<p>Visible:
				<input type = 'radio' name = 'visible' value = '0'>No
				&nbsp
				<input type = 'radio' name = 'visible' value = '1'>Yes

			</p>
			<input type = 'submit' name = 'submit' value = 'Create Subject'>
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>

	</div>
			<?php
		if (!empty($_SESSION['errors'])) {
			echo "<div class=\"errors\">You have the following errors:<ul>";
			foreach ($_SESSION['errors'] as $error) {
				echo "<li>{$error}</li>";
			}
			echo "</ul></div>";
			$_SESSION['errors'] = null;
		}

	?>


</div>
<?php include('../includes/layouts/footer.php'); ?>
