<?php
include_once "./MarshalerDynamo/MarshalerDynamo.php";

class Scan{
    private $tableName;
    private $marshaler;
    private $projectAttributes;
    private $expressionAttributeValues;
    private $expressionAttributeNames;
    private $filterExpression;
    private $variableCount;

    /*
    * Parameterized Constructor is Used :
    * @params 
    *   1. $query -> Takes Simplified user query
    *   2. tableName -> Name of the Table (DynamoDB)
    * The function initializes the Marshaker as well
    * for further data processing. 
    */
    function __construct($tableName){
        $this->tableName = $tableName;
        $this->marshaler = new MarshalerDynamo();
        $this->variableCount = 1;
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
        $queryParams = [
            "TableName" => $this->tableName,
        ];
        if($this->projectAttributes){
            $queryParams['ProjectionExpression'] = $this->projectAttributes;
        }
        if(count($this->expressionAttributeNames)){
            $queryParams['ExpressionAttributeNames'] = $this->expressionAttributeNames;
        }
        if(count($this->expressionAttributeValues)){
            $queryParams['ExpressionAttributeValues'] = $this->marshaler->marshalItem($this->expressionAttributeValues);
        }
        if($this->filterExpression){
            $queryParams['ConditionExpression'] = $this->filterExpression;
        }
        return $queryParams;
    }


    /*
    * Function checks for presence of a reserved
    * keyword in the input string, if any reserved
    * keyword is found then it replaces it with a
    * #(hash) string and maps it in the ExpressionAttributeNames
    * array for the future reference of DynamoDB
    */
    function checkForReservedKeywords($inputString, $delimiter){
        $tokens = explode($delimiter, $inputString);
        $preservedKeywords = unserialize(PRESERVED_KEYWORDS);
        $formattedString = '';
        foreach($tokens as $token){
            $token = trim($token);
            if(in_array($token, $preservedKeywords)){
                $this->expressionAttributeNames['#'.$token] = $token;
                $token = '#'.$token;
            }
            $formattedString = $formattedString == '' ? $token : $formattedString.$delimiter.$token;
        }
        return $formattedString;
    }

    /*
    * Function checks for any values present in the
    * query string. If a value is found then it is
    * replaced with a :(colon) string and that value is
    * mapped in the ExpressionAttributeValues array for
    * the future reference of DynamoDB
    */
    function checkForQueryValues($inputQuery){
        $queryTokens = explode(" ",$inputQuery);
        $keyConditionChanged = '';

        foreach($queryTokens as $token){
            $token = trim($token);
            $tokenChanged = $token;
            if($token[0] == ":"){   //Checking for expression attribute values
                $this->expressionAttributeValues[':expVar'.strval($this->variableCount)] = substr($token,1);
                $tokenChanged = ':expVar'.strval($this->variableCount);
                $this->variableCount++;
            }
            $keyConditionChanged = $keyConditionChanged == '' ? $tokenChanged : 
                                        $keyConditionChanged.' '.$tokenChanged;
        }

        return $keyConditionChanged;
    }

    function applyFilters($filterExpression){
        $this->filterExpression = $this->checkForReservedKeywords($filterExpression, " ");
        $this->filterExpression = $this->checkForQueryValues($this->filterExpression);
    }

    function setProjectAttribute($projectAttributes){
        $this->projectAttributes = $this->checkForReservedKeywords($projectAttributes, ",");
    }
}
?>