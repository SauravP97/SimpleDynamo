<?php
require './vendor/autoload.php';
date_default_timezone_set('Asia/Kolkata');
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
include_once "./config.php";

class MarshalerDynamo{

    private $marshaler;

    function __construct()
    {
        try {
            $this->marshaler = new Marshaler();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function marshalItem($params)
    {
        try {
            $item = $this->marshaler->marshalItem($params);
            return $item;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function unmarshalItem($params)
    {
        try {
            $item = $this->marshaler->unmarshalItem($params);
            return $item;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
?>
