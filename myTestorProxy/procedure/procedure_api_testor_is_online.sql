/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_is_online;
delimiter $$
create procedure api_testor_is_online( in p_token varchar(36), out p_result int )
sql security definer
begin
  declare v_code varchar(640);
  declare v_input_json longtext;
  declare v_input_text longtext;
  declare v_output_json longtext;
  declare v_output_text longtext;
  declare v_proxy_id bigint;
  declare v_ready int default 0;
  declare v_result_str varchar(1024);

  set p_result = 0;

  set v_code = 'api_testor_is_online';
  set v_input_text = concat( 'token: ', p_token, '\n' );
  set v_input_json = concat( '{"token": "', p_token, '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_result_str = json_extract( v_output_json, '$.result' );
    if v_result_str = '1' or v_result_str = '"1"' then
      set p_result = 1;
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;
