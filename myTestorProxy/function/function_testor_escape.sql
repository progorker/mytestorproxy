/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists testor_escape;
delimiter $$
create function testor_escape( p_input longtext )
returns longtext
deterministic
sql security invoker
begin
  declare v_output longtext;
  if p_input is null then
    set v_output = 'NULL';
  else
    set v_output = p_input;
  end if;
  set v_output = replace( v_output, '_', '_._us_._' );
  set v_output = replace( v_output, '''', '__sq__' );
  set v_output = replace( v_output, '\"', '__dq__' );
  set v_output = replace( v_output, '\n', '__nl__' );
  set v_output = replace( v_output, '\r', '__cr__' );
  set v_output = replace( v_output, '\t', '__tb__' );
  set v_output = replace( v_output, '`', '__td__' );
  set v_output = replace( v_output, '\\', '__sl__' );
  return v_output;
end;$$
delimiter ;