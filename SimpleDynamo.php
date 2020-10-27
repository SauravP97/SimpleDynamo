<?php
class SimpleDynamo{
    private $dynamoDb;
    private $marshaler;

    function __construct(){
        try{
            $this->dynamoDb = new Dynamo();
            $this->marshaler = new MarshalerDynamo();
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    function putItem($query, $tableName){
        $putItem = new PutItem();
        $dynamoQuery = $putItem->getFormattedQuery($query, $tableName);

        try{
            $this->dynamoDb->putItem($dynamoQuery);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
?>