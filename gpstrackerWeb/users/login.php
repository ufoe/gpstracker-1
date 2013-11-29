<?php

    session_start();
    
    include("user_config.php");

    $errori["NT"]="L'account non trovato o password errata";
    $errori["NC"]="L'account non e' stato ancora confermato, si consiglia di controllare la posta elettronica";

    $errore="";
    if (isSet($_GET["errore"])) {
        $errore=$errori[$_GET["errore"]];
    }
    

?><!DOCTYPE html>
<html>
        <head>            
            <?php includiJsCss(); ?>
            <link rel="stylesheet" type="text/css" href="users/users_style.php">
        </head>
	<body>
            
		
            
            <div data-role="page" data-title="Login">
                <!--div data-role="header" data-theme="b" data-icon="home">
                        <h1>Home</h1><a data-theme="b" href="index.html" data-icon="home" data-role="button" rel="internal" data-iconpos="notext"></a>
                </div--><!-- /header -->
                     <?php
                         if ($errore!="") {
                                ?>
                                <H1><?=$errore;?></H1><br/>
                                <?php
                         }
                     ?>

                                
                    <div data-role="content" >	
                                <p>Inserire il proprio nome utente e la password per accedere...</p>		

                        
                        <!--Content start-->
				<!--div data-type="horizontal" data-role="controlgroup" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal">
					<a data-inline="true" data-role="button" data-icon="info" href="#" data-theme="c" class="ui-btn ui-btn-inline ui-btn-icon-left ui-corner-left ui-btn-up-c"><span class="ui-btn-inner ui-corner-left"><span class="ui-btn-text">Help</span><span class="ui-icon ui-icon-gear ui-icon-shadow"></span></span></a>

					<a data-inline="true" data-role="button" data-icon="refresh" href="#" data-theme="c" class="ui-btn ui-btn-inline ui-btn-icon-left ui-corner-right ui-controlgroup-last ui-btn-up-c"><span class="ui-btn-inner ui-corner-right ui-controlgroup-last"><span class="ui-btn-text">Refresh</span><span class="ui-icon ui-icon-refresh ui-icon-shadow"></span></span></a>
				</div--><!-- /controlgroup -->
<br/>
<br/>		
		<!--Login form start-->
		<form id="login" action="login.php" method="post" data-ajax="false">
                        <input type="hidden" name="action" value="controlloLogin"/>
			<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
	         <label for="name" class="ui-input-text">Utente:</label>
	         <input type="text" value="" id="name" name="username" class="ui-input-text ui-body-null ui-corner-all ui-shadow-inset ui-body-c">
			</div>

			<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
	         <label for="name" class="ui-input-text">Password:</label>
	         <input type="password" value="" id="password" name="password" class="ui-input-text ui-body-null ui-corner-all ui-shadow-inset ui-body-c">
			</div>

		<fieldset class="ui-grid-a">
				<div class="ui-block-a"><button data-theme="b" type="submit" class="ui-btn-hidden" aria-disabled="false">Login</button></div>
				<div class="ui-block-b"><button data-theme="b" type="reset" class="ui-btn-hidden" aria-disabled="false">Clear</button></div>

	    </fieldset>

	</form>
<!-- /Login form end-->

<!--br /><br /-->
		<!--a href="http://www.171labs.com" data-role="button" data-theme="c" data-icon="check" data-inline="true">Designed at 171 Labs</a--> 

<!--Content end-->

</div><!-- /page -->
<div data-role="footer" >
		<!--h4>&copy; 2011</h4-->
	</div><!-- /footer -->

        
        
        
			<!--table>
                            <?php
                                if ($user_new_user_enabled) {
                            ?>
				<tr>
					<td>
						<a href="nuovoUtente.php">Nuovo utente ...</a>
					</td>
				</tr>
                            <?php
                                }
                            ?>
                            <?php
                                if ($user_new_user_forgot_password) {
                            ?>
				<tr>
					<td>
                                            <span style="font-size: small;" > <a href="passwordDimenticata.php">Ho dimenticato la password ...</a></span>
					</td>
				</tr>
                            <?php
                                }
                            ?>
			</table-->
                    <?php //include_once 'loginPersonalizzazione.php';?>
	</body>
</html>
