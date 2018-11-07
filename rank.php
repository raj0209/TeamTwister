		<div>
			<h2 class="text-warning"><span>Ranks:</span></h2></br>
				<?php $rankSet=mysql_query("SELECT username, totalScore FROM teamtwisterscores ORDER BY totalScore DESC");
					  confirmQuery($rankSet);?>
				<table class="table table-hover table-condensed">
				<thead>
    				<tr>
        				<th >Rank</th>
						<th >Name</th>
						<th >Points</th>
						
					</tr>
				</thead>
				<tbody>
				<?php 
					$pos=1;
					while($rank=mysql_fetch_array($rankSet)){
						echo "<tr ";
						echo " ><td>{$pos}</td><td>".htmlentities($rank[0])."</td><td>".htmlentities($rank[1])."</td></tr>";
						$pos++;
					}
				?>
				</tbody>
				</table>
		</div>