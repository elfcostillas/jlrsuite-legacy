<?php
?>

<div class="container" id="leavecon">
  <input type="text" hidden="true" id="leave-page" value="<?php echo $leavesv2_page; ?>">

  <br />
  <div class="row">
    <div class="col-md-3 pull-right">
      <a href="#" class="col-md-12 flat-btn orange" id="show-leave-form-btn">Leave Application Form</span></a>
    </div>
  </div>

  <h3 class="pg-heading">Currently On-Leave Employees</h3><span class="pg-sub-heading">All employees that are permitted to have a leave on this day.</span>
  <hr>

  <!-- <a href="leavesv2/test_send_email">Test Send Email</a> -->

  <!-- wrapper for the currently leave table -->
  <div class="row" id="leave-current-container">
    
    <div class="col-md-12">

          <?php
            if($onleaves != 0){
              /* display the table and iterate through the records */
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

                  <tbody>

                          <?php
                            $cnt = 0;
                              foreach ($onleaves as $leaves) {
                                $cnt ++;
                          ?>

                          <tr class="small tbl-row" id="leaveid-<?php echo $leaves->id; ?>">
                             
                              <td>
                                <strong><?php echo $leaves->emp_name; ?></strong>
                                <br />
                                <?php echo $leaves->reason; ?>
                              </td>

                              <td>
                                <?php echo $leaves->datefrom; ?>
                                <br />
                                <?php echo $leaves->timefrom; ?>
                              </td>

                              <td>
                                <?php echo $leaves->dateto; ?>
                                <br />
                                <?php echo $leaves->timeto; ?>
                              </td>

                              <td><?php echo $leaves->duration; ?></td>
                            
                              <td><?php echo $leaves->leave_type; ?></td>

                              <td><?php echo $leaves->reliever; ?></td>
                             
                          </tr>

                          <?php
                              }
                          ?>      
                  </tbody>
              </table>
          <?php
            }else{
              /* display the error message*/
              echo "<div class='alert alert-danger' role='alert'>No record in the database</div>";
            }

          ?>
          

          <br />
          <br />
    </div>
  </div>


  <!-- wrapper for the leave form -->
  <div class="row" id="leave-form-container">
    <h3>Leave Application Form</h3>
    <hr>

    <div class="col-md-7 leave-forms">
      <form id="leaveform">

        <div class="row leave-form-row">
          <div class="col-md-6 no-l-pads">
            <label>Name of Employee</label> 
            <br />
            <input type="text" class="col-md-12 auto-sugg" placeholder="Employee Name" id="emp-name" name="emp-name">
            <input type="hidden" id="sel-emp-id" name="sel-emp-id" placeholder="emp id">
            <input type="hidden" id="emp-dept-id" name="emp-dept-id">
            <input type="hidden" id="emp-dept" name="emp-dept">
          </div>

          <div class="col-md-6 no-l-pads">
            <label>Reliever</label>
            <br />
            <input type="text" class="col-md-12 auto-sugg" placeholder="Reliever" id="reliever" name="reliever">
          </div> 
        </div>

        <div class="row leave-form-row" >
          <div class="col-md-6 no-l-pads">
            <label>Date From</label>
            <br />
            <input type="text" class="col-md-12 datetimepicker" placeholder="Starting Date" id="date-from" name="date-from">
            <input type="hidden" class="col-md-12 " id="dt-from" name="dt-from">
          </div>
          
          <div class="col-md-2 no-l-pads">
            <label>Time</label>
            <br />
            <input type="text" class="col-md-12 timepicker" placeholder="00:00 AM" id="time-from" name="time-from">
            <input type="hidden" class="col-md-12" id="tm-from" name="tm-from">
          </div>      
        </div>

        <div class="row leave-form-row">
          <div class="col-md-6 no-l-pads">
            <label>Date To</label>
            <br />
            <input type="text" class="col-md-12 datetimepicker" placeholder="Until When" id="date-to" name="date-to">
            <input type="hidden" class="col-md-12 " id="dt-to" name="dt-to">
          </div>
          
          <div class="col-md-2 no-l-pads">
            <label>Time</label>
            <br />
            <input type="text" class="col-md-12 timepicker" placeholder="00:00 PM" id="time-to" name="time-to">
            <input type="hidden" class="col-md-12" id="tm-to" name="tm-to" >
          </div>

          <div class="col-md-4 no-l-pads">
            <label>Duration (in days)</label>
            <br />
            <input type="text" class="col-md-12 text-center" placeholder="0" id="leave-duration" name="leave-duration">
          </div>  
        </div>

        <div class="row leave-form-row">
          <div class="col-md-12 no-l-pads">
            <label>Reason</label> 
            <br />
            <input type="text" class="col-md-12" placeholder="Leave Reason" name="leave-reason" id="leave-reason">
          </div>
        </div>

        <div class="row leave-form-row">
          <div class="col-md-6 no-l-pads">
            <label>Leave Type</label> 
            <br />
            <select class="col-md-11" id="leave-type" name="leave-type">
              <option value="">SELECT A LEAVE TYPE</option>
              <option value="VACATION">VACATION</option>
              <option value="SICK">SICK</option>
              <option value="EMERGENCY">EMERGENCY</option>
              <option value="MATAERNITY/PATERNITY">MATERNITY / PATERNITY</option>
              <option value="BIRTHDAY">BIRTHDAY</option>
              <option value="UNDERTIME">UNDERTIME</option>
              <option value="COMPANY LEAVE">COMPANY LEAVE</option>
              <option value="OTHERS">OTHERS</option>
            </select>
          </div>

          <div class="col-md-2 no-l-pads">
            <label>With Pay</label>
            <br />
            <input type="text" class="col-md-12 text-center" placeholder="0" id="w-pay" name="w-pay">
          </div>  

          <div class="col-md-3 no-l-pads">
            <label>Without Pay</label>
            <br />
            <input type="text" class="col-md-7 text-center" placeholder="0" id="wo-pay" name="wo-pay">
          </div>  

        </div>

        <br />
        <br />
        <div class="row leave-form-row">
          <div class="col-md-6 no-l-pads">
            <!-- <input type="submit" id="submit-leave" value="Submit Application" class="col-md-6 flat-button"> -->
            <button type="button"  id="submit-leave" name="submit-leave" class="col-md-6 flat-button" value="submit">Submit Application <span class="glyphicon glyphicon-send"></span></button>
          </div>
          <!-- <div class="col-md-6 no-l-pads">
            <input type="submit" id="submit-leave" value="SUBMIT APPLICATION" class="col-md-6 flat-button">
          </div> -->
        </div>
      </form>
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-4">
      <div class="row col-condensed ">
        <div class="col-md-6 bal-wrapper">
          <h5 class="text-center">Remaining Balance</h5><p id="rem-bal-cnt" class="text-center bal-cnt"></p>
        </div>
        
        <div class="col-md-6 bal-wrapper">
          <h5 class="text-center">Calculated Balance</h5><p id="calc-bal-cnt" class="text-center bal-cnt"></p>
        </div>
      </div>

      <br />
      <br />
      <div class="row col-condensed ">
       
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Leave Application Reminders</h3>
          </div>
          <div class="panel-body">
            <li>This is a test reminder</li>
            <li>This is a test reminder</li>
            <li>This is a test reminder</li>
            <li>This is a test reminder</li>
            <li>This is a test reminder</li>
          </div>
        </div>
        
      </div>
    </div>
  </div>

	


</div>



