/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/pgk_mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_pattern;
delimiter $$
create procedure api_testor_pattern( 
  in p_module varchar(64),
  in p_kind varchar(36),
  in p_code varchar(600),
  in p_variant varchar(40),
  out p_pattern longtext
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

  set v_code = 'api_testor_pattern';
  set v_input_text = concat( 'module: ', testor_escape(p_module), '\n', 'kind: ', testor_escape(p_kind), '\n', 'code: ', testor_escape(p_code), '\n', 'variant: ', testor_escape(p_variant), '\n' );
  set v_input_json = concat( '{"module": "', testor_escape(p_module), '", "kind": "', testor_escape(p_kind), '", "code": "', testor_escape(p_code), '", "variant": "', testor_escape(p_variant), '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_output = json_extract( testor_unescape(v_output_json), '$.pattern' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '"', '' );
      set p_pattern = testor_unescape(v_output);
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;
