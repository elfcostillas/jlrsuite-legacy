
    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy; 2012 &bull; JLR Construction and Aggregates Inc. &bull; Ralph</p>
      </div>
    </footer>
</body>


  <script type="text/javascript">
    /*

    */
    
    $('#show-leave-form-btn').click(function(){
      
      //hide the currently leave wrapper
      $('#leave-current-container').css({"display": "none"});

      //show the leave application form
      $('#leave-form-container').css({"display": "block"});

      //hide the button
      $(this).css({"display": "none"});
      return false;
    });

    $('.view-remarks-btn').click(function(){

      var leave_id = $(this).attr('id');

      //ajax here
      $.ajax({
             type: "POST",
             url: "ajax_get_leave_remarks",
             data: "leave-id="+leave_id,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    var json = JSON.parse(data);

                    var sup_remarks = json[0].sup_remarks;
                    var mngr_remarks =json[0].mngr_remarks;

                    if(sup_remarks === null){
                      sup_remarks = '--';
                    }

                    if(mngr_remarks === null){
                      mngr_remarks = '--';
                    }

                    swal({  
                      title: 'Leave Remarks', 
                      text: "Supervisor : <span class='remarks-hylit'>"+sup_remarks+"</span> <br /> Manager : <span class='remarks-hylit'>"+mngr_remarks+"</span>",   
                      html: true,
                      timer: 3000,   
                      showConfirmButton: true
                    });

                  }
      });

      
    });



    /*
      ---------> Scripts for the Interval Pooling/Notification
    */

    function doPoll(){
          var cnt = 0;
          var id_arr = [];

          var logged_emp_id = parseInt($('#emp-id').val());
          var logged_emp_lvl = parseInt($('#emp-lvl').val());

          $("#leave-app-table > tbody > tr").each(function() {
            $this = $(this);

            //get id
            var ids = $this.attr('id');
            var id_split = ids.split('-');

            id_arr[cnt] = id_split[1];

            cnt ++;
          });

          var json_ids = JSON.stringify(id_arr);

          //ajax request

          $.ajax({
           type: "POST",
           url: "ajax_get_new_apps",
           data: "emp-id="+logged_emp_id+"&app-ids="+json_ids,
           dataType: "text",
           cache:false,
           success:
                function(data){
                  if(data != 'none'){
                    var json = JSON.parse(data);
                    var json_obj_cnt = Object.keys(json).length;

                    var leave_count = parseInt($('#noty-counter').text());
                    var new_count = leave_count + json_obj_cnt; 
                    //$('#noty-counter').text(new_count);

                    //add the count to the notification counter

                    // for ( var i = 0; i < json_obj_cnt; i++)
                    // {
                    //     $('#leave-app-table')
                    //       .prepend($('<tr>')
                    //         .attr('class', 'small tbl-row fade-notif')
                    //         .attr('id', 'leaveid-'+json[i].id)
                    //           .append($('<td>'+ json[i].emp_name +'<br />'+ json[i].reason +'</td>'))
                    //           .append($('<td>'+ json[i].datefrom +'<br />'+ json[i].timefrom +'</td>'))
                    //           .append($('<td>'+ json[i].dateto +'<br />'+ json[i].timeto +'</td>'))
                    //           .append($('<td>')
                    //             .text('0')
                    //           )
                    //           .append($('<td>')
                    //             .text(json[i].leave_type)
                    //           )
                    //           .append($('<td>')
                    //             .text(json[i].reliever)
                    //           )
                    //           .append($('<td>')
                    //             .append($('<a>')
                    //               .attr('class', 'flat-btn green leave-app-approve-but')
                    //               .attr('id', json[i].id)
                    //               .attr('href', '#')
                    //               .append($('<i>')
                    //                 .attr('class', 'fa fa-thumbs-o-up fa-lg')
                    //               )
                    //             )
                    //             .append($('<a>')
                    //               .attr('href', '#')
                    //               .attr('class', 'flat-btn red leave-app-unapprove-but')
                    //               .attr('id', json[i].id)
                    //               .append($('<i>')
                    //                 .attr('class', 'fa fa-thumbs-o-down fa-lg')
                    //               )
                    //             )
                    //           )



                    //           //.append($('<td><a href='#' class="flat-btn green leave-app-sup-approve" id='+json[i].id+'><i class="fa fa-thumbs-o-up fa-lg"></i></a></td>'))
                    //     );
                    // }
                  }
                  
                  
                }
          });

          setTimeout(doPoll,10000);
    };

    var page = $('#leave-page').val();
    if(page === 'leave-app'){
      doPoll();
    }
      




    /*
      ---------> Scripts for the Leave application page
    */

    $("tbody").on('click','.leave-app-approve-but',function(){


      var leave_id = $(this).attr('id');
      var approver = $("tbody").attr('id');
      var approver_id = $("#emp-id").val();

      swal({
          title: "Are you sure?",
          text: "To approved this leave application.",
          type: "info",
          confirmButtonText: "Okay",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Approved it!",
          cancelButtonText: "No!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {

            //ajax approved here
            $.ajax({
             type: "POST",
             url: "ajax_approved_leave",
             data: "leave-id="+leave_id+"&leave-approver="+approver+"&approver-id="+approver_id,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){
                      swal({
                        title: "Approved!",
                        text: "the leave application has been successfully approved.",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });

                      if(approver === 'supervisor'){
                        //$("tr#leaveid-"+leave_id).removeClass( "active" ).addClass("leave-recommended");
                        $("tr#leaveid-"+leave_id).alterClass('leave-*','leave-recommended');
                      }else{
                        //$("tr#leaveid-"+leave_id).removeClass( "active" ).addClass("leave-approved");
                        $("tr#leaveid-"+leave_id).alterClass('leave-*','leave-approved');
                      }
                      
                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });
          }
        }
      );
    });


    $("tbody").on('click','.leave-app-unapprove-but',function(){


      var leave_id = $(this).attr('id');
      var approver = $("tbody").attr('id');
      var approver_id = $("#emp-id").val();

      swal({
          title: "Are you sure?",
          text: "To Deny this leave application.",
          type: "info",
          confirmButtonText: "Okay",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Deny it!",
          cancelButtonText: "No!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {

            //ajax approved here
            $.ajax({
             type: "POST",
             url: "ajax_deny_leave",
             data: "leave-id="+leave_id+"&leave-approver="+approver+"&approver-id="+approver_id,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){
                      swal({
                        title: "Denied!",
                        text: "the leave application has been successfully denied.",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });
                      //$("tr#leaveid-"+leave_id).removeClass( "active" ).addClass("leave-denied");
                      $("tr#leaveid-"+leave_id).alterClass('leave-*','leave-denied');
                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });

          }
        }
      );
    });


    $("tbody").on('click','.leave-app-remarks-but',function(){


      var leave_id = $(this).attr('id');
      var approver = $("tbody").attr('id');
      var approver_id = $("#emp-id").val();

      /*swal({
          title: "Are you sure?",
          text: "To Deny this leave application.",
          type: "info",
          confirmButtonText: "Okay",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Deny it!",
          cancelButtonText: "No!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {

            //ajax approved here
            $.ajax({
             type: "POST",
             url: "ajax_deny_leave",
             data: "leave-id="+leave_id+"&leave-approver="+approver+"&approver-id="+approver_id,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){
                      swal({
                        title: "Denied!",
                        text: "the leave application has been successfully denied.",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });
                      //$("tr#leaveid-"+leave_id).removeClass( "active" ).addClass("leave-denied");
                      $("tr#leaveid-"+leave_id).alterClass('leave-*','leave-denied');
                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });

          }
        }
      );*/
      swal({
        title: "Leave Remarks",   
        text: "Any notes for this leave application? please write it down.",   
        type: "input",   
        showCancelButton: true,   
        closeOnConfirm: false,   
        animation: "slide-from-top",   
        inputPlaceholder: "remarks here" 
      }, 
      function(inputValue){   
        if (inputValue === false) return false;      
        if (inputValue === "") {     
          swal.showInputError("You need to write something!");     
          return false   
        }

        var leave_remarks = inputValue;
        //ajax the remarks here
        $.ajax({
             type: "POST",
             url: "ajax_set_leave_remarks",
             data: "leave-id="+leave_id+"&leave-approver="+approver+"&leave-remarks="+leave_remarks,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){
                      swal({
                        title: "Successfull!",
                        text: "Your remark has been added to the leave application",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });
                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });

        //then timed alert for confirmation of the remarks successful record
        //alert(inputValue);
        //swal("Nice!", "You wrote: " + inputValue, "success"); 
      });

    });




    /*
      ---------> Scripts for the Form Validation/checking of details
    */

    function validateForm(){
      var res = 18;
        $('#leaveform').find('input,select').each(function(){
            if (this.value === ''){
              res ++ ;
            }else{
              res --;
            }
        });

        console.log(res);

        if (res == 0){
          return true;
        }else{
          return false;
        }
    };

    function validateMassLeaveForm(){
      var res = 13;
        $('#form-massleave').find('input,select').each(function(){
            if (this.value === ''){
              res ++ ;
            }else{
              res --;
            }
        });

        console.log(res);

        if (res == 0){
          return true;
        }else{
          return false;
        }
    };

    $('#leave-duration').keyup(function(){
        
      var duration = parseFloat($(this).val());  
      var rembal = parseFloat($('#rem-bal-cnt').text());
      
      if(duration){
        //get remaining balance
        //compare duration to remaining balance
        if(duration <= rembal){
          //all with pay
          $('#w-pay').val(duration);
          $('#wo-pay').val('0');

        }else if(duration > rembal){
          //with and without pay
          var cal_wopay = duration - rembal;

          $('#w-pay').val(rembal);
          $('#wo-pay').val(cal_wopay);
        }
        var calc_bal = rembal - $('#w-pay').val();
        $('#calc-bal-cnt').text(calc_bal);
      }else{
        $('#w-pay').val('0');
        $('#wo-pay').val('0');
      }
    });



    $("#submit-leave").click(function(){
      if(validateForm()){
          swal({
            title: "Are you sure?",
            text: "You want to submit this leave application.",
            type: "warning",
            confirmButtonText: "Okay",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, submit it!",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              

              $.ajax({
               type: "POST",
               url: "leavesv2/ajax_submit_leave",
               data: $('#leaveform').serialize(),
               dataType: "text",
               cache:false,
               success:
                    function(data){
                      if(data > 0){
                        swal({
                          title: "Successfull!",
                          text: "Leave application submitted.",
                          type: "success",
                          timer: 1500,
                          showConfirmButton: false
                        });
                        //clear the data on the form
                        $("#leaveform input[type=text]").val('');
                      }
                    }
                });// you have missed this bracket
              return false
            }
          }
          );
      }else{
          sweetAlert("Oops...", "Cannot accept blank information. Fill it up properly!", "error");
      }
    });


    // MASS LEAVE submit button script here
    $("#massleave-submit-btn").click(function(){
      if(validateMassLeaveForm()){
          swal({
            title: "Are you sure?",
            text: "You want to submit this leave application.",
            type: "warning",
            confirmButtonText: "Okay",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, submit it!",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              
                
              $.ajax({
               type: "POST",
               url: "ajax_insert_massleave",
               data: $('#massleave-form').serialize(),
               dataType: "text",
               cache:false,
               success:
                    function(data){
                       swal({
                        title: "Successfull!",
                        text: "Mass Leave submitted.",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });
                      //clear the data on the form
                      //$("#leaveform input[type=text]").val('');
                    }
                });
              return false
            }
          }
          );
      }else{
          sweetAlert("Oops...", "Cannot accept blank information. Fill it up properly!", "error");
      }
    });





    /*
      ---------> Scripts for the Auto suggestions
    */

    $('.auto-sugg#emp-name').autocomplete({
        minChars:2,
        serviceUrl: 'leavesv2/ajax_get_employee',
        onSelect: function (suggestion) {
            $("#emp-name").val(suggestion.value);
            $("#sel-emp-id").val(suggestion.data);

            //get the dept_id and dept name via ajax
            $.ajax({
             type: "GET",
             url: "leavesv2/ajax_get_emp_dept",
             data: "emp_id="+suggestion.data,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    var json = JSON.parse(data);
                    $("#emp-dept-id").val(json[0].dept_id);
                    $("#emp-dept").val(json[0].dept);
                  }
            });

            // get the remaining credits for the selected employee
            $.ajax({
             type: "GET",
             url: "leavesv2/ajax_get_emp_balance",
             data: "emp_id="+suggestion.data,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    
                    $("#rem-bal-cnt").text(data);
                    $("#calc-bal-cnt").text(data);
                  }
            });
        }
    });

    $('.auto-sugg#reliever').autocomplete({
        minChars:2,
        serviceUrl: 'leavesv2/ajax_get_employee',
        onSelect: function (suggestion) {
            $("#reliever").val(suggestion.value);
        }
    });

    




    /*
      ---------> Scripts for the Date and Time manipulation/checking
    */

    $('.datetimepicker#date-from').datetimepicker({
      format:'l - F d, Y',
      timepicker:false,
      onSelectDate:function(ct,$i){
        
          $('#dt-from').val(ct.dateFormat('Y-m-d'));

          var date_from = moment($('#dt-from').val()).format('YYYY-MM-D');
          var date_file = moment().add(3,'days').format('YYYY-MM-D');

          /*if(moment(date_from).isAfter(date_file) || moment(date_from).isSame(date_file)){
            //do nothing
          }else{
            //clear the datepicker and prompt
            $('.datetimepicker#date-from').val('');
            $('#dt-from').val('');

            sweetAlert("Invalid", "You must file a leave 3 days in advance prior to the starting date", "error");

          }*/
        
      }
    });

    $('.datetimepicker#date-to').datetimepicker({
      format:'l - F d, Y',
      timepicker:false,
      onSelectDate:function(ct,$i){
        $('#dt-to').val(ct.dateFormat('Y-m-d'));

        //compare date from and date to here
        var date_from = moment($('#dt-from').val()).format('YYYY-MM-D');
        var date_to = moment($('#dt-to').val()).format('YYYY-MM-D');

        if(moment(date_to).isAfter(date_from) || moment(date_from).isSame(date_to)){
          //do nothing
        }else{
          //clear the datepicker and prompt
          $('.datetimepicker#date-to').val('');
          $('#dt-to').val('');

          sweetAlert("Invalid", "Date range not correct", "error");

        }
      }
    });

    $('.timepicker#time-from').datetimepicker({
      format:'g:i A',
      datepicker:false,
      onChangeDateTime:function(ct,$i){
        if(ct !== null){
          $('#tm-from').val(ct.dateFormat('H:i:s'));
        }
      }
    });

    $('.timepicker#time-to').datetimepicker({
      format:'g:i A',
      datepicker:false,
      onChangeDateTime:function(ct,$i){
         if(ct !== null){
            $('#tm-to').val(ct.dateFormat('H:i:s'));
         }
      }
    });

    $('.datepicker').datetimepicker({
      timepicker:false,
      format:'Y-m-d'
    });

    // Mass leave dates
    $('.datetimepicker#date-from-mass').datetimepicker({
      format:'l - F d, Y',
      timepicker:false,
      onSelectDate:function(ct,$i){
        $('#dt-from-mass').val(ct.dateFormat('Y-m-d'));
      }
    });

    // Mass leave dates
    $('.datetimepicker#date-to-mass').datetimepicker({
      format:'l - F d, Y',
      timepicker:false,
      onSelectDate:function(ct,$i){
        $('#dt-to-mass').val(ct.dateFormat('Y-m-d'));
      }
    });



    /*
        --------------------  test script codes only

    */

      $('#test-swal').click(function(){
        swal({   
          title: "An input!",   
          text: "Write something interesting:",   
          type: "input",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          animation: "slide-from-top",   
          inputPlaceholder: "Write something" 
        }, 
        function(inputValue){   
          if (inputValue === false) return false;      
          if (inputValue === "") {     
            swal.showInputError("You need to write something!");     
            return false   
          }      
          swal("Nice!", "You wrote: " + inputValue, "success"); 
        });
      });


      /*
        SCRIPTS FOR MASS LEAVE PAGE
      */  

      $('#deptlist-wrapper').ready(function() {
        
        //iterate through the inputs
        $('input.we').each(function(index, value){
            var deptid = $(this).val();
            var dept = $(this).attr('id');
            
            //ajax get the name of the employees
            $.ajax({
             type: "GET",
             url: "ajax_get_employee_by_dept",
             data: "deptid="+deptid,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    var json = JSON.parse(data);
                    var json_obj_cnt = Object.keys(json).length;

                    $('div#'+dept+'-dept-wrapper h3').append('<a href="#" id="' + dept + '" class="empcount-toggle" >' + json_obj_cnt + '</href>');

                    for(i = 0; i < json_obj_cnt; i++) {
                      var name = json[i].name;
                      var emp_id = json[i].emp_id;
                      
                      $('div#'+dept+'.dept-emp-list').append('<li><input type="checkbox" name="massleave-cbox[]" id="' + emp_id + '" value="' + emp_id + '" class="css-checkbox ' + dept + '-cb" /><label for="' + emp_id + '" class="css-label">' + name + '</label></li>');
                    }
                  }
            });      
        });
      });
      
    
    $('.massleave-cb').change(function(){
      var dept = $(this).attr('name');
      
      $('.' + dept + '-cb').prop('checked', $(this).prop('checked'));
    });

    $('.dept-emp-list').hide();

    $("#deptlist-wrapper").on('click','.empcount-toggle',function(){
      var dept = $(this).attr('id');
       $('#' + dept + '.dept-emp-list').toggle();
    });

    

    /*
      LEAVE RECORD SCRIPTS
    */


    $('.leave-record-filter').change(function(){
      var sel = $(this).val();
      var sel_id = $(this).attr('id');

      //clear all the values of the other filters
      $('.leave-record-filter').val('');
      $(this).val(sel);


      //alert(sel + ' --------- ' + sel_id);
      
      //do an ajax request and return a json result
      $.ajax({
       type: "POST",
       url: "ajax_get_leave_records",
       data: "type="+sel_id+"&value="+sel,
       dataType: "text",
       cache:false,
       success:
            function(data){

              //console.log(data);
               var json = JSON.parse(data);
               var json_obj_cnt = Object.keys(json).length;

               console.log(data);
               $('#leave-app-table tbody#leave-records').empty();

              for ( var i = 0; i < json_obj_cnt; i++)
                    {
                        $('#leave-app-table tbody#leave-records')
                          .prepend($('<tr>')
                            .attr('class', 'small tbl-row fade-notif')
                            .attr('id', 'leaveid-'+json[i].id)
                              .append($('<td>'+ json[i].emp_name +'<br />'+ json[i].reason +'</td>'))
                              .append($('<td>'+ json[i].datefrom +'<br />'+ json[i].timefrom +'</td>'))
                              .append($('<td>'+ json[i].dateto +'<br />'+ json[i].timeto +'</td>'))
                              .append($('<td>')
                                .text('0')
                              )
                              .append($('<td>')
                                .text(json[i].leave_type)
                              )
                              .append($('<td>')
                                .text(json[i].reliever)
                              )
                          )
                    }
            }
      });

      
    });

  /* Leave status script */

  $('#testid-only').ready(function() {
    var emp_id = $("#emp-id").val();
    //console.log(emp_id);
    //ajax call here

      //do an ajax request and return a json result
      $.ajax({
       type: "POST",
       url: "ajax_get_leave_status",
       data: "emp-id="+emp_id+"&leave-status="+status,
       dataType: "text",
       cache:false,
       success:
            function(data){

              //console.log(data);
               var json = JSON.parse(data);
               var json_obj_cnt = Object.keys(json).length;

               console.log(json_obj_cnt);
               $('#leave-status-table tbody#leave-status-recs').empty();

              for ( var i = 0; i < json_obj_cnt; i++){
                      var leave_class = '';
                      var status = json[i].mngr_app;
                      switch(status){
                        case 'PENDING':
                          if (json[i].sup_app == 'APPROVED') {
                            leave_class = 'leave-recommended';
                          }else{
                            leave_class = 'leave-pending';
                          }
                          break;
                        case 'APPROVED':

                          leave_class = 'leave-approved';
                          break;
                        case 'UNAPPROVED':
                          leave_class = 'leave-denied';
                          break;
                      }

                        $('#leave-status-table tbody#leave-status-recs')
                          .prepend($('<tr>')
                            .attr('class', leave_class + ' small tbl-row fade-notif')
                            .attr('id', 'leaveid-'+json[i].id)
                              .append($('<td>'+ json[i].emp_name +'<br />'+ json[i].reason +'</td>'))
                              .append($('<td>'+ json[i].datefrom +'<br />'+ json[i].timefrom +'</td>'))
                              .append($('<td>'+ json[i].dateto +'<br />'+ json[i].timeto +'</td>'))
                              .append($('<td>')
                                .text('0')
                              )
                              .append($('<td>')
                                .text(json[i].leave_type)
                              )
                              .append($('<td>')
                                .text(json[i].reliever)
                              )
                          )
              }
            }
      });
  });


  /*    LEAVE CREDIT SCRIPTS    */

  $("#leave-credits-table").on('click','.credit-update-btn',function(){
      var credit_id = $(this).parent().parent().attr('id');
      var credit_value = $(this).parent().prev().children('input').val();

      var $credit_box = $(this).parent().prev().children('input');

      swal({
          title: "Are you sure?",
          text: "To update this leave credit",
          type: "info",
          confirmButtonText: "Okay",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Update it!",
          cancelButtonText: "No!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {

            //ajax approved here
            $.ajax({
             type: "POST",
             url: "ajax_update_credit",
             data: "credit-id="+credit_id+"&credit-value="+credit_value,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){
                      swal({
                        title: "Approved!",
                        text: "the selected leave credit is updated carefully",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });

                      //lock the credit value box
                      $credit_box.attr('disabled',true);
                      
                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });
          }
        }
      );

  });

  $("#leave-credits-table").on('click','.credit-edit-btn',function(){
    //to be research
    $(this).parent().prev().children('input').attr('disabled',false);
  });
    
  </script>

</html>