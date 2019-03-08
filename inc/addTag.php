<?php
session_start();
require('../class/db.class.php');
$db = new Db;
$tag=strtolower($_POST['tag']);
$check = $db->countRow("select * from liste.tag where tag = '".$tag."';");
if($check == 0){
  $sql = "insert into tag(tag) values(:tag);";
  $dati = array("tag"=>$tag);
  return $db->prepared($sql,$dati);
}
?>
