<?php $rankSet=mysql_query("SELECT username, totalScore FROM teamtwisterscores ORDER BY totalScore DESC");
					  confirmQuery($rankSet);?>
					  </br>
					   <h3 class="text-warning">Top 3 Scorers of the Day ! </h3>
					   
					<table class="table table-hover" style="width:80%;">
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
								while(($rank=mysql_fetch_array($rankSet)) && ($pos<=3)){
									echo "<tr ";
									
										echo "class=\"white\"";
									
									echo " ><td>{$pos}</td><td>".htmlentities($rank[0])."</td><td>".htmlentities($rank[1])."</td></tr>";
									$pos++;
								}
							?>
						</tbody>
					</table>

