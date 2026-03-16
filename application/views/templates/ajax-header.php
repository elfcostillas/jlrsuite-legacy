<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title></title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

	
	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
	


	

        <script type="text/javascript">
            $(document).ready(function () {

            	

            	$("#submenu").hide();
            	$("#option").click(function () {
				   $("#submenu").slideToggle(300);
				});


				// ---------------------------------------------------------------
				// FOR THE DPS MODULE - javascript below are use in the dps module
				// ---------------------------------------------------------------

				$('.dpsnotes-wrapper').hide();

	                $(".dpscust-item").hover(
					  function () {
					  	var id = $(this).parent().parent().parent().attr('id');
					    $('.dpsnotes-wrapper#'+id).fadeIn(1000);
					  }, 
					  function () {
					  	var id = $(this).parent().parent().parent().attr('id');
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

	                });	

				   


				   	//Scripts for the Scheduler Part
				   	

				   	$('.update-scheddate').click(function () {
	                    var id = $(this).parent().parent().attr('id');
	                    var linkId = $(this).attr('id');

	                    var dateValue = $(this).parent().prev().prev().prev().children('input.sched-datetime-input').attr('value');
	                    var timeValue = $(this).parent().prev().prev().children('select.sched-time-updater').attr('value');
	                    var statusValue = $(this).parent().prev().children('select.sched-designstatus-update').attr('value');

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
		                        		volume: estvolume
		                        	  },
		                        dataType: "html",
		                         
		                        //This is the function which will be called if ajax call is successful.
		                        success: function(data) {
		                            //data is the html of the page where the request is made.
		                            $('#'+linkId).parent().parent().css('background','#DFF2BF');
		                            $('#'+linkId).parent().prev().children('input.sched-datetime-input').css('background','#DFF2BF');
			                            
		                        }
		                	})
		                }
	                });

	                $('.update-act-vib').click(function () {
	                    var id = $(this).parent().parent().attr('id');
	                    var linkId = $(this).attr('id');
	                    document.write (id)
	                    var vib_use = $('.activeVibrator#'+id).attr('value');
	                    var qa_rep_a = $('.qa_rep#'+id).attr('value');
	                    

	                    if (confirm("Are you sure you want to update this record?"))
						{
							$.ajax({    
		                        url: "update_act_vib",
		                        async: false, 
		                        type: "POST",
		                        data: {
		                        		id: id, 
		                        		act_vib: vib_use,
		                        		qa_rep: qa_rep_a,
		                        		volume: estvolume
		                        	  },
		                        dataType: "html",
		  
		                    })
		                }
	                });


					//Scripts for the DPS Index
					


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

   						$('#append-projinfo').empty();

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
	                
	                
	                // SCRIPTS FOR THE PROJECT MAINTENANCE
	                if ($('.samplingchoice#others').is(':checked')) {
   							$('#sampling-extend').show();
					} else {
							$('#sampling-extend').hide();
					} 


					$('.samplingchoice').click(function () {
   						var id = $(this).attr('id');

   						if(id === 'standard'){
   							$('#sampling-extend').fadeOut(500);
   						}else{
   							$('#sampling-extend').fadeIn(500);
   						}
	                });

					if ($('.testingchoice#standard').is(':checked')) {
   							$('#testing-standard').show();
					} else {
							$('#testing-standard').hide();
					} 

					if ($('.testingchoice#others').is(':checked')) {
   							$('#testing-others').show();
						} else {
							$('#testing-others').hide();
						} 



					$('.testingchoice').click(function () {
   						//var id = $(this).attr('id');

   						if ($('.testingchoice#standard').is(':checked')) {
   							$('#testing-standard').fadeIn(500);
						} else {
							$('#testing-standard').fadeOut(500);
						} 

						if ($('.testingchoice#others').is(':checked')) {
   							$('#testing-others').fadeIn(500);
						} else {
							$('#testing-others').fadeOut(500);
						} 
	                });


					if ($('.witnesschoice#with').is(':checked')) {
   							$('#witness-extend').show();
					} else {
							$('#witness-extend').hide();
					} 

	                

					$('.witnesschoice').click(function () {
   						var id = $(this).attr('id');

   						if(id === 'with'){
   							$('#witness-extend').fadeIn(500);
   						}else{
   							$('#witness-extend').fadeOut(500);
   						}
	                });

				   

            });	
        </script>

</head>