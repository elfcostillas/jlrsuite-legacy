<div id="content" class="grid-940">

	<div class="content-body">
			<?php
				$datestring = "%Y";
				$credits_year = mdate($datestring, time());

				echo "<h2>Employee Leave Credits for year " . $credits_year . "</h2>";
			?>
		

		<div class="form">
			<!-- <?php echo validation_errors(); ?> -->
			<div class="notice-success" id="notice-updatecredits"><strong>Success! </strong>Leave successfully added.</div>

			<?php 
				$attributes = array('class' => 'form-validation', 'id' => 'leavecreditsForm', 'name' => 'leavecreditsForm');
				echo form_open('',$attributes);
			?>

				<div class="form-field alt-field">
					<!-- load the employee list from the database in to that dropdown list -->
					<label for="title">Employee Name :</label>
					<select class="input-fields" id="credits_empname" name="credits_empname">
							<option value=""></option>
				            <?php				
					            foreach($employee as $employees){
					            	$firstname = $this->leaveclass->convert_Big_Ntilde($employees['first_name']);
					            	$lastname = $this->leaveclass->convert_Big_Ntilde($employees['last_name']);
					                echo '<option value="' . $employees['o1_id'] . '">' . trim($lastname) . "," . trim($firstname) .'</option>';
					            }
				            ?>
					</select>
					<input type="hidden" value="<?php echo $credits_year ?>" name="credits_year" id="credits_year" />
					
					<label id="get_leave_credits_result" for="title">Credits Left : <span></span></label>
					<!--<input type="text" id="get_leave_credits_result" name="get_leave_credits_result" />-->
					<a id="edit-credits" href="#">Edit</a>
				</div>
				
				
				<div class="form-field alt-field" id="add-credits-wrapper">
				
					
						<label for="title">Credits :</label>
						<input class="input-fields" type="text"  id="credits_value" name="credits_value">
						<a id="add-credits" href="#">Add Credit</a>
					

				</div>


				<div class="form-field alt-field" id="edit-credits-wrapper">
				
					
						<label for="title">Credits :</label>
						<input class="input-fields" type="text" placehoder="credits" id="update_credits_value" name="update_credits_value">
						<a id="update-credits" href="#">Update Credit</a>
					

				</div>

			</form>
		</div>

	</div>
</div>
