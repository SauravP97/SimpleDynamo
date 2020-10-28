<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";

class GetItem{
    private $key;
    private $tableName;
    private $marshaler;
    private $projectAttributes;
    private $consistentRead;

    /*
    * Parameterized Constructor is Used :
    * @params 
    *   1. $query -> Takes Simplified user query
    *   2. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($key, $tableName){
        $this->key = $key;
        $this->tableName = $tableName;
        $this->marshaler = new MarshalerDynamo();
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
        if($this->projectAttributes){
            $queryParams['ProjectionExpression'] = $this->projectAttributes;
        }
        if($this->consistentRead){
            $queryParams['ConsistentRead'] = True;
        }
        return $queryParams;
    }

    function setProjectAttribute($projectAttributes){
        $this->projectAttributes = $projectAttributes;
    }

    function setConsistentReadAttribute(){
        $this->consistentRead = true;
    }
}
?>