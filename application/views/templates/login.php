
	<div class="container">

      <div id="login">
      	<?php echo $status ?>

        <form action="<?php echo $action ?>" method="POST">
        	<input type="hidden" name="requestingpage" value="<?php echo $requestingpage ?>" />

          <fieldset class="clearfix">

            <p>
            	<span class="fa fa-user"></span>
            	<input type="text" id="username" name="username" value="Username" onBlur="if(this.value == '') this.value = 'Username'" onFocus="if(this.value == 'Username') this.value = ''" required>
            </p> <!-- JS because of IE support; better: placeholder="Username" -->
            
            <p>
            	<span class="fa fa-lock"></span>
            	<input type="password" id="password" name="password" value="Password" onBlur="if(this.value == '') this.value = 'Password'" onFocus="if(this.value == 'Password') this.value = ''" required>
            </p> <!-- JS because of IE support; better: placeholder="Password" -->
            
            <p><input type="submit" value="Sign In"></p>

          </fieldset>

        </form>

        <p>Not a member? <span class="fa fa-phone-square"></span>  Contact Administrator </p>

      </div> <!-- end login -->

    </div>
