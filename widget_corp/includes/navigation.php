<ul class = 'subject'>
		<?php
		$result = find_all_subjects(False);

			while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
			
				<?php 
				if ($row['id'] == $selected_subject_id) {
					echo "<li class = \"selected\">"; 	
				} else {
					echo "<li>";
				}
				?>
					<a href = "http://localhost/widget_corp/public/manage_content.php?subject=<?php echo $row['id']?>">
					<?php echo $row['menu_name']; 
						$result2 = find_pages_for_subject($row['id'], False);
					?> </a>
					<ul class = 'page'>
						<?php while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) { ?>
					<?php 
						if ($row2['id'] == $selected_page_id) {
							echo "<li class = \"selected\">"; 	
						} else {
							echo "<li>";
						}
					?>
						<a href = "http://localhost/widget_corp/public/manage_content.php?page=<?php echo $row2['id']?>">
						<?php echo $row2['menu_name']; ?>
						</a>
						</li>
						<?php } ?>
						<?php $result2->closeCursor(); ?>
					</ul>
				</li>
			
		<?php		
			}
		?>
		</ul>

		<?php $result->closeCursor(); ?>