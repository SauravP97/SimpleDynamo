<?php
use Aws\DynamoDb\Exception\DynamoDbException;

class DynamoExceptionHandler{
    private $awsErrorCode;
    private $statusCode;
    private $awsErrorMessage;

    function __construct($dynamoDbException){
        $this->awsErrorCode = $dynamoDbException->getAwsErrorCode();
        $this->statusCode = $dynamoDbException->getStatusCode();
        $this->awsErrorMessage = $dynamoDbException->getAwsErrorMessage();
    }

    function showErrorMessage(){
        error_log("=================DynamoDB Exception=======================");
        error_log("DynamoDB Error Code : ".$this->awsErrorCode);
        error_log("DynamoDB Error Status Code : ".$this->statusCode);
        error_log("DynamoDB Error Message : ".$this->awsErrorMessage);
        error_log("==========================================================");
    }
}
?>