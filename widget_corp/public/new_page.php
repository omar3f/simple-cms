<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/validation_functions.php'); ?>
<?php open_session(); ?>
<?php require_once('../includes/connect.php'); ?>
<?php 
	check_authorization();
	$success_username = $_SESSION['success_username'];
?>



<!--checks if it's a subject, a page or neither-->
<?php check_subject_or_page(); ?>


 <!--Tracks the subject in the session -->
<?php 
	if (!isset($_POST['subject_name'])) {
		$subject_of_page = find_subject_by_id($_SESSION['subject_id']);
	} else {
		$subject_of_page =	find_subject_by_name($_POST['subject_name']);
	}
?>

<?php 
	$result_for_position = $connect->query("SELECT * FROM page WHERE subject_id = {$subject_of_page['id']};"); 
	$position_array = array();
	//Creating an array for position option 
	while ($row_for_position = $result_for_position->fetch(PDO::FETCH_ASSOC)) {
		$position_array[] = $row_for_position['position'];
	}
?>
<?php
	if (isset($_POST['submit'])) {
		$menu_name = $_POST['menu_name'];
		$position = $_POST['position'];
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
		if(empty($errors)) {
			$query_page_insert = "INSERT INTO page (subject_id, menu_name, position, visible, content) VALUES (?, ?, ?, ?, ?);";
			$stmt_page_insert = $connect->prepare($query_page_insert);
			$result_page_insert = $stmt_page_insert->execute(array($subject_of_page['id'], $menu_name , $position, $visible, $content));
			if($result_page_insert) {
				$message = "Page created";
			}else {
				$message = "Page creation failed";				
			}
		}
	}

?>
<?php $layout_context = "admin"; ?>
<?php include('../includes/layouts/header.php'); ?>
<div id='main'>
	<div id='navigation'>
		<!--produces a nav bar according to the user-produced database of subjects and pages-->
		<?php include '../includes/navigation.php'; ?>
	</div>
	<div id='page'>

		<h2 style="float: left;">Make a new page for subject: <?php echo $subject_of_page['menu_name']; ?></h2>&nbsp&nbsp<a href="change_subject.php" style="float: right; margin-top: 15px;">(Not for this subject?)</a>
		<form action="new_page.php" method="post" id="new_page" style="clear: both;">
			&nbsp Page name:<input type="text" name="menu_name" value=""><br><br>
			&nbsp Position:
			<select name="position">
				<?php 
				for ($i=1; $i <= count($position_array) + 1; $i++) { 
					echo "<option value=\"{$i}\">{$i}</option>";
				}
				?>
			</select><br><br>
			&nbspVisible:
				<input type = 'radio' name = 'visible' value = '0'>No
				&nbsp
				<input type = 'radio' name = 'visible' value = '1'>Yes<br><br>
			
			&nbspContent:<br>
			<textarea name="content" cols="50" rows="20" form="new_page"></textarea><br>
			<input type="submit" name="submit" value="Create Page">

		</form>	
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
<?php include('../includes/Layouts/footer.php'); ?>