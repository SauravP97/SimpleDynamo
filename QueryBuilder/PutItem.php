<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";

class PutItem{
    private $item;
    private $tableName;
    private $marshaler;

    /*
    * Parameterized Constructor is Used :
    * @params 
    *   1. $query -> Takes Simplified user query
    *   2. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($item, $tableName){
        $this->item = $item;
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
        $dynamoItem = $this->marshaler->marshalItem($this->item);
        $queryParams = [
            "TableName" => $this->tableName,
            "Item" => $dynamoItem
        ];
        return $queryParams;
    }
}
?>