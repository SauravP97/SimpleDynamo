# SimpleDynamo
## Introduction
Simple Dynamo is a Library which allows you to write less code when you are performing operations in Amazon DynamoDB. If you have written codes for operations in Dynamo then you must have experienced repition of some parameters again and again every time. May it be putting your values in **ExpressionAttributeValues** array or making sure you declare the reserved keywords in **ExpressionAttributeNames**, I have built this library to get rid of these repititions. With this library all these operations can be performed by writing a lot less code than before.

We can think of this Library as a layer between the AWS DynamoDB Client and your code which you have written for performing operations on your Dynamo Table.

Below are the attributes which this library supports in total. We can combine these attributes with our operations as suited. I have also tried to improve the Error Handling as well which we can discuss later.

## Simple Dynamo Attributes

- ### Projection Attribute
    <p>
    We use Projection Attributes when we need to specify a particular set of keys which we need to fetch (only) while querying.
    
    > Simple Dynamo Code :
  
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Projecting id and key while querying
    $simpleDynamo->project('id, key');
```

- ### Index Name Attribute
    <p>
    We use Index Name Attribute when we are required to specify an index name while querying in DynamoDB.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Setting Index Name
    $simpleDynamo->setIndexName('your-index-name');
```

- ### Consistent Read Attribute
    <p>
    We use Consistent Read Attribute when we are required to specify a strongly consistent read operation in DynamoDB.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Consistent Read attribute
    $simpleDynamo->makeConsistentRead();
```


- ### Scan Index Attribute (Descending Order)
    <p>
    We use this attribute when we need to fetch results sorted in descending order. By default DynamoDB gives result sorted in the ascending order. 
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Scan Index attribute
    $simpleDynamo->setScanIndexAttribute();
```

- ### Limit Attribute
    <p>
    We use this attribute when we need to Limit the number of items returned in a result set. We need to specify the number of items which we want to be returned in a single operation.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Limit Attribute
    $simpleDynamo->limitQueryItems(number_of_items);
```


- ### Select Attribute
    <p>
    In case you want to fetch only the count of items present in your result set, then this attribute can come in handy.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Select Attribute
    $simpleDynamo->setSelectAttribute("Count");
```

- ### Filter Expression Attribute
    <p>
    We use this attribute, if we want to apply some additional filters to our query operation.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Filter Expression Attribute
    $simpleDynamo->applyFilters("gsi_key = :value1 and gsi_value = :value2");
```

- ### Update Expression Attribute
    <p>
    We use this attribute, if we want to set an update expression while performing update operation in Dynamo.
  
    > Simple Dynamo Code :

```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Set Update Expression Attribute
    $simpleDynamo->setUpdateExpression("set gsi_key = :value1, gsi_value = :value2");
```

## Simple Dynamo Operations

- ### Put Item
    <p>
    The operation inserts an item into our DynamoDB Table
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform a Put-Item Operation
    $simpleDynamo->putItem([
                    'key1' => 'value1', 
                    'key2' => 'value2', 
                    'key3' => 'value3',
                    'key4' => 'value4'
                ],  Table_Name);
```


- ### Get Item
    <p>
    The operation fetches an item from the Dynamo Table given a specified unique primary key.
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform a Get-Item Operation
    $simpleDynamo->getItem(primary_key, Table_Name);
```

- ### Query
    <p>
    The operation queries into the Dynamo Table.
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform a Query Operation
    $simpleDynamo->query(key_condition_expression, Table_Name);
```


- ### Update
    <p>
    The operation updates a particular item in Dynamo table.
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform an Update Operation
    $simpleDynamo->update(Table_Name, primary_key);
```


- ### Delete Item
    <p>
    The operation deletes an item from the Dynamo Table given a specified unique primary key.
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform a Delete-Item Operation
    $simpleDynamo->delete(Table_Name, primary_key);
```


- ### Scan
    <p>
    The operation scans the Dynamo Table according to a given filter expression.
    
    > Simple Dynamo Code :
    
```
    //Creating a new instance
    $simpleDynamo = new SimpleDynamo();
    //Perform a Scan Operation
    $simpleDynamo->scan(Table_Name);
```
