<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";

class Scan{
    private $tableName;
    private $marshaler;
    private $projectAttributes;
    private $expressionAttributeSetter;
    private $filterExpression;

    /*
    * Parameterized Constructor is Used :
    * @params 
    *   1. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($tableName){
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
        $queryParams = [
            "TableName" => $this->tableName,
        ];
        if($this->projectAttributes){
            $queryParams['ProjectionExpression'] = $this->projectAttributes;
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

    function applyFilters($filterExpression){
        $this->filterExpression = $this->expressionAttributeSetter->checkForReservedKeywords($filterExpression, " ");
        $this->filterExpression = $this->expressionAttributeSetter->checkForQueryValues($this->filterExpression);
    }

    function setProjectAttribute($projectAttributes){
        $this->projectAttributes = $this->expressionAttributeSetter->checkForReservedKeywords($projectAttributes, ",");
    }
}
?>