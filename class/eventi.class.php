<?php
session_start();
require("global.class.php");
class Eventi extends Generica{
  function __construct(){}
  public function addPost($dati){
    $dati['usr']=$_SESSION['id'];
    $dati['tag']='{'.implode(",",$dati['tag']).'}';
    $sql = "insert into post(titolo,testo,tag,bozza,usr) values(:titolo,:testo,:tag,:bozza,:usr)";
    return $this->prepared($sql, $dati);
  }
}

?>
