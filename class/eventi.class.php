<?php
session_start();
require("global.class.php");
class Eventi extends Generica{
  private $prefix = '';
  private $allegati_dir = "../upload/allegati/";
  private $copertine_dir = "../upload/copertine/";

  function __construct(){ $this->prefix = date('YmdHis')."-"; }

  public function handlePost($dati=array(), $file=array()){
    return $dati;
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
