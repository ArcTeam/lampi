<?php
require("db.class.php");
class Generica extends Db{
  function __construct(){}

  public function query($act=array(),$dati=array()){
    if ($act['act'] === 'inserisci'){$dati = array_filter($dati);}
    $sql = $this->prepareData($act,$dati);
    $tab = array("post");
    try {
      $this->prepared($sql, $dati);
      if (in_array($act['tab'],$tab)) {
        $this->delFile($dati['id'],$act['tab']);
      }

    } catch (\PDOException $e) {
      return $e->getMessage;
    }
  }

  protected function delFile($record,$tabella){
    $files = $this->simple("select file from allegati where record = ".$record." and tabella = '".$tabella."';");
    foreach ($files as $file) { unlink("../upload/allegati/".$file); }
    $copertina = $this->simple("select copertina from post where id = ".$record);
    unlink("../upload/copertine/".$copertina['copertina']);
  }

  protected function prepareData($act=array(),$dati=array()){
    if ($act['act'] === 'inserisci') {
      foreach ($dati as $key => $value) {
        if (isset($value) && $value !== "") {
          $campi[]=":".$key;
          $val[$key]=$value;
        }
      }
      $sql = "insert into ".$act['tab']."(".str_replace(":","",implode(",",$campi)).") values(".implode(",",$campi).");";
    }elseif($act['act'] === 'modifica') {
      foreach ($dati as $key => $value) {
        if ($value=="") {$value=null;}
        $campi[]=$key."=:".$key;
        $val[$key]=$value;
      }
      $sql = "update ".$act['tab']." set ".implode(",",$campi)." where id=:id;";
    }else {
      $k='';
      foreach ($dati as $key => $value) {
        $k=$key."=:".$key;
      }
      $sql="delete from ".$act['tab']." where ".$k.";";
    }
    return $sql;
  }

  public function organigramma($act, $dati){
    if ($act['act']=='inserisci') {
      $sql="insert into organigramma(anno, presidente, vicepresidente, segretario, tesoriere, consiglieri) values (:anno, :presidente, :vicepresidente, :segretario, :tesoriere, :consiglieri);";
    }else {
      $sql="update organigramma set anno=:anno, presidente=:presidente, vicepresidente=:vicepresidente, segretario=:segretario, tesoriere=:tesoriere, consiglieri=:consiglieri where anno = :pk;";
    }
    $dati['consiglieri']='{'.implode(",",$dati['consiglieri']).'}';
    return $this->prepared($sql, $dati);
  }
  public function link($act, $dati){
    if ($act['act']=='inserisci') {
      $sql="insert into link(anno, presidente, vicepresidente, segretario, tesoriere, consiglieri) values (:anno, :presidente, :vicepresidente, :segretario, :tesoriere, :consiglieri);";
    }else {
      $sql="update organigramma set anno=:anno, presidente=:presidente, vicepresidente=:vicepresidente, segretario=:segretario, tesoriere=:tesoriere, consiglieri=:consiglieri where anno = :pk;";
    }
    $dati['consiglieri']='{'.implode(",",$dati['consiglieri']).'}';
    return $this->prepared($sql, $dati);
  }

  public function delAmministrazione($dati){
    $sql = "delete from amministrazione where id = :id and file = :file;";
    $res = $this->prepared($sql, $dati);
    if ($res === true) {
      unlink("../upload/amministrazione/".$dati['file']);
    }
    return $res;
  }

  private function orgIns($dati = array()){
    $sql="insert into organigramma(anno, presidente, vicepresidente, segretario, tesoriere, consiglieri) values (:anno, :presidente, :vicepresidente, :segretario, :tesoriere, :consiglieri);";
    $dati['consiglieri']='{'.implode(",",$dati['consiglieri']).'}';
    return $this->prepared($sql, $dati);
  }



  function fileSizeConv($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
  }

  ##NOTE: liste
  public function tipo_doc(){ return $this->simple("select * from liste.tipo_doc order by tipo asc;"); }
  public function amministrazione(){
    $out = $this->simple("select a.id, a.anno, c.tipo, a.file from amministrazione a, liste.tipo_doc c where a.categoria = c.id order by a.anno desc;");
    foreach ($out as $i => $file) {
      $filename = "upload/amministrazione/".$file['file'];
      if (file_exists ($filename)) {
        $bytes = filesize($filename);
        $size = $this->fileSizeConv($bytes);
        $out[$i]['size']=$size;
      }
    }
    return $out;
  }

