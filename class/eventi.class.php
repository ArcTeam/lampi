<?php
session_start();
require("global.class.php");
class Eventi extends Generica{
  private $prefix = '';
  private $copertina = '';
  private $tipo = '';
  private $allegati_dir = "upload/allegati/";
  private $copertine_dir = "upload/copertine/";

  private $dataset=[];
  private $metapost=[];

  private $sqlAddPost = "insert into post(titolo,testo,usr,tag,bozza,copertina) values(:titolo,:testo,:usr,:tag,:bozza,:copertina);";
  private $sqlModPost = "update post set titolo=:titolo, testo=:testo, usr=:usr, tag=:tag, bozza=:bozza, copertina=:copertina where id = :id;";
  private $sqlDelPost = "delete from post where id = :id;";

  private $sqlAddMetaPostEvento = "insert into metapost(post, dove, da, a, costo) values (:post, :dove, :da, :a, :costo);";
  private $sqlAddMetaPostViaggio = "insert into metapost(post, dove, da, a, costo, tappe) values (:post, :dove, :da, :a, :costo, :tappe);";
  private $sqlModMetaPostEvento = "update metapost set dove=:dove, da=:da, a=:a, costo=:costo where post=:post;";
  private $sqlModMetaPostViaggio = "update metapost set dove=:dove, da=:da, a=:a, costo=:costo, tappe = :tappe where post=:post;";
  private $sqlDelMetaPost = "delete from metapost where post = :post;";

  private $sqlAddAllegati = "insert into allegati(post,file) values(:post,:file);";
  private $sqlModAllegati = "update allegati set file = :file where post = :post;";
  private $sqlDelAllegati = "delete from allegati where post = :post;";

  function __construct(){ $this->prefix = date('YmdHis')."-"; }

  public function nuovo($dati,$file){
    try {
      $fileArr=[];
      $allegati = $this->reArrayFiles($file['allegati']);
      foreach($allegati as $files){
        $file=$this->prefix.str_replace(" ","_",basename($files["name"]));
        $allegato = $this->allegati_dir.$file;
        $this->uploadfile($files["tmp_name"],$allegato);
        $fileArr[]=$file;
      }
      return $fileArr;
    } catch (\Exception $e) {
      $mask = $this->allegati_dir.$prefix.'*.*';
      array_map('unlink', glob($mask));
      return $e->getMessage();
    }

  }




















  public function handlePost($dati=array(), $file=array()){
    switch (true) {
      case $dati['tipo']=='p': $this->tipo = 'post'; break;
      case $dati['tipo']=='e': $this->tipo = 'evento'; break;
      case $dati['tipo']=='v': $this->tipo = 'viaggio'; break;
    }
    try {
      $this->begin();
      switch (true) {
        case $dati['act']==='add': $this->addEvent($dati,$file); break;
        case $dati['act']==='mod': $this->modEvent($dati,$file); break;
        case $dati['act']==='del': $this->delEvent($dati['id']); break;
      }
      $this->commitTransaction();
      return true;
    } catch (\Exception $e) {
      $this->rollback();
      return $e->getMessage();
    }
  }

  private function buildDataset($dati,$file){
    $img = $this->prefix.str_replace(" ","_",basename($file["copertina"]["name"]));
    $this->copertina = $this->copertine_dir.$img;
    $this->dataset['titolo']=trim($dati['titolo']);
    $this->dataset['testo']=$dati['testo'];
    $this->dataset['usr']=$_SESSION['id'];
    $this->dataset['tag']='{'.$dati['tag'].'}';
    $this->dataset['bozza']=$dati['bozza'];
    $this->dataset['copertina']=trim($img);
  }
  private function buildMetaPost($dati,$post){
    $this->metapost['post'] = $post;
    $this->metapost['dove'] = trim($dati['dove']);
    $this->metapost['da'] = trim($dati['da']);
    $this->metapost['a'] = trim($dati['a']);
    $this->metapost['costo'] = trim($dati['costo']);
    if($dati['tipo']==='v'){
      $this->metapost['tappe'] = '{'.$dati['tappe'].'}';
    }
  }
  private function handleAllegati($file,$post,$act){
    switch ($act) {
      case 'add': $sql = $this->sqlAddAllegati; break;
      case 'mod': $sql = $this->sqlModAllegati; break;
      case 'del': $sql = $this->sqlDelAllegati; break;
    }
    $dati=[];
    $fileArr=[];
    $allegati = $this->reArrayFiles($file);
    foreach($allegati as $files){
      $file=$this->prefix.str_replace(" ","_",basename($files["name"]));
      $allegato = $this->allegati_dir.$file;
      $this->uploadfile($files["tmp_name"],$allegato);
      $fileArr[]=$file;
    }
    $dati['post']=$post;
    $dati['file']='{'.implode(",",$fileArr).'}';
    try {
      $this->begin();
      $this->prepared($sql,$dati);
      $this->commitTransaction();
      return true;
    } catch (\Exception $e) {
      $this->rollback();
      $mask = $this->allegati_dir.$prefix.'*.*';
      array_map('unlink', glob($mask));
      return 1;
    }
  }

  private function addEvent($dati,$file){
    try {
      $this->buildDataset($dati,$file);
      $add = $this->prepared($this->sqlAddPost,$this->dataset);
      $id = $this->pdo()->lastInsertId('post_id_seq');
      if ($add) {
        if($file['allegati']['error'] === 0){
          $allegati = $this->handleAllegati($file['allegati'],$id,'add');
          if ($allegati === 1) {
            throw new \Exception("Attenzione, errore durante il salvataggio degli allegati, riprova o contatta l'amministratore.", 1);
          }
        }
        if ($dati['tipo'] !== 'p') {
          $this->buildMetaPost($dati,$id);
          $addMeta = $this->addMetaPost();
          if ($addMeta === 1) {
            throw new \Exception("Attenzione, errore durante il salvataggio dei metadati, riprova o contatta l'amministratore.", 1);
          }
        }
      }else {
        throw new \Exception("Attenzione, errore durante il salvataggio del record, riprova o contatta l'amministratore.", 1);
      }
    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }
  private function modEvent(){
    $add = $this->prepared($this->sqlModPost,$this->post);
    if ($add) {
      return true;
    }else {
      throw new \Exception("Attenzione, errore durante il salvataggio del record, riprova o contatta l'amministratore.", 1);
    }

  }
  private function delEvent(){}

  private function addMetaPost(){
    $sql = $this->tipo == 'evento' ? $this->sqlAddMetaPostEvento : $this->sqlAddMetaPostViaggio;
    $add = $this->prepared($sql,$this->metapost);
    if ($add) {return 0;}else { return 1; }
  }
  private function modMetaPost(){}
  private function delMetaPost(){}

  private function reArrayFiles($file){
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

  private function uploadfile($img,$dir){
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

  private function delFile($record,$tabella){
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
