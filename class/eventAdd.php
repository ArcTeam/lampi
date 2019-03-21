<?php
session_start();
if (isset($_POST)) {
  print_r($_POST);
  print_r($_FILES);
}
?>
