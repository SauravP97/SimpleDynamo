<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";
include_once "ExpressionAttributeSetter.php";

class UpdateItem{
    private $key;
    private $tableName;
    private $marshaler;
    private $updateExpression;
    private $expressionAttributeSetter;
    private $filterExpression;

    /*
    * Parameterized Constructor is Used :
    * @params 
    *   1. $query -> Takes Simplified user query
    *   2. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($tableName, $key){
        $this->key = $key;
        $this->tableName = $tableName;
        $this->marshaler = new MarshalerDynamo();
        $this->expressionAttributeSetter = new ExpressionAttributeSetter();
    }

    /*
    * Formatted Query function builds the dynamo
    * query from the simplified query provided by
    * the User. It returns the DynamoDB supported 
    * Query.
    * It makes use of Marshaler to marshal the inputs
    * And also uses TableName to determine the Table
    * in which the operation is destined to be made.
    */
    function getFormattedQuery(){
        $dynamoKey = $this->marshaler->marshalItem($this->key);
        $queryParams = [
            "TableName" => $this->tableName,
            "Key" => $dynamoKey
        ];
        if($this->updateExpression){
            $queryParams['UpdateExpression'] = $this->updateExpression;
        }
        if(count($this->expressionAttributeSetter->getExpressionAttributeNames())){
            $queryParams['ExpressionAttributeNames'] = $this->expressionAttributeSetter->getExpressionAttributeNames();
        }
        if(count($this->expressionAttributeSetter->getExpressionAttributeValues())){
            $queryParams['ExpressionAttributeValues'] = $this->marshaler->marshalItem($this->expressionAttributeSetter->getExpressionAttributeValues());
        }
        if($this->filterExpression){
            $queryParams['ConditionExpression'] = $this->filterExpression;
        }
        return $queryParams;
    }

    function setUpdateExpression($updateExpression){
        $this->updateExpression = $this->expressionAttributeSetter->checkForReservedKeywords($updateExpression, " ");
        $this->updateExpression = $this->expressionAttributeSetter->checkForQueryValues($this->updateExpression);
    }

    function applyFilters($filterExpression){
        $this->filterExpression = $this->expressionAttributeSetter->checkForReservedKeywords($filterExpression, " ");
        $this->filterExpression = $this->expressionAttributeSetter->checkForQueryValues($this->filterExpression);
    }
}
?>