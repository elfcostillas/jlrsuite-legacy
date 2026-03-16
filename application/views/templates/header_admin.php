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
  <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/admin.css") ?>' />
  <link rel="stylesheet" type='text/css' href='<?php echo base_url("css/base.css") ?>' />
  <link rel="stylesheet" type='text/css' href='<?php echo base_url("css/skeleton.css") ?>' />
 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />
	

  <!-- scripts for the deu -->
	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("js/main.js") ?>"></script>

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


        //read online users
        $.get('chat/onlineusers.txt', function(data) {

             var myArray = data.split('\n');
             //alert (myArray);

              // display the result in myDiv
              $('#chat-online-wrapper').empty();
              for(var cnt=0;cnt<myArray.length;cnt++){
                  //print myArray[cnt]; 
                  $('#chat-online-wrapper').append('<li>'+myArray[cnt]+'</li>');
              }
              
              var olusers = myArray.length - 1;
              $('#olusers-count').empty();
              $('#olusers-count').append(olusers);
        });
        

    });	

  </script>

</head>