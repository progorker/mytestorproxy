/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop table if exists testor_welcome;
create table testor_welcome (
  id bigint not null auto_increment primary key,
  message text not null,
  created timestamp not null default current_timestamp,
  updated timestamp not null default current_timestamp on update current_timestamp
);

insert into testor_welcome ( `message` ) values ( 'Welcome to myTestor 0.0.1!' );

insert into testor_welcome ( `message` ) values ( 'There are 36 published API procedures: ' );

insert into testor_welcome ( `message` ) values ( 'proc: api_testor_current_user' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_login' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_logout' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_user_rights' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_create_user' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_change_password' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_suite' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_case' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_suite_case' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_clean' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_test' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_finish' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_result' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_option' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_e_functions' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_e_procedures' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_e_tables' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_version' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_source' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_source_list' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_true' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_true' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_success' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_error' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_equals' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_equals' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_greater_than' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_greater_than' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_less_than' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_less_than' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_same' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_same' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_contains' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_not_contains' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_has_right' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_is_online' );

