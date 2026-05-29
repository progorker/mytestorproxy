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

insert into testor_welcome ( `message` ) values ( 'There are 3 published API procedures: ' );

insert into testor_welcome ( `message` ) values ( 'proc: api_testor_login' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_logout' );
insert into testor_welcome ( `message` ) values ( 'proc: api_testor_is_online' );

