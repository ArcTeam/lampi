<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require ("db.class.php");
require ('mailer/autoload.php');

class Utente extends Db{

  function __construct(){}
  public function login($dati=array()){
    try {
      $usrInfo = $this->checkEmail($dati['email']);
      $this->checkPwd($dati['pwd']);
      $this->setSession($usrInfo[0]);
      return "Credenziali corrette, stai per accedere all'area riservata";
    } catch (\Exception $e) {
      return $e->getMessage();
    } catch (PDOException $e){
      return $e->getMessage();
    }
  }

  public function rescuePwd($dati=array()){
    $sql = "update utenti set password=crypt(:password,gen_salt('bf',8)) where email=:email;";
    $username = $this->getUsername($dati['email']);
    try {
      $this->checkEmail($dati['email']);
      $dati['password'] = $this->createPwd();
      $this->begin();
      $this->prepared($sql,$dati);
      $this->sendMail(array($dati['email'],$username,$dati['password'],"password"));
      $this->commitTransaction();
      return "Ok! Una nuova password è stata inviata all'indirizzo email inserito.";
    } catch (\Exception $e) {
      $this->rollback();
      return $e->getMessage();
    }
  }

  private function checkEmail($email){
    $check = $this->simple("select * from utenti where email = '".$email."' and attivo = 't';");
    if (count($check)==0) {
      throw new \Exception("Errore! Email: ".$email." non valida o utente disabilitato", 1);
    }
    return $check;
  }
  private function checkPwd($pwd){
    $check = $this->simple("select id from utenti where password = crypt('".$pwd."',password);");
    if (count($check)==0) {
      throw new \Exception("Errore! La password non è corretta o è stata digitata male.<br>Riprova, se l'errore persiste contatta l'amministratore all'indirizzo beppenapo<i class='fas fa-at'></i>arc-team.com", 1);
    }
    return true;
  }

  private function setSession($dati=array()){
    $username = $this->getUsername($dati['email']);
    $_SESSION['username']=$username;
    $_SESSION['id']=$dati['id'];
    $_SESSION['classe']=$dati['classe'];
    $_SESSION['act']='logged';
    return true;
  }
  protected function getUsername($email){$u = explode("@",$email);return $u[0];}
  protected function createPwd(){
    $pwd = "";
    $pwdRand = array_merge(range('A','Z'), range('a','z'), range(0,9));
    for($i=0; $i < 10; $i++) {$pwd .= $pwdRand[array_rand($pwdRand)];}
    return $pwd;
  }

  ### sendMail function parameters:
  ### dati[0]=(char) email
  ### dati[1]=(char) username (use getUsername function)
  ### dati[2]=(char) clear password (use createPwd function)
  ### dati[3]=(char) email type(admin,user,password)
  protected function sendMail($dati=array()){
    $folder=__DIR__ . "/mailBody/";
    $mail = new PHPMailer(true);
    switch ($dati[3]) {
      case 'admin':
        $oggetto = 'New admin profile';
        $bodyFile = "initAdmin";
      break;
      case 'user':
        $oggetto = 'New account for Virtual Claudia Augusta data management system';
        $bodyFile = "newUsr";
      break;
      case 'password':
        $oggetto = 'Associazione G.B.Lmpi. Nuova password per il tuo account';
        $bodyFile = "newPwd";
      break;
    }
    $altBody = file_get_contents($folder.$bodyFile.'.txt');
    $altBody = str_replace('%utente%', $dati[1], $altBody);
    $altBody = str_replace('%password%', $dati[2], $altBody);
    $body = file_get_contents($folder.$bodyFile.'.html');
    $body = str_replace('%utente%', $dati[1], $body);
    $body = str_replace('%password%', $dati[2], $body);
    try {
      // $mail->SMTPDebug = 1;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = getenv('ARCTEAMGMAIL');
      $mail->Password = getenv('ARCTEAMGMAILPWD');
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      //Recipients
      $mail->setFrom(getenv('ARCTEAMGMAIL'), 'Arc-Team');
      $mail->addAddress($dati[0],$dati[1]);
      // $mail->addBCC(getenv('ARCTEAMGMAIL'));
      $mail->addReplyTo(getenv('ARCTEAMGMAIL'), 'Arc-Team');
      //Content
      $mail->isHTML(true);
      $mail->Subject = $oggetto;
      $mail->Body    = $body;
      $mail->AltBody = $altBody;
      $mail->send();
      return true;
    } catch (Exception $e) {
      return "Errore nell&apos;invio della mail!<br/>Se di seguito visualizzi un messaggio di errore, copialo ed invialo all&apos;amministratore di sistema - beppenapo@arc-team.com<br/>: ".$mail->ErrorInfo;
    }
  }
}

?>
