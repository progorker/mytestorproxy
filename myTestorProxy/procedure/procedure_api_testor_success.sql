/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_success;
delimiter $$
create procedure api_testor_success( in p_token varchar(36), in p_suite_id int, in p_page_no bigint )
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

  set v_code = 'api_testor_success';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'suite_id: ', testor_proxy_quote(p_suite_id), '\n', 'page_no: ', testor_proxy_quote(p_page_no), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "suite_id": ', p_suite_id, ', "page_no": ', p_page_no, '}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    if v_output_json is not null then
      select case_sql as `case`, test_sql as `test`, replace(message_sql, '__nl__', '\\n') as `message`
        from json_table(
              v_output_json,
              '$.successes[*]' columns(
                case_sql text path '$.case',
                test_sql text path '$.test',
                message_sql text path '$.message'
              )
            ) as jt;
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end$$
delimiter ;
