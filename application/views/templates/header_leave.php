<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	

	<title><?php echo $title; ?> </title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

  <!-- Favicon -->
  <link rel="shorvut icon" href='<?php echo base_url("css/images/favicon.ico") ?>'>

  <!-- Stylesheets for Leave -->
  <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/main.css") ?>' />
  <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/leave.css") ?>' />
  <link rel='stylesheet' type='text/css' media="print" href='<?php echo base_url("css/print.css") ?>' />
  <link rel="stylesheet" type="text/css" href='<?php echo base_url("css/smoothness/jquery-ui-1.8.23.custom.css") ?>' />
  <link rel="stylesheet" type="text/css" href='<?php echo base_url("css/jquery.timepicker.css") ?>' />
  <link rel="stylesheet" type="text/css" href='<?php echo base_url("css/validationEngine.jquery.css") ?>' />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />


  <!-- Scripts for Leave -->
  <script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/main.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.23.custom.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine-en.js") ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine.js") ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>


<script type="text/javascript">
		function showDays() {
		    var start = $('#inclusivefrom_picker').datepicker('getDate');
		    var end = $('#inclusiveto_picker').datepicker('getDate');
		    if (!start || !end) return;
		    var days = (end - start) / 1000 / 60 / 60 / 24;
		    if (days<0)
			  {			
			  	$('#remarks').show();	  	
			  	$.datepicker._clearDate('#inclusivefrom_picker');
			  	$('#inclusiveto_picker').datepicker("disable");
			  	$.datepicker._clearDate('#inclusiveto_picker');
			  	$('#remarks').delay(2000).fadeOut();				 
			  }
		}

		function enableDepdate() {
		    $('#inclusiveto_picker').datepicker("enable");
		}

		$(function(){
			$('#remarks').hide();
			$('#num_nights').hide();
			// Datepicker
			$('#datefiled_picker').datepicker({ dateFormat: 'yy-mm-dd' });
			$('#inclusivefrom_picker').datepicker({ dateFormat: 'yy-mm-dd',onSelect: enableDepdate });
			$( "#inclusiveto_picker" ).datepicker({ disabled: true, dateFormat: 'yy-mm-dd',onSelect: showDays });	
		});
</script>

