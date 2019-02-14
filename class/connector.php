<?php
require($_POST['oop']['file']);
$class=new $_POST['oop']['classe'];
$funzione = $_POST['oop']['func'];
if(isset($funzione) && function_exists($funzione)) {
  $trigger = $funzione($class);
  echo $trigger;
}
function login($class){return json_encode($class->login($_POST['dati']));}
function rescuePwd($class){return json_encode($class->rescuePwd($_POST['dati']));}
function buildTable($class){return json_encode($class->simple("select * from ".$_POST['dati']['tab'].";"));}
function query($class){return json_encode($class->query($_POST['act'],$_POST['dati']));}
function delRubrica($class){return json_encode($class->prepared("delete from rubrica where id = :id;",$_POST['dati']));}
?>
