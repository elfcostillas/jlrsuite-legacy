<div id="content" class="my_container">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<br>
		</div>
		<div class="col-md-9"> 
			<?php 	
				if($message !== ''){
					echo $message;
				}
			?>
		</div>
		<div class="col-md-3">
			<a href="contract-add" class="btn btn-primary col-xs-12">
			<span class="glyphicon glyphicon-plus"></span> New Contract</a>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<br>
			<div class="well well-sm">
				<span><strong>Legend:</strong></span>
				<span class="bg-info text-info"><strong>APPROVED</strong></span> &nbsp;
				<span class="bg-warning text-warning"><strong>UNAPPROVE</strong></span>
			</div>
		</div>
		<br>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="form-group form-inline">
				<label for="search" class="control-label">Search</label> 
				<div class="input-group">
					<input type="text" id="search" class="form-control input-xs">
					<div class="input-group-addon">
						<a href="#" id="search_me"><span class="glyphicon glyphicon-search"></span></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="form-inline">
				<div class="form-group">
					<label for="from_date" class="control-label">From </label>
					<div class="input-group">
						<input id="from" type="text" class="form-control fromDate" value="<?= $from; ?>">
						<div class="input-group-addon">
							<a href="#" id='calendar-from'><span class="glyphicon glyphicon-calendar"></span></a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="to_date" class="control-label">To</label>
					<div class="input-group">
						<input id="to" type="text" class="form-control toDate" value="<?= $to; ?>">
						<div class="input-group-addon">
							<a href="#" id='calendar-to'><span class="glyphicon glyphicon-calendar"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- List of Contracts -->
	<div class="row"><br></div>
	<div class="row">
		<div class="col-md-12">	
			<table class="table table-hover table-condensed table-bordered" id='tbl-contract'>
				<tbody>	
					<tr></tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-1">
		</div>
	</div>
	<!-- asdfasdf -->
