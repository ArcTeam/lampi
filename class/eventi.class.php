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
  // public function postList($id=null,$limit=null){
  //   $sql = "select * from post ";
  //   if($id!==null){$sql .= " where id = ".$id;}
  //   if(!isset($_SESSION['id'])){$sql .= " where bozza = 'f'";}
  //   $sql .= " order by data desc";
  //   if($limit !== null){$sql .=" limit ".$limit;  }
  //   $sql = ';';
  //   return $this->simple($sql);
  // }
}

?>
