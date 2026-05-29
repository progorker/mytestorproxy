/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_login;
delimiter $$
create procedure api_testor_login( 
  out p_token varchar(36), in p_username varchar(1024), in p_password varchar(4096)
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

  set v_code = 'api_testor_login';
  set v_input_text = concat( 'username: ', p_username, '\n', 'password: ', p_password, '\n' );
  set v_input_json = concat( '{"username": "', p_username, '", "password": "', p_password, '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set p_token = json_extract( v_output_json, '$.token' );
    set p_token = replace( p_token, '\"', '' );
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;