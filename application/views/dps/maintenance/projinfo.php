<?php

	$rows = $result->num_rows();
	$i = 0;				

	
	while ( $i < $rows) {

		$row = $result->row($i);
		

		
		$id = $row->o8_id;
		$proj_name = $row->project_name;
		$proj_loc = $row->project_location;
		//$sales = $row->engr_sales;
		//$sales_id = $row->o5_id;
		//foreach ($contacts as $contact) {
		$proj_owner = $row->owner_name;
		$proj_owner_contact = $row->owner_contact;

		$proj_engr = $row->engineer_name;
		$proj_engr_contact = $row->engineer_contact;

		$proj_acctg = $row->acctg_name;
		$proj_acctg_contact = $row->acctg_contact;

		$proj_witness = $row->witness_name;
		$proj_witness_contact = $row->witness_contact;

		$proj_samp_std = ($row->samp_standard == 'YES') ? "checked" : "";
		$proj_samp_oth = ($row->samp_others == 'YES') ? "checked" : "";
		$proj_samp_cyl = $row->oth_cyl;
		$proj_samp_m3 = $row->oth_m3;
		

		$proj_test_jlr = ($row->test_jlr == 'YES') ? "checked" : "";
		$proj_test_elab = ($row->test_extlab == 'YES') ? "checked" : "";

		$proj_test_jlr7 = ($row->test_jlr_7 == 'YES') ? "checked" : "";
		$proj_test_jlr14 = ($row->test_jlr_14 == 'YES') ? "checked" : "";
		$proj_test_jlr28 = ($row->test_jlr_28 == 'YES') ? "checked" : "";

		$proj_test_elab7 = ($row->test_elab_7 == 'YES') ? "checked" : "";
		$proj_test_elab14 = ($row->test_elab_14 == 'YES') ? "checked" : "";
		$proj_test_elab28 = ($row->test_elab_28 == 'YES') ? "checked" : "";

		$proj_exlab = $row->ex_lab;
		$proj_coelab = $row->co_elab;

		//curing
		$proj_curing_asite = ($row->curing_asite == 'YES') ? "checked" : "";
		$proj_curing_ajlr = ($row->curing_ajlr == 'YES') ? "checked" : "";

		$proj_witness_w = ($row->witness_presence == 'YES') ? "checked" : "";
		$proj_witness_wo = ($row->witness_presence == 'NO') ? "checked" : "";
		$proj_witness_wsame = ($row->witness_presence == 'SAME') ? "checked" : "";
		$proj_con = $row->consultant_name;
		$proj_con_num = $row->consultant_num;

?>
		<input type="hidden" name="proj_id" value="<?php echo $id ?>" />
 		<div class="fields"><label>Project Name : </label><input type="text" class="long" name="proj_name" value="<?php echo $proj_name ?>"/></div>
		<div class="fields"><label>Project Location : </label><input type="text" class="long" name="proj_loc" value="<?php echo $proj_loc ?>"/></div>

		<div class="fields">
			<label>Owner : </label>
			<input type="text" class="short validate[required]" name="proj_owner" placeholder="Name" value="<?php echo $proj_owner ?>"/>
			<input type="text" class="short" name="proj_owner_num" placeholder="Contact" value="<?php echo $proj_owner_contact ?>"/>
		</div>

		<div class="fields">
			<label>Engineer : </label>
			<input type="text" class="short" name="proj_engr" placeholder="Name" value="<?php echo $proj_engr ?>"/>
			<input type="text" class="short" name="proj_engr_num" placeholder="Contact" value="<?php echo $proj_engr_contact ?>"/>
		</div> 

		<div class="fields">
			<label>Accounting : </label>
			<input type="text" class="short" name="proj_acctg" placeholder="Name" value="<?php echo $proj_acctg ?>"/>
			<input type="text" class="short" name="proj_acctg_num" placeholder="Contact" value="<?php echo $proj_acctg_contact ?>"/>
		</div>
		
		<div class="fields">
			<label>Witness : </label>
			<input type="text" class="short" name="proj_witness" placeholder="Name" value="<?php echo $proj_witness ?>"/>
			<input type="text" class="short" name="proj_witness_num" placeholder="Contact" value="<?php echo $proj_witness_contact ?>"/>
		</div>


		<div class="fields">
			<label>Sampling : </label>
			<input type="radio" class="radio samplingchoice" id="standard" name="sampling" <?php echo $proj_samp_std ?> value="standard" />Standard&nbsp&nbsp
			<input type="radio" class="radio samplingchoice" id="others" name="sampling" <?php echo $proj_samp_oth ?> value="others" />Others
			<div class="indentedfields" id="sampling-extend">
				<input type="text" name="sampling_cylinders" placeholder="cylinder" value="<?php echo $proj_samp_cyl ?>" />
				<input type="text" name="sampling_cubic" placeholder="cubic" value="<?php echo $proj_samp_m3 ?>" />
			</div>
		</div>

		<div class="fields">
			<label>Testing : </label>
			<input type="checkbox" class="check testingchoice" name="testing_standard" id="standard" <?php echo $proj_test_jlr ?> />Standard&nbsp&nbsp
			<input type="checkbox" class="check testingchoice" name="testing_others" id="others" <?php echo $proj_test_elab ?> />External Lab
			<div class="indentedfields" id="testing-standard">
				<input type="checkbox" class="check" name="test_std_7" <?php echo $proj_test_jlr7 ?> />7
				<input type="checkbox" class="check" name="test_std_14" <?php echo $proj_test_jlr14 ?> />14
				<input type="checkbox" class="check" name="test_std_28" <?php echo $proj_test_jlr28 ?> />28
			</div>

			<div class="indentedfields" id="testing-others">
				<input type="checkbox" class="check" name="test_oth_7" <?php echo $proj_test_elab7 ?> />7
				<input type="checkbox" class="check" name="test_oth_14" <?php echo $proj_test_elab14 ?> />14
				<input type="checkbox" class="check" name="test_oth_28" <?php echo $proj_test_elab28 ?> />28&nbsp&nbsp&nbsp&nbsp
				<input type="text" placeholder="c/o Lab" name="test_oth_colab" value="<?php echo $proj_exlab ?>" />
				<input type="text" placeholder="Lab Name" name="test_oth_colabname" value="<?php echo $proj_coelab ?>" />
			</div>
		</div>

		<div class="fields">
			<label>Curing : </label>
			<input type="checkbox" class="check" name="curing_atsite" <?php echo $proj_curing_asite ?> />At Site&nbsp&nbsp
			<input type="checkbox" class="check" name="curing_atjlr" <?php echo $proj_curing_ajlr ?> />At JLR Lab
		</div>

		<div class="fields">
			<label>Client Witness : </label>
			<input type="radio" class="check witnesschoice" id="with" name="witnessradio" <?php echo $proj_witness_w ?> value="YES" />With&nbsp&nbsp
			<input type="radio" class="check witnesschoice" id="without" name="witnessradio" <?php echo $proj_witness_wo ?> value="NO" />Without&nbsp&nbsp
			<input type="radio" class="check witnesschoice" id="same" name="witnessradio" <?php echo $proj_witness_wsame ?> value="SAME" />Same in Contacts
			<div class="indentedfields" id="witness-extend">
				<input type="text" placeholder="Consultant" name="witness_consultant" value="<?php echo $proj_con ?>" />
				<input type="text" placeholder="Contact Num" name="witness_consultant_num" value="<?php echo $proj_con_num ?>" />
			</div>
			
		</div>

	
<?php
		
		$i++;
		//}   // contact foreach end
	}		// while loop end

?>

	<div class="fields maint-selection-wrapper"><center><input type="submit" class="mnt-submit-button" value="Update Customer" name=""/></center></div>
