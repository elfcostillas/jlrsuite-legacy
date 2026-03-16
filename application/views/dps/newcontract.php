<!-- <div id="content" class="grid-940 contracts-container-bg"> -->
	<!-- <a href="#" class="enjoy-css">New Contract</a> -->

	<!-- multistep form -->
	<form id="msform" action="process_test" method="POST">
	  <!-- progressbar -->
	  <ul id="progressbar">
	    <li class="active">First Party</li>
	    <li>Second Party</li> 
	    <li>Contract Details</li>
	    <li>Design Details</li>
	    <li>Notes</li>
	  </ul>

	  <input type="submit" name="submit-btn" value="Submit" />

	  <!-- test for the ocntract no. -->
	  <div id="contract-wrapper">
	  		<div id="left">
	  			<span>Contract No.</span>
	  			<input type="text" name="contract-no" placeholder="Contract No." value="16-01-xxxx" />
	  		</div>
	  		<div id="right">
	  			<span>Contract Date</span>
	  			<input type="text" name="contract-date" placeholder="Contract Date" value="29 January 2016" />
	  		</div>
	  </div>

	  <!-- fieldsets -->

	  <fieldset>
		    <h2 class="fs-title">First Party Details</h2>
		    <h3 class="fs-subtitle">The first party stated on the contract</h3>

		    
		    <!-- <table id="design-tbl" style="width:100%">
		    	<tr>
		    		<th>Strength</th>
		    		<th>Aggregate</th>
		    		<th>Slump</th>
		    		<th>Curing Days</th>
		    		<th>Unit Price / m3</th>
		    		<th>Remarks</th>
		    	</tr>

		    	<tbody>
		    		<tr>
		    			<td>2000</td>
		    			<td>3/4</td>
		    			<td>4-6</td>
		    			<td>28</td>
		    			<td>P 4,107.50</td>
		    			<td>Direct Pouring</td>
		    		</tr>

		    		<tr>
		    			<td>3500</td>
		    			<td>3/8</td>
		    			<td>4-6</td>
		    			<td>14</td>
		    			<td>P 5,302.50</td>
		    			<td>Direct Pouring</td>
		    		</tr>
		    	</tbody>
		    </table>

			<div id="design-form-wrapper">
				<input type="text" name="f-party" class="design-tbox" placeholder="Psi" Value=""/>
				<input type="text" name="f-party" class="design-tbox" placeholder="Agg." Value=""/>
				<input type="text" name="f-party" class="design-tbox" placeholder="Slump" Value=""/>
				<input type="text" name="f-party" class="design-tbox" placeholder="Curing" Value=""/>
				<input type="text" name="f-party" class="design-tbox" placeholder="Price" Value=""/>
				<input type="text" name="f-party" class="design-tbox remarks" placeholder="Remarks" Value=""/>
				<input type="submit" id="lol" name="f-party" class="design-tbox button" Value="Add Design"/>
			</div> -->

			



		    <input type="text" name="first-party" placeholder="First Party Name" Value="JLR CONSTRUCTION AND AGGREGATES INC."/>

		    <hr class="hr-spacer" />

		    <select name="sales-engr" id="">
		    	<option value="" disabled selected>Select a Sales Engineer</option>
		    	<option value="GEMMA LEE MALANA">GEMMA LEE MALANA</option>
		    	<option value="JUDITH BELANDRES">JUDITH BELANDRES</option>
		    </select>

		    <input type="text" name="sales-phone" placeholder="Telephone No." />
		    <input type="text" name="sales-mobile" placeholder="Cellphone No." />

			<hr class="hr-spacer" />
		    <input type="text" name="first-signee" placeholder="First Party Signee" />





		    <input type="button" name="next" class="next action-button" value="Next" />
		    <input type="submit" name="submit-btn" class="submit action-button" value="Submit" />
		    
	  </fieldset>

	  <fieldset>
		    <h2 class="fs-title">Second Party Details</h2>
		    <h3 class="fs-subtitle">The second party stated on the contract</h3>

		    <select name="customer-name" id="">
		    	<option value="" disabled selected>Select a Customer</option>
		    	<option value="LUENGO CONSTRUCTION">LUENGO CONSTRUCTION</option>
		    	<option value="PLD CONSTRUCTION">PLD CONSTRUCTION</option>
		    </select>

		    <input type="text" name="cust-address" placeholder="Address" />
		    <input type="text" name="cust-contact" placeholder="Contact No." />

		    <hr class="hr-spacer" />

		    <input type="text" name="attn-person" placeholder="Attention Person" />

		    <hr class="hr-spacer" />

		    <input type="text" name="second-signee" placeholder="Second Party Signee" />


		    <input type="button" name="previous" class="previous action-button" value="Previous" />
		    <input type="button" name="next" class="next action-button" value="Next" />

	  </fieldset>

	  <fieldset>
		    <h2 class="fs-title">Contract Details</h2>
		    <h3 class="fs-subtitle">Fillup the project details and designs with prices</h3>

		    <input type="text" name="proj-name" placeholder="Project Name" />
		    <input type="text" name="location" placeholder="Location" />
		    <input type="text" name="est-volume" placeholder="Estimated Volume" />
		    <input type="text" name="proj-duration" placeholder="Project Duration" />
		    <select name="payment-terms" id="">
		    	<option value="" disabled selected>Select a Terms of Payment</option>
		    	<option value="30 Days">30 Days</option>
		    	<option value="60 Days">60 Days</option>
		    </select>

		    <hr class="hr-spacer" />
		    <input type="text" name="sales-invoice" placeholder="Sales Invoice" />
		    <input type="text" name="collection-bill" placeholder="Collection Bill" />

		    <!-- <textarea name="address" placeholder="Address"></textarea> -->
		    <input type="button" name="previous" class="previous action-button" value="Previous" />
		    <input type="button" name="next" class="next action-button" value="Next" />
	  </fieldset>

	  <fieldset>
		    <h2 class="fs-title">Design Details</h2>
		    <h3 class="fs-subtitle">Add,Edit,Delete Project Designs and specific prices</h3>

		    
		    <input type="button" name="previous" class="previous action-button" value="Previous" />
		    <input type="button" name="next" class="next action-button" value="Next" />
	  </fieldset>

	  <fieldset>
		    <h2 class="fs-title">Contract Notes</h2>
		    <h3 class="fs-subtitle">Additional notes for the contract</h3>
		    
		    <textarea name="contract-notes" id="editor">
		    	<ul>
		    		<li>Aggregates used are<strong> 100 % crushed, washed and screened mountain quarried</strong> <strong>Basalt</strong> <strong>rocks</strong>.</li>
		    		<li>Pump Charge: <strong>32 m, 36 m &amp; 42 m &nbsp;reach PUTZMEISTER wireless remote control Concrete Pump</strong>
		    			<ul>
		    				<li>P 9,000.00 lump sum if volume is equal to or <u>less than 40.0 m<sup>3</sup></u></li>
		    				<li>P 225.00 / m<sup>3</sup> if volume is <u>more than 40 m<sup>3</sup></u></li>
		    			</ul>
		    		</li>
		    		<li>Sampling Procedure &ndash; for every 75.0 m<sup>3</sup> volume, <strong>one set of 10 cylinder samples (6 client copy; 4 JLR copy)</strong> is to be taken randomly from a single batch or one mixer truck.</li>
		    		<li>Testing of samples is free of charge at JLR MQC Laboratory; other testing facility is for client&rsquo;s account.</li>
		    	</ul>
		    	<p>Conditions:</p>
		    	<ul>
		    		<li><strong>JLR Construction and Aggregates, Inc. </strong>is the <strong><u>first preferred ready-mixed concrete supplier</u></strong></li>
		    		<li><strong>Duracon Construction Development Corporation</strong>, will supply bulk Portland Cement to JLR CAI North or South batching plant and to maintain an inventory of <strong>5,000 bags or higher </strong>at any given time.</li>
		    	</ul>
		    		<p>This proposal is subject to the terms and conditions stated herein and on the reverse side hereof which are incorporated as an integral part of the Contract Proposal and Agreement.</p>
		    		<p>This proposal will formally serve as a Contract Agreement upon acceptance verified by signature of an authorized representative of the <strong>SECOND PARTY</strong> and return of a signed copy to the <strong>FIRST PARTY</strong>.</p>
		    		<p>The contract price above stipulated shall remain firm for the period of the proposal and the life of the accepted Contract Agreement, except as stated in Condition no. 2 of the reverse side hereof.</p>
		    		<p>No terms or conditions shall be valid and binding except those stipulated herein and/or the reverse side hereof.No modification, amendments, assignments, assignment of transfer of this contract or any of the stipulated herein contained shall be valid and binding unless agreed to in writing between the PARTIES herein.</p>
		    </textarea>

		    <input type="button" name="previous" class="previous action-button" value="Previous" />
		    <!-- <input type="submit" name="submit" class="submit action-button" value="Submit" /> -->
		    <input type="submit" name="submit-btn" value="Submit" />
	  </fieldset>
	</form>



	<script type="text/javascript">
		//jQuery time
		var current_fs, next_fs, previous_fs; //fieldsets
		var left, opacity, scale; //fieldset properties which we will animate
		var animating; //flag to prevent quick multi-click glitches

		$(".next").click(function(){
			if(animating) return false;
			animating = true;
			
			current_fs = $(this).parent();
			next_fs = $(this).parent().next();
			
			//activate next step on progressbar using the index of next_fs
			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
			
			//show the next fieldset
			next_fs.show(); 
			//hide the current fieldset with style
			current_fs.animate({opacity: 0}, {
				step: function(now, mx) {
					//as the opacity of current_fs reduces to 0 - stored in "now"
					//1. scale current_fs down to 80%
					scale = 1 - (1 - now) * 0.2;
					//2. bring next_fs from the right(50%)
					left = (now * 50)+"%";
					//3. increase opacity of next_fs to 1 as it moves in
					opacity = 1 - now;
					current_fs.css({
		        'transform': 'scale('+scale+')',
		        'position': 'absolute'
		      });
					next_fs.css({'left': left, 'opacity': opacity});
				}, 
				duration: 800, 
				complete: function(){
					current_fs.hide();
					animating = false;
				}, 
				//this comes from the custom easing plugin
				easing: 'easeInOutBack'
			});
		});

		

		$(".previous").click(function(){
			if(animating) return false;
			animating = true;
			
			current_fs = $(this).parent();
			previous_fs = $(this).parent().prev();
			
			//de-activate current step on progressbar
			$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
			
			//show the previous fieldset
			previous_fs.show(); 
			//hide the current fieldset with style
			current_fs.animate({opacity: 0}, {
				step: function(now, mx) {
					//as the opacity of current_fs reduces to 0 - stored in "now"
					//1. scale previous_fs from 80% to 100%
					scale = 0.8 + (1 - now) * 0.2;
					//2. take current_fs to the right(50%) - from 0%
					left = ((1-now) * 50)+"%";
					//3. increase opacity of previous_fs to 1 as it moves in
					opacity = 1 - now;
					current_fs.css({'left': left});
					previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
				}, 
				duration: 800, 
				complete: function(){
					current_fs.hide();
					animating = false;
				}, 
				//this comes from the custom easing plugin
				easing: 'easeInOutBack'
			});
		});

		$(".submit").click(function(){
			return false;
		})

		//initSample();
	</script>


<!-- </div> -->