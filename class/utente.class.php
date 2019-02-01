<?php
require("db.class.php");
class Utente extends Db{

  function __construct(){}
  public function login($dati=array()){
    try {
      $usrInfo = $this->checkEmail($dati['email']);
      $this->checkPwd($dati['pwd']);
      return "Credenziali corrette, stai per accedere all'area riservata";
    } catch (\Exception $e) {
      return $e->getMessage();
    } catch (PDOException $e){
      return $e->getMessage();
    }

  }

  private function checkEmail($email){
    $check = $this->simple("select * from utenti where email = '".$email."' and attivo = 't';");
    if (count($check)==0) {
      throw new \Exception("Errore! Email non valida o utente disabilitato", 1);
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
  private function setSession($dati=array()){}
}

?>
