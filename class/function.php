<?php
if (isset($_FILES)) {
  require("db.class.php");
  $out=[];
  $target_dir = "../upload/amministrazione/";
  $file = str_replace(" ","_",basename($_FILES["file"]["name"]));
  $target_file = $target_dir.$file;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (file_exists($target_file)) {
    $out['err'] = 1;
    $out['msg'] = "Attenzione, nella cartella è già presente un file con lo stesso nome.";
  } else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      chmod($target_file, 0755);
      $pdoFunc = new Db;
      $sql= "insert into amministrazione(anno,categoria, entrate,uscite,file) values(:anno,:categoria,:entrate,:uscite,:file);";
      foreach ($_POST as $key => $value) {$dati[$key]=$value;}
      $dati['file']=$file;
      $res = $pdoFunc->prepared($sql,$dati);
      if ($res===true) {
        $out['err'] = 0;
        $out['msg'] = "Il file ". basename( $_FILES["file"]["name"]). " è stato caricato sul server.";
      }else {
        unlink($target_file);
        $out['err'] = 1;
        $out['msg'] = "Attenzione, errore durante il salvataggio del file, riprova o contatta l'amministratore.\n".$res;
      }
    } else {
      $out['err'] = 1;
      $out['msg'] = "Attenzione, errore durante il caricamento, riprova o contatta l'amministratore.";
    }
  }
  echo json_encode($out);
}
function randomBg(){
  $folder = "img/background/";
  $files = array_diff(scandir($folder), array('.', '..'));
  return $files[array_rand($files)];
}
?>
