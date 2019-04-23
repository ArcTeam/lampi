<?php
require("conn.class.php");
class Db extends Conn{
  private $string = PDO::PARAM_STR;
  private $integer = PDO::PARAM_INT;
  public function simple($sql){
    try {
      $pdo = $this->pdo();
      $exec = $pdo->prepare($sql);
      $exec->execute();
      return $exec->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return  "error: ".$e->getMessage();
    }
  }
  public function prepared($sql, $dati=array()){
      $pdo = $this->pdo();
      $exec = $pdo->prepare($sql);
      $res = $exec->execute($dati);
      if ($res) {
        return true;
      }else {
        throw new \Exception($res, 1);
      }
  }
  public function countRow($sql){
    try {
      $pdo = $this->pdo();
      $row = $pdo->query($sql)->rowCount();
      return $row;
    } catch (Exception $e) {
      return "errore: ".$e->getMessage();
    }
  }
  public function begin(){$this->pdo()->beginTransaction();}
  public function commitTransaction(){$this->pdo()->commit();}
  public function rollback(){$this->pdo()->rollBack();}
  // public function lastId($sequence){$this->pdo()->lastInsertId($sequence);}
}
?>
