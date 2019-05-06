<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require ("db.class.php");
require ('mailer/autoload.php');

class Utente extends Db{
  private $prefix = '';
  private $versamenti_dir = "upload/versamenti/";
  function __construct(){$this->prefix = date('YmdHis')."-";}

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

  public function utente(){ return $this->simple("select * from rubrica where id = ".$_SESSION['id'].";"); }
  public function iscrizioniList(){ return $this->simple("select * from iscrizioni order by data asc;"); }

  public function nuovoSocio($id){
    try {
      $this->begin();
      $iscrizione = $this->simple("select * from iscrizioni where id = ".$id.";");
      $username = $this->getUsername($iscrizione[0]['email']);
      $sql1 = "insert into rubrica(cognome, nome, email, indirizzo, cellulare) select cognome, nome, email, indirizzo, telefono from iscrizioni where id = ".$id.";";
      $pdo = $this->pdo();
      $exec = $pdo->prepare($sql1);
      $exec->execute();
      $rubrica = $this->pdo()->lastInsertId('rubrica_id_seq');
      $sql2 = "insert into soci(rubrica) values(".$rubrica.")";
      $exec = $pdo->prepare($sql2);
      $exec->execute();
      $sql3 = "insert into quote(socio, data, tipo, versamento) select ".$rubrica.", data, 1, versamento from iscrizioni where id = ".$id.";";
      $exec = $pdo->prepare($sql3);
      $exec->execute();
      $sql4 = "delete from iscrizioni where id = ".$id.";";
      $exec = $pdo->prepare($sql4);
      $exec->execute();

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = getenv('ARCTEAMGMAIL');
      $mail->Password = getenv('ARCTEAMGMAILPWD');
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      //Recipients
      $mail->setFrom(getenv('ARCTEAMGMAIL'), 'Arc-Team');
      $mail->addAddress($iscrizione[0]['email'],$username);
      $mail->addReplyTo(getenv('ARCTEAMGMAIL'), 'Arc-Team');
      //Content
      $mail->isHTML(true);
      $mail->Subject = "Iscrizione all'associazione culturale G.B.Lampi";
      $mail->Body    = "<p>Complimenti, la tua richiesta di iscrizione è stata accettata!<br>Da ora sei regolarmente iscritto all'associazione culturale G.B.Lampi</p><p>Benvenuto da tutto lo staff</p>";
      $mail->AltBody = "Complimenti, la tua richiesta di iscrizione è stata accettata!\nDa ora sei regolarmente iscritto all'associazione culturale G.B.Lampi\nBenvenuto da tutto lo staff";
      $mail->send();
      $this->commitTransaction();
    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }

  public function iscrizione($dati,$files){
    try {
      $this->begin();
      $campi=[];
      $this->checkIscrizione($dati['email']);
      if($files['error'] === 0){
        $file=$this->prefix.str_replace(" ","_",basename($files["name"]));
        $versamento = $this->versamenti_dir.$file;
        $up = $this->uploadfile($files["tmp_name"],$versamento);
        if ($up) { $dati['versamento']=$file; }else { return $up; }
      }
      foreach ($dati as $key => $value) { $campi[] = ":".$key; }
      $sql = "insert into iscrizioni(".str_replace(":","",implode(",",$campi)).") values(".implode(",",$campi).");";
      $res = $this->prepared($sql,$dati);
      $this->commitTransaction();
      return array(true,$res);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  private function checkIscrizione($email){
    $check = $this->simple("select id from iscrizioni where email = '".$email."';");
    if (count($check)>0) {
      throw new \Exception("Attenzione, esiste già una richiesta di iscrizione con questa email.", 1);
    }else {
      return true;
    }
  }

  private function uploadfile($img,$dir){
    if (move_uploaded_file($img, $dir)) {
      chmod($dir, 0755);
      return true;
    }else {
      throw new \Exception("Attenzione, errore durante il caricamento, riprova o contatta l'amministratore.", 1);
    }
  }

  public function rescuePwd($dati=array()){
    $email = $dati['email'];
    unset($dati['email']);
      $id = $this->simple("select id from rubrica where email = '".$email."';");
    $dati['rubrica'] = $id[0]['id'];
    $sql = "update utenti set password=crypt(:password,gen_salt('bf',8)) where rubrica=:rubrica;";
    $username = $this->getUsername($email);
    try {
      $checkEmail = $this->checkEmail($email);
      $dati['password'] = $this->createPwd();
      $this->begin();
      $this->prepared($sql,$dati);
      $this->sendMail(array($email,$username,$dati['password'],"password"));
      $this->commitTransaction();
      return "Ok! Una nuova password è stata inviata all'indirizzo email inserito.";
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  private function checkEmail($email){
    $check = $this->simple("select * from utenti,rubrica where utenti.rubrica = rubrica.id and rubrica.email = '".$email."' and utenti.attivo = 't';");
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
