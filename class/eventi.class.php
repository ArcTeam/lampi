<?php
session_start();
require("global.class.php");
class Eventi extends Generica{
  private $prefix = '';
  private $allegati_dir = "upload/allegati/";
  private $copertine_dir = "upload/copertine/";

  private $dataset=[];
  private $metapost=[];

  private $sqlAddPost = "insert into post(titolo,testo,usr,tag,bozza,copertina,tipo) values(:titolo,:testo,:usr,:tag,:bozza,:copertina,:tipo);";
  private $sqlModPost = "update post set titolo=:titolo, testo=:testo, usr=:usr, tag=:tag, bozza=:bozza, copertina=:copertina, tipo=:tipo where id = :id;";
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

  public function item(int $id){
    $out = [];
    $sql = "select * from post where id = ".$id.";";
    $allegati = "select unnest(file) file from allegati where post = ".$id.";";
    $out['info'] = $this->simple($sql);
    $out['allegati'] = $this->simple($allegati);
    if ($out['info'][0]['tipo'] !== 'p') {
      $meta = "select * from metapost where post = ".$id.";";
      $out['meta'] = $this->simple($meta);
    }
    return $out;
  }

  public function nuovo($dati,$file){
    try {
      $this->begin();
      $copertinaImg = $this->prefix.str_replace(" ","_",basename($file['copertina']["name"]));
      $copertina = $this->copertine_dir.$copertinaImg;
      $this->uploadfile($file['copertina']['tmp_name'],$copertina);
      $dati['copertina']=$copertinaImg;
      $this->buildDataset($dati,$file);
      $this->prepared($this->sqlAddPost,$this->dataset);
      $id = $this->pdo()->lastInsertId('post_id_seq');
      $allegati = $this->handleAllegati($file['allegati']);
      if ($allegati !== 'null') {
        $this->prepared($this->sqlAddAllegati,array("post"=>$id,"file"=>$allegati));
      }
      if ($dati['tipo'] !== 'p') {
        $sqlMeta = $dati['tipo'] === 'e' ? $this->sqlAddMetaPostEvento : $this->sqlAddMetaPostViaggio;
        $this->buildMetaPost($dati,$id);
        $this->prepared($sqlMeta,$this->metapost);
      }
      $this->commitTransaction();
      return array(true,$id);
    } catch (\Exception $e) {
      $this->rollback();
      $mask = $this->allegati_dir.$this->prefix.'*.*';
      array_map('unlink', glob($mask));
      return $e->getMessage();
    }
  }

  public function eliminaPost($id){
    try {
      $this->begin();
      $this->prepared($this->sqlDelAllegati,array("post"=>$id));
      $this->prepared($this->sqlDelPost,array("id"=>$id));
      $this->delFile($id);
      $this->commitTransaction();
      return 'post eliminato';
    } catch (\Exception $e) {
      $this->rollback();
      return $e->getMessage();
    }
  }

  public function delAllegato($dati = array()){
    try {
      $allegato = $dati['file'];
      $file = end(explode("/",$dati['file']));
      unset($dati['file']);
      $this->begin();
      $count = $this->simple("select array_length(file,1) tot from allegati where post = ".$dati['post'].";");
      $count = intval($count[0]['tot']);
      if ($count === 1) {
        $this->prepared($this->sqlDelAllegati,$dati);
      }else {
        $sql = "update allegati set file = array_remove(file,:file) where post = :post;";
        $dati['file']=$file;
        $this->prepared($sql,$dati);
      }
      if (file_exists("../".$allegato)) {
        unlink("../".$allegato);
      }
      $this->commitTransaction();
      return 'ok, allegato correttamente eliminato';
      // return $dati;
    } catch (\Exception $e) {
      $this->rollback();
      return $e->getMessage();
    }
  }

  private function buildDataset($dati,$file){
    $this->dataset['titolo']=trim($dati['titolo']);
    $this->dataset['testo']=$dati['testo'];
    $this->dataset['usr']=$_SESSION['id'];
    $this->dataset['tag']='{'.$dati['tag'].'}';
    $this->dataset['bozza']=$dati['bozza'];
    $this->dataset['copertina']=trim($dati['copertina']);
    $this->dataset['tipo']=trim($dati['tipo']);
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
  private function handleAllegati($file){
    $fileArr=[];
    $allegati = $this->reArrayFiles($file);
    foreach($allegati as $files){
      if($files['error'] === 0){
        $file=$this->prefix.str_replace(" ","_",basename($files["name"]));
        $allegato = $this->allegati_dir.$file;
        $up = $this->uploadfile($files["tmp_name"],$allegato);
        if ($up) { $fileArr[]=$file; }else { return $up; }
      }
    }
    if (count($fileArr)>0) {
      return '{'.implode(',',$fileArr).'}';;
    }else {
      return 'null';
    }
  }

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


  private function delFile($id){
    $allegati = $this->simple("select unnest(file) from allegati where post = ".$id.";");
    $copertina = $this->simple("select copertina from post where id = ".$id.";");
    foreach ($allegati as $file) {
      if (file_exists($this->allegati_dir.$file['file'])) {
        unlink($this->allegati_dir.$file['file']);
      }
    }
    if (file_exists($this->copertine_dir.$copertina['copertina'])) {
      unlink($this->copertine_dir.$copertina['copertina']);
    }
  }
}

?>
