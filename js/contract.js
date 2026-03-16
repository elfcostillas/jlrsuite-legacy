$(document).ready(function()
{
 $('#form-contract').validationEngine();
  
  

 //auto load functions
   get_client_details();
   get_sales_details();
   load_contract_details();

  // for view and edit state get the existing details of contract
  function load_contract_details()
  {
      var key = parseInt($('#key').val());

      if (key > 0) 
      {

        $.post('ajax-cntrdetails',{
          id : key
        },function(data){

          var cnt = 0;
          $.each($.parseJSON(data), function(index,obj)
          {

            var id = cnt;
            var strength = obj.psi_strength;
            var size_of_agg = obj.size_of_agg;
            var slump = obj.slump;
            var curing = obj.curing_days;
            var deliv_price  = parseFloat(obj.deliv_price).toFixed(2);
            var pickup_price = parseFloat(obj.pickup_price).toFixed(2);
            var cement_sup = parseFloat(obj.cement_supp).toFixed(2);
            var remarks = obj.remarks;

            contract_details = {id,cement_sup,strength,size_of_agg,slump,curing,deliv_price,pickup_price,remarks};

            contract.push(contract_details);
            cnt++;
          });

          array_to_table();

        }).fail(function(err,status){
          console.log(err['status']);
        });
      }
  }

  //enum
  var contr_state = {AddState: 1, EditState: 2, ViewState: 3}; 
  var cntr_assign = {IN: 1,OUT: 2};

  //for jqueryui tooltip
  $('[data-toggle="tooltip"]').tooltip();

  //for bootstrap datetimepicker
  $('.dtpicker').datepicker();

  //get client details on change
  $("#client").change(function(){
  	 get_client_details();
  });

  // from icon click
  $('.fromDate_Click').click(function(){
    $('#fromDate').focus();
  });

  // from icon click
  $('.toDate_Click').click(function(){
    $('#toDate').focus();
  });

   // from icon click
  $('.date_click').click(function(){
    $('#doc_date').focus();
  });

  //get the details of selected client 
  function get_client_details()
  {
    if ($('#key').val() === '') {
      var id = $('#client').val();

      $.ajax({    
            url: "ajax-clientdetails", //The url where the server req would we made.
            async: false, 
            type: "POST", //The type which you want to use: GET/POST
            data:"id="+id, //The variables which are going.
            dataType: "json", //Return data type (what we expect).
             
            //This is the function which will be called if ajax call is successful.
            success: function(data) 
            {
                $('#client_address').val('');
                $('#client_contact').val('');
                $('#client_terms').val('');
              if(data !== undefined )
              {
                $('#client_address').val(data[0].customer_address);
                $('#client_contact').val(data[0].contact_number);
                $('#client_terms').val(data[0].termDesc);
              }      
            },

            failed : function(data)
            {
              $('#client_address').val('');
              $('#client_contact').val('');
              $('#client_terms').val('');
            },

            error: function(err) {
              console.log(err['status']);
            }
      })
    }
  }
  
  //get sales details on change
  $("#sales_rep").change(function(){
    get_sales_details();
  });

  //get sales details of sales rep.
  function get_sales_details()
  {
    if ($('#key').val() === '') {
      var id = $('#sales_rep').val();
      $.ajax({    
            url: "ajax-salescontact", //The url where the server req would we made.
            async: false, 
            type: "POST", //The type which you want to use: GET/POST
            data:"id="+id, //The variables which are going.
            dataType: "json", //Return data type (what we expect).
             
            //This is the function which will be called if ajax call is successful.
            success: function(data) 
            {
              $('#sales_contct_no1').val('');
              $('#sales_contct_no2').val('');

              if(data !== undefined )
              {
                $('#sales_contct_no1').val(data[0].cntct_no1);
                $('#sales_contct_no2').val(data[0].cntct_no2);
              }
            },

            failed : function(data)
            {
              $('#sales_contct_no1').val('');
              $('#sales_contct_no2').val('');
            }
      })
    }
  }

//set default table type
change_tbl_type(); 

//Setting Contract Type
 $("#contract_type").change(function(){

    //check if table row is greater than 0.
    if ($('#contr-tbl tbody tr').length > 1)
    {
      //if greater than 1 then show confirm message
      var r = confirm("The details you enter would be loss if you change type. Do you want to continue?");
      if(r)
      {
        //clear all row
        $('#contr-tbl').empty();
        $('#contr-tbl').append('<thead></thead><tbody><tr></tr></tbody>');

        //reset an array of contract details
        contract = [];

         //if true then reset table else do nothing
         change_tbl_type();
      }
    }
    else
    {
      //clear all row
      $('#contr-tbl').empty();
      $('#contr-tbl').append('<thead></thead><tbody><tr></tr></tbody>');

      //reset an array of contract details
      contract = [];

      change_tbl_type();
    }
 });

//change table header
function change_tbl_type() 
{
    var contract_type =  $('#contract_type').val();

    $('#contr-tbl').fadeOut(1);

    switch(contract_type)
    {
        case 'Cement Supplied':
            $('#contr-tbl thead').append(CONTRACT_DETAILS.CS_TBL_HEAD);
            break;
        case 'Pick-Up':
            $('#contr-tbl thead').append(CONTRACT_DETAILS.PU_TBL_HEAD);
            break;
        case 'CS w/ Pick-up':
            $('#contr-tbl thead').append(CONTRACT_DETAILS.MIX_TBL_HEAD);
            break;
        default:
            $('#contr-tbl thead').append(CONTRACT_DETAILS.SC_TBL_HEAD);
    }
     $('#contr-tbl').fadeIn(500);
}

//for contract details
  var contract = [];
  var contract_details = {};
  var state = contr_state.AddState;
  //contract details id
  var id;

//add details
$('#add_details').click(function(){Add_details();});

//hot key for adding details
$(document).bind('keydown','alt+a',Add_details);

// function Add details
function Add_details()
{
  state = contr_state.AddState;

    $('#new_cement_supp').val('');
    $('#new_strength').val('');
    $('#new_size_of_agg').val('');
    $('#new_slump').val('');
    $('#new_curing_days').val('');
    $('#new_remarks').val('');
   
    $('.alert').hide();

    MODAL.Open($('#myModal'));
}

//edit details
$(document).on('click','.cntr_edit',function()
{
  state = contr_state.EditState;

  //get selected id
  id = parseInt($(this).closest('tbody tr').find('.id').text());

  //assign details to modal
  assign(cntr_assign.OUT);

  // hide error dialog of modal
  $('.alert').hide();

  MODAL.Open($('#myModal'));
});

//delete selected details
$(document).on('click','.cntr_del',function()
{

  id = parseInt($(this).closest('tr').find('.id').text());

  if(confirm('Are you sure you want to delete this?'))
  {
      var result= [];
      for(var i=0;i<contract.length;i++)
      {
          if( contract[i]['id'] !== id)
          {
              result.push(contract[i]); 
          }
      }
      contract = [];
      contract = result;
      array_to_table();
  }
});

$('#cntr-submit').click(function(){

    if(validate() === false)
    {
      return;
    }

    MODAL.Close($('#myModal'));

    //assign contract details 
    assign(cntr_assign.IN);

    //detemine action
    switch(state)
    {
      case contr_state.AddState :
        cntr_add();
        break;
      case contr_state.EditState :
        cntr_update();
        break;
    }
});

function assign(toDo)
{
  if(toDo === cntr_assign.OUT)
  {
    $('#contr_id').val(id);
    $('#new_cement_supp').val(N(contract[id]['cement_sup']));
    $('#new_strength').val(contract[id]['strength']);
    $('#new_size_of_agg').val(contract[id]['size_of_agg']);
    $('#new_slump').val(contract[id]['slump']);
    $('#new_curing_days').val(contract[id]['curing']);
    $('#new_deliv_price').val(contract[id]['deliv_price']);
    $('#new_pickup_price').val(N(contract[id]['pickup_price']));
    $('#new_remarks').val(contract[id]['remarks']);
  }
  else
  {
    var strength = N($('#new_strength').val());
    var size_of_agg = N($('#new_size_of_agg').val());
    var slump = N($('#new_slump').val());
    var curing = N($('#new_curing_days').val());
    var deliv_price  = numberWithCommas(N($('#new_deliv_price').val()));
    var remarks = N($('#new_remarks').val());
    var cement_sup = N($('#new_cement_supp').val());
    var pickup_price = numberWithCommas(N($('#new_pickup_price').val()));

    contract_details = {id,cement_sup,strength,size_of_agg,slump,curing,deliv_price,pickup_price,remarks};
  }
}

//Add new row in contract details 
function cntr_add(){
    
    //set id for new record     
    id = contract.length === undefined ? 0 : contract.length;

    //assign contract details
    assign(cntr_assign.IN);

    //add to contract array
    contract.push(contract_details); 

    array_to_table();
};

function cntr_update()
{
   //assign contract details 
   assign(cntr_assign.IN);

   //update detail
   contract[id] = contract_details; 

  array_to_table();     
}


function array_to_table()
{
  
  //get contact type
  var contract_type =  $("#contract_type").val();

  //clear all row except first
  // $('#contr-tbl').find('tbody tr:not(:first)').remove();
  $('#contr-tbl').find('tbody tr').remove();

  for(var i=0;i<contract.length;i++)
  {
      var row = '';
      switch(contract_type)
      {
        case 'Cement Supplied':
            row = CONTRACT_DETAILS.CS_Details(contract[i]);
            break;
        case 'Pick-Up':
            row = CONTRACT_DETAILS.PU_Details(contract[i]);
            break;
        case 'CS w/ Pick-up':
            row = CONTRACT_DETAILS.MIX_Details(contract[i]);
            break;
        default: 
            row = CONTRACT_DETAILS.SC_Details(contract[i]);
      }
      assing_to_row(row);
  }
}

// adding and assigning row table
function  assing_to_row(row) 
{
  // if no tr in tbody
  if($("#contr-tbl tbody tr").length === 0)
  {
    $('#contr-tbl tbody').append(row); 
  }
  else
  {
    $('#contr-tbl tbody tr:last').after(row);
  }
}

$('#form-contract').on('submit',function(e){
  if (contract.length === 0) {
     e.preventDefault()
     alert("Please provide your contract details");
  };

});

//validate contract details value
function validate(){

  var field = '';

  contract_type = $('#contract_type').val();


  if($('#new_strength').val() === '')
  {
      field = 'Strength';
  }
  else if($('#new_size_of_agg ').val() ==='')
  {
      field ='Max size of agg';
  }
  else if($('#new_slump').val() === '')
  {
      field = 'Slump'; 
  }
  else if($('#new_curing_days').val() === '')
  {
      field = 'Curing days';
  }
  else if($('#new_deliv_price').val() === '')
  {
      field ='Delivery Price';
  }
  else if($("#new_remarks").val() === '')
  {
      field  = 'Remarks';
  }
  else if((contract_type === 'Cement Supplied' || contract_type === 'CS w/ Pick-up') && $('#new_cement_supp').val() === '')
  {
      field = 'Cement Factor';
  }
  else if((contract_type === 'Pick-Up' || contract_type === 'CS w/ Pick-up') && $('#new_pickup_price').val() === '')
  {
      field = 'Pick-up Price';
  }
  else
  {
    return true;
  }
  
  $('#error-dialog').removeClass('hide');
  $('#error-dialog').append(field + " is required!");
  $('.alert').show().fadeIn(1000);
  return false;
}

//convert undefined to empty string
function N(obj) {
  return obj === undefined ? '' : obj;
}

//console.log shortcut
function log(obj){
  console.log(obj);
}

//numeric only input
$(".numeric").keydown(function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190,54]) !== -1 ||
           // Allow: Ctrl+A, Command+A
          (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
           // Allow: home, end, left, right, down, up
          (e.keyCode >= 35 && e.keyCode <= 40)) {
               // let it happen, don't do anything
               return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
      }
  });


