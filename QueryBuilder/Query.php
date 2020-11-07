<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";
include_once "ExpressionAttributeSetter.php";

class Query{
    private $tableName;
    private $marshaler;
    private $indexName;
    private $keyCondition;
    private $filterExpression;
    private $limit;
    private $sortedInDescendingOrder;
    private $selectAttribute;
    private $expressionAttributeSetter;
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
    function __construct($keyCondition, $tableName){
        $this->keyCondition = $keyCondition;
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
        $this->keyCondition = $this->expressionAttributeSetter->checkForReservedKeywords($this->keyCondition, " ");
        $keyConditionChanged = $this->expressionAttributeSetter->checkForQueryValues($this->keyCondition);
        $queryParams = [
            "TableName" => $this->tableName,
            "KeyConditionExpression" => $keyConditionChanged
        ];
        if(count($this->expressionAttributeSetter->getExpressionAttributeNames())){
            $queryParams['ExpressionAttributeNames'] = $this->expressionAttributeSetter->getExpressionAttributeNames();
        }
        if(count($this->expressionAttributeSetter->getExpressionAttributeValues())){
            $queryParams['ExpressionAttributeValues'] = $this->marshaler->marshalItem($this->expressionAttributeSetter->getExpressionAttributeValues());
        }
        if($this->projectAttributes){
            $queryParams['ProjectionExpression'] = $this->projectAttributes;
        }
        if($this->consistentRead){
            $queryParams['ConsistentRead'] = True;
        }
        if($this->indexName){
            $queryParams['IndexName'] = $this->indexName;
        }
        if($this->sortedInDescendingOrder){
            $queryParams['ScanIndexForward'] = False;
        }
        if($this->limit){
            $queryParams['Limit'] = $this->limit;
        }
        if($this->selectAttribute){
            $queryParams['Select'] = $this->selectAttribute;
        }
        if($this->filterExpression){
            $queryParams['FilterExpression'] = $this->filterExpression;
        }
        return $queryParams;
    }

    function setProjectAttribute($projectAttributes){
        $this->projectAttributes = $this->expressionAttributeSetter->checkForReservedKeywords($projectAttributes, ",");
    }

    function setConsistentReadAttribute(){
        $this->consistentRead = true;
    }

    function setIndexName($indexName){
        $this->indexName = $indexName;
    }

    function setScanIndexAttribute(){
        $this->sortedInDescendingOrder = True;
    }

    function limitQueryItems($limit){
        $this->limit = $limit;
    }

    function setSelectAttribute($selectAttribute){
        $this->selectAttribute = $selectAttribute;
    }

    function applyFilters($filterExpression){
        $this->filterExpression = $this->expressionAttributeSetter->checkForReservedKeywords($filterExpression, " ");
        $this->filterExpression = $this->expressionAttributeSetter->checkForQueryValues($this->filterExpression);
    }

    function unmarshalResult($result){
        if(@$result['Items'] && count($result['Items'])){
            $unmarshalItems = [];
            foreach($result['Items'] as $item){
                $unmarshalItems[] = $this->marshaler->unmarshalItem($item); 
            }
            $result['Items'] = $unmarshalItems;
        }
        return $result;
    }
}
?>