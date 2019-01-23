<?php
require("conn.class.php");
class Db extends Conn{
  private $string = PDO::PARAM_STR;
  private $integer = PDO::PARAM_INT;
  public function simple($sql){
    $pdo = $this->pdo();
    $exec = $pdo->prepare($sql);
    try {
      $exec->execute();
      return $exec->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return  "error: ".$e->getMessage();
    }
  }
  public function prepared($action, $sql, $dati=array()){
    if(!is_array($dati)){return "i dati devono essere un array";}
    $pdo = $this->pdo();
    $exec = $pdo->prepare($sql);
    try {
      $exec->execute($dati);
      switch ($action) {
        case 'nuovo': $out = "New record has been successfully created"; break;
        case 'modifica': $out = "The record has been successfully updated"; break;
        case 'elimina': $out = "The record has been permanently deleted"; break;
        case 'nuova password': $out = "Password has been successfully created"; break;
        case 'nuovo utente': $out = "New account has been successfully created"; break;
        case 'modifica utente': $out = "User data has been changed"; break;
        case '': $out='';
      }
      return $out;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
  protected function countRow($sql){
    $pdo = $this->pdo();
    try {
      $row = $pdo->query($sql)->rowCount();
      return $row;
    } catch (Exception $e) {
      return "errore: ".$e->getMessage();
    }
  }
  protected function begin(){$this->pdo()->beginTransaction();}
  protected function commitTransaction(){$this->pdo()->commit();}
  protected function rollback(){$this->pdo()->rollBack();}
}
?>
