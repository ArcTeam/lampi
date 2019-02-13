<?php
require("db.class.php");
class Global extends Db{
  function __construct(){}
  public function inserisci($tabella,$dati=array()){
    return $dati;
  }
}

?>
