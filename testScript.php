<?php
include_once "SimpleDynamo.php";

$simpleDynamo = new SimpleDynamo();
$item = ['id' => 'I-SUBSC321', 'name' => 'Saurav', 'age' => 23];
$simpleDynamo->putItem($item,'Table-1');

?>