<?php
include_once "./Dynamo/Dynamo.php";
include_once "./QueryBuilder/PutItem.php";

class SimpleDynamo{
    private $dynamoDb;
    private $queryParams;
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
        $this->queryParams = $putItem->getFormattedQuery();
        try{
            $this->showQueryParameters();
            //$this->dynamoDb->putItem($dynamoQuery);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /*
    * Function acts as a logger to
    * print the query parameters. If
    * you have any issues in querying or
    * any exception pops up then you can
    * debug the problem by viewing the query
    * parameters, by invoking the
    * showQueryParameters function
    */
    function showQueryParameters(){
        echo print_r($this->queryParams, true)."\n";
    }
}
?>