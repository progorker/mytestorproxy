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


-|_|-----------|___/----------------------
             Alpha Testing
------------------------------------------


-------|__/-------------------------
           INSTALLATION
------------------------------------

$) cd __WORK_DIR__

$) git clone https://github.com/progorker/mytestor-proxy.git

$) cd mytestor-proxy/myTestorProxy

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


-------|__/-------------------------
        RUNNING BRIDGE
------------------------------------

$) export MYTESTORPROXY_DIR=""
$) nano $MYTESTORPROXY_DIR/config.php
----> Modify myTestor account, myTestorProxy account and other settings
$) cd $MYTESTORPROXY_DIR && php ./agent.php


-------|__/-------------------------
        Getting manual page
------------------------------------

$) export MYTESTORPROXY_DIR=""
$) export MODULE="mytestor"
$) export KIND="procedure"
$) export CODE="api_testor_suite"
$) cd $MYTESTORPROXY_DIR && php ./man.php $MODULE $KIND $CODE


-------|__/-------------------------
        Getting code pattern
------------------------------------
 
$) export MYTESTORPROXY_DIR=""
$) export MODULE="mytestor"
$) export KIND="procedure"
$) export CODE="api_testor_suite"
$) export VARIANT="scrp"
$) cd $MYTESTORPROXY_DIR && php ./pattern.php $MODULE $KIND $CODE $VARIANT


-------|__/-------------------------
    Controlling source versions
------------------------------------

$) export MYTESTORPROXY_DIR=""
$) export PHP_WORKED_DIR=""
$) cp -f $MYTESTORPROXY_DIR/svc.php $PHP_WORKED_DIR/
$) cp -f $MYTESTORPROXY_DIR/svc-cfg.php $PHP_WORKED_DIR/
$) nano $MYTESTORPROXY_DIR/svc-cfg.php
---> Modify myTestorProxy account and other settings
$) cd $PHP_WORKED_DIR && php ./svc.php


```
