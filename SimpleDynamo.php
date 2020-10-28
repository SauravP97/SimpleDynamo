<?php
include_once "./Dynamo/Dynamo.php";
include_once "./QueryBuilder/PutItem.php";
include_once "./QueryBuilder/GetItem.php";

class SimpleDynamo{
    private $dynamoDb;
    private $queryParams;
    private $projectAttributes;
    private $consistenrRead;

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

    function getItem($key, $tableName){
        $getItem = new GetItem($key, $tableName);
        if($this->projectAttributes){   //If there exist Projected Attributes
            //Set the Projected Attributes in the Get Item class
            $getItem->setProjectAttribute($this->projectAttributes);
        }
        if($this->consistenrRead){      //If Strongly Consistent Read is made
            //Set the Consistent Read attribute of Get Item class
            $getItem->setConsistentReadAttribute();
        }
        //Generating the formatted query
        $this->queryParams = $getItem->getFormattedQuery();
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

    /*
    * Function sets the Projected Attributes
    * while making a Dynamo Operation.
    * Optional for usage
    */
    function project($projectAttributes){
        $this->projectAttributes = $projectAttributes;
    }

    /*
    * Function sets the Dynamo Read
    * Operation to be Strongly Consistent
    * Optional for usage
    */
    function makeConsistentRead(){
        $this->consistenrRead = true;
    }
}
?>