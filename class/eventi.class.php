<?php
session_start();
require("global.class.php");
class Eventi extends Generica{
  private $prefix = '';
  private $allegati_dir = "../upload/allegati/";
  private $copertine_dir = "../upload/copertine/";

  function __construct(){ $this->prefix = date('YmdHis')."-"; }

  public function handlePost($dati=array(), $file=array()){
    if($file['allegati']['error'] === 0){ $allegati = $this->reArrayFiles($_FILES['allegati']); }
    return $copertina;
  }

  protected function reArrayFiles($file){
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

  protected function uploadfile($img,$dir){
    if (move_uploaded_file($img, $dir)) {
      chmod($dir, 0755);
      return true;
    }else {
      throw new \Exception("Attenzione, errore durante il caricamento, riprova o contatta l'amministratore.", 1);
    }
  }

  public function eventiDel($tabella,$record){
    try {
      $this->delFile($record,$tabella);
      $this->simple("delete from allegati where tabella ='".$tabella."' AND record = ".$record.";");
      $this->simple("delete from post where id = ".$record.";");
      return 'post eliminato';
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  protected function delFile($record,$tabella){
    $allegatiDir="../upload/allegati/";
    $copertineDir="../upload/copertine/";
    $allegati = $this->simple("select file from allegati where record = ".$record." and tabella = '".$tabella."';");
    $copertina = $this->simple("select copertina from ".$tabella." where id = ".$record.";");
    foreach ($allegati as $file) {
      if (file_exists($allegatiDir.$file['file'])) {
        unlink($allegatiDir.$file['file']);
      }
    }
    if (file_exists($copertineDir.$copertina[0]['copertina'])) {
      unlink($copertineDir.$copertina[0]['copertina']);
    }
  }
}

?>
