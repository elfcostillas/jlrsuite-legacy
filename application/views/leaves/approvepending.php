<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel='stylesheet' type='text/css' href='<?php echo base_url("css/table.css") ?>' />

        <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.0.min.js") ?>"></script>    
    <script type="text/javascript" src="<?php echo base_url("js/jquery.fancybox.js") ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.fancybox.css") ?>" media="screen" />
    
    <script type="text/javascript">
            $(document).ready(function () {

                $('table#leave-table td a.approve-leaves-button').click(function()
                {

                    if (confirm("Are you sure you want to approved this application?"))
                    {
                        var id = $(this).parent().parent().attr('id');
                        var data = 'id=' + id ;
                        var parent = $(this).parent().parent();

                          $.ajax(
                        {
                               type: "POST",
                               url: "approve_leave_record",
                               data: data,
                               cache: false,
                            
                               success: function()
                               {
                                    parent.fadeOut('slow', function() {$(this).remove();});
                               }
                         });      
                    }
                });

            });     
    </script>

    </head>
 
    <body>
        <div class="content-body">
            
            <h3>Currently un-approve leave applications</h3>

            <table id="leave-table" padding="0" class="tables">

                <tr id="head">
                    <th id="right-head">Name</th>
                    <th>Reason</th>
                    <th>Date Filed</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th id="left-head">Approve</th>
                </tr>

                    <?php foreach ($pending_leaves as $leaves): ?>
                        
                        
                        <tr class="items" id="<?php echo $leaves['id'] ?>">
                            <td align="left" id="left-item"><?php echo $leaves['emp_id'] ?></td>
                            <td align="center"><?php echo $leaves['reason'] ?></td>    
                            <td align="center"><?php echo $leaves['date_filed'] ?></td>
                            <td align="center"><?php echo $leaves['inclusive_from'] ?></td>
                            <td align="center"><?php echo $leaves['inclusive_to'] ?></td>
                            <td align="center"><a href='#' class='approve-leaves-button'><img alt='' align='absmiddle' border='0' src='<?php echo base_url("css/images/approve.png") ?>' title='Approve leave'/></a></td>
                        </tr>

                        

                    <?php endforeach ?>
            </table>
        </div>
    </body>
</html>