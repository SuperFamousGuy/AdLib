<?php
/*======================================================================*\
|| #################################################################### ||
|| # Copyright ©2006-2009 Youjoomla LLC. All Rights Reserved.           ||
|| # ----------------     JOOMLA TEMPLATES CLUB      ----------- #      ||
|| # @license http://www.gnu.org/copyleft/gpl.html GNU/GPL            # ||
|| #################################################################### ||
\*======================================================================*/
defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_yj_pop_login/stylesheet.css');
echo "<!-- http://www.Youjoomla.com YJ Pop Login for Joomla 1.5 starts here --> ";
?>

<?php if($type == 'logout') : ?>
<div id="logins">
<?php if ($params->get('greeting')) : ?>
	<?php echo JText::_('HINAME') ?><?php echo ($user->get('name') ); ?>
<?php endif; ?>
<form action="index.php" method="post" name="login" id="form-login">
<input type="submit" name="Submit" class="button" value="Logout" />
<input type="hidden" name="option" value="com_user" />
<input type="hidden" name="task" value="logout" />
<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
</div>
<?php else : ?>





<?php 
JHTML::_('behavior.mootools'); 
$document->addScript(JURI::base() . 'modules/mod_yj_pop_login/src/yj_login_pop.js');


?>
<script type="text/javascript">
window.addEvent('domready', function() {
		$("login_pop").setStyles({
			left: (window.getScrollLeft() + (window.getWidth() - 290)/2)+'px'
	
		}); 

		$("reg_pop").setStyles({
			left: (window.getScrollLeft() + (window.getWidth() - 445)/2)+'px'

		}); 
});
</script>

  

   
 
<!-- registration and login -->
<div class="poping_links">
<?php echo $params->get('pretext'); ?><br  />
        	
        <a href="javascript:;" onclick="this.blur();showThem('login_pop');return false;" id="openLogin">Login</a>
      <?php $usersConfig = &JComponentHelper::getParams( 'com_users' ); if ($usersConfig->get('allowUserRegistration')) : ?>
        <a href="javascript:;" onclick="this.blur();showThem('reg_pop');return false;" id="openReg">Register</a><?php endif; ?>

	<br />
<a href="<?php echo JRoute::_( 'http://ad-lib.updatechicago.com/index.php?option=com_user&view=reset&Itemid=26' ); ?>"><?php echo JText::_('FORGOT_YOUR_PASSWORD') ?></a> | <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind&Itemid=27' ); ?>"><?php echo JText::_('FORGOT_YOUR_USERNAME') ?></a>
    </div>
    
   <!-- login -->
       <div id="login_pop" style="display:none;">
       <?php if(JPluginHelper::isEnabled('authentication', 'openid')) : ?>
	<?php JHTML::_('script', 'openid.js'); ?>
<?php endif; ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
	

	
		<label for="yjpop_username"><?php echo JText::_('Username') ?></label>	<br />
		<input id="yjpop_username" type="text" name="username" class="inputbox" alt="username" size="18" />
		<br />

		<label for="yjpop_passwd"><?php echo JText::_('Password') ?></label>	<br />
		<input id="yjpop_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" />
		<br />
	<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
		<br />
		<label for="yjpop_remember"><?php echo JText::_('Remember me') ?></label>
		<input id="yjpop_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" />
		<br />
	<?php endif; ?>
	<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />

	
	<?php echo $params->get('posttext'); ?>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
       <a href="javascript:;" onclick="this.blur();showThem('login_pop');return true;" id="closeLogin">Close</a>
       </div>


       <!-- registration  -->
        <div id="reg_pop"  style="display:none;">
       <script type="text/javascript" src="<?php echo JURI::base() ?>media/system/js/validate.js"></script>
				<script type="text/javascript">Window.onDomReady(function(){document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);});</script>
				<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">
				
				<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
				<tr>
					<td width="30%" height="40">
						<label id="namemsg" for="name">
							<?php echo JText::_( 'NAME' ); ?>:
						</label>
					</td>
				  	<td>
				  		<input type="text" name="name" id="name" size="40" value="" class="inputbox required" maxlength="50" /> *
				  	</td>
				</tr>
				<tr>
					<td height="40">
						<label id="usernamemsg" for="username">
							<?php echo JText::_( 'USERNAME' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" id="username" name="username" size="40" value="" class="inputbox required validate-username" maxlength="25" /> *
					</td>
				</tr>
				<tr>
					<td height="40">
						<label id="emailmsg" for="email">
							<?php echo JText::_( 'EMAIL' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" id="email" name="email" size="40" value="" class="inputbox required validate-email" maxlength="100" /> *
					</td>
				</tr>
				<tr>
					<td height="40">
						<label id="pwmsg" for="password">
							<?php echo JText::_( 'PASSWORD' ); ?>:
						</label>
					</td>
				  	<td>
				  		<input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> *
				  	</td>
				</tr>
				<tr>
					<td height="40">
						<label id="pw2msg" for="password2">
							<?php echo JText::_( 'VERIFY_PASSWORD' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> *
					</td>
				</tr>
				<tr>
					<td colspan="2" height="40">
						<p class="information_td"><?php echo JText::_( 'REGISTER_REQUIRED' ); ?></p>
					</td>
				</tr>
				</table>
					<button class="button validate" type="submit"><?php echo JText::_('REGISTER'); ?></button>
					<input type="hidden" name="task" value="register_save" />
					<input type="hidden" name="id" value="0" />
					<input type="hidden" name="gid" value="0" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</form>
                
                 <a href="javascript:;" onclick="this.blur();showThem('reg_pop');return true;" id="closeReg">Close</a>
       </div>



<!-- end registration and login -->
<?php endif; ?>
