<?php
$errors = array();

function has_presence($value) {
	return isset($value) && $value !== "";
}

function stringify_fieldname($fieldname) {
	$string = str_replace("_"," ",$fieldname);
	$output = ucfirst($string);
	return $output;
}

//$required_fields is an array of fields' names to be tested
function field_present($required_fields) {
	global $errors;
	foreach ($required_fields as $field) {
		$value = trim($_POST[$field]);
		if (!has_presence($value)) {
			$errors[$field] = stringify_fieldname($field) . " can't be blank";
		}

	}
}

?>