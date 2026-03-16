<div class="container" id="grid">

	<br class="clear" />
	<div class='eleven columns'>
		<form method="POST" action="admin/check_daily_stock_position">
			<input type="submit" value="test warehouse" name="testbtn">
		</form>
		<h6 class="title-head"><span>LOGS</span></h6>

		<div class="row">
			<br class="clear" />

			<div class="three columns alpha">
				<p id="online" class="semi-headers">DPS Online Users : <span id="olusers-count"></span></p>
				<div id="chat-online-wrapper">
				</div>
			</div>

			<div class="nine columns omega">
				<h6 class="semi-headers">Sync History</h6>
				<div id="log-wrapper">
					<table class="condensed zebra-striped">
						<tr>
							<th>DATE PERFORMED</th>
							<th>DESC</th>
							<th>MODE</th>
							<th>STATUS</th>
						</tr>
						
						<?php
							foreach ($cronlog as $result) {
								$date = $result->date_performed;
								$time = $result->time_performed;
								$area = $result->area;
								$day = $result->day;
								$mode = $result->mode;
								$status = $result->status;
						?>

							<tr>
								<td><?php echo $date . ' - ' . $time ?></td>
								<td><?php echo $area . ' - ' . $day ?></td>
								<td><?php echo $mode ?></td>
								<td><?php echo $status ?></td>
							</tr>
						<?php
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class='four columns'>
		<h5 class='title-head'><span>TOOLS</span></h5>
		<br class="clear" />
		<ul>
			<a href="cli/sync_weigherdata_manual?area=north&day=today" class="full-width button">NORTH [Today]</a>
			<a href="cli/sync_weigherdata_manual?area=south&day=today" class="full-width button">SOUTH [Today]</a>
			<a href="cli/sync_weigherdata_manual?area=north&day=yesterday" class="full-width button">NORTH [Yesterday]</a>
			<a href="cli/sync_weigherdata_manual?area=south&day=yesterday" class="full-width button">SOUTH [Yesterday]</a>
			<a href="cli/sync_southweigherdata?area=south&day=today" class="full-width button">SOUTH <--> SOUTH [Today]</a>
			<a href="cli/sync_southweigherdata?area=south&day=yesterday" class="full-width button">SOUTH <--> SOUTH [Yesterday]</a>

			<a href="cli/sync_weigherdata_auto_south" class="full-width button">TEST SOUTH</a>
		</ul>
	</div>

	<!-- 	<div class="row">
			<div class="four columns" id="we">4</div>
			<div class="four columns" id="we">4</div>
			<div class="four columns" id="we">4</div>
			<div class="four columns" id="we">4</div>
		</div> -->

	<div class='twelve columns'>
		<h5 class="title-head"><span>Weigher Tools</span></h5>
		<div class="row">
			<br class="clear" />

			<div class="three columns">
		      <label for="exampleEmailInput">Company</label>
		      <input class="u-full-width" type="text" placeholder="Company" id="exampleEmailInput">
		    </div>

			<div class="two columns">
		      <label for="exampleEmailInput">Truck Plate No.</label>
		      <input class="u-full-width" type="text" placeholder="AAA-123" id="exampleEmailInput">
		    </div>

		    <div class="two columns">
		      <label for="exampleEmailInput">Length</label>
		      <input class="u-full-width" type="text" placeholder="00.0" id="exampleEmailInput">
		    </div>

		    <div class="two columns">
		      <label for="exampleEmailInput">Width</label>
		      <input class="u-full-width" type="text" placeholder="00.0" id="exampleEmailInput">
		    </div>

		    <div class="two columns">
		    	<label for="exampleEmailInput"> </label>
		      <input class="button-primary" type="submit" value="Submit">
		    </div>
		    
		</div>

	</div>
	<br class="clear" />

</div>

<?php
$this->output->enable_profiler(TRUE);
?>
