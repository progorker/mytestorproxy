```
===========_____=======_============
  _ __ _  |_   _|__ __| |_ ___ _ _ 
 | '  \ || || |/ -_|_-<  _/ _ \ '_|
 |_|_|_\_, ||_|\___/__/\__\___/_|  
=======|__/=========================
 [ myTestor ] Unit Testing Platform
           ----- oOo -----
  Unit testing framework for MySQL
====================================


-------|__/-------------------------
           INSTALLATION
------------------------------------

$) cd __WORK_DIR__

$) git clone https://github.com/progorker/mytestorproxy.git

$) cd mytestorproxy

$) sudo mysql

$)>source ./setup-security.sql

-----

$) nano ./setup-security-tested.sql

$)-- Replace 'mytestorcheck' by your user string

$)-- Replace mytestortested by your database string

$)-- Comment following lines if you use existing database:
---
drop database if exists mytestortested;
create database mytestortested;
---

$) sudo mysql

$)>source ./setup-security-tested.sql

```
