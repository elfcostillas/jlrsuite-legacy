<?php

	 //var_dump($deptlist[0][0]);
	//display the department list

	 
	
?>

<div class="container">

	<br/>
		<div class="row">
			<h3>Leave Credits</h3>
			<hr>
		</div>

		<div class="row">
			<table class="table" id="leave-credits-table">
              <thead>
                  <tr class="tbl-row-hdr">
                      <th>Employee</th>
                      <th>Credits</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody id="leave-credits">

              	<?php
              		foreach ($credits as $credit) {
              	?>


              	<tr id="<?php echo $credit->credit_id ?>">
                  <td><?php echo $credit->name; ?></td>
                  <td><input type="text" disabled value="<?php echo $credit->credit ?>"></td>
                  
                  <td>
                    <a href="#" class="flat-btn orange credit-edit-btn">EDIT</a>
                    <a href="#" class="flat-btn green credit-update-btn">SAVE</a>
                  </td>
                </tr>

                <?php
              		}
              	?>

              </tbody>
			</table>	
		</div>



</div>

<?php
	// var_dump($test)
?>



