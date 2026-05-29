/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists testor_proxy_ready;
delimiter $$
create function testor_proxy_ready( p_proxy_id bigint )
returns int
deterministic
sql security invoker
begin
  declare v_count int default 0;
  declare v_replied int;

  select count(`id`) into v_count from `testor_proxy` where `id` = p_proxy_id;
  if v_count <> 1 then
    return 0;
  else 
    select `replied` into v_replied from `testor_proxy` where `id` = p_proxy_id limit 1;
    return v_replied;
  end if; 
end;$$
delimiter ;