  public function index(){
    $out['post']= $this->postList(5,'f',null);
    // $out['eventi']= $this->eventiList(5);
    // $out['viaggi']= $this->eventiList(5);
    return $out;
  }
  public function postList($l=null,$b=null, $filtri=null){
    $limit = $l ? ' limit '.$l:'';
    if ($b || $filtri) {
      $where = ' AND ';
      if ($b) { $where .=" bozza ='" .$b."' ";}
      if ($filtri) { $where .= $this->filterBuild($filtri);}
    }else {
      $where = '';
    }
    $sql ="select p.id,p.copertina, p.titolo, p.data, p.testo,p.bozza, p.tag, u.email from post p, utenti u where p.usr = u.id ".$where." order by data desc ".$limit.";";
    return $this->simple($sql);
  }

  protected function filterBuild($filtri){
    if (is_array($filtri)) {
      $fArr=[];
      foreach ($filtri as $key => $val) {
        if (is_string($val)) {
          $fArr[]=$key." ilike '%".$val."%'";
        }else {
          $fArr[]=$key."=".$val;
        }
      }
      return implode(" AND ", $fArr);
    } elseif (is_string($filtri)) {
      return $key." ilike '%".$val."'%";
    }else {
      return $key."=".$val;
    }
  }

  /**
  * Truncates text.
  *
  * Cuts a string to the length of $length and replaces the last characters
  * with the ending if the text is longer than length.
  *
  * ### Options:
  *
  * - `ending` Will be used as Ending and appended to the trimmed string
  * - `exact` If false, $text will not be cut mid-word
  * - `html` If true, HTML tags would be handled correctly
  *
  * @param string  $text String to truncate.
  * @param integer $length Length of returned string, including ellipsis.
  * @param array $options An array of html attributes and options.
  * @return string Trimmed string.
  * @access public
  * @link http://book.cakephp.org/view/1469/Text#truncate-1625
  */
  public function truncate($text, $length = 100, $options = array()) {
      $default = array(
          'ending' => '...', 'exact' => true, 'html' => false
      );
      $options = array_merge($default, $options);
      extract($options);

      if ($html) {
          if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
              return $text;
          }
          $totalLength = mb_strlen(strip_tags($ending));
          $openTags = array();
          $truncate = '';

          preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
          foreach ($tags as $tag) {
              if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                  if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                      array_unshift($openTags, $tag[2]);
                  } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                      $pos = array_search($closeTag[1], $openTags);
                      if ($pos !== false) {
                          array_splice($openTags, $pos, 1);
                      }
                  }
              }
              $truncate .= $tag[1];

              $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
              if ($contentLength + $totalLength > $length) {
                  $left = $length - $totalLength;
                  $entitiesLength = 0;
                  if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                      foreach ($entities[0] as $entity) {
                          if ($entity[1] + 1 - $entitiesLength <= $left) {
                              $left--;
                              $entitiesLength += mb_strlen($entity[0]);
                          } else {
                              break;
                          }
                      }
                  }

                  $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                  break;
              } else {
                  $truncate .= $tag[3];
                  $totalLength += $contentLength;
              }
              if ($totalLength >= $length) {
                  break;
              }
          }
      } else {
          if (mb_strlen($text) <= $length) {
              return $text;
          } else {
              $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
          }
      }
      if (!$exact) {
          $spacepos = mb_strrpos($truncate, ' ');
          if (isset($spacepos)) {
              if ($html) {
                  $bits = mb_substr($truncate, $spacepos);
                  preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                  if (!empty($droppedTags)) {
                      foreach ($droppedTags as $closingTag) {
                          if (!in_array($closingTag[1], $openTags)) {
                              array_unshift($openTags, $closingTag[1]);
                          }
                      }
                  }
              }
              $truncate = mb_substr($truncate, 0, $spacepos);
          }
      }
      $truncate .= $ending;

      if ($html) {
          foreach ($openTags as $tag) {
              $truncate .= '</'.$tag.'>';
          }
      }

      return $truncate;
  }

}

?>
