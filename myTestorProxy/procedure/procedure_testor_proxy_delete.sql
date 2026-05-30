/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_delete;
delimiter $$
create procedure testor_proxy_delete (
  in p_proxy_id bigint
)
sql security definer
begin
  delete from `testor_proxy` where `id` = p_proxy_id;
end;$$
delimiter ;