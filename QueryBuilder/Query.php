<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";

class Query{
    private $tableName;
    private $marshaler;
    private $indexName;
    private $keyCondition;
    private $filterExpression;
    private $limit;
    private $sortedInDescendingOrder;
    private $selectAttribute;
    private $expressionAttributeValues;
    private $expressionAttributeNames;
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
        $this->expressionAttributeNames = array();
        $this->expressionAttributeValues = array();
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
        $queryTokens = explode(" ",$this->keyCondition);
        $variableCount = 1;
        $keyConditionChanged = '';

        foreach($queryTokens as $token){
            $token = trim($token);
            $tokenChanged = $token;
            if($token[0] == ":"){   //Checking for expression attribute values
                $this->expressionAttributeValues[':expVar'.strval($variableCount)] = substr($token,1);
                $tokenChanged = ':expVar'.strval($variableCount);
                $variableCount++;
            }
            else{   //Checking for reserved keywords
                $preservedKeywords = unserialize(PRESERVED_KEYWORDS);
                if(in_array($token, $preservedKeywords)){
                    $this->expressionAttributeNames['#'.$token] = $token;
                    $tokenChanged = '#'.$token;
                }
            }
            $keyConditionChanged = $keyConditionChanged == '' ? $tokenChanged : 
                                        $keyConditionChanged.' '.$tokenChanged;
        }
        $queryParams = [
            "TableName" => $this->tableName,
            "KeyConditionExpression" => $keyConditionChanged
        ];
        if(count($this->expressionAttributeNames)){
            $queryParams['ExpressionAttributeNames'] = $this->expressionAttributeNames;
        }
        if(count($this->expressionAttributeValues)){
            $queryParams['ExpressionAttributeValues'] = $this->marshaler->marshalItem($this->expressionAttributeValues);
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
        return $queryParams;
    }

    function setProjectAttribute($projectAttributes){
        $this->projectAttributes = $this->checkForReservedKeywords($projectAttributes);
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

    function checkForReservedKeywords($inputString){
        $tokens = explode(",", $inputString);
        $preservedKeywords = unserialize(PRESERVED_KEYWORDS);
        $formattedString = '';
        foreach($tokens as $token){
            $token = trim($token);
            if(in_array($token, $preservedKeywords)){
                $this->expressionAttributeNames['#'.$token] = $token;
                $token = '#'.$token;
            }
            $formattedString = $formattedString == '' ? $token : $formattedString.", ".$token;
        }
        return $formattedString;
    }
}
?>