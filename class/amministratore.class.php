<?php
session_start();
require("db.class.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('mailer/autoload.php');
class Amministratore extends Db{
  private $prefix = '';
  function __construct(){ $this->prefix = date('YmdHis')."-"; }
  public function listaSoci($filtro=null){
    $sql = "select r.id, r.cognome||' '||r.nome socio from rubrica r, soci s where s.rubrica = r.id order by socio asc";
    if ($filtro) { $sql .= " and s.attivo = '".$filtro."' "; }
    $sql .= " order by socio asc;";
    return $this->simple($sql);
  }

  public function addUserList(){
    return $this->simple("select id, cognome||' '||nome as utente from rubrica where id not in(select rubrica from utenti) order by utente asc;");
  }

  public function utenti(){
    return $this->simple("select rubrica.*,utenti.classe,utenti.attivo from rubrica,utenti where utenti.rubrica = rubrica.id order by rubrica.cognome, rubrica.nome;");
  }

  public function anniQuote(){return $this->simple("select anno from quote order by anno asc limit 1;");}
  public function checkQuote($anno){
    $sql = "with filtro as (select socio,anno,tipo from quote where anno <= ".$anno.")
    select distinct r.id, r.cognome||' '||r.nome socio
    from rubrica r, soci s, filtro
    where
      s.rubrica = r.id
      and filtro.socio = s.rubrica
      and r.id not in ( select socio from filtro where anno = ".$anno.")
    order by socio asc;";
    return $this->simple($sql);
  }
  public function registraQuota($dati=array()){
    $sql = "insert into quote(socio,tipo,anno) values (:socio,:tipo,:anno);";
    return $this->prepared($sql,$dati);
  }
  public function addNewUser($dati=array()){
    try {
      $sql="insert into utenti(rubrica,classe,password) values (:utente,:classe,crypt(:password, gen_salt('bf',8)))";
      $dati['password'] = $this->createPwd();
      $this->prepared($sql,$dati);
      $getEmail = $this->simple("select email from rubrica where id = ".$dati['utente']);
      $email = $getEmail[0]['email'];
      $username = $this->getUsername($email);
      $this->sendMail(array($email,$username,$dati['password'],'user'));
      return "L'utente è stato creato correttamente.";
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function promuovi($dati=array()){
    $sql = "update utenti set classe = 2 where rubrica = :utente;";
    return $this->prepared($sql,$dati);
  }
  public function changeState($dati=array()){
    $sql = "update utenti set attivo = :stato where rubrica = :utente;";
    return $this->prepared($sql,$dati);
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
        $oggetto = 'Associazione G.B.Lmpi. Nuovo account.';
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
