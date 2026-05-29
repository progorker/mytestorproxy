/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

SET GLOBAL sql_require_primary_key = OFF;

drop user if exists 'mytestorproxy'@'localhost';
create user 'mytestorproxy'@'localhost' identified with mysql_native_password by 'kunqhtsadzmopeh';

drop database if exists mytestorproxy;
create database mytestorproxy;

use mytestorproxy;

source ./setup.sql

grant select on mytestorproxy.testor_welcome to 'mytestorproxy'@'localhost';
grant usage on mytestorproxy.testor_welcome to 'mytestorproxy'@'localhost';
grant create temporary tables on mytestorproxy.* to 'mytestorproxy'@'localhost';

grant execute on procedure mytestorproxy.testor_proxy_list_requests to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_list_replies to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_get_request to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_get_reply to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_reply to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_delete to 'mytestorproxy'@'localhost';

grant execute on procedure mytestorproxy.api_testor_login to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_logout to 'mytestorproxy'@'localhost';

grant execute on procedure mytestorproxy.api_testor_is_online to 'mytestorproxy'@'localhost';
