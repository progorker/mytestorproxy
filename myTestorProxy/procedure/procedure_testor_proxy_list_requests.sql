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
create procedure testor_proxy_list_requests ()
sql security definer
begin
  select `id` as `proxy_id`, `code` from `testor_proxy` where `replied` = 0 order by `id` asc;
end;$$
delimiter ;