<?php
include_once "./Dynamo/Dynamo.php";
include_once "./QueryBuilder/PutItem.php";
include_once "./QueryBuilder/GetItem.php";
include_once "./QueryBuilder/Query.php";
include_once "./QueryBuilder/UpdateItem.php";
include_once "./QueryBuilder/DeleteItem.php";
include_once "./QueryBuilder/Scan.php";

class SimpleDynamo{
    private $dynamoDb;
    private $queryParams;
    private $projectAttributes;
    private $consistentRead;
    private $indexName;
    private $sortInDescendingOrder;
    private $limit;
    private $selectAttribute;
    private $filterExpression;
    private $updateExpression;

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
        if($this->consistentRead){      //If Strongly Consistent Read is made
            //Set the Consistent Read attribute of Get Item class
            $getItem->setConsistentReadAttribute();
        }
        try{
            //Generating the formatted query
            $this->queryParams = $getItem->getFormattedQuery();
            $this->showQueryParameters();
            //$this->dynamoDb->putItem($dynamoQuery);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    function query($keyCondition, $tableName){
        $query = new Query($keyCondition, $tableName);
        if($this->projectAttributes){   //If there exist Projected Attributes
            //Set the Projected Attributes in the Get Item class
            $query->setProjectAttribute($this->projectAttributes);
        }
        if($this->consistentRead){      //If Strongly Consistent Read is made
            //Set the Consistent Read attribute of Get Item class
            $query->setConsistentReadAttribute();
        }
        if($this->indexName){
            //Set the Index name on which query will be performed
            //If left unset, then Primary Key is queried by default
            $query->setIndexName($this->indexName);
        }
        if($this->sortInDescendingOrder){
            // Sort the query results in descending order
            // If left unset then query will be returned
            // in ascending order by default
            $query->setScanIndexAttribute();
        }
        if($this->limit){
            // Limiting the number of Items returned
            // after a successful query
            $query->limitQueryItems($this->limit);
        }
        if($this->selectAttribute){
            // Setting up the Select parameter in the
            // dynamo query
            $query->setSelectAttribute($this->selectAttribute);
        }
        if($this->filterExpression){
            // Setting up the Filter Expression for the
            // Dynamo query
            $query->applyFilters($this->filterExpression);
        }
        try{
            $this->queryParams = $query->getFormattedQuery();
            $this->showQueryParameters();
            //$this->dynamoDb->putItem($dynamoQuery);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    function update($tableName, $key){
        $update = new UpdateItem($tableName, $key);
        if($this->updateExpression){
            $update->setUpdateExpression($this->updateExpression);
        }
        if($this->filterExpression){
            $update->applyFilters($this->filterExpression);
        }
        try{
            $this->queryParams = $update->getFormattedQuery();
            $this->showQueryParameters();
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    function delete($tableName, $key){
        $delete = new DeleteItem($tableName, $key);
        if($this->filterExpression){
            $delete->applyFilters($this->filterExpression);
        }
        try{
            $this->queryParams = $delete->getFormattedQuery();
            $this->showQueryParameters();
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    function scan($tableName){
        $scan = new Scan($tableName);
        if($this->projectAttributes){
            $scan->setProjectAttribute($this->projectAttributes);
        }
        if($this->filterExpression){
            $scan->applyFilters($this->filterExpression);
        }
        try{
            $this->queryParams = $scan->getFormattedQuery();
            $this->showQueryParameters();
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
        $this->consistentRead = true;
    }

    /*
    * Function sets the Index name for
    * making a query in DynamoDB
    */
    function setIndexName($indexName){
        $this->indexName = $indexName;
    }

    /*
    * Function allows the result items 
    * to be returned in descending order
    */
    function setScanIndexAttribute(){
        $this->sortInDescendingOrder = True;
    }

    /*
    * The function limits the number of
    * items returned per query
    */
    function limitQueryItems($limit){
        $this->limit = $limit;
    }

    /*
    * The function sets the Select attribute
    * for querying in DynamoDB
    */
    function setSelectAttribute($selectAttribute){
        $this->selectAttribute = $selectAttribute;
    }

    /*
    * The function sets the Filter Expression
    * for querying in DynamoDB
    */
    function applyFilters($filterExpression){
        $this->filterExpression = $filterExpression;
    }

    /*
    * The function sets the Update Expression
    * for update operation in DynamoDB
    */
    function setUpdateExpression($updateExpression){
        $this->updateExpression = $updateExpression;
    }
}
?>