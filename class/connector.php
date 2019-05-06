<?php
require($_POST['oop']['file']);
$class=new $_POST['oop']['classe'];
$funzione = $_POST['oop']['func'];
if(isset($funzione) && function_exists($funzione)) {
  $trigger = $funzione($class);
  echo $trigger;
}
function buildTable($class){return json_encode($class->simple("select * from ".$_POST['dati']['tab'].";"));}
function changePwd($class){return json_encode($class->changePwd($_POST['dati']));}
function changeUsrData($class){return json_encode($class->changeUsrData($_POST['dati']));}
function checkQuote($class){return json_encode($class->checkQuote($_POST['dati']['anno']));}
function delAllegato($class){return json_encode($class->delAllegato($_POST['dati']));}
function delAmministrazione($class){ return json_encode($class->delAmministrazione($_POST['dati']));}
function delRubrica($class){return json_encode($class->prepared("delete from rubrica where id = :id;",$_POST['dati']));}
function delTappa($class){return json_encode($class->delTappa($_POST['dati']));}
function eventiDel($class){return json_encode($class->eliminaPost($_POST['dati']['id']));}
function listaSoci($class){return json_encode($class->listaSoci($_POST['dati']['filtro']));}
function login($class){return json_encode($class->login($_POST['dati']));}
function nuovoSocio($class){return json_encode($class->nuovoSocio($_POST['dati']['id']));}
function organigramma($class){return json_encode($class->organigramma($_POST['act'],$_POST['dati']));}
function post($class){return json_encode($class->item($_POST['dati']['post']));}
function query($class){return json_encode($class->query($_POST['act'],$_POST['dati']));}
function registraQuota($class){return json_encode($class->registraQuota($_POST['dati']));}
function rescuePwd($class){return json_encode($class->rescuePwd($_POST['dati']));}
function tagList($class){return json_encode($class->simple("select tag as value from tag order by tag asc;"));}
?>