</div>
<script>
	$(document).ready(function(){

		//free load 
		contract_list();

		//tooltip
		$('[data-toggle="tooltip"]').tooltip();

		$("#cntrdel").click(function(){
			console.log('check');
		});

		//load by date change
		$("#from").change(function()
		{ 
			if($("#to").val() === '')
			{
				$("#to").val($('#from').val());
			}

			get_list();
		});

		$("#to").change(function()
		{ 
			if($("#from").val() === '')
			{
				$("#from").val($("#to").val());
			}

			get_list();
		});

		//load by search click
		$('#search_me').click(function()
		{
		 	get_list();
		});

		var is_approver = 0;

		function contract_list() {
			$.post('ajax-user-rights',function(data, status){
				is_approver = parseInt(data);
				get_list();
 			});
		}

		function get_list()
		{
			//clear row except first
			$("#tbl-contract").find("tr:gt(0)").remove();

			//if date is empty assign it today
			if($('#from').val() === '')
			{
				 $('#from').val(DATE_FORMAT.MDY_SLASH(new Date()));
			}

			//if date is empty assign it today
			if($('#to').val() === '')
			{
				 $('#to').val(DATE_FORMAT.MDY_SLASH(new Date()));
			}

			var fromDate = $('#from').val();
			var toDate = $('#to').val();
			var search = $('#search').val();
			var bg_color = 'warning'; 
			var btn = '';
			
			$.post('ajax-contractlist',{
				fromDate : fromDate,
				toDate : toDate,
				search : search
			},function(data,status){
				$($.parseJSON(data)).each(function(i,obj){

					var cntr_no = obj.contract_no;
					var btn_print = ''; //btn_print used for approver to preview contract 

					if(obj.revision > 0)
					{
						cntr_no = cntr_no+"Rev"+ obj.revision;
					}
					
					if(obj.is_approved == 1) 
					{
						bg_color = 'info';
						btn = "<div class='col-md-4'>"+
									"<div class='btn-group'>"+
									"<a href='contract-view?id="+ obj.cc_id +"'class='btn btn-info btn-sm'>"+
										"<span class='glyphicon glyphicon-eye-open'></span><strong> Details</strong>"+
									"</a> "+
									"<a href='contract-print?id="+ obj.cc_id +"' target = '_blank' class='btn btn-primary btn-sm'>"+
										"<span class='glyphicon glyphicon-print'></span><strong> Print</strong>"+
									"</a> "+
									"<a href='contract-rev?id="+ obj.cc_id +"' onclick=\"return confirm('Are you sure do you want to revised "+ cntr_no +"?')\"class='btn btn-success btn-sm'>"+
										"<span class='glyphicon glyphicon-registration-mark'></span> <strong>Revision</strong>"+
									"</a> "+
									"</div>"+
								"</div>"
					} 
					else 
					{
						bg_color = 'warning';
						btn = "<div class='col-md-4'>"+
								"<div class='btn-group'>"+
								"<a href='contract-view?id="+ obj.cc_id +"'class='btn btn-info btn-sm'>"+
									"<span class='glyphicon glyphicon-eye-open'></span> <strong>View</strong>"+
								"</a> "+
								"<a href='contract-edit?id="+ obj.cc_id +"'class='btn btn-success btn-sm'>"+
									"<span class='glyphicon glyphicon-pencil'></span> <strong>Edit</strong>"+
								"</a> "+
								"<a href='contract-print?id="+ obj.cc_id +"' target = '_blank' class='btn btn-primary btn-sm'>"+
										"<span class='glyphicon glyphicon-print'></span><strong> Print</strong>"+
									"</a> "+
								"<a href='contract-delete?id="+ obj.cc_id +
								"' onclick= \"return confirm('Are you sure do you want to delete "+ cntr_no +"?')\" class='btn btn-danger btn-sm'>"+
									"<span class='glyphicon glyphicon-trash' ></span> <strong>Delete</strong>"+
								"</a> "+
								"</div>"+
							"</div>";
					}
					var row = "<tr class='"+ bg_color +"'><td class='col-md-12'>"+
					"<div class='col-md-8'>"+
						"<span class='cntr-no'><strong>No :</strong> "+ cntr_no +
						 "</span> <br>" +
						"<strong>Type:</strong> "+ obj.contract_type + " <br>" +
						"<strong>Client Name:</strong> "+ obj.client_name + " <br>" +
						"<strong>Project:</strong> "+ obj.project_name + " <br>" +
						"<strong>Date:</strong> "+ DATE_FORMAT.YMD_DASH(new Date(obj.doc_date)) + " <br>" +
						"<small>Created Date: "+ DATE_FORMAT.YMD_DASH(new Date(obj.created_date)) +
						" Created By: "+ obj.created_by +"</small>"+
					"</div>" + btn + 
					
					"</td></tr>";
					$('#tbl-contract tr:last').after(row);
				});
			});

		}

		//if icon click focus text
		$('#calendar-from').click(function(){
			$('.fromDate').focus();
		});

		$('#calendar-to').click(function(){
			$('.toDate').focus();
		});
	});

	$( function() {
    var dateFormat = "mm/dd/yy",
      from = $( ".fromDate" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".toDate" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
  });

	;DATE_FORMAT = {
		year : 0,
		month : 0,
		day : 0,
		_INIT : function(date)
		{
			this.year = date.getFullYear();
			this.month	= ("0" + (date.getMonth() + 1)).slice(-2);
			this.day = ("0" + date.getDate()).slice(-2);
		},

		// DATE FORMAT : YYYY-MM-DD (2017-05-19)
		YMD_DASH : function(date)
		{
			this._INIT(date);

			return  this.year + "-" + this.month	+ "-" + this.day;	
		},

		// DATE FORMAT : MM/DD/YYYY (05/19/2017)
		MDY_SLASH : function(date)
		{
			this._INIT(date);

			return this.month + "/" + this.day + "/" + this.year;
		}
	};
</script>
