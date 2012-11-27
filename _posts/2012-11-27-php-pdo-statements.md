---
layout: post
title: php pdo statements
categories: [ code ]
tags: [ php, mysql ]
---

### 概念

关于预处理语句这个概念，PHP官网有这样一段描述：

> Prepared statements and stored procedures
> 
> Many of the more mature databases support the concept of prepared statements. What are they? They can be thought of as a kind of compiled template for the SQL that an application wants to run, that can be customized using variable parameters. Prepared statements offer two major benefits:
> 
> *   The query only needs to be parsed (or prepared) once, but can be executed multiple times with the same or different parameters. When the query is prepared, the database will analyze, compile and optimize its plan for executing the query. For complex queries this process can take up enough time that it will noticeably slow down an application if there is a need to repeat the same query many times with different parameters. By using a prepared statement the application avoids repeating the analyze/compile/optimize cycle. This means that prepared statements use fewer resources and thus run faster.
> *   The parameters to prepared statements don't need to be quoted; the driver automatically handles this. If an application exclusively uses prepared statements, the developer can be sure that no SQL injection will occur (however, if other portions of the query are being built up with unescaped input, SQL injection is still possible).
> 
> Prepared statements are so useful that they are the only feature that PDO will emulate for drivers that don't support them. This ensures that an application will be able to use the same data access paradigm regardless of the capabilities of the database.

可见，prepared statements是SQL的一种编译模板，主要有以下优点：

*   查询只需一次解析（预处理），即可多次执行。在预处理查询时，数据库会自动对其进行分析、编译和优化执行计划。对于复杂的查询而言，在不使用prepared statement的情况下，如果这个查询需要多次以不同的参数分别执行，那么数据库就将相应的多次重复这个预处理过程，这将有可能需要消耗足够多的时间而导致应用程序的运行明显变慢。而使用prepared statement则可有效避免多次重复这个过程，这意味着prepared statements能使查询效率更高、消耗更少。 
*   prepared statements的参数无需做任何处理，pdo将会自动对其进行相应的处理，这些处理包括特殊字符转义、字符串加引号等等。如果对用户的输入都使用prepared statements，将可避免出现数据库遭到SQL注入攻击的情况。 

### 示例

{% highlight php linenos %}

    <?php
    # eg. 1
    $stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':value', $value);
    
    // insert one row
    $name = 'one';
    $value = 1;
    $stmt->execute();
    
    // insert another row with different values
    $name = 'two';
    $value = 2;
    $stmt->execute();
    ?>
    
{% endhighlight %}

自从用了PDO，代码果然小清新多了。需要注意的是以上示例里的bindParam如果使用不当即为巨坑，详情见[PDOStatement::bindParam的一个陷阱][1] ，前车之鉴后事之师！

 [1]: http://www.laruence.com/2012/10/16/2831.html