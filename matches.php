<div class="span3 pre-scrollable">
	<?php $matchSet=mysql_query("SELECT * FROM teamtwistermatches");
			  confirmQuery($matchSet);
	?>
	<ul>
		<?php
			$done = true;
			while($match=mysql_fetch_array($matchSet)){
				echo "<div class=\"alert alert-block alert-error fade in\">";
				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>";
					echo "<h4 class=\"alert-heading\">".htmlentities($match[0])."</h4>";
					
					echo "<h5><a target=\"_blank\" style=\"color:#37F216;\" href=\"http://www.espncricinfo.com/ci/content/match/fixtures/index.html?days=30\">Match between ".htmlentities($match[1])." and ".htmlentities($match[2])."</a></h5>";
				echo "</div>";
			  }	
		?>
	</ul>
</div>