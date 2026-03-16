<!-- COORDINATOR SCHEDULER TABLE-->
	<div id="coordinator-scheduler-table">
		
			<div id="content-fluid">

				<table id="mytable" class="scheduler-table">
					<fieldset>
						<legend>Legend</legend>
							<ul class="batch-legend-wrapper">
								<li id="approved">Uploaded</li>
								<li></li>								
								<li id="selected">Selected for Upload</li>
								<li></li>
								<li id="origdate">Original Date</li>
								<li id="moddate">Modified Date</li>
								<li></li>
								<li id="desforp4upload">Design for Plant 4</li>
								
							</ul>

					</fieldset>
					

		<?php
			if(isset($result)){
				echo $result;
				echo "<br /><br />";
			}
		?>

				</table>
			
			</div>
			<div><button id="btn-top" title= "Go top">&uarr;</button></div>
		
	</div>