// add comma to number provided
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


  $('#client_rep').on('change',function(){
      var client_name = $('#client_rep').val();

      if ($('#client_sign_by').val() === '')
      {
          $('#client_sign_by').val(client_name);
      } 
  });

  $('#client_pos').on('change',function(){
      var client_pos = $('#client_pos').val();

      if ($('#client_sign_pos').val() === '')
      {
          $('#client_sign_pos').val(client_pos);
      } 
  });

  // charges module *************************************
  
  // create array for charges
  var pump_id;
  var cntr_id = $('#key').val();
  var pump_charges = [];

  // free load for default values
 load_pump_charges(); 

 function load_pump_charges() 
 {
    $.post('ajax-pump-charges',
    {
        cntr_id:cntr_id,
    },
    function(data,status)
    {
      if(status === 'success')
      {
        $.each($.parseJSON(data), function(index,obj)
        {
              var chckbox = $('.pump[value='+ obj.pump_id +']')
              chckbox.prop("checked",true);

              $.post('ajax-set-pump-charges',
              {
                pump_id:obj.pump_id,
                cntr_id:cntr_id
              },
              function(data,status)
              {
                if (status === 'success') 
                {
                  btn_edit = chckbox.parent().find('.edit_pump');
                  btn_edit.removeClass('hide').fadeIn(1000);

                  $(".charges"+obj.pump_id).html('').fadeOut(0);
                  $(".charges"+obj.pump_id).html(data).fadeIn(1000);

                  pump_charges = [];
                }
              });
        });
      }
    });
 }

  // get pump charges
  function get_pump_charges()
  { 
      $.post('ajax-pumps',
      {
        pump_id:pump_id,
        cntr_id:cntr_id,
        project:$('#project').val()
      },
      function(data,status)
      {
        if (status === 'success') 
        {

          $(".charges"+pump_id).html('').fadeOut(1);
          $(".charges"+pump_id).html(data).fadeIn(1000);

          pump_charges = [];

        }
      });
  }

  $('.pump').change(function()
  {
    pump_id = $(this).val();
    btn_edit = $(this).parent().find('.edit_pump')
    if($(this).is(':checked'))
    {
      btn_edit.removeClass('hide').fadeIn(1000);

      // ajax call for charges
      get_pump_charges();
    }
    else
    {
     unassign_pump_charges();
     // if unchecked clear charges
     $(".charges"+pump_id).html('');
     btn_edit.addClass('hide').fadeIn(1000);
    }
  });

  // unassigned charges on unchecked pump
  function unassign_pump_charges()
  {
    $.post('ajax-unassign-pump-charges',
    {
      pump_id:pump_id
    },function(data,status){
      
    });
  }

  function edit_charges() 
  {
    $.post('ajax-charges',
    {
        pump_id:pump_id
    },
    function(data,status)
    {
      if(status === 'success')
      {
        // console.log(data);
        $('.edit_charges').html(data);

        //show entry if checkbox is checked
        $(".c_charges").each(function()
        {
            if($(this).is(":checked"))
            {
              $(this).closest('.li-pump').find('.entry-collapse').collapse();
            }
        });

        MODAL.Open($('#my_modal'));

        $(".c_charges").click(function()
        {
          
          var entry = $(this).closest('.li-pump').find('.entry-collapse');
          var value = entry.find('.c_value');
          var desc = entry.find(".c_desc");

          $(this).closest('.li-pump').find('.entry-collapse').collapse("hide");

          if($(this).is(":checked"))
          {
            entry.collapse("show");
            value.val("");
            desc.val("");
          }
          /*else
          {
            entry.collapse();
          }*/
        });
        

        $('#select_charge').click(function()
        {
          var charges = {};
          var charge_id;
          var value;
          var desc;

          $('.li-pump').each(function()
          {
            var checkbox = $(this).find('input[type="checkbox"]:checked');
            if(checkbox.length === 1)
            {
              charge_id = checkbox.val();
              temp_value = $(this).find('.c_value').val();
              
              if(temp_value == '')
              {
                value = null
              }
              else
              {
                 value = parseFloat(temp_value.replace(',',''));
              }
             
              desc = $(this).find('.c_desc').val();

              charges = {charge_id,value,desc};
              pump_charges.push(charges);
              console.log(pump_charges);
            }
          });

          // assign to server
          assign_pump();
          MODAL.Close($('#my_modal'));
        });
        // end of select_charge click events
      }
    });
  }

  // assign pump charges to server
  function assign_pump()
  {
    $.post('ajax-assign-in-pump',
    {
      pump_id:pump_id,
      pump_charges:pump_charges
    },
    function(data,status)
    {
      if (status === 'success') 
      {
        $('.data').html(data);
        get_pump_charges();
      }
    });
  }

  $('.edit_pump').click(function()
  {
    pump_id = $(this).parent().find('input:checkbox:first').val();
    edit_charges();
  });

  //******************************************************

});
// end of document ready declaration

