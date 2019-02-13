<?php
require("db.class.php");
class Generica extends Db{
  function __construct(){}
  public function query($act=array(),$dati=array()){
    $sql = $this->prepareData($act,$dati);
    return $this->prepared($sql, $dati);
  }

  private function prepareData($act=array(),$dati=array()){
    foreach ($dati as $key => $value) {
      if (isset($value) && $value!=="") {
        $act['act']=='inserisci' ? $campi[]=":".$key : $campi[]=$key."=:".$key;
          $val[$key]=$value;
      }
    }
    $act['act']=='inserisci'
    ? $sql = "insert into ".$act['tab']."(".str_replace(":","",implode(",",$campi)).") values(".implode(",",$campi).");"
    : $ql = "update ".$act['tab']." set ".implode(",",$campi)." where id=:id;";
    return $sql;
  }
}

?>
