<?php
require './vendor/autoload.php';
date_default_timezone_set('Asia/Kolkata');
use Aws\DynamoDb\Exception\DynamoDbException;
include_once "../config.php";

class Dynamo
{

    private $dynamodb;

    function __construct()
    {
        try {
            $sdk = new Aws\Sdk([
                'endpoint'   => DYNAMODB_ENDPOINT,
                'region'   => DYNAMODB_REGION,
                'version'  => 'latest',
                'credentials' => [
                    'key' => DYNAMODB_KEY,
                    'secret' => DYNAMODB_SECRET,
                ]
            ]);

            $this->dynamodb = $sdk->createDynamoDb();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function putItem($params){
        try{
            $result = $this->dynamodb->putItem($params);
            return $result;
        }
        catch(Exception $e){
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function getItem($params)
    {
        try {
            $result = $this->dynamodb->getItem($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function query($params)
    {
        try {
            $result = $this->dynamodb->query($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
?>