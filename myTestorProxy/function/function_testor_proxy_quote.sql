/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists testor_proxy_quote;
delimiter $$
create function testor_proxy_quote( p_input varchar(8192) )
returns varchar(8192)
deterministic
sql security invoker
begin
  declare v_output varchar(8192);
  set v_output = p_input;
  set v_output = replace( v_output, '''', '''''' );
  set v_output = replace( v_output, '\"', '\\\"' );
  set v_output = replace( v_output, '\n', '\\n' );
  set v_output = replace( v_output, '\r', '\\r' );
  set v_output = replace( v_output, '\t', '\\t' );
  return v_output;
end;$$
delimiter ;