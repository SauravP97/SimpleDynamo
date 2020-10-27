<?php
class PutItem{
    private $query;
    private $tableName;
    private $marshaler;

    /*
    * Parameterized Constructor is Used :
    *   @params 
    *       1. $query -> Takes Simplified user query
    *       2. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($query, $tableName){
        $this->query = $query;
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
        return $this->query;
    }
}
?>