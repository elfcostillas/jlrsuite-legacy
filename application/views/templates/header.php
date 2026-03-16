<html>
<head>
	<title><?php echo $title ?> - JLRegner System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/smoothness/jquery-ui-1.8.23.custom.css") ?>' />
	<link rel='stylesheet' type='text/css' media="print" href='<?php echo base_url("css/print.css") ?>' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url("css/table.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/jquery.timepicker.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/validationEngine.jquery.css") ?>' />

	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.23.custom.min.js") ?>"></script>

	
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine-en.js") ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine.js") ?>" charset="utf-8"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />


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

            	$('#approve-pending').fancybox({
            		'width'     : '80%',
        			'height'    : '80%',
        			'scrolling' : 'auto'
            	});

            	

            	$('.print').hide();
            	$('#search_year_dropdown').hide();
                $('#empname_search').change(function () {
                    $('#search_year_dropdown').show();
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
				$('#add-leave-submit').click(function()
				{

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


                $(".edit-leave-records").fancybox({
					
					fitToView	: false,
					width		: '60%',
					height		: '40%',
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none'
				});
                
                $('#get_leave_credits_result').hide();
                $('#edit-credits-wrapper').hide();
                $('#edit-credits').hide();
                $('#add-credits-wrapper').hide();
				$('#credits_empname').change(function () {
                    //var selFilter = 'department';
                    var id = $(this).attr('value');
                    var year = $('#credits_year').attr('value');

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
                          			$('#get_leave_credits_result').html(data);
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



            });


            
			
        </script>
	

</head>
<body>

	<div id="header" class="grid-940">
		<h1></h1>
		
		<h2>Leave Monitoring - <?php echo $title ?></h2>
		<?php
				$datestring = " %F %d, %Y";
				$time = time();

				echo "<p>Today is : " . mdate($datestring, $time) . "</p>";
			?>

	</div>

	<div id="navigation">
	  <ul>
	    <li>
	    	<?php
	    		
	    		if ($linkclass == 'attendance'){
	    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
	    			echo anchor('leaves', 'Attendance Reports', $attrib);
	    		} 
		    	else{
		    		echo anchor('leaves', 'Attendance Reports','title="Attendance Monitoring"');
		    	}  	
		    ?>
	    </li>

	    <li>
	    	<?php
	    		if ($linkclass == 'leaves'){
	    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
	    			echo anchor('leaves/leave', 'Leaves', $attrib);
	    		}
	    		else{
	    			echo anchor('leaves/leave', 'Leaves', 'title="Leave Monitoring"');
	    		}	
	    	?>
	      <ul>
	        <li>
	        	<?php
		    		if ($linkclass == 'addleave'){
		    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
		    			echo anchor('leaves/addleave', 'Add Leave',$attrib);
		    		}
		    		else{
		    			echo anchor('leaves/addleave', 'Add Leave', 'title="Add a Leave"');
		    		}	
	    		?>
	        </li>

	        <li>
	        	<?php
		    		if ($linkclass == 'search'){
		    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
		    			echo anchor('leaves/searchemployee', 'Search Employee',$attrib);
		    		}
		    		else{
		    			echo anchor('leaves/searchemployee', 'Search Employee', 'title="Search Employee"');
		    		}	
	    		?>
	        	
	        </li>   
	      </ul> 
	     </li>
	    <li>
	    	<?php
		    		if ($linkclass == 'maintenance'){
		    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
		    			echo anchor('leaves/maintenance', 'Maintenance',$attrib);
		    		}
		    		else{
		    			echo anchor('leaves/maintenance', 'Maintenance', 'title="Leave Monitoring"');
		    		}	
	    	?>
	    	
	      <ul>
	        <li>
	        	<?php
		    		if ($linkclass == 'leaverecords'){
		    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
		    			echo anchor('leaves/leaverecords', 'Leave Records',$attrib);
		    		}
		    		else{
		    			echo anchor('leaves/leaverecords', 'Leave Records', 'title="Add a Leave"');
		    		}	
	    		?>
	        	
	        </li>

	        <li>
	        	<?php
		    		if ($linkclass == 'leavecredits'){
		    			$attrib = array('title' => 'Leave Monitoring','class' => 'active');
		    			echo anchor('leaves/leavecredits', 'Leave Credits',$attrib);
		    		}
		    		else{
		    			echo anchor('leaves/leavecredits', 'Leave Credits', 'title="Add a Leave"');
		    		}	
	    		?>
	        	
	        </li>
	      </ul> 
	     </li>
	    <li><a href="javascript:window.print()">Print</a></li>
	  </ul>
	</div>
		