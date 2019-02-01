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
        case 'nuovo': $out = "Il nuovo record è stato correttamente creato"; break;
        case 'modifica': $out = "Il record è stato modificato con successo"; break;
        case 'elimina': $out = "Il recor dè stato definitivamente eliminato"; break;
        case 'nuova password': $out = "La password è stata creata"; break;
        case 'nuovo utente': $out = "Il nuovo utente è stato creato"; break;
        case 'modifica utente': $out = "I dati dell'utente sono stati modificati"; break;
        default: $out='Operazione avvenuta con successo'; break;
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
