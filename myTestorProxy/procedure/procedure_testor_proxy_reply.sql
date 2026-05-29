/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_reply;
delimiter $$
create procedure testor_proxy_reply (
  in p_proxy_id bigint,
  in p_output_json longtext,
  in p_output_text longtext
)
sql security definer
begin
  start transaction;
  update `testor_proxy` set `replied` = 1, `output_json` = p_output_json, `output_text` = p_output_text where `id` = p_proxy_id;
  commit;
end;$$
delimiter ;