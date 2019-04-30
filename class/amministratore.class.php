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

  public function anniQuote(){
    return $this->simple("select date_part('year',data) anno from quote order by data asc limit 1;");
  }
}
?>
