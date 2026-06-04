/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop function if exists testor_unescape_nocr;
delimiter $$
create function testor_unescape_nocr( p_input longtext )
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
  set v_output = replace( v_output, '__sq__', '''' );
  set v_output = replace( v_output, '__dq__', '\"' );
  set v_output = replace( v_output, '__nl__', '\n' );
  set v_output = replace( v_output, '__cr__', '\r' );
  set v_output = replace( v_output, '__tb__', '\t' );
  set v_output = replace( v_output, '__td__', '`' );
  set v_output = replace( v_output, '__sl__', '\\' );
  set v_output = replace( v_output, '_._us_._', '_' );
  set v_output = replace( v_output, '\r', '\\r' );
  set v_output = replace( v_output, '\n', '\\n' );
  return v_output;
end;$$
delimiter ;