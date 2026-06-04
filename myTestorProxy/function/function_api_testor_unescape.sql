/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists api_testor_unescape;
delimiter $$
create function api_testor_unescape( p_input varchar(8192) )
returns varchar(8192)
sql security definer
deterministic
begin
  return testor_unescape( p_input );
end;$$
delimiter ;
