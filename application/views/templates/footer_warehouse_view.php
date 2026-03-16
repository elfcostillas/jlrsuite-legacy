
    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy; 2016 &bull; JLR Construction and Aggregates Inc. &bull; Ralph</p>
      </div>
    </footer>
</body>


  <script type="text/javascript">
    /*

    */
    
    /*$('#show-leave-form-btn').click(function(){
      
      //hide the currently leave wrapper
      $('#leave-current-container').css({"display": "none"});

      //show the leave application form
      $('#leave-form-container').css({"display": "block"});

      //hide the button
      $(this).css({"display": "none"});
      return false;
    });

    $('.view-remarks-btn').click(function(){

      var leave_id = $(this).attr('id');

      //ajax here
      $.ajax({
             type: "POST",
             url: "ajax_get_leave_remarks",
             data: "leave-id="+leave_id,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                    var json = JSON.parse(data);

                    var sup_remarks = json[0].sup_remarks;
                    var mngr_remarks =json[0].mngr_remarks;

                    if(sup_remarks === null){
                      sup_remarks = '--';
                    }

                    if(mngr_remarks === null){
                      mngr_remarks = '--';
                    }

                    swal({  
                      title: 'Leave Remarks', 
                      text: "Supervisor : <span class='remarks-hylit'>"+sup_remarks+"</span> <br /> Manager : <span class='remarks-hylit'>"+mngr_remarks+"</span>",   
                      html: true,
                      timer: 3000,   
                      showConfirmButton: true
                    });

                  }
      });
      
    });*/

    

    $('.withdrawal-approve-but').click(function(){


      var ws_code = $(this).attr('id');
      var id = $(this).parent().parent().attr('id');
      
            

      swal({
          title: "Are you sure?",
          text: "To approved this withdrawal request.",
          type: "info",
          confirmButtonText: "Okay",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Approved it!",
          cancelButtonText: "No!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {


            //ajax approved here
            $.ajax({
             type: "POST",
             url: "ajax_approved_withdrawal_request",
             data: "ws_code="+ws_code,
             dataType: "text",
             cache:false,
             success:
                  function(data){

                    if (data == 'success'){

                      //make the row green so that user may know that it has been approved
                      $('#'+ id +'.ws-row').css("background-color", "#DAFFEB");
                      $('#'+ ws_code +'.withdrawal-approve-but').css("display", "none");

                      swal({
                        title: "Approved!",
                        text: "the leave application has been successfully approved.",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                      });

                    }else{
                      swal("Oops...", "Something went wrong! Contact administrator.", "error");
                    }
                     
                  }
            });
          }
        }
      );
      
      event.preventDefault();
    });

    $('.itemdetails-tgl').click(function(){
        //get the id
        var id = $(this).attr('id');
        var ws_code = $.trim($(this).text());

        //check if it has a class=collapse
        //if yes then remove it and replace it with opened
        
        if($('#'+ id +'.itemdetails-tbl-row').hasClass('collapse')){
          
          //ajax get the items
          $.ajax({
             type: "POST",
             url: "ajax_get_ws_items",
             data: "ws_code="+ws_code,
             dataType: "text",
             cache:false,
             success:
                  function(data){
                      //console.log(data);
                     var json = JSON.parse(data);
                     var json_obj_cnt = Object.keys(json).length;

                     //console.log(json_obj_cnt);


                     $('#'+id+'.item-details-wrapper').empty();

                      for ( var i = 0; i < json_obj_cnt; i++){
                              
                              var item_desc = json[i].item_desc;
                              var item_um = json[i].item_um;
                              var qty = json[i].qty_req;

                                $('#'+id+'.item-details-wrapper')
                                  //.prepend($('<span>')
                                      .prepend($('<span><b class="itmd-hylit">'+ qty + ' ' + item_um + '</b> ' + item_desc +'</span>'))
                                  //)
                      }
                  }
          });


          $('#'+ id +'.itemdetails-tbl-row').addClass('opened').removeClass('collapse');
          $('#'+ id +'.itemdetails-tbl-row').css("display", "table-row");
        }else{
          $('#'+ id +'.itemdetails-tbl-row').addClass('collapse').removeClass('opened');
          $('#'+ id +'.itemdetails-tbl-row').css("display", "none");
        }

        event.preventDefault();
    });

    // $('.itemdetails-tgl').qtip({
      
    //     content: {
    //         text: function(event, api) {
    //             $.ajax({
    //                 url: 'ajax_get_ws_items',
    //                 type: 'POST', 
    //                 dataType: 'text',
    //                 data: {
    //                     ws_code: $.trim($(this).text()) 
    //                 },
    //             })
    //             .then(function(data) {
    //                 /* Process the retrieved JSON object
    //                  *    Retrieve a specific attribute from our parsed
    //                  *    JSON string and set the tooltip content.
    //                  */
                    

    //                 var json = JSON.parse(data);
    //                 var json_obj_cnt = Object.keys(json).length;

    //                 var item_desc = json[0].item_desc;

    //                 console.log(json_obj_cnt);
    //                 //console.log(sup_remarks);
    //                 var content = '<b>ITEM'++'</b> ' + item_desc + '<br /> test new line';

    //                  //Now we set the content manually (required!)
    //                 api.set('content.text', content);
                    
    //             }, function(xhr, status, error) {
    //                 // Upon failure... set the tooltip content to the status and error value
    //                 api.set('content.text', status + ': ' + error);
    //             });

    //             return 'Loading...';
    //         }
    //     }
    // });

    
  </script>

</html>