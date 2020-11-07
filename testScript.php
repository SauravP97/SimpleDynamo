<?php
include_once "SimpleDynamo.php";

$simpleDynamo = new SimpleDynamo();
$item = ['id' => 'I-SUBSC321', 'name' => 'Saurav', 'age' => 23];
//$simpleDynamo->putItem($item,'Table-1');

$key = ['id' => 'ID1231', "key" => "USER_KEY"];
//$simpleDynamo->project('value');
//$simpleDynamo->makeConsistentRead();
//$simpleDynamo->getItem($key,'Table-1');
/*
$simpleDynamo->setIndexName('key-value-index');
$simpleDynamo->project('id, key');
$simpleDynamo->setScanIndexAttribute();
$simpleDynamo->limitQueryItems(100);
$simpleDynamo->setSelectAttribute('Count');
$simpleDynamo->applyFilters("set key = :PREMIUM_KEY and value = :100");
$simpleDynamo->query('key = :keyName and value = :valueName','Table-1');

$simpleDynamo->setUpdateExpression('set key = :PREMIUM_STRING and value = :101');
$simpleDynamo->applyFilters('key1 = :PREMIIUM_PLUS_MEMS');
$simpleDynamo->update('Table-1',['id'=>'ID_1190', 'key'=>'PREMIUM_VALUE']);

$simpleDynamo->applyFilters('key = :PREMIIUM_PLUS_MEMS');
$simpleDynamo->delete('Table-1', ['id'=>'ID_1190', 'key'=>'PREMIUM_VALUE']);

$simpleDynamo->project('id, key');
$simpleDynamo->applyFilters('key = :PREMIIUM_PLUS_MEMS');
$simpleDynamo->scan("Table-1");
*/
//$result = $simpleDynamo->query('id = :INVOICE','Auth-Test-Table-2');
//$result = $simpleDynamo->getItem(["id" => "zY6yM+nZTd64"], 'Auth-Test-Table-1');
/*$result = $simpleDynamo->putItem([
                'id'=>'SAURAV_PRATEEK_1001', 
                'key'=>'SAURAV_KEY', 
                'key1'=> 'SAURAV_KEY_1',
                'value'=> 'SAURAV_VALUE'
            ], 'Auth-Test-Table-2');
*/
//$simpleDynamo->setUpdateExpression('set value = :SAURAV_VALUE_UPDATED_AGAIN');
//$simpleDynamo->applyFilters('key1 = :SAURAV_KEY_1');
//$result = $simpleDynamo->update('Auth-Test-Table-2', ['id'=> 'SAURAV_PRATEEK_1001', 'key'=> 'SAURAV_KEY']);

//$simpleDynamo->applyFilters('key1 = :SAURAV_KEY_1');
//$simpleDynamo->delete('Auth-Test-Table-2', ['id'=>'SAURAV_PRATEEK_1001','key'=>'SAURAV_KEY']);
//echo print_r($result, true);

?>