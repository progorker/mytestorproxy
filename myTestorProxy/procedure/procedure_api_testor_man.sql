/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_man;
delimiter $$
create procedure api_testor_man( 
  in p_module varchar(64),
  in p_kind varchar(36),
  in p_code varchar(640),
  out p_man longtext
)
sql security definer
begin
  declare v_code varchar(640);
  declare v_input_json longtext;
  declare v_input_text longtext;
  declare v_output_json longtext;
  declare v_output_text longtext;
  declare v_proxy_id bigint;
  declare v_ready int default 0;
  declare v_output longtext;

  set v_code = 'api_testor_man';
  set v_input_text = concat( 'module: ', testor_proxy_quote(p_module), '\n', 'kind: ', testor_proxy_quote(p_kind), '\n', 'code: ', testor_proxy_quote(p_code), '\n' );
  set v_input_json = concat( '{"module": "', testor_proxy_quote(p_module), '", "kind": "', testor_proxy_quote(p_kind), '", "code": "', testor_proxy_quote(p_code), '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_output = json_extract( v_output_json, '$.man' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '"', '' );
      set p_man = v_output;
      set p_man = replace( p_man, '__nl__', '\n' );
      set p_man = replace( p_man, '__cr__', '\r' );
      set p_man = replace( p_man, '__dq__', '"' );
      set p_man = replace( p_man, '__sq__', '''' );
      set p_man = replace( p_man, '__td__', '`' );
      set p_man = replace( p_man, '__sl__', '\\' );
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;
