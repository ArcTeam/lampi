<?php
session_start();
require("db.class.php");
require("function.php");
$prefix = date('YmdHis')."-";
$pdoFunc = new Db;
$allegati_dir = "../upload/allegati/";

$copertina_img = $prefix.str_replace(" ","_",basename($_FILES["copertina"]["name"]));
$copertine_dir = "../upload/copertine/";
$copertina = $copertine_dir.$copertina_img;
$dati['titolo']=filter_var(trim($_POST['titolo']), FILTER_SANITIZE_STRING);
$dati['testo']=$_POST['testo'];
$dati['usr']=$_SESSION['id'];
$dati['tag']='{'.$_POST['tag'].'}';
$dati['bozza']=$_POST['bozza'];
$dati['copertina']=trim($copertina_img);
$sql= "insert into post(titolo,testo,usr,tag,bozza,copertina) values(:titolo,:testo,:usr,:tag,:bozza,:copertina);"; //imposto la query
try {
  $pdoFunc->begin(); //apro la transazione
  uploadfile($_FILES["copertina"]["tmp_name"],$copertina); //sposto la copertina
  exec('mogrify -resize 1028x '.$copertina);
  $pdoFunc->prepared($sql, $dati); //inserisco i dati
  if($_FILES['allegati']['error']==0){ //sposto gli allegati
    $record = $pdoFunc->lastInsertId('post_id_seq');
    $allegati = $_FILES['allegati'];
    $allegati = reArrayFiles($allegati);
    foreach($allegati as $val){
      $allegato_img=$prefix.str_replace(" ","_",basename($val["name"]));
      $allegato = $allegati_dir.$allegato_img;
      uploadfile($val["tmp_name"],$allegato);
      $allSql="insert into allegati(record,tabella,file) values(:record,:tabella,:file)";
      $allArr['record']=$record;
      $allArr['tabella']=$_POST['tab'];
      $allArr['file']=$allegato_img;
      $pdoFunc->prepared($allSql, $allArr);
    }
  }
  $pdoFunc->commitTransaction(); //chiudo la transazione
  header("Location: ../postAct.php?act=".$_POST['act']."&tab=".$_POST['tab']."&res=ok");
} catch (\PDOException $e) {
  $pdoFunc->rollback();
  unlink($copertina);
  $mask = $prefix.'*.*';
  array_map('unlink', glob($mask));
  header("Location: ../postAct.php?act=".$_POST['act']."&tab=".$_POST['tab']."&res=errore");
}

?>
