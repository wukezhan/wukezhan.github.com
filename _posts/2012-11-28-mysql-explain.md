---
layout: post
title: mysql explain
published: false
categories: [ code ]
tags: [ mysql, explain ]
---


	mysql> desc url;
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