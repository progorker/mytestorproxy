/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop table if exists testor_proxy;
create table testor_proxy (
  id bigint not null auto_increment primary key,
  code varchar(640) not null,
  replied int not null default 0,
  input_json longtext,
  input_text longtext,
  output_json longtext,
  output_text longtext
);