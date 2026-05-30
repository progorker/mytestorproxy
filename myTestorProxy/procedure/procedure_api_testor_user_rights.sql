/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_user_rights;
delimiter $$
create procedure api_testor_user_rights(
  in p_token varchar(36), 
  out p_api_call int,
  out p_user_make int,
  out p_user_demo int,
  out p_storage_full int
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
  declare v_output varchar(8192);

  set v_code = 'api_testor_user_rights';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_output = json_extract( v_output_json, '$.api_call' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_api_call = cast( v_output as signed );
    end if;
    set v_output = json_extract( v_output_json, '$.user_make' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_user_make = cast( v_output as signed );
    end if;
    set v_output = json_extract( v_output_json, '$.user_demo' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_user_demo = cast( v_output as signed );
    end if;
    set v_output = json_extract( v_output_json, '$.storage_full' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_storage_full = cast( v_output as signed );
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;