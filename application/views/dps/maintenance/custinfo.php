<?php

	$rows = $result->num_rows();
	$i = 0;				

	
	while ( $i < $rows) {

		$row = $result->row($i);
		

		
		$id = $row->o5_id;
		$customer_name = $row->customer_name;
		$customer_add = $row->customer_address;
		$billing_add = $row->billing_address;
		$contact_num = $row->contact_number;
		$sales = $row->sales_id;
		//$sales_id = $row->o5_id;

?>
		<div class="fields"><label>Customer Name : </label><input type="text" class="long" name="cust_name" value="<?php echo $customer_name ?>" /></div>
		<div class="fields"><label>Customer Address : </label><input type="text" class="long" name="cust_add" value="<?php echo $customer_add ?>" /></div>
		<div class="fields"><label>Billing Address : </label><input type="text" class="long" name="billing_add" value="<?php echo $billing_add ?>" /></div>
		<div class="fields"><label>Contact Number : </label><input type="text" class="short" name="contact_num" value="<?php echo $contact_num ?>" /></div>
		
		
		<div class="fields">
			<label>Sales Engineer : </label>
			<select name="sales_engg">
				<option value=""></option>
				<?php
					foreach ($salesengg as $sle) {
						if($sales == $sle->slsID){
							echo "<option value='$sle->slsID' selected='true'>$sle->name</option>";
						}else{
							echo "<option value='$sle->slsID'>$sle->name</option>";
						}
						
					}
				?>
			</select>
		</div>
<?php
		
		$i++;
	}

?>

		<div class="fields maint-selection-wrapper"><center><input type="submit" class="mnt-submit-button" value="Update Customer" name=""/></center></div>