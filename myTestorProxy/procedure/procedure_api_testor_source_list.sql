/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_source_list;
delimiter $$
create procedure api_testor_source_list( in p_token varchar(36), in p_suite_id bigint )
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

  set v_code = 'api_testor_source_list';
  set v_input_text = concat( 'token: ', testor_proxy_quote(p_token), '\n', 'suite_id: ', testor_proxy_quote(p_suite_id), '\n' );
  set v_input_json = concat( '{"token": "', testor_proxy_quote(p_token), '", "suite_id": ', p_suite_id, '}' );

  call testor_proxy_insert( v_proxy_id, v_code, v_input_json, v_input_text );
  call testor_proxy_wait( v_proxy_id, -1, -1, v_ready );

  if v_ready = 1 then
    call testor_proxy_get_reply( v_proxy_id, v_output_json, v_output_text );
    if v_output_json is not null then
      select rel_key_sql as `rel_key`, abs_key_sql as `test`, rel_value_sql as `rel_value`, abs_value_sql as `abs_value`
        from json_table(
              v_output_json,
              '$.kvs[*]' columns(
                rel_key_sql text path '$.rel_key',
                abs_key_sql text path '$.abs_key',
                rel_value_sql text path '$.rel_value',
                abs_value_sql text path '$.abs_value'
              )
            ) as jt;
    end if;
  end if;
  call testor_proxy_delete( v_proxy_id );
end$$
delimiter ;
