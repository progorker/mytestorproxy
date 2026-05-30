/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists testor_proxy_null_if;
delimiter $$
create procedure testor_proxy_null_if (
  inout p_data varchar(8192)
)
sql security definer
begin
  if p_data is not null then
    if p_data = 'NULL' or p_data = 'null' or p_data = '\"NULL\"' or p_data = '\"null\"' then
      set p_data = NULL;
    end if;
  end if;
end;$$
delimiter ;