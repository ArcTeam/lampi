<?php
require('../class/db.class.php');
$db = new DB;
$sql = "select p.id, p.data, p.titolo, p.testo, p.tag, p.bozza, p.copertina, u.email from post p, utenti u where p.usr = u.id ";
if (isset($_POST) && !empty($_POST['term']) ) {
  $keywords = str_replace(' ', ' & ', $_POST['term']);
  $sql .= "AND to_tsvector(concat_ws('italian',titolo,testo,tag)) @@ to_tsquery('".strtolower($keywords)."') ";
}
$sql .= " order by data desc;";
echo json_encode($db->simple($sql));
?>
