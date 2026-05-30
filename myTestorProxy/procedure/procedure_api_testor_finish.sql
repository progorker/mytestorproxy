/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_finish;
delimiter $$
create procedure api_testor_finish( in p_token varchar(36), in p_suite_id bigint )
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

  set v_code = 'api_testor_finish';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'suite_id: ', testor_proxy_quote(p_suite_id), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "suite_id": ', p_suite_id, '}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    if v_output_json is not null then
      select case_sql as `case`, test_sql as `test`, replace(message_sql, '__nl__', '\\n') as `message`
        from json_table(
              v_output_json,
              '$.errors[*]' columns(
                case_sql text path '$.case',
                test_sql text path '$.test',
                message_sql text path '$.message'
              )
            ) as jt;
      select version_sql as `version`, status_sql as `status`, code_sql as `code`, id_sql as `id`, success_count_sql as `success_count`, failed_count_sql as `failed_count`, test_count_sql as `test_count`, case_count_sql as `case_count`
        from json_table(
              v_output_json,
              '$.status[*]' columns(
                version_sql text path '$.version',
                status_sql text path '$.status',
                code_sql text path '$.code',
                id_sql text path '$.id',
                success_count_sql text path '$.success_count',
                failed_count_sql text path '$.failed_count',
                test_count_sql text path '$.test_count',
                case_count_sql text path '$.case_count'
              )
            ) as jt;
      select reprint_sql as `To re-print: `, get_source_sql as `To get source file of [a] test case: `
        from json_table(
              v_output_json,
              '$.hints[*]' columns(
                reprint_sql text path '$.reprint',
                get_source_sql text path '$.get_source'
              )
            ) as jt;
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end$$
delimiter ;
