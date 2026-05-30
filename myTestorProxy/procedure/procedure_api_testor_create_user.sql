/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_create_user;
delimiter $$
create procedure api_testor_create_user(
  in p_token varchar(36), 
  in p_username varchar(1024),
  in p_password varchar(4096),
  in p_api_call int,
  in p_user_make int,
  in p_user_demo int,
  in p_quota bigint
)
sql security definer
begin
  declare v_code varchar(640);
  declare v_input_json longtext;
  declare v_input_text longtext;
  declare v_proxy_id bigint;
  declare v_ready int default 0;

  set v_code = 'api_testor_create_user';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'username: ', testor_proxy_quote(p_username), '\n', 'password: ', testor_proxy_quote(p_password), '\n', 'api_call: ', p_api_call, '\n', 'user_make: ', p_user_make, '\n', 'user_demo: ', p_user_demo, '\n', 'quota: ', p_quota, '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "username": "', testor_proxy_quote(p_username), '", "password": "', testor_proxy_quote(p_password), '", "api_call": ', p_api_call, ', "user_make": ', p_user_make, ', "user_demo": ', p_user_demo, ', "quota": ', p_quota, '}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;