<?php

//include_once ("../inclusione.inc.php");
if (file_exists("functions.php")) {
    require_once("functions.php");
} else {
    if (file_exists("../functions.php")) {
        require_once("../functions.php");
    }
}

require_once 'class.phpmailer.php';

if (file_exists(__DIR__."settaggiEmail.php")) {
    require_once(__DIR__."settaggiEmail.php");
}

class BfaHtmlEmail {

    public $mail = null;
    public $allegati = null;
    public $sostituzioni = null;

    function isCli() {

        if (php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
            return true;
        } else {
            return false;
        }
    }

    public function __construct() {
        global $mail_Host, $mail_Port, $mail_SMTPAuth, $mail_Username, $mail_Password, $mail_From, $mail_FromName;
        global $logger;

        if ($mail_Port == null) {
            $mail_Port = 25;
        }



        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();                                      // set mailer to use SMTP
        $this->mail->Host = $mail_Host;  // specify main and backup server
        $this->mail->Port = $mail_Port;
        $this->mail->SMTPAuth = $mail_SMTPAuth;     // turn on SMTP authentication
        $this->mail->Username = $mail_Username;  // SMTP username
        $this->mail->Password = $mail_Password; // SMTP password
        $this->mail->From = $mail_From;
        $this->mail->FromName = $mail_FromName;
        $this->mail->IsHTML(true);                                  // set email format to HTML
        $this->mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
    }

    function send($to, $subject, $fileName) {
        try {
            //$mail->AddReplyTo('name@yourdomain.com', 'First Last');


            $destMails = preg_split("/[;,]+/", $to);
            foreach ($destMails as $destinatario_) {
                $this->mail->AddAddress($destinatario_);                  // name is optional
            }


            //$this->mail->AddAddress($to);
            //$mail->SetFrom('name@yourdomain.com', 'First Last');
            //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
            $this->mail->Subject = $subject;

            if (file_exists($fileName)) {
                $testoHTML = file_get_contents($fileName);
            } else {
                $testoHTML = $fileName;
            }

            // sostituzioni
            if ($this->sostituzioni != null) {
                foreach ($this->sostituzioni as $chiave => $valore) {
                    $testoHTML = str_replace($chiave, $valore, $testoHTML);
                }
            }

            $pos = dirname($fileName);
            if ($pos == ".") {
                $pos = realpath(dirname($fileName));
            }

            $this->mail->MsgHTML($testoHTML, $pos);


            if ($this->allegati != null) {
                for ($t = 0; $t < count($this->allegati); $t++) {
                    if (file_exists($this->allegati[$t])) {
                        $this->mail->AddAttachment($this->allegati[$t]);         // add attachments
                    }
                }
            }

            $res = $this->mail->Send();
            if (!$res) {
                if ($this->isCli()) {
                    echo $this->mail->ErrorInfo . "\r\n";
                }
            }
            return $res;
        } catch (phpmailerException $e) {
            if ($this->isCli()) {
                echo $e->errorMessage() . "\r\n";
            } else {
                if (isSet($logger)) {
                    $logger->error($e->errorMessage()); //Pretty error messages from PHPMailer
                }
            }
        } catch (Exception $e) {
            if ($this->isCli()) {
                echo $e->getMessage() . "\r\n";
            } else {
                if (isSet($logger)) {
                    $logger->error($e->getMessage()); //Pretty error messages from PHPMailer
                }
            }
        }
    }

    function setAllegati($allegati) {
        $this->allegati = $allegati;
    }

    function setSostituzioni($sostituzioni) {
        $this->sostituzioni = $sostituzioni;
    }

}

if (function_exists("getGet")) {

    if (getGet("AZIONE") == "TESTEMAIL") {
        $email = new BfaHtmlEmail();

        $email->setSostituzioni(array("TESTOTESTO" => "testo sostituito", "DATADATA" => "data da mettere"));
        $email->setAllegati(array("../img/email.png"));

        $res = $email->send("fbrisa@gmail.com", "email complessa 2", "test/contenuto.html");
        if ($res) {            
            echo json_encode(array("success" => "true", "result" => $res));
        } else {
            echo json_encode(array("success" => "true", "result" => $res));
        }
    }
}
