<?php
class SimpleDynamo{
    private $dynamoDb;

    /*
    * Simple Dynamo Class acts as an interface between
    * the user friendly simple Dynamo Queries and the
    * actual Dynamo supported Query.
    * Writing actual queries can be lengthy and time
    * taking as well. Hence this library will convert
    * every user friendly Simple Dynamo queries to the
    * actual Dynamo supported queries and return the
    * results accordingly.
    */
    function __construct(){
        try{
            $this->dynamoDb = new Dynamo();
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /*
    * Every Function below have a similar
    * working structure.
    *   1. The function takes input as the
    *      user friendly simple dynamo queries.
    *   2. Use corresponding query formatter to
    *      format the user friendly queries into
    *      Dynamo supported query.
    *   3. Return the results accordingly after
    *      making the final query.
    */
    
    function putItem($query, $tableName){
        $putItem = new PutItem($query, $tableName);
        $dynamoQuery = $putItem->getFormattedQuery();
        try{
            $this->dynamoDb->putItem($dynamoQuery);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
?>