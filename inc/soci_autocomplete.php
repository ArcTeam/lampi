<?php
session_start();
require('../class/db.class.php');
$db = new Db;
$soci = $db->simple("select id, cognome ||' '||nome as value from rubrica order by value asc;");
header("Content-Type: application/json; charset=utf-8");
echo json_encode(
  array_filter($soci, function($item) {
    return strpos(strtolower($item['value']), strtolower($_GET['term'])) !== false;
  })
);
?>
