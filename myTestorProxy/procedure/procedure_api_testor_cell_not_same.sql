/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_cell_not_same;
delimiter $$
create procedure api_testor_cell_not_same( in p_token varchar(36), out p_test_id bigint, in p_suite_id bigint, in p_case_id bigint, in p_test_code varchar(640), in p_table varchar(8192), in p_field varchar(8192), in p_where varchar(8192), in p_order varchar(8192), in p_limit varchar(8192), in p_value varchar(8192) )
sql security invoker
begin
  declare v_error_message mediumtext;
  declare v_message mediumtext;
  declare v_sql longtext;
  declare v_success int;
  declare v_ec_code varchar(640);

  declare exit handler for sqlexception
  begin
    get diagnostics condition 1 v_error_message = message_text;
    set v_ec_code = concat( p_test_code, '__exception' );
    call api_testor_error( p_token, p_test_id, p_suite_id, p_case_id, v_ec_code, v_error_message );
  end;

  set v_sql = concat( 'select ', p_field, ' into @v_value_cell_not_same from ', p_table, ' ', p_where, ' ', p_order, ' ', p_limit );
  set @v_sql_testor_cell_not_same = v_sql;
  prepare stmt_testor_cell_not_same from @v_sql_testor_cell_not_same;
  execute stmt_testor_cell_not_same;
  deallocate prepare stmt_testor_cell_not_same;

  if @v_value_cell_not_same is null then
    set @v_value_cell_not_same = 'NULL';
    set v_success = false;
    set v_message = concat( '[', p_test_code, '] test (cell_not_same) is failed. \nOperand: ', @v_value_cell_not_same, '\nValue: ', p_value, '\n' );
  else
    if @v_value_cell_not_same <> p_value then
      set v_success = true;
      set v_message = concat( '[', p_test_code, '] test (cell_not_same) is success. \nOperand: ', @v_value_cell_not_same, '\nValue: ', p_value, '\n' );
    else
      set v_success = false;
      set v_message = concat( '[', p_test_code, '] test (cell_not_same) is failed. \nOperand: ', @v_value_cell_not_same, '\nValue: ', p_value, '\n' );
    end if;
  end if;

  call api_testor_test( p_token, p_test_id, p_suite_id, p_case_id, p_test_code, v_success, v_message );
end;$$
delimiter ;
