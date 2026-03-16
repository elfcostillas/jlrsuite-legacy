<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	
	<!-- <meta http-equiv="Refresh" content="15"> -->

	<title><?php echo $title; ?> </title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

  <link rel="shortcut icon" href='<?php echo base_url("css/images/favicon.ico") ?>'>

  <!-- Stylesheets for Leave -->
  
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/main.css") ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/dps.css") ?>' />
    <!-- for the weekly scheduler -->
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rev2/weekly-sched.css") ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rev2/font-awesome.min.css") ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rev2/jquery.bxslider.css") ?>' />

    <link rel='stylesheet' type='text/css' media="print" href='<?php echo base_url("css/print.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/smoothness/jquery-ui-1.8.23.custom.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/jquery.timepicker.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/validationEngine.jquery.css") ?>' />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/messi.css") ?>" media="screen" />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rev2/sweetalert.css") ?>' />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.qtip.min.css") ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/mobile.css") ?>" media="screen" />



	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("js/main.js") ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("js/blink.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.idTabs.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.timepicker.js") ?>"></script>
<!--
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.23.custom.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.custom.min.js") ?>"></script>
-->
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui.min.js") ?>"></script>

	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine-en.js") ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine.js") ?>" charset="utf-8"></script>


	<script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/messi.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.qtip.min.js") ?>"></script>

	

	<script type="text/javascript" src="<?php echo base_url("js/rev2/sweetalert.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.collapse.js") ?>"></script>

	

  





  <script type="text/javascript">
    $(document).ready(function () 
    {
    	$('#mobilemenu').hide();

		$('#menu-toggle').click(function () {
			$('#mobilemenu').slideToggle();
			return false;
		});


		$('.mlink').click(function () {
			$('#mobilemenu').slideUp(300);
			return true;
		});


          $('.blink').blink();

          
          $('.m-unapproved').blink();
          
          $('.revisestatus').blink();

          $('.blink-cust-coor').blink();

          $('.timeinput').timepicker({ 'timeFormat': 'HH:mm', 'step': 15});

          //$("#submenu").hide();
          $("#option").click(function () {
             $("#submenu").slideToggle(300);
          });


          $(".image-expand").fancybox({
            openEffect  : 'none',
            closeEffect : 'none'
          });

          $('.print').hide();


          $(".landmark_box").fancybox({
            openEffect  : 'elastic',
            closeEffect : 'elastic',

            helpers : {
              title : {
                type : 'float'
              }
            }
          });
                                              
                                            

  				// ---------------------------------------------------------------
  				// FOR THE DPS MODULE - javascript below are use in the dps module
  				// ---------------------------------------------------------------

  			$('.lvl1').qtip({
				content: 'Sales & Marketing'
			});
			$('.lvl2').qtip({
				content: 'Accounting'
			});
			$('.lvl3').qtip({
				content: 'Plant Supervisor'
			});
			$('.lvl4').qtip({
				content: 'QA Department'
			});
			$('.addnoteform').qtip({
				content: 'Click to add a note.'
			});
			$('.managerapproved-but').qtip({
				content: 'Click once to Approved All Schedules.'
			});
			
			




	        $("#lock-button").toggle(function() { 
                $('#dps-project-customerinfo :input').attr('disabled',true);
                },
                 function() { 
                $('#dps-project-customerinfo :input').attr('disabled', false);
            });


          $(".recent-pour").click(function(){
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
				  $("#add-table-row").click(function(){
				    // add new row to table using addTableRow function
				    addTableRow($("#dps-addproject"));
				 
				    // prevent button redirecting to new page
				    return false;
				  });


				  // function to add a new row to a table by cloning the last row and
				  // incrementing the name and id values by 1 to make them unique
				  function addTableRow(table){
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
				  $("#remove-last-table-row").click(function(){
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
			    $("#check-hasentfee").click(function(){
					  if ($('#check-hasentfee').is(':checked')) {
						    $("#check-entfee").fadeIn(500);
						} else {
						    $("#check-entfee").fadeOut(500);
						} 
				  });


			   $("#check-others").hide();
			   $("#check-hasothers").click(function(){
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

			   $("#check-add-pipes").click(function(){
					  if ($('#check-add-pipes').is(':checked')) {
						    $("#add-pipes-num").fadeIn(500);
						} else {
						    $("#add-pipes-num").fadeOut(500);
						} 
				  });


                            				   
			   $("#check-add-vibrator").click(function(){
					  if ($('#check-add-vibrator').is(':checked')) {
						    $("#add-vibrator-pesos").fadeIn(500);
						} else {
						    $("#add-vibrator-pesos").fadeOut(500);
						} 
				  });

			   $("#check-add-others").click(function(){
					  if ($('#check-add-others').is(':checked')) {
						    $("#add-others-value").fadeIn(500);
						} else {
						    $("#add-others-value").fadeOut(500);
						} 
				  });


			   //Scripts below are for SAMPLING PROCEDURE in the add project form 1

			   $("#samp-others-wrapper").hide();

			   $(".sampling-radio").click(function(){
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
			   $('.witness-choice').click(function(){
					  if ($('#witness-with').is(':checked')) {
						    $(".witness-wrapper").fadeIn(500);
						    
						} else {
						    $(".witness-wrapper").fadeOut(500);
						    
						} 
				  });
			   

			   $("#check-testing-jlrlab").click(function(){
					  if ($('#check-testing-jlrlab').is(':checked')) {
						    $("#test-jlrlab").fadeIn(500);
						    
						} else {
						    $("#test-jlrlab").fadeOut(500);
						} 
				  });

			   $("#check-testing-external").click(function(){
					  if ($('#check-testing-external').is(':checked')) {
						    $(".test-extlab").fadeIn(500);
						    $("#extlab-input-wrappers").fadeIn(500);
						    
						} else {
						    $(".test-extlab").fadeOut(500);
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

            //get the contract no
            $.ajax({    
                url: "ajax_getproject_contract", //The url where the server req would we made.
                async: false, 
                type: "POST", //The type which you want to use: GET/POST
                data: "id="+projectId, //The variables which are going.
                dataType: "html", //Return data type (what we expect).

                success: function(data) {
                    $("#contract-num").val(data);
                }
            })
          });

  			  //Scripts for the Scheduler Part
          //$('.coorotheredit-wrapper').hide();

          $(".toggleothers").toggle(function(){
		    $(".coorotheredit-wrapper").fadeOut(500);},
		    function(){
		    $(".coorotheredit-wrapper").fadeIn(500);}
		  );

          $(".coor-others-but").click(function(){
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

                                        

  				/*$('.sched-datetime-input').datepicker({
					  //dateFormat: 'yy-mm-dd'
  				});*/

					$(".sched-datetime-input").datepicker({
						dateFormat: 'yy-mm-dd',
					    onSelect: function(dateText, inst) {
					        
					        //get the value of the temp date
					        var new_date = $(this).val();
					        var tmp_date = $(this).prev().val();

					        //get the status value for backup
					        var tmp_status = $(this).parent().next().next().children('.cls-tmp-status').val();



					        //compare the two dates
					        if(new_date == tmp_date){
					        	$(this).parent().next().next().children('.sched-designstatus-update').val(tmp_status);
					        }else{
					        	//change the status value to re-sched
					        	$(this).parent().next().next().children('.sched-designstatus-update').val('Re-Sched');
					        }
					        
					    }
					});

  				//listen for the change here

	  			$('.update-scheddate').click(function () {
	                      var id = $(this).parent().parent().attr('id');
	                      var linkId = $(this).attr('id');

	                      var smdstatus = $(this).parent().children('#scheduler-smdstatus').attr('value');
	                      
	                      var dateValue_tmp = $(this).parent().prev().prev().prev().prev().children('input.sched-datetime-tmp').attr('value');
	                      var dateValue = $(this).parent().prev().prev().prev().prev().children('input.sched-datetime-input').attr('value');
	                      var oldtimeValue = $(this).parent().prev().prev().prev().children('p#orig-date').attr('value');
	                      var timeValue = $(this).parent().prev().prev().prev().children('select.sched-time-updater').attr('value');
	                      var statusValue = $(this).parent().prev().prev().children('select.sched-designstatus-update').attr('value');

	                      var proj_name = $('.proj_name#'+id).attr('value');
	                      var proj_address = $('.proj_address#'+id).attr('value');


	                      var str = $('.str#'+id).attr('value');
	                      var agg = $('.agg#'+id).attr('value');
	                      var curing = $('.curing#'+id).attr('value');
	                      var slump = $('.slump#'+id).attr('value');

	                      //temp for comparing
	                      var tmp_str = $('.tmp-str#'+id).attr('value');
	                      var tmp_agg = $('.tmp-agg#'+id).attr('value');
	                      var tmp_curing = $('.tmp-curing#'+id).attr('value');
	                      var tmp_slump = $('.tmp-slump#'+id).attr('value');


	                      var pouring = $('.pouring#'+id).attr('value');
	                      var structure = $('.structure#'+id).attr('value');
	                      var remarks = $('.remarks#'+id).attr('value');
	                      var estvolume = $('.estvolume#'+id).attr('value');

	                      var pipes = $('.add-pipes#'+id).attr('value');
	                      var vibrator = $('.add-vibrator#'+id).attr('value');
	                      var slumpcone = $('.add-slumpcone#'+id).attr('value');
	                      var beam = $('.add-beam#'+id).attr('value');
	                      var others = $('.add-others#'+id).attr('value');

	                      var vibrator_no = $('.vibrator-no#'+id).attr('value');
	                      var pumpcharge_no = $('.pumpcharge-no#'+id).attr('value');

	                      var po = $('.po-no#'+id).attr('value');

	                      var whatday = $(this).parent().children('#schedpage').attr('value');
	                      var plant = $(this).parent().children('#schedplant').attr('value');

	                      //alert(dateValue_tmp);


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
				                          		oldtime: oldtimeValue,
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
				                                smd_status: smdstatus,
				                                tmp_str: tmp_str,
				                          		tmp_agg: tmp_agg,
				                          		tmp_curing: tmp_curing,
				                          		tmp_slump: tmp_slump,
				                          		vibrator_no: vibrator_no,
				                          		pumpcharge_no: pumpcharge_no,
				                          		po_no: po,
				                          		whatday: whatday,
				                          		tmpdate: dateValue_tmp,
				                          		plant: plant,
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

				$('.update-act-vib').click(function () {
	                    var id = $(this).parent().parent().attr('id');
	                    var linkId = $(this).attr('id');
	                    var vib_use = $('.activeVibrator#'+id).attr('value');
	                    var qa_rep_a = $('.qa_repv#'+id).attr('value');
	                    

	                    if (confirm("Are you sure you want to update this record?"))
						{
							$.ajax({    
		                        url: "update_act_vib",
		                        async: false, 
		                        type: "POST",
		                        data: {
		                        		id: id, 
		                        		act_vib: vib_use,
		                        		qa_rep: qa_rep_a
		                        	  },
		                        dataType: "html",
		                    })
		                }
	                });

				$('.update-scheddate-advance').click(function () {
	                      var id = $(this).parent().parent().attr('id');
	                      var linkId = $(this).attr('id');

	                      var smdstatus = $(this).parent().children('#scheduler-smdstatus').attr('value');
	                      

	                      var dateValue = $(this).parent().prev().prev().prev().prev().children('input.sched-datetime-input').attr('value');
	                      var oldtimeValue = $(this).parent().prev().prev().prev().children('p#orig-date').attr('value');
	                      var timeValue = $(this).parent().prev().prev().prev().children('select.sched-time-updater').attr('value');
	                      var statusValue = $(this).parent().prev().prev().children('select.sched-designstatus-update').attr('value');

	                      var proj_name = $('.proj_name#'+id).attr('value');
	                      var proj_address = $('.proj_address#'+id).attr('value');


	                      var str = $('.str#'+id).attr('value');
	                      var agg = $('.agg#'+id).attr('value');
	                      var curing = $('.curing#'+id).attr('value');
	                      var slump = $('.slump#'+id).attr('value');

	                      //temp for comparing
	                      var tmp_str = $('.tmp-str#'+id).attr('value');
	                      var tmp_agg = $('.tmp-agg#'+id).attr('value');
	                      var tmp_curing = $('.tmp-curing#'+id).attr('value');
	                      var tmp_slump = $('.tmp-slump#'+id).attr('value');


	                      var pouring = $('.pouring#'+id).attr('value');
	                      var structure = $('.structure#'+id).attr('value');
	                      var remarks = $('.remarks#'+id).attr('value');
	                      var estvolume = $('.estvolume#'+id).attr('value');

	                      var pipes = $('.add-pipes#'+id).attr('value');
	                      var vibrator = $('.add-vibrator#'+id).attr('value');
	                      var slumpcone = $('.add-slumpcone#'+id).attr('value');
	                      var beam = $('.add-beam#'+id).attr('value');
	                      var others = $('.add-others#'+id).attr('value');

	                      var vibrator_no = $('.vibrator-no#'+id).attr('value');
	                      var pumpcharge_no = $('.pumpcharge-no#'+id).attr('value');

	                      var po = $('.po-no#'+id).attr('value');

	                      


	                        if (confirm("Are you sure you want to update this record?"))
	          						{
	          							$.ajax({    
				                          url: "update_sched_date_advance",
				                          async: false, 
				                          type: "POST",
				                          data: {
				                          		id: id, 
				                          		date: dateValue,
				                          		time: timeValue,
				                          		oldtime: oldtimeValue,
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
				                                smd_status: smdstatus,
				                                tmp_str: tmp_str,
				                          		tmp_agg: tmp_agg,
				                          		tmp_curing: tmp_curing,
				                          		tmp_slump: tmp_slump,
				                          		vibrator_no: vibrator_no,
				                          		pumpcharge_no: pumpcharge_no,
				                          		po_no: po,
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





				//For Batching upload button 

				$('.update-upload').click(function(){

					if(confirm('Are you sure you want to update this record?')){
						
						var id = $(this).parent().parent().attr('id');
						var linkId = $(this).attr('id');
					

                        $.ajax({
                        	url:"update_upload_stat",
                        	async:false,
                        	type:"POST",
                        	data: {
                        		id : id,                   
                        	},
                        	dataType:"html",
                        	success : function(data){
               						
                        			swal({   
                        				title: "success!",   
                        				text:  "Successfully Upload",
                        				type:  "success",
                        				timer: 700,   
                        				showConfirmButton: false 
                        			});

                        			$('#'+id).css('background','#fff2f2');
                        			$('#'+linkId).next('#upselected'+linkId).attr('disabled',false);
                        			$('#'+linkId).parent().prev('#stat'+linkId).html('For Upload');
                        			$('#img'+linkId).attr('src','<?php echo base_url("css/images/upload.png")?>');
                        			$('#img'+linkId).attr('title','Upload');                        			
                        			$('#'+linkId).off("click");
                        												
                        				
                         	}
                        })
					}
					return false;
				});
				
				//hide the Upload button
				$('.upload-approved-submit').hide();
                $('.upload-select-checkbox').click(function(){
                	var linkId = $(this).attr('id');
                	var counter = $('#selectcounter').attr('value');
                	
                	
                	if( $('#'+linkId).is(':checked') ) {
                		$('#'+linkId).parent().parent().css('background','#FEEFB3');              		
                		counter ++;
                		$('#selectcounter').attr('value',counter);

                	}else{
                		$('#'+linkId).parent().parent().css('background','#FFFFFF');               		
                		counter --;
                		$('#selectcounter').attr('value',counter);
                	}

                	//check if counter is not zero---if zero then button is hide
                	if(counter === 0 ){
  						$('.upload-approved-submit').fadeOut(500);
  					}
  					else{
  						$('.upload-approved-submit').fadeIn(500);

  					}

                }); 



                $('#btn-top').hide();
				$('#btn-top').click(function(){
					$("html, body").scrollTop(0);
				});
			
				$(window).scroll(function() {
    				
        			if ($(this).scrollTop() > 35 ) {
        				$('#btn-top').fadeIn(200);
    				}else {
        				$('#btn-top').fadeOut(100);
   					}
				});







                              					
  				//hide the approved button
  				$(".scheduler-approved-submit").hide();

  				$(".sched-select-checkbox").click(function(){
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
						swal({   
                        			title: "success!",   
                        			text:  "Successfully Update!",
                        			type:  "success",
                        			timer: 700,   
                        			showConfirmButton: false 
                    	});


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
          /*For finance search button search by date*/
           $('#searchbut-bydate-FID').click(function () {
              var date = $('#bydate-date').attr('value');
              
              $.ajax({    
                  url: "ajax_searchbydate_FID", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "date="+date, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                            //data is the html of the page where the request is made.
                          $('#searchbyform-result').empty();
                          $('#searchbydate-result-FID').fadeIn(1000);
                          $('#searchbydate-result-FID').html(data);     
                  }
              })

              return false; 
          });
        	/*For finance search button search by customer*/
           $('#searchbut-bycust-FID').click(function () {
              var cust = $('#bycust-cust').attr('value');
              var cust_name = $('#bycust-cust option:selected').text();
              
              $.ajax({    
                  url: "ajax_searchbycust", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "cust="+cust+"&name="+ encodeURIComponent(cust_name), //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                            //data is the html of the page where the request is made.
                          $('#searchbyform-result').empty();
                          $('#searchbydate-result-FID').fadeIn(1000);
                          $('#searchbydate-result-FID').html(data);     
                  }
              })

              return false; 
          });



          //search by customer
          $('#searchbut-bycust').click(function () {
              var cust = $('#bycust-cust').attr('value');
              var cust_name = $('#bycust-cust option:selected').text();
              // alert(cust_name);
              $.ajax({    
                  url: "ajax_searchbycust", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "cust="+cust+"&name="+ encodeURIComponent(cust_name), //The variables which are going.
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

          
          $('.pendingsched-updatebut').click(function () {
          		var id = $(this).attr('id');
              	var date = $('.pendingsched-date#'+id).attr('value');
              	var status = $('#designstatus'+id).attr('value');
              	

              	

              
              $.ajax({    
                  url: "ajax_updatepending", //The url where the server req would we made.
                  async: false, 
                  type: "POST", //The type which you want to use: GET/POST
                  data: "date="+date+"&id="+id+"&status="+status, //The variables which are going.
                  dataType: "html", //Return data type (what we expect).
                   
                  //This is the function which will be called if ajax call is successful.
                  success: function(data) {
                        if(data === 'okay'){
                        	$('.pendingsched-updatebut#'+id).parent().siblings().css('background','#CCFFCC');
                        	$('.pendingsched-updatebut#'+id).parent().css('background','#CCFFCC');
                        }              
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
		            var remarks = $(this).parent().prev().prev().children('select.acctg-remarks').attr('value');

		            var otherremarks = $(this).parent().prev().children('#acctg-otherrem').attr('value');


		            if (confirm("Are you sure you want to update this?"))
		            {
		  	          $.ajax({    
		                  url: "update_acctg_remarks", //The url where the server req would we made.
		                  async: false, 
		                  type: "POST", //The type which you want to use: GET/POST
		                  data: "id="+id+"&remarks="+remarks+"&date="+sched_date+"&notes="+otherremarks, //The variables which are going.
		                  dataType: "html", //Return data type (what we expect).
		                   
		                  //This is the function which will be called if ajax call is successful.
		                  success: function(data) {
		                      //data is the html of the page where the request is made.
		                      $('#'+linkId).parent().parent().css('background','#e4edfe');
		                      //$('#tab2').load('dps/edit_pouring_today');
		                      if (data === 'prepaid'){
		                         window.location.reload();
		                     }
		                  }
		            	})
		            }
		            return false;
		        });

				//----mobile
				$('.m-acctg-updatebut').click(function () {
		            var id = $(this).parent().parent().parent().attr('id');
		            var linkId = $(this).attr('id');
		            var sched_date = $(this).next().attr('value');
		            var remarks = $(this).parent().prev().children('#acctg-remarks'+id).attr('value');

		            var otherremarks = $(this).parent().parent().next('tr').children('td').children('#acctg-otherrem').attr('value');


		            if (confirm("Are you sure you want to update this?"))
		            {
		  	          $.ajax({    
		                  url: "update_acctg_remarks", //The url where the server req would we made.
		                  async: false, 
		                  type: "POST", //The type which you want to use: GET/POST
		                  data: "id="+id+"&remarks="+remarks+"&date="+sched_date+"&notes="+otherremarks, //The variables which are going.
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
		            var modtime = $(this).next().next().attr('value');
		            var sched_time = $(this).parent().prev().prev().prev().prev().prev().children('select#schedtime'+id).attr('value');
		            var sched_date = $(this).next().attr('value');
		            var servEngr = $(this).parent().prev().prev().prev().children('select#servengr'+id).attr('value');
		            var batchPlant = $(this).parent().prev().prev().prev().prev().children('select#batch-plant'+id).attr('value');
		            var timestat = 0;

		            //check if modtime is equal to the time
		            //change = 1
		            //no change = 0


		            if(modtime === sched_time){
		            	timestat = 0;
		            }else{
		            	timestat = 1;
		            }

		            //alert(timestat);
		            
		            
		            
		            if (confirm("Are you sure you want to update this?"))
		            {
		  		        $.ajax({    
		                    url: "update_supervisor", //The url where the server req would we made.
		                    async: false, 
		                    type: "POST", //The type which you want to use: GET/POST
		                    data: "id="+id+"&servengr="+servEngr+"&batchplant="+batchPlant+"&date="+sched_date+"&time="+sched_time+"&timestat="+timestat, //The variables which are going.
		                    dataType: "html", //Return data type (what we expect).
		                     
		                    //This is the function which will be called if ajax call is successful.
		                    success: function(data) {
		                        //data is the html of the page where the request is made.
		                        //$('#'+linkId).parent().parent().css('background','#e4edfe');
		                        $("tr#"+id).css('background','#e4edfe');
		                        //$('#tab2').load('dps/edit_pouring_today');
		                          
		                    }
		            	})
		            }
		            
		            
		            
		            
		            
		            return false;
		        });

				//-----> 
		        $('.m-supervisor-updatebut').click(function () {
		            var id = $(this).parent().parent().parent().attr('id');
		            var linkId = $(this).attr('id');
		            var sched_date = $(this).next().attr('value');
		            
		            var batchPlant = $(this).parent().prev().children('select#batch-plant'+id).attr('value');
		            var servEngr = $(this).parent().parent().next('tr').children('td').children('#servengr'+id).attr('value');
		            

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
  				
  				//$('.dpsnotes-wrapper notesshow').show();
  				$('.dpssmdsched-wrapper').hide();
  				$('.dpsnotes-wrapper').hide();
  				$('.dpsnotes-wrapper').filter('.notesshow').show();

  				$('.dpscontacts-wrapper').hide();
  				

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


          	$(".dpsproj-item").hover(
  				  function () {
  				  	  var sched_id = $(this).attr('id');
  				  	  var id = $(this).parent().parent().parent().parent().attr('id');

		              
		              
		              $.ajax({    
		                  url: "dps/ajax_search_contacts", //The url where the server req would we made.
		                  async: false, 
		                  type: "POST", //The type which you want to use: GET/POST
		                  data: "schedid="+sched_id, //The variables which are going.
		                  dataType: "html", //Return data type (what we expect).
		                   
		                  //This is the function which will be called if ajax call is successful.
		                  success: function(data) {
		                            //data is the html of the page where the request is made.
	                         $('.dpscontacts-wrapper#'+id).empty();
	                         $('.dpscontacts-wrapper#'+id).fadeIn(500);
	                         $('.dpscontacts-wrapper#'+id).html(data);     
		                  }
		              })


		              return false; 
  				  },
  				  function () {
  				  			var id = $(this).parent().parent().parent().parent().attr('id');
  				  			$('.dpscontacts-wrapper#'+id).empty();
	                        $('.dpscontacts-wrapper#'+id).fadeOut(500);
  				  }
  			  );


			$(".smdcust-item").hover(

  				  function () {
  				  	var id = $(this).attr('id');
  				  	$('.dpssmdsched-wrapper#'+id).fadeIn(500);
  				  	
  				  },
  				  //hover callback
  				  function () {
		  			var id = $(this).attr('id');
		  			$('.dpssmdsched-wrapper#'+id).fadeOut(200);
  				  }
  				  
  			);
          


  			//$('.dpsnotes-form').hide();

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
                  
          $('.spcheck').hide();
          var i = 0;
          $('.batch-plant,.servengr,.schedtimeplant').change(function() {
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

              if(property == 'structures' && code == '')
              {
              	alert('Cannot accept blank Information.');

              }
              else if(property == 'structures' && code.length >= 26)
              {
              	alert("Structure name is too long! limited to 25 characters only.");
              }
              else
              {
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
              }
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





     //      //chat scripts
     //      $.ajaxSetup({ cache: false });

     //      //$('#chat-content-wrapper').hide();
     //      $('#chat-togglebut').click(function() {
     //        $('#chat-content-wrapper').slideToggle(300, function() {
     //          // Animation complete.
     //          var text = $('#chat-togglebut').text();
     //          if(text === "Hide"){
     //            $('#chat-togglebut').text("Show");
     //            clearInterval(resizeTime);
     //          }else{
     //            $('#chat-togglebut').text("Hide");
     //            var objDiv = document.getElementById("chat-messages");
     //            objDiv.scrollTop = objDiv.scrollHeight;
     //            //start scanning msgs here
                
     //            resizeTime = setInterval(function() {
     //                // Do something after 5 seconds
     //                $.get('chat/log.txt', function(data) {
     //                	 cache: false
     //                     var myArray = data.split('\n');
     //                     //alert (myArray);

     //                      // display the result in myDiv
     //                      for(var cnt=0;cnt<myArray.length;cnt++){
     //                          var msg = myArray[cnt];
     //                          //split myarray
     //                          var myArray2 = msg.split('-');
     //                          //alert (myArray2);
     //                          for(var i=0;i<myArray2.length;i++){

                                
                                
     //                            if(!myArray2[1] || !myArray2[2] || !myArray2[3]){   
     //                            }else{
     //                              if($(".msg-wrapper#" +cnt).length == 0) {
     //                                  //it doesn't exist
     //                                  //change the color of the header
                                      
     //                                  //$('#chat-header').css("background-color", "#D44332");
     //                                  $('#chat-messages').append('<div class="msg-wrapper" id="'+cnt+'"><div id="msg-header"><p id="name">'+myArray2[2]+' says:</p><p id="time">'+myArray2[1]+'</p></div><div id="msg-content">'+myArray2[3]+'</div></div>');
     //                                  var objDiv = document.getElementById("chat-messages");
     //                                  objDiv.scrollTop = objDiv.scrollHeight;
     //                                }
     //                            }
                                
     //                          }
     //                      }
     //                });

					// //read the onlineusers.txt for the list of online usersin the dps
					// $.get('chat/onlineusers.txt', function(data) {

     //                     var myArray = data.split('\n');
     //                     //alert (myArray);

     //                      // display the result in myDiv
     //                      $('#chat-online-wrapper').empty();
     //                      for(var cnt=0;cnt<myArray.length;cnt++){
     //                          //print myArray[cnt]; 
     //                          $('#chat-online-wrapper').append('<li>'+myArray[cnt]+'</li>');
     //                      }
                          
     //                      var olusers = myArray.length - 1;
     //                      $('#olusers-count').empty();
     //                      $('#olusers-count').append(olusers);
     //                });
     //            }, 3000);


     //          }
     //        });
     //      });//lol








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

          $('#upload-sketch-notify').hide();
          $("a#upload-sketch-but").click(function(){
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
          $('.selectable').live('click',function(){
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

			//SMD UNAPPROVED
	          $('.unapproved-button').click(function () {
	              var id = $(this).attr('id');
	              
	              $.ajax({    
	                    url: "ajax_unapproved_smd", //The url where the server req would we made.
	                    async: false, 
	                    type: "POST", //The type which you want to use: GET/POST
	                    data: "id="+id, //The variables which are going.
	                    dataType: "html", //Return data type (what we expect).
	                     
	                    //This is the function which will be called if ajax call is successful.
	                    success: function(data) {
	              
	                     	if(data === '1'){
	                     		$('.unapproved-button#'+id).parent().parent().css("background-color", "#F8F8F8");
	                     	}else{
	                     		alert('Problem occured while updating this record.');
	                     	}
	                        
	                    }
	              })

	              return false;
	        });

	        //For Prepaid button 
	        //added by WBSOLON Nov 19,2018 

	        //SMD PREPAID BUTTON
	         $('.prep-but').click(function () {
	         	var id = $(this).attr('id');
	         	if(confirm("Are you sure to change prepaid?")){

	         		$.ajax({
	         			url: "ajax_prepaid_smd",
	         			async : false,
	         			type : "POST",
	         			data :"id="+id,
	         			dataType : "html",
	         				success : function (data){
	         					swal({   
                        				title: "success!",   
                        				text:  "Successfully Upload",
                        				type:  "success",
                        				timer: 700,   
                        				showConfirmButton: false 
                        			});	         					
	         						$('.prep-but#'+id).hide();	
	         						
	         			}
	         		})
	         		
	         	}
	         	return false;
	         });

	         //mobile SMD PREPAID BUTTON
	         $('.mobile-prep-but').click(function () {
	         	var id = $(this).attr('id');
	         	if(confirm("Are you sure to Update?")){
	         	$.ajax({
	         			url: "ajax_prepaid_smd",
	         			async : false,
	         			type : "POST",
	         			data :"id="+id,
	         			dataType : "html",
	         				success : function (data){
	         					swal({   
                        				title: "success!",   
                        				text:  "Successfully Upload",
                        				type:  "success",
                        				timer: 700,   
                        				showConfirmButton: false 
                        			});	         					
	         						$('.mobile-prep-but#'+id).hide();	         						
	         			}
	         		})
	         	}
	         	return false;
	         });  



			//scripts added by ralph april 7, 2014 for the smd approval mobile version
			$(".smdmobile-appbut").hide();
			$(".smd_mobilecheck").click(function(){
				var id = $(this).attr('id');

			  	if ($('.smd_mobilecheck#'+id).is(':checked')) {
			  		//$(this).closest("tbody").attr("id")
				    $('tbody#'+id).addClass("smdmobile-selapp");
				    $(".smdmobile-appbut").fadeIn();
				} else {
				    $('tbody#'+id).removeClass("smdmobile-selapp");
				} 
			});

			$("tbody").click(function(){
				var id = $(this).attr('id');
				$('tbody').removeClass("smdmobile-sel-tbody");
				$('tbody#'+id).addClass("smdmobile-sel-tbody");
			});

			
			$('#weekly-sched-container').hide();
			$('#display-switcher').click(function () {
				var but_class = $(this).children('i').hasClass('fa-list');

				if(but_class == true){
					//currently displaying a weekly sched
					$(this).children('i').removeClass('fa-list').addClass('fa-th');

					$('#weekly-sched-container').css('visibility','hidden');
					$('#weekly-sched-container').hide();

					$('#daily-sched-container').css('visibility','visible');
					$('#daily-sched-container').show();

				}else{
					//currently displaying the old table
					$(this).children('i').removeClass('fa-th').addClass('fa-list');
					$('#weekly-sched-container').css('visibility','visible');
					$('#weekly-sched-container').show();

					$('#daily-sched-container').css('visibility','hidden');
					$('#daily-sched-container').hide();
				}



				return false;
			});



			//added by ralph august 14, 2015 for the smd to update the contract
			$('.contract-update-but').click(function () {
		            var id = $(this).attr('id');
		            var contract_no = $(this).parent().prev().children('#contract'+id).attr('value');

		            if(contract_no === '' || contract_no === '0'){
		            	swal({   
                        	title: "Error!",   
                        	text: "Contract number must not be Blank or Zero.",
                        	type: "error",
                        	timer: 2000,   
                        	showConfirmButton: false 
                        });
		            }else{
		            	swal({   
			            	title: "Are you sure?",   
			            	text: "You want to update this record.",   
			            	type: "warning",   
			            	showCancelButton: true,   
			            	confirmButtonColor: "#40d47e",   
			            	confirmButtonText: "Yes, update it!",   
			            	closeOnConfirm: false 
			            }, 
			            function(){ 
			            	$.ajax({    
			                    url: "ajax_update_contract",
			                    async: false, 
			                    type: "POST", 
			                    data: "id="+id+"&contract="+contract_no,
			                    dataType: "html", 
			                     
			                    
			                    success: function(data) {

			                    	if(data == 'ok'){
			                    		swal({   
				                        	title: "Success!",   
				                        	text: "Updated Successfully.",
				                        	type: "success", 
				                        	timer: 1000,   
				                        	showConfirmButton: false 
				                        });

				                        //get the red class on the input box
				                        $('#contract'+id).removeClass('contract-blank');

			                    	}else{
			                    		swal({   
				                        	title: "Error!",   
				                        	text: "A problem occured,please contact IT.",
				                        	type: "error",
				                        	timer: 2000,   
				                        	showConfirmButton: false 
				                        });
			                    	}   
			                    }
			            	})
			            });

			            return false;
			        }
			});

			$('.mobile-acctg-terms-btn').click(function () {
				var notes = $(this).attr('id');
				swal({   
					title: "Finance Note",   
					text: "<span style='color:#3F82C8;font-weight:bold;'>" + notes + "<span>",
					html: true 
				});

				event.preventDefault();
			});


			
    });	
  </script>

</head>