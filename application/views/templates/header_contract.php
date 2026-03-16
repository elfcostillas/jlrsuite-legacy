<?php date_default_timezone_set("Asia/Taipei"); ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />


	<title><?php echo $title; ?> </title>

	<meta name="keywords" content="" />
	<meta name="description" content="" />

  <link rel="shortcut icon" href='<?php echo base_url("css/images/favicon.ico") ?>'>

  <!-- External Stylesheets -->
  	<link rel='stylesheet' type='text/css' href='<?php echo base_url("css/main.css") ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/dps.css") ?>' />

    <link rel='stylesheet' type='text/css' href='<?php echo base_url("js/jqueryui/jquery-ui.css") ?>' />
    <link rel="stylesheet" href="<?php 	echo base_url("css/validationEngine.jquery.css") ?>" type="text/css"/>

    
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rev2/bootstrap.css") ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/rod/contract.css") ?>' />
  
	


<!-- External Javascript -->	
	<script type="text/javascript" src="<?php echo base_url("js/jquery_1.12.4.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jqueryui/jquery-ui.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/rev2/bootstrap.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/rev2/jquery.hotkeys.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery_validation2/js/languages/jquery.validationEngine-en.js" ) ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery_validation2/js/jquery.validationEngine.js" ) ?>" charset="utf-8"></script>


    <script type="text/javascript" src="<?php echo base_url("js/main.js") ?>"></script>
	
	<script>
		//resolve name collision between jquery ui and twitter bootstrap :)
		$.widget.bridge('uitooltip', $.ui.tooltip);

		$(document).ready(function(){
			$("#option").click(function () {
	             $("#submenu").slideToggle(300);
	         });
		});
		
	</script>


</head>
