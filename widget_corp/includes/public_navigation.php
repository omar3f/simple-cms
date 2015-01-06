<ul class = 'subject'>
		<?php
		$result = find_all_subjects();
			if (isset($selected_page_id)) { $subject_of_page_nav = find_subject_of_page($selected_page_id)['subject_id']; } else { $subject_of_page_nav = null; }
			 ?>
			
				<?php 
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) { //*
					if ($row['id'] == $selected_subject_id || $row['id'] == $subject_of_page_nav || (!isset($_GET['subject']) && !isset($_GET['page']))) {//****
					?>
					<li class = "selected"> 	
				
				
					<a href = "http://localhost/widget_corp/public/index.php?subject=<?php echo $row['id']?>">
					<?php 
						echo $row['menu_name']; 
						$result2 = find_pages_for_subject($row['id']);
					?> 
					</a>
					<?php
					if ($row['id'] == $selected_subject_id || $row['id'] == $subject_of_page_nav || (!isset($_GET['subject']) && !isset($_GET['page']))) { //**
					?>

					<ul class = 'page'>
					<?php while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) { //*** ?>
					<?php 
						if ($row2['id'] == $selected_page_id) {
							echo "<li class = \"selected\">"; 	
						} else {
							echo "<li>";
						}
					?>
						<a href = "http://localhost/widget_corp/public/index.php?page=<?php echo $row2['id']?>">
						<?php echo $row2['menu_name']; ?>
						</a>
						</li>
					<?php } //***?>
					</ul>
				<?php } //** ?> 

				</li>
				<?php } //****?>
				<?php } //* ?> 

	
		</ul>

