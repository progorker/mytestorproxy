/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_contains;
delimiter $$
create procedure api_testor_contains( in p_token varchar(36), out p_id bigint, in p_suite_id bigint, in p_case_id bigint, in p_code varchar(640), in p_operand varchar(8192), in p_value varchar(8192) )
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

  set v_code = 'api_testor_contains';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'suite_id: ', testor_proxy_quote(p_suite_id), '\n', 'case_id: ', testor_proxy_quote(p_case_id), '\n', 'test_code: ', testor_proxy_quote(p_code), '\n', 'operand: ', testor_proxy_quote(p_operand), '\n', 'value: ', testor_proxy_quote(p_value), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "suite_id": ', p_suite_id, ', "case_id": ', p_case_id, ', "test_code": "', testor_proxy_quote(p_code), '", "operand": "', testor_proxy_quote(p_operand), '", "value": "', testor_proxy_quote(p_value), '"}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    set v_output = json_extract( v_output_json, '$.test_id' );
    if v_output is not null and v_output <> 'NULL' and v_output <> '\"NULL\"' then
      set v_output = replace( v_output, '\"', '' );
      set p_id = cast( v_output as signed );
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end$$
delimiter ;
