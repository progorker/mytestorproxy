/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_get_request;
delimiter $$
create procedure testor_proxy_get_request (
  in p_proxy_id bigint,
  out p_input_json longtext,
  out p_input_text longtext
)
sql security definer
begin
  select `input_json`, `input_text` into p_input_json, p_input_text from `testor_proxy` where `id` = p_proxy_id;
  if p_input_json is null then
    set p_input_json = '{}'; 
  end if;
  if p_input_text is null then
    set p_input_text = '';
  end if;
end;$$
delimiter ;