$(function() {
    $('.date-month').datepicker( {
        duration:"slow",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
});
       
// daterange manipulation
$( function() {
    var dateFormat = "mm/dd/yy",
      from = $( ".fromDate" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear:true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".toDate" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear:true,
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


    // terms and conditions tab powered by bootstrap tabs..
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show');
    });

  });

;CONTRACT_DETAILS = {
  
  SC_TBL_HEAD : function()
  {
    $('.cement_supp').addClass('hide');
    $('.pickup').addClass('hide');

    return "<tr class='bg-primary'>" +
      "<th align = 'center' class=' col-md-1 col-xs-12 hide'>ID</th>" +
      "<th align = 'center' class=' col-md-1'>Strength</th>" +
      "<th align = 'center' class=' col-md-1'>Max. Size of Aggregates(inch)</th>" +
      "<th align = 'center' class=' col-md-1'>Slump</th>" +
      "<th align = 'center' class=' col-md-1'>Curing Days</th>" +
      "<th align = 'center' class=' col-md-1'>Unit price per m³</th>" +
      "<th align = 'center' class=' col-md-2'>Remarks</th>" +
      "<th align = 'center' class='col-md-1 edit_only' colspan='2'>Action</th>" +
    "</tr>";
  },

  CS_TBL_HEAD : function()
  {
     $('.pickup').removeClass('hide');
     $('.cement_supp').removeClass('hide');

     return "<tr class='bg-primary'>" +
      "<th align = 'center' class=' col-md-1 hide'>ID</td>" +
      "<th align = 'center' class=' col-md-1'>Cement Factor</td>" +
      "<th align = 'center' class=' col-md-1'>Strength</td>" +
      "<th align = 'center' class=' col-md-1'>Max. Size of Aggregates(inch)</td>" +
      "<th align = 'center' class=' col-md-1'>Slump</td>" +
      "<th align = 'center' class=' col-md-1'>Curing Days</td>" +
      "<th align = 'center' class=' col-md-1'>Delivery Price</td>" +
      "<th align = 'center' class=' col-md-1'>Pick-up Price</td>" +
      "<th align = 'center' class=' col-md-2'>Remarks</td>" +
      "<th align = 'center' class='col-md-1 edit_only' colspan='2'>Action</td>" +
    "</tr>";
  },

  OLD_CS_TBL_HEAD : function()
  {
     $('.cement_supp').removeClass('hide');
     $('.pickup').addClass('hide');

     return "<tr class='bg-primary'>" +
      "<th align = 'center' class=' col-md-1 hide'>ID</th>" +
      "<th align = 'center' class=' col-md-1'>Cement Factor</th>" +
      "<th align = 'center' class=' col-md-1'>Strength</th>" +
      "<th align = 'center' class=' col-md-1'>Max. Size of Aggregates(inch)</th>" +
      "<th align = 'center' class=' col-md-1'>Slump</th>" +
      "<th align = 'center' class=' col-md-1'>Curing Days</th>" +
      "<th align = 'center' class=' col-md-1'>Unit price per m³</th>" +
      "<th align = 'center' class=' col-md-2'>Remarks</th>" +
      "<th align = 'center' class='col-md-1 edit_only' colspan='2'>Action</th>" +
    "</tr>";
  },

  PU_TBL_HEAD : function()
  {
     $('.pickup').removeClass('hide');
     $('.cement_supp').addClass('hide');

     return "<tr class='bg-primary'>" +
      "<th align = 'center' class=' col-md-1 hide'>ID</th>" +
      "<th align = 'center' class=' col-md-1'>Strength</th>" +
      "<th align = 'center' class=' col-md-1'>Max. Size of Aggregates(inch)</th>" +
      "<th align = 'center' class=' col-md-1'>Slump</th>" +
      "<th align = 'center' class=' col-md-1'>Curing Days</th>" +
      "<th align = 'center' class=' col-md-1'>Delivery Price</th>" +
      "<th align = 'center' class=' col-md-1'>Pick-up Price</th>" +
      "<th align = 'center' class=' col-md-2'>Remarks</th>" +
      "<th align = 'center' class='col-md-1 edit_only' colspan='2'>Action</th>" +
    "</tr>";
  },

  

  SC_Details : function(details)
  {
    return "<tr>" +
              "<td class='id hide'> <input type='hidden' name='contract[id][]' value='"+ details['id'] +"' />" +  details['id']  + "</td>" + 
              "<td class='hide'> <input type='hidden' name='contract[cement_supp][]' value='"+ details['cement_sup'] +"' />" + details['cement_sup'] + "</td>" + 
              "<td data-title = 'Strength:' align ='center'> <input type='hidden' name='contract[strength][]' value='"+ details['strength'] +"' />" + details['strength'] + "</td>" + 
              "<td data-title = 'Max size of agg:' align ='center'> <input type='hidden' name='contract[size_of_agg][]' value='"+ details['size_of_agg'] +"' />" + details['size_of_agg'] + "</td>" +
              "<td data-title = 'Slump:' align ='center'> <input type='hidden' name='contract[slump][]' value='"+ details['slump'] +"' />" + details['slump'] + "</td>" +
              "<td data-title = 'Curing days:' align ='center'> <input type='hidden' name='contract[curing][]' value='"+ details['curing'] +"' />" + details['curing'] + "</td>" +
              "<td data-title = 'Delivery price:' align ='center'> <input type='hidden' name='contract[deliv_price][]' value='"+ details['deliv_price'] +"' />" + details['deliv_price'] + "</td>" +
              "<td class = 'hide'> <input type='hidden' name='contract[pickup_price][]' value='"+ details['pickup_price'] +"' />" + details['pickup_price'] + "</td>" +
              "<td data-title = 'Remarks:' align ='center'> <input type='hidden' name='contract[remarks][]' value='"+ details['remarks'] +"' />" + details['remarks'] + "</td>" +
              "<td data-title = 'Edit:' align ='center' align='center' class='edit_only'><button data-toggle='tooltip' title='Edit' type='button' id= 'cntr_edit' class ='cntr_edit btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil'></span></button></td>" +
              "<td data-title = 'Delete:' align ='center' align='center' class='edit_only'><button data-toggle='tooltip' title='Delete' type='button' class ='cntr_del btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button></td>" +
           "</tr>";
  },

   CS_Details : function(details)
  {
    return "<tr>" +
              "<td class='id hide'> <input type='hidden' name='contract[id][]' value='"+ details['id'] +"' />" +  (details['id'])  + "</td>" + 
              "<td data-title='Cement Supp:' align = 'center'> <input type='hidden' name='contract[cement_supp][]' value='"+ details['cement_sup'] +"' />" + details['cement_sup'] + "</td>" + 
              "<td data-title='Strength:' align = 'center'> <input type='hidden' name='contract[strength][]' value='"+ details['strength'] +"' />" + details['strength'] + "</td>" + 
              "<td data-title='Max size of agg:' align = 'center'> <input type='hidden' name='contract[size_of_agg][]' value='"+ details['size_of_agg'] +"' />" + details['size_of_agg'] + "</td>" +
              "<td data-title='Slump:' align = 'center'> <input type='hidden' name='contract[slump][]' value='"+ details['slump'] +"' />" + details['slump'] + "</td>" +
              "<td data-title='Curing days:' align = 'center'> <input type='hidden' name='contract[curing][]' value='"+ details['curing'] +"' />" + details['curing'] + "</td>" +
              "<td data-title='Delivery price:' align = 'center'> <input type='hidden' name='contract[deliv_price][]' value='"+ details['deliv_price'] +"' />" + details['deliv_price'] + "</td>" +
              "<td data-title='Pick-up price:' align = 'center'> <input type='hidden' name='contract[pickup_price][]' value='"+ details['pickup_price'] +"' />" + details['pickup_price'] + "</td>" +
              "<td data-title='Remarks:' align = 'center'> <input type='hidden' name='contract[remarks][]' value='"+ details['remarks'] +"' />" + details['remarks'] + "</td>" +
              "<td data-title='Edit:'align='center' class='edit_only'><button data-toggle='tooltip' title='Edit' type='button' id= 'cntr_edit' class ='cntr_edit btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil'></span></button></td>" +
              "<td data-title='Delete:'align='center' class='edit_only'><button data-toggle='tooltip' title='Delete' type='button' class ='cntr_del btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button></td>" +
           "</tr>";
  },

  OLD_CS_Details : function(details)
  {
    return "<tr>" +
              "<td class='id hide'> <input type='hidden' name='contract[id][]' value='"+ details['id'] +"' />" +  details['id']  + "</td>" + 
              "<td data-title='Cement Supp:' align='center'> <input type='hidden' name='contract[cement_supp][]' value='"+ details['cement_sup'] +"' />" + details['cement_sup'] + "</td>" + 
              "<td data-title='Strength:' align='center'> <input type='hidden' name='contract[strength][]' value='"+ details['strength'] +"' />" + details['strength'] + "</td>" + 
              "<td data-title='Max size of agg:' align='center'> <input type='hidden' name='contract[size_of_agg][]' value='"+ details['size_of_agg'] +"' />" + details['size_of_agg'] + "</td>" +
              "<td data-title='Slump:' align='center'> <input type='hidden' name='contract[slump][]' value='"+ details['slump'] +"' />" + details['slump'] + "</td>" +
              "<td data-title='Curing days:' align='center'> <input type='hidden' name='contract[curing][]' value='"+ details['curing'] +"' />" + details['curing'] + "</td>" +
              "<td data-title='Unit price per m³:' align='center'> <input type='hidden' name='contract[deliv_price][]' value='"+ details['deliv_price'] +"' />" + details['deliv_price'] + "</td>" +
              "<td class = 'hide'> <input type='hidden' name='contract[pickup_price][]' value='"+ details['pickup_price'] +"' />" + details['pickup_price'] + "</td>" +
              "<td data-title='Remarks' align='center'> <input type='hidden' name='contract[remarks][]' value='"+ details['remarks'] +"' />" + details['remarks'] + "</td>" +
              "<td data-title='Edit:' align='center' align='center' class='edit_only'><button data-toggle='tooltip' title='Edit' type='button' id= 'cntr_edit' class ='cntr_edit btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil'></span></button></td>" +
              "<td data-title='Delete:' align='center' align='center' class='edit_only'><button data-toggle='tooltip' title='Delete' type='button' class ='cntr_del btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button></td>" +
           "</tr>";
  },

  PU_Details : function(details)
  {
    return "<tr>" +
              "<td class='id hide'> <input type='hidden' name='contract[id][]' value='"+ details['id'] +"' />" +  details['id']  + "</td>" + 
              "<td class='hide'> <input type='hidden' name='contract[cement_supp][]' value='"+ details['cement_sup'] +"' />" + details['cement_sup'] + "</td>" + 
              "<td data-title='Strength:' align='center'> <input type='hidden' name='contract[strength][]' value='"+ details['strength'] +"' />" + details['strength'] + "</td>" + 
              "<td data-title='Max size of agg:' align='center'> <input type='hidden' name='contract[size_of_agg][]' value='"+ details['size_of_agg'] +"' />" + details['size_of_agg'] + "</td>" +
              "<td data-title='Slump:' align='center'> <input type='hidden' name='contract[slump][]' value='"+ details['slump'] +"' />" + details['slump'] + "</td>" +
              "<td data-title='Curing days:' align='center'> <input type='hidden' name='contract[curing][]' value='"+ details['curing'] +"' />" + details['curing'] + "</td>" +
              "<td data-title='Delivery price:' align='center'> <input type='hidden' name='contract[deliv_price][]' value='"+ details['deliv_price'] +"' />" + details['deliv_price'] + "</td>" +
              "<td data-title='Pick-up price:' align='center'> <input type='hidden' name='contract[pickup_price][]' value='"+ details['pickup_price'] +"' />" + details['pickup_price'] + "</td>" +
              "<td data-title='Remarks' align='center'> <input type='hidden' name='contract[remarks][]' value='"+ details['remarks'] +"' />" + details['remarks'] + "</td>" +
              "<td data-title='Edit:' align='center'class='edit_only'><button data-toggle='tooltip' title='Edit' type='button' id= 'cntr_edit' class ='cntr_edit btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil'></span></button></td>" +
              "<td data-title='Delete:' align='center' class='edit_only'><button data-toggle='tooltip' title='Delete' type='button' class ='cntr_del btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button></td>" +
           "</tr>";
  }
}

;MODAL = {
  Open : function(selector)
  {
    selector.modal({ show:'true'});
  },

   Close : function(selector)
  {
    selector.modal('toggle');
  }
}



