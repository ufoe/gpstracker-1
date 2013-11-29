<html>
	<body background="../logo tea in acqua.gif">
            <br/>
            <br/>
            <br/>
            <center>
            <h1>Creazione nuovo utente</h1><br/>
            Inserire un indirizzo di posta valido e scegliere una password da utilizzare per poter accedere al sito.<br/>
            Verra' quindi mandata una mail di attivazione all'indirizzo di posta inserito.<br/>
            Nella mail sara' contenuto un link da visitare per poter attivare l'account e poter quindi accedere alla visione dell'impianto.<br/>
            <br/>
            <form name="login" action="creaUtente.php" method="POST">
                            <table>
                                    <tr>
                                            <td>Email:</td>
                                            <td><input type="text" name="email"></td>
                                    </tr>
                                    <tr>
                                            <td>Password:</td>
                                            <td><input type="password" name="password" value=""></td>
                                    </tr>
                                    <tr>
                                            <td>Ripeti password:</td>
                                            <td><input type="password" name="password2" value=""></td>
                                    </tr>
                                    <tr>
                                            <td></td>
                                            <td><input type="submit" value="  Crea nuovo utente  "></td>
                                    </tr>
                            </table>

            </form>	
	</center>
	</body>
</html>