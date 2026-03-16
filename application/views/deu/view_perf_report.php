<div class="grid-940" id="deu-main-wrapper" >

	<div class="search-wrapper" id="perfreport-search">
		<div class="float-right">
			<select id="perfrep-selection">
				<option value="">Please Select</option>
				<option value="daily">Daily</option>
				<option value="monthly">Monthly</option>
			</select>

			<input type="text" name="perfrep-day" id="perfrep-day" placeholder="Select a Date"/>

			<select id="perfrep-monthly">
				<option value="">Select Month</option>
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>



			<select id="perfrep-year">
				<option value="">Select Year</option>
				<option value="2011">2011</option>
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
			</select>



			<a href="#" id="perfrep-searchbutton" value="">SEARCH</a>
		</div>
	</div>

	<div id="perfrep-printheader">
		<p>Report generated : <?php echo date('F m, Y') ?></p>
	</div>

	<div id="perfreport-wrapper">
		<center><p>Please select a <i><strong>date</strong></i> to view the report.</p></center>
	</div>
</div>