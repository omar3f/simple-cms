<!DOCTYPE HTML>
<?php 
if (!isset($layout_context)) {
	$layout_context = "public";
}
?>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Widget Corp <?php if ($layout_context == "admin") { echo "Admin"; } ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheets/public.css">
	</head>
	<body>
		<div id='header'>
			<h1>Widget Corp <?php if ($layout_context == "admin") { echo "Admin"; } ?></h1>
		</div>
