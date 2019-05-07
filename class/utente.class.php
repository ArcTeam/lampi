<?php
session_start();
require ("amministratore.class.php");

class Utente extends Amministratore{
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

  public function utente(){ return $this->simple("select rubrica.* from rubrica, utenti where utenti.rubrica = rubrica.id and utenti.id = ".$_SESSION['id'].";"); }

  public function changePwd($dati=array()){
    $check = $this->simple("select password from utenti where id = ".$_SESSION['id']." and password = crypt('".$dati['oldpwd']."',password);");
    if (!empty($check)){
      $val = array('newpwd'=>$dati['newpwd'],'id'=>$_SESSION['id']);
      $sql = "update utenti set password=crypt(:newpwd,gen_salt('bf',8)) where id=:id;";
      try {
        $this->prepared($sql,$val);
        return array('success','ok, la password è stata correttamente modificata, potrai usarla dal prossimo login');
      } catch (Exception $e) {
        return array('danger',$e->getMessage());
      }
    }else{
      return array('danger','attenzione, la password corrente non è corretta o è stata digitata male, riprova');
    }
  }

  public function changeUsrData($dati=array()){
    $rubrica = $this->simple("select rubrica from utenti where id = ".$_SESSION['id'].";");
    $dati['id']=$rubrica[0]['rubrica'];
    foreach ($dati as $key => $value) {
      if ($value=="") {$value=null;}
      $campi[]=$key."=:".$key;
      $val[$key]=$value;
    }
    $sql = "update rubrica set ".implode(",",$campi)." where id=:id;";
    return $this->prepared($sql, $dati);
  }

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
      $sql3 = "insert into quote(socio, anno, tipo, versamento) select ".$rubrica.", date_part('year',data), 1, versamento from iscrizioni where id = ".$id.";";
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
    $check = $this->simple("select utenti.id, utenti.classe, rubrica.email from utenti,rubrica where utenti.rubrica = rubrica.id and rubrica.email = '".$email."' and utenti.attivo = 't';");
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
}
?>
