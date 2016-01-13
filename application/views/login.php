
	<div id='form_login'>
    <div class='title'><?php echo $this->lang->line('login_login');?> Form</div>
    <div class='the_content'>
    	<?php echo form_open('login/do_login',array('name'=>'login_form','id'=>'login_form'));?>
    	<form id="login_form" method="post" action="index.php/login/do_login">
      <table class='myform' style='width:100%'>
        <tr>
          <td class='a_right' valign='top'><?php echo $this->lang->line('login_username');?> :</td>
          <td class='a_left' valign='top'><input type='text' name='username' style='width:97%' value="<?php if(isset($username)) echo $username; ?>" /></td>
        </tr>
        <tr>
          <td class='a_right' valign='top'><?php echo $this->lang->line('login_password');?> :</td>
          <td class='a_left' valign='top'><input type='password' name='password' style='width:97%' /></td>
        </tr>
      </table>
      <div class='the_footer a_right'>
      	<input type="submit" value="<?php echo $this->lang->line('login_go');?>" />
      </div>
      </form>
      
    </div>
	</div>
	<div id="result" align="center">
		<?php if(isset($log_error)) echo $log_error;?>	
	</div>
  