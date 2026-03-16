<?php

// var_dump($lvl);
?>

<div class="container" id="leavecon">
	<br/>




  <div class="row">

    <input type="text" hidden="true" id="leave-page" value="<?php echo $leavesv2_page; ?>">
    <h3 class="col-md-6">Leave Application</h3>
    <ul class="pull-right col-md-5 list-inline" id="leave-app-legend">
      <li class="leave-pending"><i class="fa fa-file-text-o"></i> Pending <span>(<?php echo $leave_apps_pending ?>)</span></li>
      <li class="leave-recommended"><i class="fa fa-share-square-o"></i> Recommended</li>
      <li class="leave-approved"><i class="fa fa-thumbs-o-up"></i> Approved <span>(<?php echo $leave_apps_approved ?>)</span></li>
      <li class="leave-denied"><i class="fa fa-thumbs-o-down"></i> Denied <span>(<?php echo $leave_apps_denied ?>)</span></li>
    </ul>

  </div>

  <div class="clearfix"></div>
  <hr>

  <div class="row">
        <div class="col-md-12">

          <?php
            if($leave_apps != 0){
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
                          <th>Action</th>
                      </tr>
                  </thead>

                  <tbody id="<?php echo $leave_approver; ?>">

                          <?php

                          

                            $cnt = 0;
                              foreach ($leave_apps as $leaves) {

                                $cnt ++;

                                switch ($leave_approver) {
                                  case 'manager':
                                    $leave_app_status = $leaves->mngr_app;
                                    break;
                                  
                                  case 'supervisor':
                                    $leave_app_status = $leaves->sup_app;
                                    break;
                                }


                                //for supervisor approver
                                if( $leave_approver == 'supervisor' AND $leaves->sup_app == 'PENDING' AND $leaves->mngr_app == 'PENDING'){
                                  $tr_class = "leave-pending";
                                }

                                else if($leave_approver == 'supervisor' AND $leaves->sup_app == 'APPROVED' AND $leaves->mngr_app == 'PENDING'){
                                  $tr_class = "leave-recommended";
                                }

                                else if($leave_approver == 'supervisor' AND $leaves->sup_app == 'APPROVED' AND $leaves->mngr_app == 'UNAPPROVED'){
                                  $tr_class = "leave-denied";
                                }

                                else if($leave_approver == 'supervisor' AND $leaves->sup_app == 'APPROVED' AND $leaves->mngr_app == 'APPROVED'){
                                  $tr_class = "leave-approved";
                                }

                                else if($leave_approver == 'supervisor' AND $leaves->sup_app == 'UNAPPROVED'){
                                  $tr_class = "leave-denied";
                                }

                                //for manager approver
                                if( $leave_approver == 'manager' AND $leaves->sup_app == 'PENDING' AND $leaves->mngr_app == 'PENDING'){
                                  $tr_class = "leave-pending";
                                }

                                else if($leave_approver == 'manager' AND $leaves->sup_app == 'APPROVED' AND $leaves->mngr_app == 'PENDING'){
                                  $tr_class = "leave-recommended";
                                }

                                else if($leave_approver == 'manager' AND ($leaves->sup_app == 'UNAPPROVED' OR $leaves->mngr_app == 'UNAPPROVED')){
                                  $tr_class = "leave-denied";
                                }

                                else if($leave_approver == 'manager' AND $leaves->sup_app == 'APPROVED' AND $leaves->mngr_app == 'APPROVED'){
                                  $tr_class = "leave-approved";
                                }

                                else if($leave_approver == 'manager' AND $leaves->sup_app == 'PENDING' AND $leaves->mngr_app == 'APPROVED'){
                                  $tr_class = "leave-approved";
                                }
                          ?>

                          <tr class="<?php echo $tr_class ?> small tbl-row" id="leaveid-<?php echo $leaves->id; ?>">
                             
                              <td>
                                <!-- <div class="remarks-but-disp">
                                  <a title="Remarks" href="#" class="flat-btn yellow view-remarks-btn" id="<?php echo $leaves->id; ?>">
                                    <i class="fa fa-comment-o fa-lg"></i>
                                  </a>
                                </div> -->
                                <div class="empleave-wrap">
                                  <strong><?php echo $leaves->emp_name; ?></strong>
                                  <br />
                                  <?php echo $leaves->reason; ?>
                                </div>
                                
                                
                              </td>
                              <!-- <td><?php echo $leaves->reason; ?>

                              </td> -->

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

                              <td>
                                <span class="duration">
                                  <?php echo $leaves->duration; ?>
                                </span>
                                
                              </td>
                            
                              <td><?php echo $leaves->leave_type; ?></td>

                              <td><?php echo $leaves->reliever; ?></td>
                              
                              <td>
                                <?php
                                  $hidder = '';

                                  //get the dept_id of the leave and check if it has a supervisor
                                  //if none then override by the managers approval
                                  if($leave_approver == 'manager'){
                                    if($this->leaves_model2->check_ifhas_supervisor($leaves->dept_id)){
                                      if($leave_approver == 'supervisor' AND ($leaves->mngr_app == 'APPROVED' OR $leaves->mngr_app == 'UNAPPROVED')){
                                        //do not display for the supervisor
                                        $hidder = 'but-hide';
                                      }else if($leave_approver == 'supervisor' AND $leaves->mngr_app == 'PENDING'){
                                        $hidder = '';
                                      }else if($leave_approver == 'manager' AND ($leaves->sup_app == 'PENDING' OR $leaves->sup_app == 'UNAPPROVED')){
                                        $hidder = 'but-hide';
                                      }else{
                                        $hidder = '';
                                      }
                                    }else{
                                      $hidder = '';
                                    }

                                  }

                                ?>
                                <a title="Remarks" href="#" class="flat-btn test view-remarks-btn" id="<?php echo $leaves->id; ?>">
                                  <i class="fa fa-comment-o fa-lg"></i>
                                </a>
                                <a title="Add Remark" href="#" class="flat-btn blue leave-app-remarks-but <?php echo $hidder; ?>" id="<?php echo $leaves->id; ?>"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                <a title="Approve Application" href="#" class="flat-btn green leave-app-approve-but <?php echo $hidder; ?>" id="<?php echo $leaves->id; ?>"><i class="fa fa-thumbs-o-up fa-lg"></i></a>
                                <a title="Deny Application" href="#" class="flat-btn red leave-app-unapprove-but <?php echo $hidder; ?>" id="<?php echo $leaves->id; ?>"><i class="fa fa-thumbs-o-down fa-lg"></i></a>
                                
                              </td>
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
          <br />
          <br />
        </div>
  </div>

  




</div>



