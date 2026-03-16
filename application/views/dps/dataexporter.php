<div class="grid-940">
	
	<label>Customer name : </label>
	<select id="exp-customer-list">
		<option value=""></option>
		<?php
			foreach ($custnames as $cust_name) {
				echo "<option value='$cust_name->o5_id'>$cust_name->customer_name</option>";
			}
		?>
	</select>

	<br /><br /><br />

	<form action="lo.php" method="POST">
		<div id="project-list-formwrapper">
		</div>
		<input type="submit" value="EXPORT">
	</form>
</div>

