/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_get_reply;
delimiter $$
create procedure testor_proxy_get_reply (
  in p_proxy_id bigint,
  out p_output_json longtext,
  out p_output_text longtext
)
sql security definer
begin
  select `output_json`, `output_text` into p_output_json, p_output_text from `testor_proxy` where `id` = p_proxy_id;
  if p_output_json is null then
    set p_output_json = '{}'; 
  end if;
  if p_output_text is null then
    set p_output_text = '';
  end if;
end;$$
delimiter ;