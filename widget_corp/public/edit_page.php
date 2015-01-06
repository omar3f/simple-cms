<?php require_once('../includes/functions.php'); ?>
<?php open_session(); ?>
<?php require_once('../includes/validation_functions.php'); ?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>


<?php 
	if (!isset($_GET['page'])) {
		redirect_to("manage_content.php");
	}
?>
<!--checks if it's a subject, a page or neither-->
<?php check_subject_or_page(); ?>
<!--puts all subjects' names in an array-->
<?php ?>
<?php 
	$subjects_result = find_all_subjects();
	$subjects_name_array = array();

    while($subjects_rows = $subjects_result->fetch(PDO::FETCH_ASSOC)) {
 		$subjects_name_array[] = $subjects_rows['menu_name'];
 	}
?>
<?php 
if (isset($_SESSION['changed_subject'])) {
	$subject_of_page = $_SESSION['changed_subject'];
} else {
	$subject_of_page = find_subject_of_page($page_by_id['id'])['subject_id'];
}
?>
<?php 
	$result_for_position = $connect->query("SELECT * FROM page WHERE subject_id = {$subject_of_page};"); 
	$position_array = array();
	//Creating an array for position option 
	while ($row_for_position = $result_for_position->fetch(PDO::FETCH_ASSOC)) {
		$position_array[] = $row_for_position['position'];
	}
?>

<?php

if(isset($_POST['submit'])) {
	
	$menu_name = $_POST['menu_name'];
	$position = $_POST['position'];
	$subject_name = $_POST['subject_name'];
	if (isset($_POST['visible'])) {
		$visible = $_POST['visible'];
	}
	$content = $_POST['content'];

	$required_fields = array("menu_name", "position", "visible", "content");
	if (!isset($_POST['visible'])) {
		unset($required_fields[2]);
		$errors['visible'] = "Choose visibility"; 
	}

	field_present($required_fields);

	if (empty($errors)) {

		$query_stmt = "UPDATE page 
					   SET 
					   subject_id = ?,
					   menu_name = ?,
					   position = ?,
					   visible = ?,
					   content = ?
					   WHERE id = ?
					   LIMIT 1;";
		$stmt = $connect->prepare($query_stmt);
		$result_stmt = $stmt->execute(array((int) find_subject_by_name($subject_name)['id'], $menu_name, $position, $visible, $content, $page_by_id['id']));

		if($result_stmt) {
			$message = "Page edited.";
			redirect_to("edit_page.php?page={$page_by_id['id']}");
		} else {
			$message = "Page editing failed.";
		}

	} 

}
?>

<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
		<a href="new_subject.php">+Add a new subject</a>
	</div>
	<div id='page'>
	
		<h2 style="float: left;">Editing page <?php echo $page_by_id['menu_name']; ?> for subject: <?php echo find_subject_by_id($subject_of_page)['menu_name']; ?></h2>
		

		<form method="post" id="edit_page" action="edit_page.php?page=<?php echo $page_by_id['id']?>">
			&nbsp Page name:<input type="text" name="menu_name" value="<?php echo $page_by_id['menu_name']; ?>"><br><br>
			&nbspInsert into subject:
			
			<select name="subject_name">
				<?php for ($i = 0; $i < count($subjects_name_array); $i++) { ?> 
					<option value="<?php echo $subjects_name_array[$i]; ?>" <?php if($subjects_name_array[$i] == find_subject_by_id($subject_of_page)['menu_name']) { echo "selected"; } ?>><?php echo $subjects_name_array[$i]; ?>
					</option>
				<?php } ?>
			</select><br><br>
			&nbsp Position:
			<select name="position">
				<?php 
				for ($i=1; $i <= count($position_array); $i++) { 
					echo "<option value=\"{$i}\"";
					if ($page_by_id['position'] == $i) {
						echo "selected";
					}
					echo ">{$i}</option>";
				}
				?>
			</select><br><br>
			&nbspVisible:
				<input type = 'radio' name = 'visible' value = '0' <?php if ($page_by_id['visible'] == 0) { echo "checked";}?>>No
				&nbsp
				<input type = 'radio' name = 'visible' value = '1' <?php if ($page_by_id['visible'] == 1) { echo "checked";}?>>Yes<br><br>
			
			&nbspContent:<br>
			<textarea name="content" cols="50" rows="18" form="edit_page"><?php echo $page_by_id['content']; ?></textarea><br>
			<input type="submit" name="submit" value="Edit Page">

		</form>
		<a href="manage_content.php">Cancel</a>
		<a href="delete_page.php?page=<?php echo $selected_page_id?>" onclick="return confirm('Are you sure?');">Delete</a>

	</div>
	<?php
		if (!empty($errors)) {
			echo "<div class=\"errors\"><br>&nbsp&nbspYou have the following errors:<ul>";
			foreach ($errors as $error) {
				echo "<li>{$error}</li>";
			}
			echo "</ul></div>";
		}
	?>
	<?php 
	if (isset($message)) {
		echo "<div class=\"message\" id=\"page_message\">{$message}</div>";
	}
	?>

</div>

<?php include('../includes/layouts/footer.php'); ?>
