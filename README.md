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
