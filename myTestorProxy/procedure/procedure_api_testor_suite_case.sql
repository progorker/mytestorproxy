/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_suite_case;
delimiter $$
create procedure api_testor_suite_case( in p_token varchar(36), out p_suite_id bigint, out p_case_id bigint, in p_suite_code varchar(640), in p_case_code varchar(640) )
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

  set v_code = 'api_testor_suite_case';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'suite_code: ', testor_proxy_quote(p_suite_code), '\n', 'case_code: ', testor_proxy_quote(p_case_code), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "suite_code": "', testor_proxy_quote(p_suite_code), '", "case_code": "', testor_proxy_quote(p_case_code), '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_output = json_extract( v_output_json, '$.suite_id' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_suite_id = cast( v_output as signed );
    end if;
    set v_output = json_extract( v_output_json, '$.case_id' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_case_id = cast( v_output as signed );
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end;$$
delimiter ;
