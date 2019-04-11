<?php
session_start();
require("db.class.php");
require("function.php");
$prefix = date('YmdHis')."-";
$pdoFunc = new Db;
$allegati_dir = "../upload/allegati/";
$allegati = reArrayFiles($_FILES['allegati']);

$copertina_img = $prefix.str_replace(" ","_",basename($_FILES["copertina"]["name"]));
$copertine_dir = "../upload/copertine/";
$copertina = $copertine_dir.$copertina_img;
$dati['titolo']=trim($_POST['titolo']);
$dati['testo']=$_POST['testo'];
$dati['usr']=$_SESSION['id'];
$dati['tag']='{'.$_POST['tag'].'}';
$dati['bozza']=$_POST['bozza'];
$dati['copertina']=trim($copertina_img);
$sql= "insert into post(titolo,testo,usr,tag,bozza,copertina) values(:titolo,:testo,:usr,:tag,:bozza,:copertina);";
try {
  $pdoFunc->begin();
  uploadfile($_FILES["copertina"]["tmp_name"],$copertina);
  exec('mogrify -resize 1028x '.$copertina);
  $pdoFunc->prepared($sql, $dati);
  $record = $pdoFunc->pdo()->lastInsertId('post_id_seq');
  foreach($allegati as $files){
    if($files['error']==0){
      $allegato_img=$prefix.str_replace(" ","_",basename($files["name"]));
      $allegato = $allegati_dir.$allegato_img;
      uploadfile($files["tmp_name"],$allegato);
      $allSql="insert into allegati(record,tabella,file) values(:record,:tabella,:file)";
      $allArr['record']=$record;
      $allArr['tabella']=$_POST['tab'];
      $allArr['file']=$allegato_img;
      $pdoFunc->prepared($allSql, $allArr);
    }
  }
  $pdoFunc->commitTransaction();
  header("Location: ../postAct.php?act=".$_POST['act']."&tab=".$_POST['tab']."&res=ok");
} catch (\PDOException $e) {
  $pdoFunc->rollback();
  print_r($e->getMessage());
  unlink($copertina);
  $mask = "../upload/allegati/".$prefix.'*.*';
  array_map('unlink', glob($mask));
  header("Location: ../postAct.php?act=".$_POST['act']."&tipo=".$_POST['tipo']."&res=errore");
}

?>
