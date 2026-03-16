$(document).ready(function () {
			// ---------------------------------------------------------------
			// FOR THE USEREDIT OPTION in the Banner side
			// ---------------------------------------------------------------
      
    
      $('#useroption-wrapper').hide();
      $("#useredit").click(function(){
        $('#useroption-wrapper').slideToggle(100);
        
        return false;
      });

      $('#useredit-error').hide();
      $('#useredit-passerror').hide();
      $('#useredit-success').hide();
      $("a#useredit-updatebut").click(function(){
          var id = $(this).attr('value');
          var password  =  $('#useredit-password').attr('value');
          var cpassword =  $('#useredit-cpassword').attr('value');
          var firstname =  $('#useredit-firstname').attr('value');
          var lastname  =  $('#useredit-lastname').attr('value');

          //check if password and confirm password is same

          if(password === cpassword){
            //proceed
            $.ajax({    
                  url: "dps/ajax_updateprofile", 
                  async: false, 
                  type: "POST",
                  data: "id="+id+"&password="+password+"&fname="+firstname+"&lname="+lastname, 
                  dataType: "html",
                  success: function(data) {
                    if(data === 'success'){
                      $('#useredit-error').hide();
                      $('#useredit-passerror').hide();
                      $('#useredit-success').fadeIn(100);
                      $('#useroption-wrapper').fadeOut(4000);
                    }else{
                      $('#useredit-success').hide();
                      $('#useredit-passerror').hide();
                      $('#useredit-error').fadeIn(500);
                    }
                  }
            })
          }else{
            //error
            $('#useredit-success').hide();
            $('#useredit-error').hide();
            $('#useredit-passerror').fadeIn(500);
          }
          return false;
      });
});	