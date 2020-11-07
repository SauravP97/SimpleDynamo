<?php
class ExpressionAttributeSetter{
    private $expressionAttributeValues;
    private $expressionAttributeNames;
    private $variableCount;

    function __construct(){
        $this->expressionAttributeNames = array();
        $this->expressionAttributeValues = array();
        $this->variableCount = 1;
    }

    function getExpressionAttributeNames(){
        return $this->expressionAttributeNames;
    }

    function getExpressionAttributeValues(){
        return $this->expressionAttributeValues;
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
}
?>