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
grant execute on procedure mytestorproxy.testor_proxy_null_if to 'mytestorproxy'@'localhost';

grant execute on procedure mytestorproxy.api_testor_login to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_logout to 'mytestorproxy'@'localhost';

grant execute on procedure mytestorproxy.api_testor_is_online to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_has_right to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_current_user to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_user_rights to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_change_password to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_create_user to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_suite to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_case to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_suite_case to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_clean to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_test to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_finish to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_result to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_option to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_functions to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_procedures to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_e_tables to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_version to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_source to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_source_list to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_true to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_true to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_success to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_error to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_equals to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_equals to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_greater_than to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_greater_than to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_less_than to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_less_than to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_same to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_same to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_contains to 'mytestorproxy'@'localhost';
grant execute on procedure mytestorproxy.api_testor_not_contains to 'mytestorproxy'@'localhost';

