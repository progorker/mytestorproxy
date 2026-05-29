/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_logout;
delimiter $$
create procedure api_testor_logout( 
  in p_token varchar(36)
)
sql security definer
begin
  declare v_code varchar(640);
  declare v_input_json longtext;
  declare v_input_text longtext;
  declare v_proxy_id bigint;
  declare v_ready int default 0;

  set v_code = 'api_testor_logout';
  set v_input_text = concat( 'token: ', p_token, '\n' );
  set v_input_json = concat( '{"token": "', p_token, '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;