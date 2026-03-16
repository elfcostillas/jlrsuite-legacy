<div id="content-fluid">
	<?php echo $status ?>
<?php if(!$this->functionlist->isFIDCollection($this->lvl)){?>	
	<div id="search-menu-wrapper">

		<div id="searchbyform-wrapper" class="searchproj_menudiv">
			<p>Enter Form</p>
			<center>
				<select id="byform-select" name="byform-select">
					<option value=""></option>
					<option value="form1">Form 1</option>
					<option value="form1a">Form 1A</option>
				</select>
				<input type="text" name="byform-number" id="byform-number">
			</center>
			<br />
			<center><a href="#" id="searchbut-byform" class="searchbutton">Search Form</a></center>
		</div>

		<p id="search_or">OR</p>

		<div id="searchbydate-wrapper" class="searchproj_menudiv">
			<p>Enter Date</p>
			<center>
				<input type="text" name="bydate-date" id="bydate-date">
			</center>
			<br />
			<center><a href="#" id="searchbut-bydate" class="searchbutton">Search Date</a></center>
		</div>

		<div id="searchbydate-wrapper" class="searchproj_menudiv">
			<p>Select a Customer</p>
			<!-- get the customer list -->
			<center>
				<select name="bycust-cust" id="bycust-cust">
					<option value=""></option>
					<?php
						foreach ($custnames as $custlist) {
							//$custlist->customer_name;
							//$custlist->o5_id;
							$fil_cust = $custlist->customer_name;
							 // echo "<option value='$custlist->o5_id'>$custlist->customer_name</option>";
							 // echo "<option value='$custlist->customer_name'>$custlist->customer_name</option>";
							 echo "<option value='$fil_cust'>$custlist->customer_name</option>";
						}
					?>	
				</select>
			</center>
			<br />
			<center><a href="#" id="searchbut-bycust" class="searchbutton">Search Customer</a></center>
		</div>
	</div>


	<div id="searchby-result-wrapper">
		<!-- RESULT OF THE SEARCHING /FILTER BY FORM NUM OR BY DATE	-->
		<div id="searchbyform-result"></div>
		<div id="searchbydate-result"></div>
	</div>
    
    <?php } else { ?>
	<?php echo $status ?>

		<!-- FOR FID SEARCH VIEW ONLY -->
	<center>
	<fieldset style="width:30%;height:70px;display: inline-block;">
		<legend><div style="margin-left: 10px;font-family: Helvetica;">Search project by date </div></legend>
		<div id="searchbydate-wrapper" class="searchprojfid">			
			<div id="tb-srch-fid"><input type="text" name="bydate-date" id="bydate-date" placeholder="Enter date" style="height: 30px;width:200px;"></div>			
			<div id="btn-srch-fid"><a href="#" id="searchbut-bydate-FID" class="searchbutton2" style="height: 15px;">Search Date</a></div>
		</div>
	</fieldset>

	<fieldset style="width:30%;height:70px;display: inline-block;">
		<legend><div style="margin-left: 10px;font-family: Helvetica;">Search Customer </div></legend>
		<div id="searchbydate-wrapper" class="searchprojfid">			
			
			<center>
				<select name="bycust-cust" id="bycust-cust" style="height: 30px;width:100%;">
					<option value=""></option>
					<?php
						foreach ($custnames as $custlist) {
							//$custlist->customer_name;
							//$custlist->o5_id;
							// echo "<option value='$custlist->o5_id'>$custlist->customer_name</option>";
							echo "<option value='$custlist->customer_name'>$custlist->customer_name</option>";
						}
					?>	
				</select>
			</center>
				
			<div id="btn-srch-fid"><a href="#" id="searchbut-bycust-FID" class="searchbutton2" style="height: 15px;">Search</a></div>
		</div>
	</fieldset>
	</center>



	<div id="searchby-result-wrapper">
		<!-- RESULT OF THE SEARCHING /FILTER BY FORM NUM OR BY DATE	-->
		<div id="searchbydate-result-FID"></div>
	</div>
	<?php }?>
</div>