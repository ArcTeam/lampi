<?php
session_start();
require("db.class.php");
class Amministratore extends Db{
  private $prefix = '';
  function __construct(){ $this->prefix = date('YmdHis')."-"; }
  public function listaSoci($filtro=null){
    $sql = "select r.id, r.cognome||' '||r.nome socio from rubrica r, soci s where s.rubrica = r.id";
    if ($filtro) { $sql .= " and s.attivo = '".$filtro."' "; }
    $sql .= " order by socio asc;";
    return $this->simple($sql);
  }

  public function anniQuote(){return $this->simple("select anno from quote order by anno asc limit 1;");}
  public function checkQuote($anno){
    $sql = "with filtro as (select socio,anno,tipo from quote where anno <= ".$anno.")
    select r.id, r.cognome||' '||r.nome socio, filtro.socio as idsocio
    from rubrica r, soci s, filtro
    where
      s.rubrica = r.id
      and filtro.socio = s.rubrica
      and r.id not in ( select socio from filtro where anno = ".$anno.")
    order by socio asc;";
    return $this->simple($sql);
  }
  public function registraQuota($dati=array()){
    $sql = "insert into quote(socio,tipo,anno) values (:socio,:tipo,:anno);";
    return $this->prepared($sql,$dati);
  }
}
?>
