
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
		<a href="new_subject.php">+Add a new subject</a>
	</div>
	<div id='page'>
	<?php if(!empty($_SESSION['message'])) { message(); } ?>
	<?php 
		//echoes the menu name of the subject if the query for $subject_by_id is set,
		if ($subject_by_id) { ?>
			
			<h2>Manage Subject</h2>
			&nbsp&nbsp Menu Name: <?php echo $subject_by_id['menu_name']; ?><br>
			&nbsp&nbsp&nbsp<a href="edit_subject.php?subject=<?php echo $selected_subject_id; ?>">Edit Subject</a>

			<?php 
		//.. or the menu name of the page if the query for $subject_by_id is set,	
		} elseif ($page_by_id) {	?>

			<h2>Manage Page</h2>
			Page Name: <?php echo $page_by_id['menu_name']; ?><br>
			<p id="page_content"><?php echo $page_by_id['content']; ?></p>
			<a href="edit_page.php?page=<?php  echo $page_by_id['id']?>">Edit Page</a>
			<?php 
		} else {
		//..or prompts the user to choose a page or subject if neither is selected.
			echo "Please select a subject or page";
		}
		
	?>
	<hr>
	<?php echo show_pages_for_subject($selected_subject_id, False); ?>

	</div>
</div>
<?php 
	if(isset($_GET['page'])) {
		$_SESSION['subject_id'] = find_subject_of_page($selected_page_id)['subject_id'];
		
	} elseif (isset($_GET['subject'])) {
		$_SESSION['subject_id'] = $_GET['subject'];
	}
?>
<?php include('../includes/layouts/footer.php'); ?>
