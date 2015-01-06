
<!--puts all subjects' names in an array-->
<?php 
	$subjects_result = find_all_subjects();
	$subjects_name_array = array();
    while($subjects_rows = $subjects_result->fetch(PDO::FETCH_ASSOC)) {
 		$subjects_name_array[] = $subjects_rows['menu_name'];
 	}
 ?>

&nbsp To which subject?:
<select name="subject_name">
	
	<?php for ($i = 0; $i < count($subjects_name_array); $i++) { ?> 
		<option value="<?php echo $subjects_name_array[$i]; ?>"><?php echo $subjects_name_array[$i]; ?>
		</option>
	<?php } ?>
</select><br><br>
