<?php
require './vendor/autoload.php';
date_default_timezone_set('Asia/Kolkata');
use Aws\DynamoDb\Exception\DynamoDbException;
include_once "./config.php";
include_once "./ExceptionHandler/DynamoExceptionHandler.php";

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
        } catch (DynamoDbException $e) {
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function putItem($params){
        try{
            $result = $this->dynamodb->putItem($params);
            return $result;
        }
        catch(DynamoDbException $e){
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function getItem($params){
        try {
            $result = $this->dynamodb->getItem($params);
            return $result;
        } catch (DynamoDbException $e) {
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function query($params){
        try {
            $result = $this->dynamodb->query($params);
            return $result;
        } catch (DynamoDbException $e) {
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function updateItem($params){
        try{
            $result = $this->dynamodb->updateItem($params);
            return $result;
        }
        catch(DynamoDbException $e){
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function deleteItem($params){
        try{
            $this->dynamodb->deleteItem($params);
            return true;
        }
        catch(DynamoDbException $e){
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }

    function scan($params){
        try{
            $result = $this->dynamodb->scan($params);
            return $result;
        }
        catch(DynamoDbException $e){
            $dynamoExceptionHandler = new DynamoExceptionHandler($e);
            $dynamoExceptionHandler->showErrorMessage();
            throw new Exception($e->getMessage());
        }
    }
}
