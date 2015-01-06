<?php

//redirecting to another page
function redirect_to($new_location) {
	header("Location:{$new_location}");
	exit;
}

function is_session_active() {
	if (isset($_SESSION['is_open'])) {
		return True;
	}else {
		return False;
	}
	

}
function open_session() {
	if (!is_session_active()) {
		session_start();
		$_SESSION['is_open']= True;	
	}
}
//displaying a message by starting a new session
function message() {
	open_session();
	if (isset($_SESSION['message'])) {
		echo "<div class='message'>{$_SESSION['message']}</div>";
		$_SESSION['message'] = null;
	}
}

//if a query isn't correct it displays an error message
function confirm_query ($result_set) {
	if (!$result_set) {
		die('Query execution failed');
	}
}

//queries for all subjects
function find_all_subjects($public = True) {
	//query for subjects
	global $connect;
	
	$query = "SELECT * FROM subject ";
	if ($public == True) {
		$query .= "WHERE visible=1 ";
	}
	$query .= "ORDER BY position ASC";
	$result = $connect->query($query);
	confirm_query($result);
	return $result;
}

//queries for all subjects with a specified position
function find_subjects_with_position($position) {
	//query for subjects
	global $connect;
	
	$query = "SELECT * FROM subject WHERE position = {$position};";
	$result = $connect->query($query);
	confirm_query($result);
	return $result;
}

//queries for all pages per each subject(when placed inside the subject loop)
function find_pages_for_subject($subject_id, $public = True) {
	//query for pages
	global $connect;

	$query2 = "SELECT * FROM page WHERE "; 
	if ($public == True) {
		$query2 .= "visible = 1 AND ";
	}
	$query2 .= "subject_id = {$subject_id}";
	$result2 = $connect->query($query2);
	confirm_query($result2);

	return $result2;
}

function find_subject_of_page($page_id) {
	
	global $connect;
	$query = "SELECT subject_id FROM page WHERE id = {$page_id};";
	$result = $connect->query($query);
	confirm_query($result);
	if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		return $row;
	} else {
		return null;
	}		
	

}


//takes the $subject_id as an argument and queries for the subject with id = $subject_id
function find_subject_by_id($subject_id) {
	global $connect;

	$query = "SELECT * FROM subject WHERE id = {$subject_id};";
	$result3 = $connect->query($query);
	confirm_query($result3);
	
	

	if ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
		return $row3;
	} else {
		return null;
	}
}


function find_subject_by_name($subject_name){
	global $connect;
	$subject_name_esc1 = str_replace("'", "''", $subject_name);
	$subject_name_esc = str_replace("\"", "\\\"", $subject_name_esc1);
//	$subject_name_esc = addslashes($subject_name_esc);
	$query_name = "SELECT * FROM subject WHERE menu_name = '{$subject_name_esc}' ;";
	$result3_name = $connect->query($query_name); 
	//$stmt_name = $connect->prepare($query_name);
	//$result3_name = $stmt_name->execute(array($subject_name));
	confirm_query($result3_name);
	
	

	if ($row3_name = $result3_name->fetch(PDO::FETCH_ASSOC)) {
		return $row3_name;
	} else {
		return null;
	}	
}

//takes the $page_id as an argument and queries for the subject with id = $page_id
function find_page_by_id($page_id, $public = True) {
	global $connect;
	$query = "SELECT * FROM page WHERE id = {$page_id}";
	if ($public) {
		$query .= " AND visible = 1;";
	}
	$result3 = $connect->query($query);
	confirm_query($result3);
	
	

	if ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
		return $row3;
	} else {
		return null;
	}
}

//Chooses a default first page if a subject is selected
function find_default_page_for_subject($subject_id) {
	$page_set = find_pages_for_subject($subject_id);
	if ($first_page = $page_set->fetch(PDO::FETCH_ASSOC)) {
		return $first_page;
	} else {
		return null;
	}
}


//checks if the page if the link is subject or page and queries for the page or subject with the current id
function check_subject_or_page($public = False) {
	global $subject_by_id;
	global $page_by_id;
	global $selected_subject_id;
	global $selected_page_id;

	if (isset($_GET['subject'])) {
		$selected_subject_id = $_GET['subject'];
		$subject_by_id = find_subject_by_id($selected_subject_id); 
		if ($public) {
			$page_by_id = find_default_page_for_subject($selected_subject_id); //find a default page
		} else {
			$page_by_id = null;
		}
		$selected_page_id = null; 
	} elseif (isset($_GET['page'])) {
		$selected_page_id = $_GET['page'];
		$page_by_id = find_page_by_id($selected_page_id, $public); 
		$subject_by_id = null;
		$selected_subject_id = null;
	} else {
		$selected_subject_id = null;
		$selected_page_id = null; 
		$subject_by_id = null;
		$page_by_id = null;
	}
}

