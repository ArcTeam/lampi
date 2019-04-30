<?php
session_start();
require("db.class.php");
class Amministratore extends Db{
  private $prefix = '';
  function __construct(){ $this->prefix = date('YmdHis')."-"; }
  public function listaSoci($filtro=null){
    $sql = "select r.cognome||' '||r.nome socio from rubrica r, soci s where s.rubrica = r.id";
    if ($filtro) { $sql .= " and s.attivo = '".$filtro."' "; }
    $sql .= " order by socio asc;";
    return $this->simple($sql);
  }
}
?>
