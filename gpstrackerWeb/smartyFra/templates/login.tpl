{extends file="layoutLogin.tpl"}
{block name=title}Sito - Login{/block}
{block name=body}
        
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
{/block}
