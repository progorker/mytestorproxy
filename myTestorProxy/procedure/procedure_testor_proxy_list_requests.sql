/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_list_requests;
delimiter $$
create procedure testor_proxy_list_requests (in p_page_no bigint)
sql security definer
begin
  declare v_offset bigint;
  if p_page_no <= 0 then
    set p_page_no = 1;
  end if;
  set v_offset = (p_page_no - 1) * 5;
  select `id` as `proxy_id`, `code` from `testor_proxy` where `replied` = 0 order by `id` asc limit v_offset, 5;
end;$$
delimiter ;