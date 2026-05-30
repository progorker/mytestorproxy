/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_insert;
delimiter $$
create procedure testor_proxy_insert (
  out p_proxy_id bigint,
  in p_code varchar(640),
  in p_input_json longtext,
  in p_input_text longtext
)
sql security invoker
begin
  insert into `testor_proxy` ( `code`, `replied`, `input_json`, `input_text`, `output_json`, `output_text` ) values ( p_code, 0, p_input_json, p_input_text, '{}', '' );
  set p_proxy_id = last_insert_id();
end;$$
delimiter ;