<script type="text/javascript">
  $(document).ready(function () {

                    //this is the leave header
              	    $('.timeinput').timepicker({ 'timeFormat': 'HH:mm', 'step': 15});

              	    $("#submenu").hide();
                  	$("#option").click(function () {
            				      $("#submenu").slideToggle(300);
            				});



                  	$('#approve-pending').fancybox({
                  		'width'     : '80%',
                			'height'    : '80%',
                			'scrolling' : 'auto'
                  	});

                    //FANCYBOXES scripts
                    $(".edit-leave-records").fancybox({
              
                      fitToView : false,
                      width   : '60%',
                      height    : '40%',
                      autoSize  : false,
                      closeClick  : false,
                      openEffect  : 'none',
                      closeEffect : 'none'
                    });

                    $("#mass-leave-but").fancybox({
                      fitToView : false,
                      width   : '80%',
                      height    : '80%',
                      autoSize  : false,
                      closeClick  : false,
                      openEffect  : 'none',
                      closeEffect : 'none'
                    });

                

                  	$('.print').hide();
                  	$('#search_year_dropdown').hide();
                    $('#empname_search').change(function () {
                        $('#search_year_dropdown').show();
                    });

                    //Add Mass Leave Scripts
                    $('#massleave-datefiled').datepicker({ dateFormat: 'yy-mm-dd' });
                    $('#massleave-datefrom').datepicker({ dateFormat: 'yy-mm-dd' });
                    $('#massleave-dateto').datepicker({ dateFormat: 'yy-mm-dd' });
                  
                    $("#checkall").click(function () {
                      $('.chkitem').attr('checked', this.checked);
                    });

                    $(".chkitem").click(function(){
           
                        if($(".chkitem").length == $(".chkitem:checked").length) {
                            $("#checkall").attr("checked", "checked");
                        } else {
                            $("#checkall").removeAttr("checked");
                        }
                    });

                    //ADD LEAVE scripts
                    $('#addleave-wrapper').hide();
                    $('#addleave-credits-result').hide();

                 
                    $('#addleave_emp_name').change(function () {
                    	  var id = $(this).attr('value');
                        var year = $('#currentyear').attr('value');
                        $('#addleave-wrapper').fadeOut(200);
                      	$('#undertime-hours-wrapper').hide();
                      	$('#paytype-1').hide();
                      	$('#paytype-2').hide();
                      	$('#paytype-3').hide();

                        $.ajax({    
                            url: "get_leave_credits", //The url where the server req would we made.
                            async: false, 
                            type: "POST", //The type which you want to use: GET/POST
                            data: "id="+id+"&year="+year, //The variables which are going.
                            dataType: "html", //Return data type (what we expect).
                             
                            //This is the function which will be called if ajax call is successful.
                            success: function(data) {
                                //data is the html of the page where the request is made.
                               
                              		
                              			
                              			$('#addleave-credits-result').fadeIn(1000);
                              			
                              			$('#addleave-credits-result span').html(data);


                              			if (data === '0.00')
                              			{
                              				$('#addleave-wrapper').fadeIn(1000);
                              				$("#emp-credit-balance").val(data);

                              			}
                              			else
                              			{
                              				$('#addleave-wrapper').fadeIn(1000);
                              				$("#emp-credit-balance").val(data);
                              			}
                              		
                                
                            }
                    	  })
                    });

    				        $('#addleave_leavetype').change(function () {
                       var selValue = $(this).attr('value');
                       var creditBalance = $('#emp-credit-balance').attr('value');

                       if(selValue === 'undertime')
                       {
                       	$('#undertime-hours-wrapper').fadeIn(1000);
                       	$('#paytype-1').fadeOut(1000);
                       	$('#paytype-2').fadeOut(1000);
                       }
                       else if(selValue === '')
                       {
                       	$('#undertime-hours-wrapper').fadeOut(1000);
                       	$('#paytype-1').fadeOut(1000);
                       	$('#paytype-2').fadeOut(1000);

                       }
                       else
                       {
                       	$('#undertime-hours-wrapper').fadeOut(1000);
                       	$('#paytype-1').fadeIn(1000);
                       		//conditional here
                       		if(creditBalance === '0.00'){
                       			$('#paytype-1').hide();
                       			$('#paytype-3').fadeIn(1000);
                       			$('#paytype-3').fadeIn(1000);
                       			$('#addleave-nobalance').val("zerobalance");
                       			
                       		}
                       }
                    });

                    $('#addleave_paytype1').change(function () {
                       var selValue = $(this).attr('value');

                       if(selValue === 'with pay')
                       {
                       	$('#paytype-2').fadeIn(1000);
                       	//show the pay_type 2 with the selected pay_type which is without pay
                       	$('#addleave_paytype2').val('without pay');
                       }
                       else
                       {
                       	$('#paytype-2').fadeIn(1000);
                       	//show the pay_type 2 with the selected pay_type which is with pay
                       	$('#addleave_paytype2').val('with pay');
                       }
                    });


                    $('#year_dropdown').change(function () {
                        var selName = $('#empname_search').attr('value');
                        var test = $("#empname_search option:selected").text();
                        var selYear = $(this).attr('value');



                        $('#search-name').html(test);
                        $('#search-year').html(selYear);
                        

                        $.ajax({    
                            url: "ajax_employee_search", //The url where the server req would we made.
                            async: false, 
                            type: "POST", //The type which you want to use: GET/POST
                            data: "empname="+selName+"&year="+selYear, //The variables which are going.
                            dataType: "html", //Return data type (what we expect).
                             
                            //This is the function which will be called if ajax call is successful.
                            success: function(data) {
                                //data is the html of the page where the request is made.
                                $('#content_result').html(data);
                                $('.print').show();
                            }
                    	  })
                    });

                    $('#emp_search_result').hide();
                    $('#dept_filter').change(function () {
                        $('#emp_search_default').hide();
                        var selFilter = 'department';
                        var selFilterValue = $(this).attr('value');

                        $.ajax({    
                              url: "employee_filter", //The url where the server req would we made.
                              async: false, 
                              type: "POST", //The type which you want to use: GET/POST
                              data: "filter="+selFilter+"&filtervalue="+selFilterValue, //The variables which are going.
                              dataType: "html", //Return data type (what we expect).
                               
                              //This is the function which will be called if ajax call is successful.
                              success: function(data) {
                                  //data is the html of the page where the request is made.
                                  $('#emp_search_result').show();
                                  $('#emp_search_result').html(data);
                              }
                      	})
                    });

    				        $('#status_filter').change(function () {
                        $('#emp_search_default').hide();
                        var selFilter = 'status';
                        var selFilterValue = $(this).attr('value');

                        $.ajax({    
                            url: "employee_filter", //The url where the server req would we made.
                            async: false, 
                            type: "POST", //The type which you want to use: GET/POST
                            data: "filter="+selFilter+"&filtervalue="+selFilterValue, //The variables which are going.
                            dataType: "html", //Return data type (what we expect).
                             
                            //This is the function which will be called if ajax call is successful.
                            success: function(data) {
                                //data is the html of the page where the request is made.
                                $('#emp_search_result').show();
                                $('#emp_search_result').html(data);
                            }
                    	  })
                    });

                    $('table#leave-table td a.delete').click(function(){
              					if (confirm("Are you sure you want to delete this record?"))
              					{
              						var id = $(this).parent().parent().attr('id');
              						var data = 'id=' + id ;
              						var parent = $(this).parent().parent();

              						$.ajax(
              						{
              							   type: "POST",
              							   url: "delete_leave_record",
              							   data: data,
              							   cache: false,
              							
              							   success: function()
              							   {
              									parent.fadeOut('slow', function() {$(this).remove();});
              							   }
              						 });				
              					  }
              			});

                    $('#notice-addleave-success').hide();
        			      $('.addleave-error').hide();

            				$('#add-leave-submit').click(function(){
            					//check the fields if not empty
            					var datefiled = $('#datefiled_picker').attr('value');
            					if(datefiled === ''){
            						
            						$('#datefiled-error').fadeIn(500);
            						setTimeout( "$('#datefiled-error').fadeOut(1000);",5000 );
                        return false;
                      }
            						
            				
  					
                      ///////////////////////////////////////////////////////
            					var datefrom = $('#inclusivefrom_picker').attr('value');
              					if(datefrom === ''){
              						$('#inclusivetime-error').fadeIn(500);
              						setTimeout( "$('#inclusivetime-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					////////////////////////////////////////////////////////
            					var timefrom = $('#timefrom').attr('value');
              					if(timefrom === ''){
              						$('#inclusivetime-error').fadeIn(500);
              						setTimeout( "$('#inclusivetime-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					
                        ////////////////////////////////////////////////////////
            					var dateto = $('#inclusiveto_picker').attr('value');
              					if(dateto === ''){
              						$('#inclusivetimeto-error').fadeIn(500);
              						setTimeout( "$('#inclusivetimeto-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					 ///////////////////////////////////////////////////////
            					var timeto = $('#timeto').attr('value');
              					if(timeto === ''){
              						$('#inclusivetimeto-error').fadeIn(500);
              						setTimeout( "$('#inclusivetimeto-error').fadeOut(1000);",5000 );
              						return false;
              					}

                        ///////////////////////////////////////////////////////
            					var reason = $('#reason').attr('value');
              					if(reason === ''){
              						$('#reason-error').fadeIn(500);
              						setTimeout( "$('#reason-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					
                        //////////////////////////////////////////////////////
            					var leavetype = $('#addleave_leavetype').attr('value');
              					if(leavetype === ''){
              						$('#leavetype_undertime-error').fadeIn(500);
              						setTimeout( "$('#leavetype_undertime-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					///////////////////////////////////////////////////////
            					var undertimehours = $('#undertime-hours').attr('value');
              					if(undertimehours === '' && $('#undertime-hours-wrapper').css('display') !== 'none'){
              						$('#leavetype_undertime-error').fadeIn(500);
              						setTimeout( "$('#leavetype_undertime-error').fadeOut(1000);",5000 );
              						return false;
              					}

                        ///////////////////////////////////////////////////////
            					var paytype1 = $('#addleave_paytype1').attr('value');
              					if(paytype1 === '' && $('#paytype-1').css('display') !== 'none'){
              						$('#payamount1-error').fadeIn(500);
              						setTimeout( "$('#payamount1-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					
                        ///////////////////////////////////////////////////////
            					var payamount1 = $('#pay_amount1').attr('value');
              					if(payamount1 === '' && $('#paytype-1').css('display') !== 'none'){
              						$('#payamount1-error').fadeIn(500);
              						setTimeout( "$('#payamount1-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					
                        ///////////////////////////////////////////////////////
            					var payamount2 = $('#pay_amount2').attr('value');
              					if(payamount2 === '' && $('#paytype-2').css('display') !== 'none'){
              						$('#payamount2-error').fadeIn(500);
              						setTimeout( "$('#payamount2-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					var payamount3 = $('#pay_amount3').attr('value');
              					if(payamount3 === '' && $('#paytype-3').css('display') !== 'none'){
              						$('#payamount3-error').fadeIn(500);
              						setTimeout( "$('#payamount3-error').fadeOut(1000);",5000 );
              						return false;
              					}
            					

            					if (confirm("Are you sure you want to add this leave?")){
            							dataString = $("#addleaveForm").serialize();

            							$.ajax({
            							   type: "POST",
            							   url: "add_leave",
            							   data: dataString,
            							   cache: false,
            							
            							   success: function()
            							   {
            									$('#notice-addleave-success').fadeIn(1000);
            									setTimeout(function(){ window.location = 'addleave'; }, 1500);
            									//parent.fadeOut('slow', function() {$(this).remove();});
            							   }
            						  });			
            					}

				            });


            				$('#notice-updatecredits').hide();
            				$('#add-credits').click(function(){

            					if (confirm("Are you sure you want to add this credit?"))
            					{
            							//dataString = $("#leavecreditsForm").serialize();
            							var id = $('#credits_empname').attr('value');
            							var year = $('#credits_year').attr('value');
            							var credits = $('#credits_value').attr('value');

            							$.ajax(
            						{
            							   type: "POST",
            							   url: "add_credits",
            							   data: "id="+id+"&year="+year+"&credits="+credits,
            							   cache: false,
            							
            							   success: function()
            							   {
            									$('#notice-updatecredits').fadeIn(1000);
            									setTimeout(function(){ window.location = 'leavecredits'; }, 1500);
            									//parent.fadeOut('slow', function() {$(this).remove();});
            							   }
            						 });			
            					}
            				});
      
                    $('#get_leave_credits_result').hide();
                    $('#edit-credits-wrapper').hide();
                    $('#edit-credits').hide();
                    $('#add-credits-wrapper').hide();
          	        $('#credits_empname').change(function () {
                        //var selFilter = 'department';
                        var id = $(this).attr('value');
                        var year = $('#credits_year').attr('value');

                        $('#edit-credits-wrapper').fadeOut(1000);

                        

                        $.ajax({    
                            url: "get_leave_credits", //The url where the server req would we made.
                            async: false, 
                            type: "POST", //The type which you want to use: GET/POST
                            data: "id="+id+"&year="+year, //The variables which are going.
                            dataType: "html", //Return data type (what we expect).
                             
                            //This is the function which will be called if ajax call is successful.
                            success: function(data) {
                                //data is the html of the page where the request is made.
                          			if (data === 'no results'){
                                  $("#get_leave_credits_result").fadeOut(1000)
                                  $("#add-credits-wrapper").fadeIn(1000)
                                  $('#edit-credits').fadeOut(1000);
                                }
                                else
                                {
                                  $('#add-credits-wrapper').fadeOut(1000);
                                  $('#edit-credits').fadeIn(1000);
                                  $('#get_leave_credits_result').fadeIn(1000);
                                  $('#get_leave_credits_result span').html(data);
                                }
                            }
                    	  })
                    });


            				$('#edit-credits').click(function(){
            					 $('#edit-credits-wrapper').fadeIn(1000);
            				});



            				$('#update-credits').click(function(){
            					if (confirm("Are you sure you want to update this credit?"))
            					{
            							var id = $('#credits_empname').attr('value');
            							var year = $('#credits_year').attr('value');
            							var credits = $('#update_credits_value').attr('value');

            							$.ajax(
            						{
            							   type: "POST",
            							   url: "edit_credits",
            							   data: "id="+id+"&year="+year+"&credits="+credits,
            							   cache: false,
            							
            							   success: function()
            							   {
            									$('#notice-updatecredits').fadeIn(1000);
            									setTimeout(function(){ window.location = 'leavecredits'; }, 1500);
            									//parent.fadeOut('slow', function() {$(this).remove();});
            							   }
            						 });			
            					}
            				});


                  	$('#notice-editleave-success').hide();

                  	$('#datefiled_picker').datepicker({ dateFormat: 'yy-mm-dd' });
                  	$('#inclusivefrom_picker').datepicker({ dateFormat: 'yy-mm-dd' });
                  	$('#inclusiveto_picker').datepicker({ dateFormat: 'yy-mm-dd' });
                          

                    $('#edit-record-submit').click(function(){
            					if (confirm("Are you sure you want to update this record?"))
            					{
            						var id = $('#leave-id').attr('value');
            	                    //var dateFiled = $('#datefiled_picker').attr('value');
            	                    //var includeFrom = $('#includefrom_picker').attr('value');
            	                    //var includeTo = $('#includeto_picker').attr('value');
            	                    //var reason = $('#reason').attr('value');
            	                    //var leavetype = $('#leave_type').attr('value');
            	                    //var paytype = $('#pay_type').attr('value');
            	                    //var payamount = $('#pay_amount').attr('value');


            	                    dataString = $("#edit-mainform").serialize();
            	                    data = 'id=' + id  + '&' + dataString;

									
            	                    $.ajax({    
            	                        url: "update_leave_record", //The url where the server req would we made.
            	                        async: false, 
            	                        type: "POST", //The type which you want to use: GET/POST
            	                        data: data, //The variables which are going.
            	                        dataType: "html", //Return data type (what we expect).
            	                         
            	                        //This is the function which will be called if ajax call is successful.
            	                        success : function(data) {
            	                            //data is the html of the page where the request is made.
            	                            //$('#content_result').html(data);
            	                            $('#notice-editleave-success').fadeIn(1000);
            	                            $('#notice-editleave-success').fadeOut(1000);
            	                            //$('.fancybox-wrap').hide(1500);
            	                            //$.fancybox.close();
            	                            
            	                            setTimeout(function(){$('.fancybox-wrap').hide(1500)},1000);
            	                            setTimeout(function(){$('.fancybox-overlay').click()},1900)
            	                            //parent.fadeOut('slow', function() {$(this).remove();});
            	                            //$('.fancybox-overlay-fixed').hide();
            	                            //$('.fancybox-overlay').remove();
            	                            
            	                        },
										complete : function(data){
											console.log('leave updated');
										}
            	                	})	

									
            					}
            				});


            				// sort the employee list by first letter of surname
            				$('.sort-letter').click(function(){
            					var letterValue = $(this).attr('value');

            	                    $.ajax({    
            	                        url: "employee_letter_sort", //The url where the server req would we made.
            	                        async: false, 
            	                        type: "POST", //The type which you want to use: GET/POST
            	                        data: "value="+letterValue, //The variables which are going.
            	                        dataType: "html", //Return data type (what we expect).
            	                         
            	                        //This is the function which will be called if ajax call is successful.
            	                        success: function(data) {
            	                        	$('#emp_search_default').hide();
            	                            $('#emp_search_result').show();
            	                            
                                        	$('#emp_search_result').html(data);
            	                            
            	                        }
            	                	})	
            				});
                       

          				  //hide the divs
            				$('#monthly-wrapper').hide();
            				$('#quarterly-wrapper').hide();
            				$('#semiannually-wrapper').hide();
            				$('#annually-wrapper').hide();

          				  $('#leave-report-choice').change(function () {
                        var selValue = $(this).attr('value');

              					$('#monthly-wrapper').hide();
              					$('#quarterly-wrapper').hide();
              					$('#semiannually-wrapper').hide();
              					$('#annually-wrapper').hide();
                        switch (selValue)
                    						{
                    						case '1':
                    						//show the month selection div
                    						  $('#monthly-wrapper').fadeIn(1000);
                    						  break;
                    						case '3':
                    						//show the quarterly selection div
                    						  $('#quarterly-wrapper').fadeIn(1000);
                    						  break;
                    						case '6':
                    						//show the semi annual selection div
                    						  $('#semiannually-wrapper').fadeIn(1000);
                    						  break;
                    						case '12':
                    						//show the annual selection div
                    						  $('#annually-wrapper').fadeIn(1000);
                    						  break;
                    						}
                    });

                    $('#leave-report-monthly').change(function () {
                    	  var selValue = $(this).attr('value');
                        var selChoice = $('#leave-report-choice').attr('value');

                        switch(selValue){
              						case '1':
              						  value = 'January';
              						  break;
              						case '2':
              						  value = 'February';
              						  break;
              						case '3':
              						  value = 'March';
              						  break;
              						case '4':
              						  value = 'April';
              						  break;
              						case '5':
              						  value = 'May';
              						  break;
              						case '6':
              						  value = 'June';
              						  break;
              						case '7':
              						  value = 'July';
              						  break;
              						case '8':
              						  value = 'August';
              						  break;
              						case '9':
              						  value = 'September';
              						  break;
              						case '10':
              						  value = 'October';
              						  break;
              						case '11':
              						  value = 'November';
              						  break;
              						case '12':
              						  value = 'December';
              						  break;
            						}

                  			switch(selChoice){
                  				case '1':
                  				  choice = 'Monthly';
                  				  break;
                  				case '3':
                  				  choice = 'Quarterly';
                  				  break;
                  				case '6':
                  				  choice = 'Semi-Annual';
                  				  break;
                  				case '12':
                  				  choice = 'Annual';
                  				  break;
            			      }

            		

                        $.ajax({    
                              url: "ajax_leave_reports", //The url where the server req would we made.
                              async: false, 
                              type: "POST", //The type which you want to use: GET/POST
                              data: "value="+selValue+"&choice="+selChoice+"&headerchoice="+choice+"&headervalue="+value, //The variables which are going.
                              dataType: "html", //Return data type (what we expect).
                               
                              //This is the function which will be called if ajax call is successful.
                              success: function(data) {
                                  //data is the html of the page where the request is made.
                                $('#leave_report_result').fadeIn(1000);
                                $('#leave_report_result').html(data);     
                              }
                      	})
                    });

          	        $('#leave-report-quarterly').change(function () {
                    	var selValue = $(this).attr('value');
                      var selChoice = $('#leave-report-choice').attr('value');

                      switch(selValue)
              						{
              						case '1':
              						  value = '1st Quarter';
              						  break;
              						case '2':
              						  value = '2nd Quarter';
              						  break;
              						case '3':
              						  value = '3rd Quarter';
              						  break;
              						case '4':
              						  value = '4th Quarter';
              						  break;
              						
              						}

            					switch(selChoice)
            						{
            						case '1':
            						  choice = 'Monthly';
            						  break;
            						case '3':
            						  choice = 'Quarterly';
            						  break;
            						case '6':
            						  choice = 'Semi-Annual';
            						  break;
            						case '12':
            						  choice = 'Annual';
            						  break;
            						
            						}

                        $.ajax({    
                            url: "ajax_leave_reports", //The url where the server req would we made.
                            async: false, 
                            type: "POST", //The type which you want to use: GET/POST
                            data: "value="+selValue+"&choice="+selChoice+"&headerchoice="+choice+"&headervalue="+value, //The variables which are going.
                            dataType: "html", //Return data type (what we expect).
                             
                            //This is the function which will be called if ajax call is successful.
                            success: function(data) {
                                //data is the html of the page where the request is made.
                              $('#leave_report_result').fadeIn(1000);
                              $('#leave_report_result').html(data);     
                            }
                    	  })
                    });

          				  $('#leave-report-semiannually').change(function () {
                          	var selValue = $(this).attr('value');
                            var selChoice = $('#leave-report-choice').attr('value');

                            switch(selValue)
                  						{
                  						case '1':
                  						  value = '1st Half';
                  						  break;
                  						case '2':
                  						  value = '2nd Half';
                  						  break;
                  						
                  						}
                            switch(selChoice)
                    					{
                    					case '1':
                    					  choice = 'Monthly';
                    					  break;
                    					case '3':
                    					  choice = 'Quarterly';
                    					  break;
                    					case '6':
                    					  choice = 'Semi-Annual';
                    					  break;
                    					case '12':
                    					  choice = 'Annual';
                    					  break;
                    					
                    					}

                            $.ajax({    
                                url: "ajax_leave_reports", //The url where the server req would we made.
                                async: false, 
                                type: "POST", //The type which you want to use: GET/POST
                                data: "value="+selValue+"&choice="+selChoice+"&headerchoice="+choice+"&headervalue="+value, //The variables which are going.
                                dataType: "html", //Return data type (what we expect).
                                 
                                //This is the function which will be called if ajax call is successful.
                                success: function(data) {
                                    //data is the html of the page where the request is made.
                                  $('#leave_report_result').fadeIn(1000);
                                  $('#leave_report_result').html(data);     
                                }
                        	  })
                    });

            				$('#leave-report-annually').change(function () {
                      	var selValue = $(this).attr('value');
                        var selChoice = $('#leave-report-choice').attr('value');

              					switch(selChoice)
              						{
              						case '1':
              						  choice = 'Monthly';
              						  break;
              						case '3':
              						  choice = 'Quarterly';
              						  break;
              						case '6':
              						  choice = 'Semi-Annual';
              						  break;
              						case '12':
              						  choice = 'Annual';
              						  break;
              						
              						}

                        value = selValue;
                        $.ajax({    
                              url: "ajax_leave_reports", //The url where the server req would we made.
                              async: false, 
                              type: "POST", //The type which you want to use: GET/POST
                              data: "value="+selValue+"&choice="+selChoice+"&headerchoice="+choice+"&headervalue="+value, //The variables which are going.
                              dataType: "html", //Return data type (what we expect).
                               
                              //This is the function which will be called if ajax call is successful.
                              success: function(data) {
                                  //data is the html of the page where the request is made.
                                $('#leave_report_result').fadeIn(1000);
                                $('#leave_report_result').html(data);     
                              }
                      	})
                    });

                    /*
            				// ---------------------------------------------------------------
            				// FOR THE USEREDIT OPTION in the Banner side
            				// ---------------------------------------------------------------
                    
                  
                    $('#useroption-wrapper').hide();
                    $("#useredit").click(function(){
                      $('#useroption-wrapper').slideToggle(100);
                      
                      return false;
                    });

                    $('#useredit-error').hide();
                    $('#useredit-passerror').hide();
                    $('#useredit-success').hide();
                    $("a#useredit-updatebut").click(function(){
                        var id = $(this).attr('value');
                        var password  =  $('#useredit-password').attr('value');
                        var cpassword =  $('#useredit-cpassword').attr('value');
                        var firstname =  $('#useredit-firstname').attr('value');
                        var lastname  =  $('#useredit-lastname').attr('value');

                        //check if password and confirm password is same

                        if(password === cpassword){
                          //proceed
                          $.ajax({    
                                url: "dps/ajax_updateprofile", 
                                async: false, 
                                type: "POST",
                                data: "id="+id+"&password="+password+"&fname="+firstname+"&lname="+lastname, 
                                dataType: "html",
                                success: function(data) {
                                  if(data === 'success'){
                                    $('#useredit-error').hide();
                                    $('#useredit-passerror').hide();
                                    $('#useredit-success').fadeIn(100);
                                    $('#useroption-wrapper').fadeOut(4000);
                                  }else{
                                    $('#useredit-success').hide();
                                    $('#useredit-passerror').hide();
                                    $('#useredit-error').fadeIn(500);
                                  }
                                }
                          })
                        }else{
                          //error
                          $('#useredit-success').hide();
                          $('#useredit-error').hide();
                          $('#useredit-passerror').fadeIn(500);
                        }
                        return false;
                    });
                    */
  });	
</script>

</head>