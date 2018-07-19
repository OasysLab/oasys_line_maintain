<?php
$file = fopen("vardump.txt", "r");
$members = array();

while (!feof($file)) {
   $members[] = fgets($file);
}

fclose($file);

var_dump($members);
?>