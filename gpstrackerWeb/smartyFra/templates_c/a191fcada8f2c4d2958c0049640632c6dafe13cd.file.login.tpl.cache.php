<?php /* Smarty version Smarty-3.1.12, created on 2013-10-22 11:05:31
         compiled from "smartyFra/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8425391505266be6b44e1e8-30326319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a191fcada8f2c4d2958c0049640632c6dafe13cd' => 
    array (
      0 => 'smartyFra/templates/login.tpl',
      1 => 1374852834,
      2 => 'file',
    ),
    'd27af9267e86afdb6f4fe67ce01c3470797e1142' => 
    array (
      0 => 'smartyFra/templates/layoutLogin.tpl',
      1 => 1371542805,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8425391505266be6b44e1e8-30326319',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'debug' => 0,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5266be6b5d6bf7_91718806',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5266be6b5d6bf7_91718806')) {function content_5266be6b5d6bf7_91718806($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>            
        <?php echo $_smarty_tpl->getSubTemplate ('javascript_css.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('min'=>''), 0);?>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        <title>Sito - Login</title>
    </head>
<body>
<div id="content" style="margin:10px;">

        
        <script  src="js/webtoolkit.md5.js"></script>
        <script>
            function cifraPassword() {
                $("#password").val(MD5($("#password").val()));
                return true;
            }

			$(function() {
				$( "#bt_login" ).button({
					icons: {
						primary: "customIconLogin"
					},
					text: true
				});					
				$( "#bt_passwd").button({
					icons: {
						primary: "customIconLogout"
					},
					text: true
				});					
			});	
        </script>
        <style>
        #login {
            margin: 0 auto;
            width:250px;
        }
        </style>

        <div id="login" class="ui-widget-content">
        <h3 class="ui-widget-header">Login</h3>
        <form id="login" action="login.php" method="post" onSubmit="return cifraPassword();">
        <table>
            <tr>
                <td><label for="name">Utente:</label></td>
                <td></td>
                <td colspan="2">
                <input type="text" value="" id="name" name="username"><input type="hidden" name="action" value="controlloLogin"/></td>
                
            </tr>
            <tr>
                <td><label for="name">Password:</label></td>
                <td></td>                
                <td colspan="2">
                <input type="password" value="" id="password" name="password" ></td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td align="center"><button id="bt_login" type="submit">Login</button></td>
                <td align="center"><button id="bt_passwd" type="reset">Clear</button></td>
            </tr>  
        </table>    	
        </form><!-- data-theme="b" /Login form end-->
    </div><!--Content end-->            
	<script>
	    $('input').addClass("ui-corner-all");
    </script>

</div>

</body>
</html>
<?php if ((isset($_smarty_tpl->tpl_vars['debug']->value))){?><?php echo '/*%%SmartyNocache:8425391505266be6b44e1e8-30326319%%*/<?php $_smarty_tpl->smarty->loadPlugin(\'Smarty_Internal_Debug\'); Smarty_Internal_Debug::display_debug($_smarty_tpl); ?>/*/%%SmartyNocache:8425391505266be6b44e1e8-30326319%%*/';?>
<?php }?>
<?php }} ?>