function show_pages_for_subject($subject_id, $public = True) {
	if(isset($_GET['subject'])) {
		$pages_group = find_pages_for_subject($subject_id, $public);
		if($page_row = $pages_group->fetch(PDO::FETCH_ASSOC)) {
			$output = "<h3>This subject contains pages..</h3><ul>";
			do {
				$page_row_id = $page_row['id'];
				$page_row_name = $page_row['menu_name'];
				$output .= "<li><a href=\"manage_content.php?page={$page_row_id}\">{$page_row_name}</a></li>";

			}
			while($page_row = $pages_group->fetch(PDO::FETCH_ASSOC)); 
			$output .= "</ul>";			
		} else {
			$output = "<h3>No pages for this subject</h3>";
		}
		$output .= "<a href=\"new_page.php\">+Add a new page</a>"; 			
		
	}else {
	$output = "<a href=\"new_page.php\">+Add a new page</a>";
	}		
	return $output;
}

//Functions for admins
////cRud - Reading admins
function get_all_admins() {
	global $connect;
	$query = "SELECT * FROM admin ORDER BY username ASC;";
	$result = $connect->query($query);
	confirm_query($result);
	$admins_usernames = array();
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$admin_id = $row['id'];
		$admins_usernames[$admin_id] = $row['username'];
	}
	return $admins_usernames;
}

function print_admins($admins_set, $separator) {
	foreach ($admins_set as $id => $admin) {
		$output = "<div class=\"admins_names\">" . $admin . "</div>";
		$output .= "<div class=\"admins_actions\">";
		$output .= "<a href=\"edit_admin.php?admin={$id}\">Edit</a>";
		$output .= "&nbsp";
		$output .= "<a href=\"delete_admin.php?admin={$id}\" onclick=\"return confirm('Are you sure?');\">Delete</a>";
		$output .= "</div>";
		$output .= $separator;
		echo $output;
	}
}

////Crud - Creating Admins
function set_admins_vars() {
	global $admin_name;
	global $password;

	if (isset($_POST['admin_name'])) {
		$admin_name = $_POST['admin_name'];
	} else {
		$admin_name = null;
	}
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	} else {
		$password = null;
	}
}

function insert_admin() {
	global $connect;
	global $admin_name;
	global $password;
	global $inserted;
	$password = password_encrypt($password);
	$query = "INSERT INTO admin (username, hashed_password) VALUES (\"{$admin_name}\", \"{$password}\");";
	if($result = $connect->query($query)) {
		$_SESSION['inserted'] = True;
	}
	confirm_query($result);

}

function list_iterate($iteration_array) {
	$output = "";
	foreach ($iteration_array as $item) {
		$output .= "<li>" . $item ."</li>";
	}
	return $output;
}

//crUd .. Update

function set_edit_admins_vars() {
	global $edit_admin_name;
	global $edit_password;

	if (isset($_POST['edit_admin_name'])) {
		$edit_admin_name = $_POST['edit_admin_name'];
	} else {
		$edit_admin_name = null;
	}
	if (isset($_POST['edit_password'])) {
		$edit_password = $_POST['edit_password'];
	} else {
		$edit_password = null;
	}
}

function get_last_update() {
	global $connect;
	$id = $_GET['admin'];
	$query = "SELECT * FROM admin WHERE id = {$id}";
	$result = $connect->query($query);
	confirm_query($result);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function edit_admin() {
	global $connect;
	global $edit_admin_name;
	global $edit_password;
	global $updated;
	$id = $_GET['admin'];
	$edit_password = password_encrypt($edit_password);
	$query = "UPDATE admin SET username=\"{$edit_admin_name}\", hashed_password = \"{$edit_password}\"
			  WHERE id = {$id};";
	if($result = $connect->query($query)) {
		$updated = True;
	}
	confirm_query($result);
}
//cruD .. Delete admin
function delete_admin() {
	global $connect;
	$id = $_GET['admin'];

	$query = "DELETE FROM admin WHERE id = {$id}";
	if($result = $connect->query($query)) {
		$_SESSION['delete_admin'] = True;
	}
	confirm_query($result);
}

//generic functions for admins

function search_for_admin($admin_id) {
	global $connect;

	$query = "SELECT * FROM admin WHERE id = {$admin_id}";
	$result = $connect->query($query);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	return $row;

}

//functions for HASHING passwords
function generate_salt($length) {
	$unique_id = md5(uniqid(mt_rand(), true));

	$base64 = base64_encode($unique_id);
	$modified_base64 = str_replace('+', '.', $base64);

	$salt = substr($modified_base64, 0, $length);

	return $salt;

}

function password_encrypt($password) {

	$salt_length = 22;
	$format = "$2y$10$";
	$salt = generate_salt($salt_length);
	$format_and_salt = $format . $salt;

	$hashed_password = crypt($password, $format_and_salt);

	return $hashed_password;

}

function check_password($provided, $existing) {
	if (crypt($provided, $existing) === $existing) {
		return True;
	} else {
		return False;
	}
}

//functions for login

function find_username($username) {
	global $connect;
	$query = "SELECT * FROM admin WHERE username = '{$username}'";
	if($result = $connect->query($query)) {
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	} else {
		return false;
	}

}

function attempt_login($username, $password) {
	if ($user = find_username($username)) {
		$existing_password = $user['hashed_password'];

		if (check_password($password, $existing_password)) {
			return $user;
		} else {

		}
	} else {
		return false;
	}
}

function logged_in() {
	return isset($_SESSION['success_username']);
}

function check_authorization() {
	if (!logged_in()) {
		redirect_to("login.php");
	} else {
		
	}
}
?>
