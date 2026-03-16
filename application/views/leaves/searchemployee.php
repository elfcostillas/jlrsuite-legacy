<div id="content" class="grid-940">
<h2 class="noprint">Search employee leave history</h2>


<div class="form">
	<?php echo validation_errors(); ?>


		
<form id="" class="form-validation noprint">
	<div class="form-field" id="employee-dropdown">
		
		
		
		<label for="title">Employee Name :</label>
		<!-- load the employee list from the database in to that dropdown list -->
		<select id="empname_search" class="input-fields validate[required]" name="empname_search">
			
			<option value=""></option>
            <?php				
	            foreach($employee as $employees){
	            	$firstname = $this->leaveclass->convert_Big_Ntilde($employees['first_name']);
	            	$lastname = $this->leaveclass->convert_Big_Ntilde($employees['last_name']);
	                echo '<option value="' . $employees['o1_id'] . '">' . trim($lastname) . "," . trim($firstname) .'</option>';
	            }
            ?>
		</select> 
	</div>



	<div class="form-field noprint" id="search_year_dropdown">
		<label for="title">Year :</label>
		<?php
			$yearOp = array();
			for($i=0;$i<4;$i++)
			{
				$c = -$i;
				$yearOp[$i] =  date("Y",strtotime("".$c." year"));
			}
			$options = array(
							  ''  => '',
			                  $yearOp[3] => $yearOp[3],
			                  $yearOp[2] => $yearOp[2],
			                  $yearOp[1] => $yearOp[1],
			                  $yearOp[0] => $yearOp[0]
			                );
			/*$options = array(
							  ''  => '',
			                  date("Y",strtotime("-3 year")),
			                  date("Y",strtotime("-2 year")),
			                  date("Y",strtotime("-1 year")),
			                  date("Y")
			);*/
			$attrib = 'id="year_dropdown" class="input-fields validate[required]"';
			echo form_dropdown('year', $options,'', $attrib);
		?>
	</div>
	
</form>
	 	
	
	


</div>
		<div class="print">
			<h2>
				<p id="search-name"></p>'s Leave Summary for Year <p id="search-year"></p>
				<p id="gendate">Report generated : <?php echo date('F d, Y',time())?></p>
			</h2>

		</div>

<div id="content_result"></div>
</div>



