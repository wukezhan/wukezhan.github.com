---
layout: post
title: mysql explain
published: false
categories: [ code ]
tags: [ mysql, explain ]
---

{% highlight mysql %}

    mysql> CREATE TABLE `url` (
      `id` bigint(20) NOT NULL,
      `digest` varchar(32) NOT NULL DEFAULT '' COMMENT '链接的摘要',
      `data` text NOT NULL COMMENT '链接',
      `create_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
      `update_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
      PRIMARY KEY (`id`),
      UNIQUE KEY `url_digest_idx` (`digest`) USING BTREE,
      KEY `cu_time` (`create_at`,`update_at`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    Query OK, 0 rows affected (0.16 sec)

	mysql> desc `url`;
    +-----------+-------------+------+-----+---------+-------+
    | Field     | Type        | Null | Key | Default | Extra |
    +-----------+-------------+------+-----+---------+-------+
    | id        | bigint(20)  | NO   | PRI | NULL    |       |
    | digest    | varchar(32) | NO   | UNI |         |       |
    | data      | text        | NO   |     | NULL    |       |
    | create_at | int(11)     | NO   | MUL | 0       |       |
    | update_at | int(11)     | NO   |     | 0       |       |
    +-----------+-------------+------+-----+---------+-------+
	5 rows in set (0.07 sec)

{% endhighlight %}

###
{% highlight mysql %}

    mysql> explain select * from `url` limit 10;
    +----+-------------+-------+------+---------------+------+---------+------+------+-------+
    | id | select_type | table | type | possible_keys | key  | key_len | ref  | rows | Extra |
    +----+-------------+-------+------+---------------+------+---------+------+------+-------+
    |  1 | SIMPLE      | url   | ALL  | NULL          | NULL | NULL    | NULL | 3034 |       |
    +----+-------------+-------+------+---------------+------+---------+------+------+-------+
    1 row in set (0.00 sec)
    
{% endhighlight %}


###查询时，order by的影响
```mysql
    mysql> explain select * from `url` where digest>'123' order by id limit 10;             
    +----+-------------+-------+-------+----------------+---------+---------+------+------+-------------+
    | id | select_type | table | type  | possible_keys  | key     | key_len | ref  | rows | Extra       |
    +----+-------------+-------+-------+----------------+---------+---------+------+------+-------------+
    |  1 | SIMPLE      | url   | index | url_digest_idx | PRIMARY | 8       | NULL |   20 | Using where |
    +----+-------------+-------+-------+----------------+---------+---------+------+------+-------------+
    1 row in set (0.00 sec)
    
    mysql> explain select * from `url` where digest>'123' order by digest limit 10;   
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    | id | select_type | table | type  | possible_keys  | key            | key_len | ref  | rows | Extra       |
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    |  1 | SIMPLE      | url   | range | url_digest_idx | url_digest_idx | 98      | NULL | 1337 | Using where |
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    1 row in set (0.00 sec)
    
    mysql> explain select * from `url` where digest>'123' limit 10;             
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    | id | select_type | table | type  | possible_keys  | key            | key_len | ref  | rows | Extra       |
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    |  1 | SIMPLE      | url   | range | url_digest_idx | url_digest_idx | 98      | NULL | 1337 | Using where |
    +----+-------------+-------+-------+----------------+----------------+---------+------+------+-------------+
    1 row in set (0.00 sec)
```
