/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists api_testor_escape;
delimiter $$
create function api_testor_escape( p_input longtext )
returns longtext
sql security definer
deterministic
begin
  return testor_escape( p_input );
end;$$
delimiter ;
