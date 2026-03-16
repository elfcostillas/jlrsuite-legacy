<div class="container">

	<div class="row leave-forms">
    <br />
		<h3 class="col-md-4">Leave Records</h3>
		<div class="pull-right col-md-2 ralphskie">
			<label>Employee Name</label>
			<select class="col-md-12 leave-record-filter" id="by-emp" name="leave-type">
          <option value=""></option>
          <option value="monthly">Monthly</option>
          <option value="quarterly">Quarterly</option>
          <option value="semiannual">Semi Annual</option>
          <option value="yearly">Yearly</option>
      </select>
		</div>
    <div class="pull-right col-md-2 ralphskie">
      <label>Leave Type</label>
      <select class="col-md-12 leave-record-filter" id="by-leavetype" name="leave-type">
            <option value=""></option>
            <option value="VACATION">VACATION</option>
            <option value="SICK">SICK</option>
            <option value="EMERGENCY">EMERGENCY</option>
            <option value="MATAERNITY/PATERNITY">MATERNITY / PATERNITY</option>
            <option value="BIRTHDAY">BIRTHDAY</option>
            <option value="UNDERTIME">UNDERTIME</option>
            <option value="COMPANY LEAVE">COMPANY LEAVE</option>
            <option value="MASS LEAVE">MASS LEAVE</option>
            <option value="OTHERS">OTHERS</option>      
      </select>
    </div>
    <div class="pull-right col-md-2 ralphskie">
      <label>Period</label>
      <select class="col-md-12 leave-record-filter" id="by-period" name="leave-type">
            <option value=""></option>
            <option value="monthly">Monthly</option>
            <option value="quarterly">Quarterly</option>
            <option value="semiannual">Semi Annual</option>
            <option value="yearly">Yearly</option>
          </select>
    </div>
    <div class="pull-right col-md-2 ralphskie">
      <label>Department</label>
      <select class="col-md-12 leave-record-filter" id="by-dept" name="leave-type">
            <option value=""></option>
            <option value="ADMIN">ADMIN</option>
            <option value="FINANCE">FINANCE</option>
            <option value="HR">HR</option>
            <option value="IT">IT</option>
            <option value="QA">QA</option>
            <option value="QAD">QAD</option>
            <option value="QMS">QMS</option>
            <option value="RMC">RMC</option>
            <option value="RMD">RMD</option>
            <option value="SMD">SMD</option>
          </select>
    </div>
	</div>

	
	<hr />
	

	<div class="row">
        <div class="col-md-12">

          <?php
            //if($records != 0){
              
          ?>


          <table class="table" id="leave-app-table">
              <thead>
                  <tr class="tbl-row-hdr">
                      <th>Employee</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Duration</th>
                      <th>Type</th>
                      <th>Reliever</th>
                  </tr>
              </thead>

              <tbody id="leave-records">
              </tbody>



          </table>


            <?php
              // }else{
              //   /* display the error message*/
              //   echo "<div class='alert alert-danger' role='alert'>No record in the database</div>";
              // }

            ?>

          <br />
          <br />
          <br />
          <br />
        </div>
  </div>

</div>

