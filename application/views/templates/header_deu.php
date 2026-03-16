<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

	<title><?php echo $title; ?> </title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

  <link rel="shorvut icon" href='<?php echo base_url("css/images/favicon.ico") ?>'>

  <!-- stylesheets for the deu -->
  <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/main.css") ?>' />
  <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/deu.css") ?>' />
  <link rel="stylesheet" type="text/css" href='<?php echo base_url("css/smoothness/jquery-ui-1.8.23.custom.css") ?>' />
	<link rel='stylesheet' type='text/css' media="print" href='<?php echo base_url("css/print.css") ?>' />
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/jquery.timepicker.css") ?>' />
  <link rel="stylesheet" type="text/css" href='<?php echo base_url("css/validationEngine.jquery.css") ?>' />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />
	

  <!-- scripts for the deu -->
	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("js/main.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery.timepicker.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.23.custom.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-timepicker.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine-en.js") ?>" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo base_url("js/jquery.validationEngine.js") ?>" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>
	
  <script type="text/javascript">
    $(document).ready(function () 
    {

        $(".unitcode").fancybox({
            openEffect  : 'elastic',
            closeEffect : 'elastic',

            helpers : {
              title : {
                type : 'float'
              }
            }
        });

        $("#submenu").hide();
        $("#option").click(function () {
           $("#submenu").slideToggle(300);
        });
        //DEU Scripts start here

        //validation engine
        $("#addunits").validationEngine();
        $("#addrepair-form").validationEngine();
        

        $('.deu-add-time').datepicker({ dateFormat: 'yy-mm-dd' });
        $('#perfrep-day').datepicker({ dateFormat: 'yy-mm-dd' });

        //search-button
        $(".search-button").click(function(){
            //check where the click button is
            var source = $(this).parent().parent().attr('id');
            var form_data = new FormData();
            form_data.append("source", source)   

            if(source === 'equipmentlist'){
                //set the params
                form_data.append("unit_type", $(this).prev().attr('value'))   
            }
            else if(source === 'searchhistory'){
                //set params
                form_data.append("unit", $(this).prev().prev().prev().attr('value'))
                form_data.append("month", $(this).prev().prev().attr('value'))
                form_data.append("year", $(this).prev().attr('value'))
            }
            else if(source === 'monthlyrepairs'){
                //set params
                form_data.append("month", $(this).prev().prev().attr('value'))
                form_data.append("year", $(this).prev().attr('value'))
            }

            $.ajax({
                url: "ajax_searchbutton",
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {
                  //$('#upload-result-wrapper').html(data);]
                  if(source === 'equipmentlist'){
                       $('#equiplist-wrapper').empty();
                       $('#equiplist-wrapper').append(data);
                  }
                  else if(source === 'searchhistory'){
                       $('#searchhistory-wrapper').empty();
                       $('#searchhistory-wrapper').append(data);
                  }
                  else if(source === 'monthlyrepairs'){
                       $('#monthlyreps-wrapper').empty();
                       $('#monthlyreps-wrapper').append(data);
                  }
                }
            })

            return false;
        });

        //edit units
        $(".edit-units").click(function(){
            //check where the click button is
            var source = $(this).parent().parent().attr('id');
            var form_data = new FormData();
            form_data.append("source", source)   

            $.ajax({
                url: "ajax_searchbutton",
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {
                  //$('#upload-result-wrapper').html(data);]
                  if(source === 'equipmentlist'){
                       $('#equiplist-wrapper').empty();
                       $('#equiplist-wrapper').append(data);
                  }
                  else if(source === 'searchhistory'){
                       $('#searchhistory-wrapper').empty();
                       $('#searchhistory-wrapper').append(data);
                  }
                  else if(source === 'monthlyrepairs'){
                       $('#monthlyreps-wrapper').empty();
                       $('#monthlyreps-wrapper').append(data);
                  }
                }
            })

            return false;
        });

        $(".edit-units").click(function(){
            //check where the click button is
            var id = $(this).attr('id');
            var unit_id = $(this).parent().parent().parent().attr('id');
            var form_data = new FormData();
            form_data.append("unit-id", unit_id) 

            //ajax
            $.ajax({
                url: "ajax_query_unitinfo",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {

                  $.each(data, function (i, elem) {
                      //console.log(elem);
                      //alert(elem.unit_id);
                      //write the DATA TO THE HTML FORMS
                      $("#addunit-unitid").attr('value',elem.unit_id);
                      $("#addunit-unitcode").attr('value',elem.code);
                      $("#addunit-unitcolor").attr('value',elem.color);
                      $("#unitbox-desc").attr('value',elem.desc);
                      $("#addunit-plateno").attr('value',elem.plateno);
                      $("#addunit-capacity").attr('value',elem.capacity);
                      $("#addunit-model").attr('value',elem.model);
                      $("#addunit-serial").attr('value',elem.serialno);
                      $("#addunit-unittype").attr('value',elem.type);
                      $("#addunit-unitmake").attr('value',elem.make);
                      $("#addunit-unitweight").attr('value',elem.weight);
                      $("#addunit-unitlocation").attr('value',elem.location);
                      $("#addunit-assignedto").attr('value',elem.assignedto);
                      $("#addunit-unitstatus").attr('value',elem.status);
                      if(elem.image === '' || elem.image === null){   
                         
                        $('#preview').attr('src', '../css/images/heavyequip.png');                  
                      }else{
                        $('#preview').attr('src', '../'+elem.image);
                      }

                      


                  });

                }
            })



            //change the actionof the form and value of the button
            $("form#addunits").attr('action','update_unit');
            $("#addunit-button").attr('value','UPDATE UNIT');
            

            

            return false;
        });


        $(".delete-units").click(function(){
            //check where the click button is
            $(this).parent().parent().parent().fadeOut(500);
            
            /*
            $.ajax({
                url: "ajax_searchbutton",
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {
                  //$('#upload-result-wrapper').html(data);]
                  if(source === 'equipmentlist'){
                       $('#equiplist-wrapper').empty();
                       $('#equiplist-wrapper').append(data);
                  }
                  else if(source === 'searchhistory'){
                       $('#searchhistory-wrapper').empty();
                       $('#searchhistory-wrapper').append(data);
                  }
                  else if(source === 'monthlyrepairs'){
                       $('#monthlyreps-wrapper').empty();
                       $('#monthlyreps-wrapper').append(data);
                  }
                }
            })
            */

            return false;
        });


        $(".deu-maint-updatebut").click(function(){
            //check where the click button is
            var id = $(this).parent().parent().attr('id');

            var date_in = $(this).parent().siblings().children('#maint-datein').attr('value');
            var time_in = $(this).parent().siblings().children('#maint-timein').attr('value');
            var details = $(this).parent().siblings().children('#maint-details').attr('value');
            var location = $(this).parent().siblings().children('#maint-location').attr('value');
            var est = $(this).parent().siblings().children('#maint-est').attr('value');
            var mechanic = $(this).parent().siblings().children('#edit-mech').attr('value');
            var additional_work = $(this).parent().siblings().children('#edit-exdetails').attr('value');
            var percentage = $(this).parent().siblings().children('#edit-perc').attr('value');
            var date_out = $(this).parent().siblings().children('#edit-dateout').attr('value');
            var time_out = $(this).parent().siblings().children('#edit-timeout').attr('value');


            //check if checkbox is checked or not
            var check_status = $(this).parent().siblings().children('#maint-status').attr('checked')?true:false;
           
            if(check_status){
              var status = 'COMPLETE';
            }else{
              var status = ''
            }

            var form_data = new FormData();
            form_data.append("unit-id", id)
            form_data.append("datein", date_in)
            form_data.append("timein", time_in)
            form_data.append("details", details)
            form_data.append("location", location)
            form_data.append("est", est)
            form_data.append("mechanic", mechanic)
            form_data.append("additional_work", additional_work)
            form_data.append("percentage", percentage)
            form_data.append("dateout", date_out)
            form_data.append("timeout", time_out)
            form_data.append("status", status)

            
            

            $.ajax({
                url: "update_maintenance",
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {
                  $('#deu-maint-updatebut'+id).parent().siblings().css('background','#ccffcc');
                  $('#deu-maint-updatebut'+id).parent().css('background','#ccffcc');
                }
            })
            
          
            return false;
        });


        

        $("#addunit-browseimg-but").click(function(){
            $('input[type=file]#deu-browseupload').trigger('click');
            //alert('waaaaaaaa hasul!');
            

            return false;
        });

        $('#perfrep-day').hide();
        $('#perfrep-monthly').hide();
        $('#perfrep-year').hide();
        $('#perfrep-searchbutton').hide();

        //$('#perfrep-printheader').hide();
        
        

        $('#perfrep-selection').change(function () {
              var selected = $(this).attr('value');

              if(selected === 'daily'){
                $('#perfrep-day').fadeIn(1000);
                $('#perfrep-monthly').hide();
                $('#perfrep-year').hide();
                $('#perfrep-searchbutton').hide();
              }
              if(selected === 'monthly'){
                $('#perfrep-day').hide();
                $('#perfrep-searchbutton').hide();
                $('#perfrep-monthly').fadeIn(1000);
                $('#perfrep-year').fadeIn(1000);
              }

              return false;
        });

        $('#perfrep-day').change(function () {
              var selected = $(this).attr('value');

              if(selected !== ''){
                $('#perfrep-searchbutton').fadeIn(500);
                $('#perfrep-searchbutton').attr('value','daily');
              }else{
                $('#perfrep-searchbutton').hide();
              }
              
              return false;
        });

        $('#perfrep-year').change(function () {
              var selected = $(this).attr('value');
              var selected_prev = $(this).prev().attr('value');

              if(selected !== '' && selected_prev !== ''){
                $('#perfrep-searchbutton').fadeIn(500);
                $('#perfrep-searchbutton').attr('value','monthly');
              }else{
                $('#perfrep-searchbutton').hide();
              }
              
              return false;
        });

        $("#perfrep-searchbutton").click(function(){
            var selected = $(this).attr('value');
            var form_data = new FormData();
            
            if(selected === 'daily'){
              var date = $('#perfrep-day').attr('value');
              form_data.append("selection", "daily")
              form_data.append("date", date)
              
            }
            if(selected === 'monthly'){
              var month = $('#perfrep-monthly').attr('value');
              var year = $('#perfrep-year').attr('value');
              form_data.append("selection", "monthly")
              form_data.append("month", month)
              form_data.append("year", year)
              
            }

            //send the data via ajax post

            $.ajax({
                url: "ajax_perf_report",
                dataType: 'html',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,    // Setting the data attribute of ajax with file_data
                type: 'post',
                success: function(data) {
                  $('#perfreport-wrapper').empty();
                  $('#perfreport-wrapper').append(data);
                }
            })
            

            return false;
        });

    });	

  </script>

</head>