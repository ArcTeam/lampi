<?php
function randomBg(){
  $folder = "img/background/";
  $files = array_diff(scandir($folder), array('.', '..'));
  return $files[array_rand($files)];
}
?>
