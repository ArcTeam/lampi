<?php
session_start();
require('../class/db.class.php');
$db = new DB;
$sql = "select p.id, p.data, p.titolo, p.testo, p.tag, p.bozza, p.copertina, u.email from post p, utenti u where p.usr = u.id ";
if (!isset($_SESSION['id'])) { $sql .= " AND p.bozza = 'f'"; }
if (isset($_POST)){
  if (!empty($_POST['tipo'])) { $sql .= " AND tipo = '".$_POST['tipo']."' ";}
  if (!empty($_POST['term'])) {
    $keywords = str_replace(' ', ' & ', $_POST['term']);
    $sql .= "AND to_tsvector(concat_ws('italian',titolo,testo,tag)) @@ to_tsquery('".strtolower($keywords)."') ";
  }
  $limit = !empty($_POST['limit']) ? "LIMIT ".$_POST['limit'].";" : ";";
}
$sql .= " order by data desc ".$limit;
echo json_encode($db->simple($sql));
?>
