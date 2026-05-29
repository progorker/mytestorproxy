/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_wait;
delimiter $$
create procedure testor_proxy_wait (
  in p_proxy_id bigint,
  in p_count_max bigint,
  in p_sleep_time double,
  out p_ready int
)
sql security invoker
begin
  declare v_count bigint default 0;

  if p_sleep_time < 0 or p_count_max < 0 then
    set p_sleep_time = 0.01;
    set p_count_max = 100 * 60 * 5;
  end if;

  set p_ready = 0;
  while v_count < p_count_max and testor_proxy_ready( p_proxy_id ) = 0 do
    do sleep(p_sleep_time);
    set v_count = v_count + 1;
  end while;

  set p_ready = testor_proxy_ready( p_proxy_id );
end;$$
delimiter ;