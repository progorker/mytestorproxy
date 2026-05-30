/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

SET GLOBAL sql_require_primary_key = OFF;

drop user if exists 'mytestorcheck'@'localhost';
create user 'mytestorcheck'@'localhost' identified with mysql_native_password by 'kunqhtsadzmopeh';

drop database if exists mytestortested;
create database mytestortested;

use mytestortested;

grant all privileges on mytestortested.* to 'mytestorcheck'@'localhost';

grant select on mytestorproxy.testor_welcome to 'mytestorcheck'@'localhost';
grant usage on mytestorproxy.testor_welcome to 'mytestorcheck'@'localhost';
grant create temporary tables on mytestorproxy.* to 'mytestorcheck'@'localhost';

grant execute on procedure mytestorproxy.testor_proxy_list_requests to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_list_replies to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_get_request to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_get_reply to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_reply to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_delete to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.testor_proxy_null_if to 'mytestorcheck'@'localhost';

grant execute on procedure mytestorproxy.api_testor_login to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_logout to 'mytestorcheck'@'localhost';

grant execute on procedure mytestorproxy.api_testor_is_online to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_has_right to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_current_user to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_user_rights to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_change_password to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_create_user to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_suite to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_case to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_suite_case to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_clean to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_test to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_finish to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_result to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_option to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_functions to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_procedures to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_tables to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_version to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_source to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_source_list to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_true to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_true to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_success to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_error to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_equals to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_equals to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_greater_than to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_greater_than to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_less_than to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_less_than to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_same to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_same to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_contains to 'mytestorcheck'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_contains to 'mytestorcheck'@'localhost';

