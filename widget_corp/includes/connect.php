<?php
try {
	$connect = new PDO('mysql:host=localhost;dbname=widget_corp', 'root','');
} catch(PDOException $e) {
	echo 'There was a connection error number: ' . $e->getCode();
}
?>