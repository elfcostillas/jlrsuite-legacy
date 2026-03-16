<div id="content" class="my_container">
<div class="container">
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
	<div class="row">
	<div class="col-md-12">
		<ul class="list-group">
			<li class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Contract No: 2017-0065</h5>
					<small><span class="glyphicon glyphicon-pencil"></span></small>
				</div>
			</li>
		</ul>
	</div>
	</div>
</div>
</div>

<script>
$(document).ready(function(){
	//if icon click focus text
	$('#calendar-from').click(function(){
		$('.fromDate').focus();
	});

	$('#calendar-to').click(function(){
		$('.toDate').focus();
	});

	function contract_list()
	{
		//if date is empty assign it today
		if($('#from').val() === ''){$('#from').val(DATE_FORMAT.MDY_SLASH(new Date()));}

		//if date is empty assign it today
		if($('#to').val() === ''){$('#to').val(DATE_FORMAT.MDY_SLASH(new Date()));}

		var fromDate = $('#from').val();
		var toDate = $('#to').val();
		var search = $('#search').val();

		$.post('ajax-contractlist',{
				fromDate : fromDate,
				toDate : toDate,
				search : search
			},function(data,status){
				$($.parseJSON(data)).each(function(i,obj){

				});
			});
	}
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