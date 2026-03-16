<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

	<title><?php echo $title; ?> </title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/smoothness/jquery-ui-1.8.23.custom.css") ?>' />
	<link rel='stylesheet' type='text/css' media="print" href='<?php echo base_url("css/print.css") ?>' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url("css/table.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/jquery.timepicker.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/validationEngine.jquery.css") ?>' />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/messi.css") ?>" media="screen" />


	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("js/blink.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.idTabs.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.23.custom.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine-en.js") ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine.js") ?>" charset="utf-8"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/messi.min.js") ?>"></script>

  <link rel="shorvut icon" href='<?php echo base_url("css/images/favicon.ico") ?>'>



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

                $('.blink').blink();
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

              $(".image-expand").fancybox({
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
                           
                          		if (data === '0'){
                          			$('#addleave-credits-result').fadeOut(1000);
                          			
                          		}
                          		else
                          		{
                          			
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

                


                $('table#leave-table td a.delete').click(function()
				{
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
				$('#add-leave-submit').click(function()
				{
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
					

					









					if (confirm("Are you sure you want to add this leave?"))
					{
							dataString = $("#addleaveForm").serialize();

							$.ajax(
						{
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
				$('#add-credits').click(function()
				{

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


        //FANCYBOXES scripts
        $(".edit-leave-records").fancybox({
	
					fitToView	: false,
					width		: '60%',
					height		: '40%',
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none'
				});

				$("#mass-leave-but").fancybox({
					fitToView	: false,
					width		: '80%',
					height		: '80%',
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none'
				});

                

				$(".landmark_box").fancybox({
			    	openEffect	: 'elastic',
			    	closeEffect	: 'elastic',

			    	helpers : {
			    		title : {
			    			type : 'float'
			    		}
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
                          			//$('#get_leave_credits_result').hide();
                          			$("#get_leave_credits_result").fadeOut(1000)
                          			$("#add-credits-wrapper").fadeIn(1000)
                          			$('#edit-credits').fadeOut(1000);
                          			//$('#add-credits-wrapper').show();
                          		}
                          		else
                          		{
                          			$('#add-credits-wrapper').fadeOut(1000);
                          			$('#edit-credits').fadeIn(1000);
                          			$('#get_leave_credits_result').fadeIn(1000);
                          			//$("#get_leave_credits_result").fadeIn(2000);
                          			$('#get_leave_credits_result span').html(data);
                          		}
                            
                        }
                	})
                });


				$('#edit-credits').click(function()
				{
					 $('#edit-credits-wrapper').fadeIn(1000);
				});



				$('#update-credits').click(function()
				{
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
                

                $('#edit-record-submit').click(function()
				{
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
	                        success: function(data) {
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
	                            
	                        }
	                	})	
					}
				});


				// sort the employee list by first letter of surname
				$('.sort-letter').click(function()
				{
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


                    //$('#monthly-wrapper').show();
                    				//hide the divs
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

                    switch(selValue)
        						{
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
					//$('#leaverep-header').empty();
                    //$('#leaverep-header').append(choice+' Report : <strong>'+value+'<strong>');
                    

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
					//$('#leaverep-header').empty();
                    //$('#leaverep-header').append(choice+' Report : <strong>'+value+'<strong>');


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
					//$('#leaverep-header').empty();
                    //$('#leaverep-header').append(choice+' Report : <strong>'+value+'<strong>');


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
					//$('#leaverep-header').empty();
                    //$('#leaverep-header').append(choice+' Report : <strong>'+selValue+'<strong>');


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


				// ---------------------------------------------------------------
				// FOR THE DPS MODULE - javascript below are use in the dps module
				// ---------------------------------------------------------------

				
				

				$("#lock-button").toggle(function() { 
                     
                      $('#dps-project-customerinfo :input').attr('disabled',true);
                      },
                       function() { 
                   
                      $('#dps-project-customerinfo :input').attr('disabled', false);
                });


                $(".recent-pour").click(function()
				{
					var projectId = $('#addproject-id').attr('value');

					if (confirm("Are you sure you want to update this record?"))
					{
						$.ajax({    
	                        url: "addproject_form", //The url where the server req would we made.
	                        async: false, 
	                        type: "POST", //The type which you want to use: GET/POST
	                        data: "project_id="+projectId, //The variables which are going.
	                        dataType: "html", //Return data type (what we expect).
	                         
	                        //This is the function which will be called if ajax call is successful.
	                        success: function(data) {
	                            //data is the html of the page where the request is made.
	                            window.location = "addproject_form";
		                            
	                        }
	                	})
	                }
					
				});

				$('.design-inputbox-date').datepicker({ dateFormat: 'yy-mm-dd' });
				$("#remove-last-table-row").hide();

				// trigger event when button is clicked
				  $("#add-table-row").click(function()
				  {
				    // add new row to table using addTableRow function
				    addTableRow($("#dps-addproject"));
				 
				    // prevent button redirecting to new page
				    return false;
				  });


				  // function to add a new row to a table by cloning the last row and
				  // incrementing the name and id values by 1 to make them unique
				  function addTableRow(table)
				  {
				    // clone the last row in the table
				    var $tr = $(table).find("#designbody tr:last").clone();
				 
				    // get the name attribute for the input and select fields
				    $tr.find("input,select").attr("name", function()
				    {
				      // break the field name and it's number into two parts
				      var parts = this.id.match(/(\D+)(\d+)$/);
				 
				      // create a unique name for the new field by incrementing
				      // the number for the previous field by 1
				      return parts[1] + ++parts[2];
				    // repeat for id attributes
				    }).attr("id", function()
				    {
				      var parts = this.id.match(/(\D+)(\d+)$/);
				      return parts[1] + ++parts[2];
				    });
				         
				    // append the new row to the table
				    $(table).find("#designbody tr:last").after($tr);
				    $("#designbody tr:last").css("background-color", "#CCFFFF");
				    $("#designbody tr td input.design-inputbox-date :last").removeClass('hasDatepicker');
				    $('.design-inputbox-date').datepicker({ dateFormat: 'yy-mm-dd' });
				    $("#remove-last-table-row").fadeIn(1000);

				    //increment the counter
				    var ctr_value = $('#designtable-ctr').attr('value');
				    ctr_value++;
				    $('#designtable-ctr').attr('value',ctr_value);
				    
				    $('#designbody tr :last :input[type=text]').attr('value','');

				  };



				  //remove last table row
				  
				   $("#remove-last-table-row").click(function()
				  {
				    $('#dps-addproject #designbody tr:last').remove();

				    //decrement the counter
				    var ctr_value = $('#designtable-ctr').attr('value');
				    ctr_value--;
				    $('#designtable-ctr').attr('value',ctr_value);

				    var rowCount = $('#dps-addproject tr').length;

				    if (rowCount === 2){
				    	$(this).fadeOut(500);
				    }
				 
				    // prevent button redirecting to new page
				    return false;

				    
				  });

				   // MORE Contacts Script
				   
				   $("#more-contacts :input").attr("disabled", true);
				   $("#more-contacts-button").hover(function(){
					    $("#more-contacts").css("background-color","#ccc");
					    },function(){
					    $("#more-contacts").css("background-color","#f3f3f3");
					  });

				   $("#more-contacts-button").toggle(function(){
					    $("#more-contacts :input").attr("disabled", false);},
					    function(){
					    $("#more-contacts :input").attr("disabled", true);}
					  );

				  //Scripts below are for permits in the add project form 1

				   $("#check-entfee").hide();
				   $("#check-hasentfee").click(function()
					  {
						  if ($('#check-hasentfee').is(':checked')) {
							    $("#check-entfee").fadeIn(500);
							} else {
							    $("#check-entfee").fadeOut(500);
							} 
					  });


				   $("#check-others").hide();
				   $("#check-hasothers").click(function()
					  {
						  if ($('#check-hasothers').is(':checked')) {
							    $("#check-others").fadeIn(500);
							} else {
							    $("#check-others").fadeOut(500);
							} 
					  });


				   //Scripts below are for ADDITIONAL EQUIPMENT in the add project form 1

				   $("#add-pipes-num").hide();
				   $("#add-vibrator-pesos").hide();
				   $("#add-others-value").hide();

				   $("#check-add-pipes").click(function()
					  {
						  if ($('#check-add-pipes').is(':checked')) {
							    $("#add-pipes-num").fadeIn(500);
							} else {
							    $("#add-pipes-num").fadeOut(500);
							} 
					  });


				   
				   $("#check-add-vibrator").click(function()
					  {
						  if ($('#check-add-vibrator').is(':checked')) {
							    $("#add-vibrator-pesos").fadeIn(500);
							} else {
							    $("#add-vibrator-pesos").fadeOut(500);
							} 
					  });

				   $("#check-add-others").click(function()
					  {
						  if ($('#check-add-others').is(':checked')) {
							    $("#add-others-value").fadeIn(500);
							} else {
							    $("#add-others-value").fadeOut(500);
							} 
					  });


				   //Scripts below are for SAMPLING PROCEDURE in the add project form 1

				   $("#samp-others-wrapper").hide();

				   $(".sampling-radio").click(function()
					  {
						  if ($('#check-sampling-others').is(':checked')) {
							    $("#samp-others-wrapper").fadeIn(500);

							} else {
							    $("#samp-others-wrapper").fadeOut(500);
							} 
					  });

				   //Scripts below are for TESTING SCHEDULE in the add project form 1

				   //$('.checksub-check').hide();
				   //$('#extlab-input-wrappers').hide();
				   $('.witness-wrapper').hide();
				   //witness-sameas

				   //check witness radio button
				   $('.witness-choice').click(function()
					  {
						  if ($('#witness-with').is(':checked')) {
							    $(".witness-wrapper").fadeIn(500);
							    
							} else {
							    $(".witness-wrapper").fadeOut(500);
							    
							} 
					  });
				   

				   $("#check-testing-jlrlab").click(function()
					  {
						  if ($('#check-testing-jlrlab').is(':checked')) {
							    $("#test-jlrlab").fadeIn(500);
							    
							} else {
							    $("#test-jlrlab").fadeOut(500);
							} 
					  });

				   $("#check-testing-external").click(function()
					  {
						  if ($('#check-testing-external').is(':checked')) {
							    $("#test-extlab").fadeIn(500);
							    $("#extlab-input-wrappers").fadeIn(500);
							    
							} else {
							    $("#test-extlab").fadeOut(500);
							    $("#extlab-input-wrappers").fadeOut(500);
							} 
					  });

				  //FORM1 validation
				  $(".add-project-form").validationEngine();


          //Form 1a scripts

          $('.form1acustomerselect#cust-name').change(function () {
            var selValue = $(this).attr('value');
            
            
            $.ajax({    
                url: "ajax_getprojectby_cust", //The url where the server req would we made.
                async: false, 
                type: "POST", //The type which you want to use: GET/POST
                data: "id="+selValue, //The variables which are going.
                dataType: "html", //Return data type (what we expect).
                 
                //This is the function which will be called if ajax call is successful.
                success: function(data) {
                    //data is the html of the page where the request is made.
                    $("#selectedprojectby_cust").attr("disabled", false);
                    $("#selectedprojectby_cust").empty();
                    $("#selectedprojectby_cust").append(data);
                }
            })
  
          });

          $('#selectedprojectby_cust').change(function () {
            var selValue = $(this).attr('value');
            var textValue = $('#selectedprojectby_cust option:selected').text();
            var projectId = $('#selectedprojectby_cust option:selected').attr('id');



            $("#location").attr("disabled", false);
            $("#location").val(selValue);
            $("#hidden-projectname").val(textValue);
            $("#hidden-projectid").val(projectId);
  
          });

          


				  //Scripts for the Scheduler Part

          
          //$('.coorotheredit-wrapper').hide();

          $(".coor-others-but").click(function()
            {
              var id = $(this).attr('id');
              var name = $(this).attr('value');

              if (name === 'show') {
                $(".coorotheredit-wrapper#"+id).fadeIn(500);
                $(this).empty();
                $(this).append('Hide');
                $(this).val('hide');
              }

              if (name === 'hide') {
                $(".coorotheredit-wrapper#"+id).fadeOut(500);
                $(this).empty();
                $(this).append('Show');
                $(this).val('show');
              }

              return false;
          });

          

					$('.sched-datetime-input').datepicker({ dateFormat: 'yy-mm-dd' });
          
          


				  $('.update-scheddate').click(function () {
	                    var id = $(this).parent().parent().attr('id');
	                    var linkId = $(this).attr('id');

	                    var dateValue = $(this).parent().prev().prev().prev().prev().children('input.sched-datetime-input').attr('value');
	                    var timeValue = $(this).parent().prev().prev().prev().children('select.sched-time-updater').attr('value');
	                    var statusValue = $(this).parent().prev().prev().children('select.sched-designstatus-update').attr('value');

	                    var proj_name = $('.proj_name#'+id).attr('value');
	                    var proj_address = $('.proj_address#'+id).attr('value');


	                    var str = $('.str#'+id).attr('value');
	                    var agg = $('.agg#'+id).attr('value');
	                    var curing = $('.curing#'+id).attr('value');
	                    var slump = $('.slump#'+id).attr('value');
	                    var pouring = $('.pouring#'+id).attr('value');
	                    var structure = $('.structure#'+id).attr('value');
	                    var remarks = $('.remarks#'+id).attr('value');
	                    var estvolume = $('.estvolume#'+id).attr('value');

                      var pipes = $('.add-pipes#'+id).attr('value');
                      var vibrator = $('.add-vibrator#'+id).attr('value');
                      var slumpcone = $('.add-slumpcone#'+id).attr('value');
                      var beam = $('.add-beam#'+id).attr('value');
                      var others = $('.add-others#'+id).attr('value');

                      

	                    if (confirm("Are you sure you want to update this record?"))
          						{
          							$.ajax({    
	                        url: "update_sched_date",
	                        async: false, 
	                        type: "POST",
	                        data: {
	                        		id: id, 
	                        		date: dateValue,
	                        		time: timeValue,
	                        		status: statusValue,
	                        		proj_name: proj_name,
	                        		proj_address: proj_address,
	                        		str: str,
	                        		agg: agg,
	                        		curing: curing,
	                        		slump: slump,
	                        		pouring: pouring,
	                        		structure: structure,
	                        		remarks: remarks,
	                        		volume: estvolume,
                              pipes: pipes,
                              vibrator: vibrator,
                              slumpcone: slumpcone,
                              beam: beam,
                              others: others,
	                        	  },
	                        dataType: "html",
	                         
	                        //This is the function which will be called if ajax call is successful.
	                        success: function(data) {
	                            //data is the html of the page where the request is made.
	                            $('#'+linkId).parent().parent().css('background','#DFF2BF');
	                            $('#'+linkId).parent().prev().children('input.sched-datetime-input').css('background','#DFF2BF');
		                          $('.coorotheredit-wrapper#'+id).fadeOut(200);
	                        }
    		                })
          		        }

                      return false;
	                });

					
					//hide the approved button
					$(".scheduler-approved-submit").hide();

					$(".sched-select-checkbox").click(function()
					  {
					  	var linkId = $(this).attr('id');
					  	var selcounter = $('#selectcounter').attr('value');
						  if ($('#'+linkId).is(':checked')) {
							    $('#'+linkId).parent().parent().css('background','#FEEFB3');
							    selcounter ++;
							    $('#selectcounter').attr('value',selcounter);
							  
							    
							} else {
							    $('#'+linkId).parent().parent().css('background','#e5e5e5');
							    selcounter --;
							    $('#selectcounter').attr('value',selcounter);
							    
							} 

						//check if counter is not zero---if zero then button is hide

						if(selcounter === 0 ){
							$(".scheduler-approved-submit").fadeOut(500);
						}
						else{
							$(".scheduler-approved-submit").fadeIn(500);
						}
					  });


          //Search project script here
          $('#bydate-date').datepicker({ dateFormat: 'yy-mm-dd' });

          
          $('.searchbydate-updatebut').live("click",(function () {
              var id = $(this).attr('id');
              var date = $('.searchbydate-date#'+id).attr('value');
              
              $.ajax({    
                  url: "ajax_editsearchdesign_date", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "id="+id+"&date="+date, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                            //data is the html of the page where the request is made.
                    $('.searchbydate-date#'+id).css('background','#2DC123');
                  }
              })
         

              return false;
              
          })); 

         
          $('#searchbut-byform').click(function () {
              var number = $('#byform-number').attr('value');
              var form = $('#byform-select').attr('value');
              

              $.ajax({    
                  url: "ajax_searchbyform", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "form="+form+"&form_num="+number, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                            //data is the html of the page where the request is made.
                          $('#searchbydate-result').empty();
                          $('#searchbyform-result').fadeIn(1000);
                          $('#searchbyform-result').html(data);     
                  }
              })

              return false;
              
          }); 

          $('#searchbut-bydate').click(function () {
              var date = $('#bydate-date').attr('value');
              
              $.ajax({    
                  url: "ajax_searchbydate", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "date="+date, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                            //data is the html of the page where the request is made.
                          $('#searchbyform-result').empty();
                          $('#searchbydate-result').fadeIn(1000);
                          $('#searchbydate-result').html(data);     
                  }
              })

              return false;

              
          });



					// DPS EDIT SCRIPTS

					// Accounting side
					$('.acctg-updatebut').click(function () {
            var id = $(this).parent().parent().attr('id');
            var linkId = $(this).attr('id');
            var sched_date = $(this).next().attr('value');
            var remarks = $(this).parent().prev().children('select.acctg-remarks').attr('value');

            

            if (confirm("Are you sure you want to update this?"))
	          {
		          $.ajax({    
                  url: "update_acctg_remarks", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "id="+id+"&remarks="+remarks+"&date="+sched_date, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                      //data is the html of the page where the request is made.
                      $('#'+linkId).parent().parent().css('background','#e4edfe');
                      //$('#tab2').load('dps/edit_pouring_today');
                        
                  }
            	})
            }
            return false;
	        });	

					// Supervisor side
					$('.supervisor-updatebut').click(function () {
            var id = $(this).parent().parent().attr('id');
            var linkId = $(this).attr('id');
            var sched_date = $(this).next().attr('value');
            var servEngr = $(this).parent().prev().children('select#servengr'+id).attr('value');
            var batchPlant = $(this).parent().prev().prev().children('select#batch-plant'+id).attr('value');

            

            if (confirm("Are you sure you want to update this?"))
	          {
			        $.ajax({    
                    url: "update_supervisor", //The url where the server req would we made.
                    async: false, 
                    type: "POST", //The type which you want to use: GET/POST
                    data: "id="+id+"&servengr="+servEngr+"&batchplant="+batchPlant+"&date="+sched_date, //The variables which are going.
                    dataType: "html", //Return data type (what we expect).
                     
                    //This is the function which will be called if ajax call is successful.
                    success: function(data) {
                        //data is the html of the page where the request is made.
                        $('#'+linkId).parent().parent().css('background','#e4edfe');
                        //$('#tab2').load('dps/edit_pouring_today');
                          
                    }
            	})
            }
            return false;
	        });	

					// QC side
					$('.qc-updatebut').click(function () {
              var id = $(this).parent().parent().attr('id');
              var linkId = $(this).attr('id');
              var sched_date = $(this).next().attr('value');
              var qc_remarks = $(this).parent().prev().children('select#qc_remarks'+id).attr('value');
              var qc_opt_remarks = $(this).parent().prev().children('#qc_opt_remarks'+id).attr('value');
              var qa_rep = $(this).parent().prev().prev().children('select#qa_rep'+id).attr('value');
              var f_code2 = $(this).parent().prev().prev().prev().children('select#fcode2'+id).attr('value');
              var f_code1 = $(this).parent().prev().prev().prev().children('select#fcode1'+id).attr('value');

              if (confirm("Are you sure you want to update this?"))
		          {
					      $.ajax({    
                        url: "update_qc", //The url where the server req would we made.
                        async: false, 
                        type: "POST", //The type which you want to use: GET/POST
                        data: "id="+id+"&fcode1="+f_code1+"&fcode2="+f_code2+"&qa_rep="+qa_rep+"&qc_remarks="+qc_remarks+"&date="+sched_date+"&qcoptrem="+qc_opt_remarks, //The variables which are going.
                        dataType: "html", //Return data type (what we expect).
                         
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                            //data is the html of the page where the request is made.
                            $('#'+linkId).parent().parent().css('background','#e4edfe');
                            //$('#tab2').load('dps/edit_pouring_today');
	                          //display the newly inserted fcodes to the table
                            $('span#code1 a#'+id).empty();
                            $('span#code2 a#'+id).empty();
                            $('span#code1 a#'+id).append(f_code1);
                            $('span#code2 a#'+id).append(f_code2);
                        }
                	})
              }
            return false;
	        });	

					
					//DPS INDEX Scripts

          //Data importation to batchtec
          
          $('.index-importbut').click(function () {
              var value = $(this).attr('value');
              var id = $(this).attr('id');
              var viewportWidth = $(window).width();

              if (confirm("Import this design?"))
              {
                $.ajax({    
                        url: "dps/ajax_importbatch",
                        async: false, 
                        type: "POST", 
                        data: "id="+id,
                        dataType: "html",
                        success: function(data) {
                            if(data === 'existing' ){
                              new Messi('Item is already on the database,Cannot Import,Update only.', {modal:true,autoclose: 2000,center: false, viewport: {top: '300px',left: viewportWidth/2 - 250 }});
                              $('.index-importbut#'+id).parent().css('background','#ccffcc');
                            }
                            if(data === 'imported' ){
                              $('.index-importbut#'+id).parent().css('background','#ccffcc');
                            }
                            
                        }
                  })
              }
            
            return false;
          }); 
					
					$('.dpsnotes-wrapper').hide();

	                $(".dpscust-item").hover(
					  function () {
					  	var id = $(this).parent().parent().parent().parent().attr('id');
					    $('.dpsnotes-wrapper#'+id).fadeIn(200);
					  }, 
					  function () {
					  	var id = $(this).parent().parent().parent().parent().attr('id');
					    $('.dpsnotes-wrapper#'+id).fadeOut(200);
					  }
					);


					$('.dpsnotes-form').hide();

          $('.addnoteform').click(function () {
              var id = $(this).attr('id');
              
            $('.dpsnotes-form').fadeOut(200);

            if($('.dpsnotes-form#'+id).is(':visible')) {
		          $('.dpsnotes-form#'+id).fadeOut(500); 
						}else{
							$('.dpsnotes-form#'+id).fadeIn(800);
						}

	          return false;
          });	

	        
          // DPS NOTE Submit
					$('.dpsnote-submit').click(function () {
            var id = $(this).parent().parent().parent().attr('id');
            var user = $('#dpsnote-user'+id).attr('value');
            var note = $('#dpsnote-content'+id).attr('value');
            

            if (confirm("Are you sure you want to add this note?"))
	          {
		          $.ajax({    
                  url: "dps/process_addnote", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "id="+id+"&user="+user+"&note="+note, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                      
                      $('.dpsnotes-form#'+id).fadeOut(1500);
                      
                    }
            	})

            }

            return false;
          });	

	                
	                // DPS summary testing
	                // added scripts for multi approving

	                //acctg
	                $('.acctg-multiupdate-but').hide();
	                $('.dpscheck').hide();
	                var i = 0;
	        $('.acctg-remarks').change(function() {
	                	var id = $(this).parent().parent().attr('id');
	                	

	                	// change color of the tr of the change item
	                	$('.acctg-remtr#'+id).css('background','#DFF2BF');

	                	//set the check=yes of the selected row
	                	$('.dpscheck#'+id).attr('checked','checked');

	                	i++;

	                	
	                	if(i > 1){
	                		// show the mutiple update button
	                	$('.acctg-multiupdate-but').fadeIn(1000);
	                	}
					});


					//plant supervisor
	                //$('.acctg-multiupdate-but').hide();
	                $('.spcheck').hide();
	                var i = 0;
	                $('.batch-plant,.servengr').change(function() {
	                	var id = $(this).parent().parent().attr('id');
	                	
	                	//alert(id);
	                	// change color of the tr of the change item
	                	$('.sp-tr#'+id).css('background','#DFF2BF');

	                	//set the check=yes of the selected row
	                	$('.spcheck#'+id).attr('checked','checked');

	                	i++;

	                	
	                	if(i > 1){
	                		// show the mutiple update button
	                		//$('.acctg-multiupdate-but').fadeIn(1000);
	                	}
					});


	                //QC
	                //$('.acctg-multiupdate-but').hide();
	                $('.qccheck').hide();
	                var i = 0;
	                $('.fcode1,.fcode2,.qa_rep,.qc_remarks').change(function() {
	                	var id = $(this).parent().parent().attr('id');
	                	
	              
	                	// change color of the tr of the change item
	                	$('.qc-tr#'+id).css('background','#DFF2BF');

	                	//set the check=yes of the selected row
	                	$('.qccheck#'+id).attr('checked','checked');

	                	i++;

	                	
	                	if(i > 1){
	                		// show the mutiple update button
	                		//$('.acctg-multiupdate-but').fadeIn(1000);
	                	}
					});


					//Scripts for the DPS Index
					$('#selected-pouringdate').datepicker({ dateFormat: 'yy-mm-dd'});
					//$('.hdayspicker').datepicker({ dateFormat: 'yy-mm-dd'});
					$( ".hdayspicker" ).datepicker({
			            altField: "#alternatehdays",
			            altFormat: "mm-dd"
			        });


					$('#nextpouring-jumpdate').click(function () {
						var selectedDate = $('#selected-pouringdate').attr('value');
	                    $("#ajax-content").empty().append("<center><div id='loading'><img src='<?php echo base_url("css/images/ajax-loader.gif") ?>' alt='Loading' /></div></center>");
 						
					    $.ajax({    
		                        url: "dps/ajax_nextpouring", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "date="+selectedDate, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                            $("#ajax-content").empty().append(data);
		                        }
		                	})
	                    return false;
	                });

					

					$('#hdaysedit').hide();
					$('#hdaysadd').hide();
					$('.hdaysvalue').live("click",function () {
						
						$('#hdaysadd').fadeOut(500);
   						$('#hdaysedit').fadeIn(1000);
   						$('#hdays-action-wrapper').fadeOut(1000);
   						var id = $(this).attr('id');
						$('#hdaysedit-hidden').val(id);

	                    return false;
	                });

					$('#hdaysedit-submit-button').click(function () {
   						var id = $('#hdaysedit-hidden').attr('value');
						var status = $('#update-hdaysvalue').attr('value');

   						$.ajax({    
		                        url: "ajax_update_holiday", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "id="+id+"&status="+status, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                            $('#hdaysedit').fadeOut(1000);
		                            $('.hdaysvalue#'+id).removeClass('hday-inactive hday-active');
		                            $('#update-hdaysvalue').val('');

		                            if(status === 'INACTIVE'){
		                            	$('.hdaysvalue#'+id).addClass("hday-inactive");
		                            }
		                            if(status === 'ACTIVE'){
		                            	$('.hdaysvalue#'+id).addClass("hday-active");
		                            }
		                            
		                        }
		                	})

	                    return false;
	                });

	                $('#hdaysadd-button').click(function () {
						var selectedDate = $(this).attr('value');
   						$('#hdaysadd').fadeIn(1000);
   						$('#hdaysedit').fadeOut(500);
   						$('#hdays-action-wrapper').fadeOut(500);
	                    return false;
	                });

	                $('.hdaysadd-error').hide();
	                $('#hdaysadd-submit-button').click(function () {
   						var date = $('#alternatehdays').attr('value');

   						$.ajax({    
		                        url: "ajax_add_holiday", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "date="+date, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                            
		                            if(data === 'exist'){
		                            	$('.hdaysadd-error#exist').fadeIn(300);
		                            	$('.hdaysadd-error#exist').fadeOut(2500);
		                            	$('.hdayspicker').val('');
		                            }
		                            if(data === 'inserted'){
		                            	$('.hdaysadd-error#inserted').fadeIn(300);
		                            	$('.hdaysadd-error#inserted').fadeOut(2500);
		                            	setTimeout(function(){$('#hdaysadd').fadeOut(500);}, 2000);
		                            	$('#hdays-wrapper').append('<a href="#" class="hday-active hdaysvalue" id="'+date+'">'+date+'</a>');
		                            }
		                        }
		                	})

	                    return false;
	                });

					// Scripts for the DPS add customer in the maintenance area
					$('#maintenance-addbutton').hide();

					$('#addcust-selectsales').change(function () {
						var cust_name = $('#cust_name').attr('value');
						var cust_add = $('#cust_add').attr('value');
						var billing_add = $('#billing_add').attr('value');
						var contact_num = $('#contact_num').attr('value');

						if(cust_name.length > 0 && cust_add.length > 0 && billing_add.length > 0 && contact_num.length > 0){
							$('#maintenance-addbutton').fadeIn(500);
						}

   						
	                    return false;
	                });


					$('#selected-custname').change(function () {
   						var cust_id = $(this).attr('value');

   						$('#append-custinfo').empty();

   						$.ajax({    
		                        url: "ajax_get_cust_info", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "id="+cust_id, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                        	
		                            $('#append-custinfo').html(data);
		                            
		                        }
		                	})

	                    return false;
	                });

					$('#selected_project_id').change(function () {
   						var id = $(this).attr('value');

   						//$('#append-projinfo').empty();

   						$.ajax({    
		                        url: "ajax_get_proj_info", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "id="+id, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                        	
		                            $('#append-projinfo').html(data);
		                            
		                        }
		                	})

	                    return false;
	                });

          //ADD DESIGN in Maintenance scripts
          $('.adddesign-but').click(function () {
              var value = $(this).prev().prev().prev().attr('value');
              var code = $(this).prev().attr('value');
              var property = $(this).parent().attr('id');

              //alert (encodeURIComponent(code));

              $.ajax({    
                    url: "ajax_design_insert", //The url where the server req would we made.
                    async: false, 
                    type: "POST", //The type which you want to use: GET/POST
                    data: "property="+property+"&value="+value+"&code="+encodeURIComponent(code), //The variables which are going.
                    dataType: "html", //Return data type (what we expect).
                     
                    //This is the function which will be called if ajax call is successful.
                    success: function(data) {
                      if(data == 'success'){
                        $('a#'+property).parent().css("background-color", "#dafcda");
                        $('a#'+property).prev().prev().prev().val('');
                        $('a#'+property).prev().val('');
                      }
                      
                    }
              })

              return false;
          });

	                
	                
					//SCRIPTS FOR THE CHECKING OF FORM NUMBER INPUT
					$('#form-num').change(function () {
   						var value = $(this).attr('value');
              var form  = $(this).parent().attr('class');

              

   						$.ajax({    
		                        url: "ajax_check_formnum", //The url where the server req would we made.
		                        async: false, 
		                        type: "POST", //The type which you want to use: GET/POST
		                        data: "value="+value+"&form="+form, //The variables which are going.
		                        dataType: "html", //Return data type (what we expect).
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                        	
		                            if(data >= 1){
		                            	new Messi(
		                            		'The form number is already in use.'
		                            		, 
		                            		{
		                            			title: 'Notification',
		                            			modal: true,
		                            			modalOpacity: .5,
		                            			buttons: [{id: 0, label: 'Close', val: 'X'}],

		                            		}
		                            	);
		                            	$('#form-num').val('');
		                            }
		                            
		                        }
		                	})

	                    return false;

   						
	                });

				    //Scripts fof the mobile version of DPS
				    //display all the north tables
					$('#today.mytable-wrapper-north').show();
					$('#tom.mytable-wrapper-north').show();


					//hide all the south tables
					$('#today.mytable-wrapper-south').hide();
					$('#tom.mytable-wrapper-south').hide();

					//when today north summary is click
					$("a#todaynorth-but").click(function()
					{
						$('#today.mytable-wrapper-south').hide();
						$('#today.mytable-wrapper-north').fadeIn(1000);
						return false;
					});

					//when today south summary is click
					$("a#todaysouth-but").click(function()
					{
						$('#today.mytable-wrapper-north').hide();
						$('#today.mytable-wrapper-south').fadeIn(1000);
						return false;
					});

					//when tom north summary is click
					$("a#tomnorth-but").click(function()
					{
						$('#tom.mytable-wrapper-south').hide();
						$('#tom.mytable-wrapper-north').fadeIn(1000);
						return false;
					});

					//when tom south summary is click
					$("a#tomsouth-but").click(function()
					{
						$('#tom.mytable-wrapper-north').hide();
						$('#tom.mytable-wrapper-south').fadeIn(1000);
						return false;
					});



          //chat scripts

          $('#chat-content-wrapper').hide();

          
          /*
          setInterval(function() {
              // Do something after 5 seconds
              $.get('chat/log.txt', function(data) {
                   var myArray = data.split('\n');
                   //alert (myArray);

                    // display the result in myDiv
                    for(var cnt=0;cnt<myArray.length;cnt++){
                        var msg = myArray[cnt];
                        //split myarray
                        var myArray2 = msg.split('-');
                        //alert (myArray2);
                        for(var i=0;i<myArray2.length;i++){

                          
                          
                          if(!myArray2[1] || !myArray2[2] || !myArray2[3]){   
                          }else{
                            if($(".msg-wrapper#" +cnt).length == 0) {
                                //it doesn't exist
                                $('#chat-messages').append('<div class="msg-wrapper" id="'+cnt+'"><div id="msg-header"><p id="name">'+myArray2[2]+' says:</p><p id="time">'+myArray2[1]+'</p></div><div id="msg-content">'+myArray2[3]+'</div></div>');
                                var objDiv = document.getElementById("chat-messages");
                                objDiv.scrollTop = objDiv.scrollHeight;
                              }
                          }
                          
                        }
                    }
                   
                    
                    
                });
          }, 1500);

*/


          $('#chat-togglebut').click(function() {
            $('#chat-content-wrapper').slideToggle(300, function() {
              // Animation complete.
              var text = $('#chat-togglebut').text();
              if(text === "Hide"){
                $('#chat-togglebut').text("Show");
                clearInterval(resizeTime);
              }else{
                $('#chat-togglebut').text("Hide");
                var objDiv = document.getElementById("chat-messages");
                objDiv.scrollTop = objDiv.scrollHeight;
                //start scanning msgs here
                
                resizeTime = setInterval(function() {
                    // Do something after 5 seconds
                    $.get('chat/log.txt', function(data) {
                         var myArray = data.split('\n');
                         //alert (myArray);

                          // display the result in myDiv
                          for(var cnt=0;cnt<myArray.length;cnt++){
                              var msg = myArray[cnt];
                              //split myarray
                              var myArray2 = msg.split('-');
                              //alert (myArray2);
                              for(var i=0;i<myArray2.length;i++){

                                
                                
                                if(!myArray2[1] || !myArray2[2] || !myArray2[3]){   
                                }else{
                                  if($(".msg-wrapper#" +cnt).length == 0) {
                                      //it doesn't exist
                                      //change the color of the header
                                      
                                      //$('#chat-header').css("background-color", "#D44332");
                                      $('#chat-messages').append('<div class="msg-wrapper" id="'+cnt+'"><div id="msg-header"><p id="name">'+myArray2[2]+' says:</p><p id="time">'+myArray2[1]+'</p></div><div id="msg-content">'+myArray2[3]+'</div></div>');
                                      var objDiv = document.getElementById("chat-messages");
                                      objDiv.scrollTop = objDiv.scrollHeight;
                                    }
                                }
                                
                              }
                          }
                         
                          
                          
                      });
                }, 1500);


              }
              
            });
          });

          $("#message-box").keyup(function(event){
              if(event.keyCode == 13){
                var text = $('#message-box').val();
                var user = $('#chat-username').attr('value');

                var logmsg = user+'-'+text;
                
                //write the message into the textfile
                $.ajax({    
                    url: "dps/ajax_write_chatmsg", //The url where the server req would we made.
                    async: false, 
                    type: "POST", //The type which you want to use: GET/POST
                    data: "message="+logmsg, //The variables which are going.
                    dataType: "html", //Return data type (what we expect).
                     
                    //This is the function which will be called if ajax call is successful.
                    success: function(data) {
                      //$('#chat-messages').append(text+'&#10;');
                      $('#message-box').val('');
                      //$('').scrollTop = $('#chat-messages').scrollHeight;
                      var psconsole = $('#chat-messages');
                      psconsole.scrollTop(
                          psconsole[0].scrollHeight - psconsole.height()
                      );
                    }
              })

              }
            return false;
          });


        
        $('#exp-customer-list').change(function () {
              var cust_id = $(this).attr('value');

              

              $.ajax({    
                  url: "ajax_get_customer_project", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "id="+cust_id, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                    
                      $('#project-list-formwrapper').html(data);
                      
                  }
            })

            return false;
        });



          //DEU Scripts start here

          $('.deu-add-time').datepicker({ dateFormat: 'yy-mm-dd' });

          $('#upload-sketch-notify').hide();
          $("a#upload-sketch-but").click(function()
          {
            var file_data = $("#sketch").prop("files")[0];  // Getting the properties of file from file field
            var cust = $("#cust").attr('value'); 
            var proj = $("#proj").attr('value'); 
            var address = $("#address").attr('value'); 

            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("file", file_data)             // Appending parameter named file with properties of file_field to form_data
            form_data.append("cust", cust)
            form_data.append("proj", proj)
            form_data.append("address", address)

            $(this).fadeOut(300);
            $('#upload-sketch-notify').fadeIn(1000);
            $('#upload-sketch-notify p').append('Uploading the image,please wait.');
            

            
            $.ajax({
                        url: "ajax_uploadsketch",
                        dataType: 'html',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: 'post',
                        success: function(data) {
                          
                                $('#upload-result-wrapper').html(data);
                                //$('#upload-sketch-notify').fadeOut(200);
                                $('#upload-sketch-notify p').fadeOut(100);
                                $('#upload-sketch-notify p').fadeIn(150);
                                $('#upload-sketch-notify p').empty();
                                $('#upload-sketch-notify p').append('Location sketch uploaded. - <a href="maintain_sketch">upload again?</a>');
                            }
               })
            return false;
          });


          $('#select-sketch-notify').hide();
          $('.selectable').live('click',function()
          {
            var id = $(this).attr('id');

            if($('.img-selectbox#'+id).attr('checked')){
                $('.img-selectbox#'+id).prop('checked', false);
                $('.selectable').not(this).parent().fadeIn(500);
                $('#selected-result').empty();
                $('#selected-image').val('');
                $('#select-sketch-notify').fadeOut(1000);
                $('#select-sketch-notify').empty();
              }else{
                $('.img-selectbox#'+id).prop('checked', true);
                $('.selectable').not(this).parent().fadeOut(1000);
                var wa = $('.selectable#'+id).attr('value');
                $('#selected-result').empty();
                $('#selected-result').append(wa);
                $('#selected-image').val(wa);

                $('#select-sketch-notify').fadeIn(1000);
                $('#select-sketch-notify').append(wa);
                
              }
            return false;
            
          });

          $('#useroption-wrapper').hide();
          $("#useredit").click(function()
          {
            $('#useroption-wrapper').slideToggle(100);
            
            return false;
          });



          
          $('#useredit-error').hide();
          $('#useredit-passerror').hide();
          $('#useredit-success').hide();
          $("a#useredit-updatebut").click(function()
          {
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


          
					

				   // Scripts for the upload image module using HTML5 Filereader API
           /*
				    document.getElementById('files').addEventListener('change', handleFileSelect, false);
				    function handleFileSelect(evt) {
					    var files = evt.target.files;
					    var f = files[0];
					    var reader = new FileReader();
					     
					      reader.onload = (function(theFile) {
					        return function(e) {
					          document.getElementById('image-preview').innerHTML = ['<img src="', e.target.result,'" title="', theFile.name, '" width="600" width="500" />'].join('');
					        };
					      })(f);
					       
					      reader.readAsDataURL(f);
					}*/

            });	

        </script>

</head>