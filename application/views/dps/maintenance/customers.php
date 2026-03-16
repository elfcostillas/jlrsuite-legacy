<div id="content" class="grid-940">
	


	<div id="usual1" class="usual">  
		<ul>
		  	<li><a href="#tab1" class="selected"><img src="<?php echo base_url("css/images/add-customer.png") ?>" /> Add Customers</a></li> 
			<li><a href='#tab2'><img src="<?php echo base_url("css/images/edit-customer.png") ?>" /> Edit Customers</a></li>
		</ul> 


		<div id="tab1">
			
			<form name="add-cust-form" class="maintenance-form" method="POST" action="process_add_customer">
				<div class="fields"><label>Customer Name : </label><input type="text" class="short" name="cust_name" id="cust_name" /></div>
				<div class="fields"><label>Customer Address : </label><input type="text" class="long" name="cust_add" id="cust_add" /></div>
				<div class="fields"><label>Billing Address : </label><input type="text" class="long" name="billing_add" id="billing_add" /></div>
				<div class="fields"><label>Contact Number : </label><input type="text" class="short" name="contact_num" id="contact_num" /></div>
				<div class="fields">
					<label>Sales Engineer : </label>
					<select name="sales_engg" id="addcust-selectsales">
						<option value=""></option>
						<?php
							foreach ($salesengg as $sle) {
								echo "<option value='$sle->slsID'>$sle->name</option>";
							}
						?>
					</select>
				</div>
				<div class="fields maint-selection-wrapper" id="maintenance-addbutton"><center><input type="submit" class="mnt-submit-button" value="Add New Customer" name=""/></center></div>
			</form>
		</div>

		<div id="tab2">
			<form name="add-cust-form" class="maintenance-form" method="POST" action="process_editcust">
				<div class="fields maint-selection-wrapper">
					<label>Select Customer Name : </label>

					<select name="selected-custname" id="selected-custname">
						<option value=""></option>
						<?php
							foreach ($custnames as $custlist) {
								//$custlist->customer_name;
								//$custlist->o5_id;
								echo "<option value='$custlist->o5_id'>$custlist->customer_name</option>";
							}
						?>	
					</select>
					
				</div>
				<div id="append-custinfo"></div>
				
			</form>
		</div>
	</div> 
 




<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
</div>