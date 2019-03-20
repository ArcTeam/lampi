<?php
require('../class/db.class.php');
$db = new DB;
$where = '';
if(isset($_GET['term'])){
  $where = "where tag ilike '%".$_GET['term']."%'";
}
echo json_encode($db->simple("select tag as value from tag ".$where." order by tag asc;"));
?>
