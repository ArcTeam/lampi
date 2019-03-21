<?php
function randomBg(){
  $folder = "img/background/";
  $files = array_diff(scandir($folder), array('.', '..'));
  return $files[array_rand($files)];
}
function reArrayFiles($file){
  $file_ary = array();
  $file_count = count($file['name']);
  $file_key = array_keys($file);
  for($i=0;$i<$file_count;$i++){
    foreach($file_key as $val){
      $file_ary[$i][$val] = $file[$val][$i];
    }
  }
  return $file_ary;
}

function uploadfile($img,$dir){
  if (move_uploaded_file($img, $dir)) {
    chmod($dir, 0755);
    return true;
  }else {
    throw new \Exception("Attenzione, errore durante il caricamento, riprova o contatta l'amministratore.", 1);
  }
}
?>
