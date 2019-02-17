<?php
require("db.class.php");
class Generica extends Db{
  function __construct(){}
  public function query($act=array(),$dati=array()){
    if ($act['act'] === 'inserisci'){$dati = array_filter($dati);}
    $sql = $this->prepareData($act,$dati);
    return $this->prepared($sql, $dati);
  }

  public function organigramma($act, $dati){
    if ($act['act']=='inserisci') {
      return $this->orgIns($dati);
    }else {
      return $this->orgIns($dati);
    }
  }

  private function orgIns($dati = array()){
    $sql="insert into organigramma(anno, presidente, vicepresidente, segretario, tesoriere, consiglieri) values (:anno, :presidente, :vicepresidente, :segretario, :tesoriere, :consiglieri);";
    $dati['consiglieri']='{'.implode(",",$dati['consiglieri']).'}';
    return $this->prepared($sql, $dati);
  }

  private function prepareData($act=array(),$dati=array()){
    if ($act['act'] === 'inserisci') {
      foreach ($dati as $key => $value) {
        if (isset($value) && $value !== "") {
          $campi[]=":".$key;
          $val[$key]=$value;
        }
      }
      $sql = "insert into ".$act['tab']."(".str_replace(":","",implode(",",$campi)).") values(".implode(",",$campi).");";
    }else {
      foreach ($dati as $key => $value) {
        if ($value=="") {$value=null;}
        $campi[]=$key."=:".$key;
        $val[$key]=$value;
      }
      $sql = "update ".$act['tab']." set ".implode(",",$campi)." where id=:id;";
    }
    return $sql;
  }
}

?>
