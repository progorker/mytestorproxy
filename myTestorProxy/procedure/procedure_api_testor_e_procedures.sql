/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_e_procedures;
delimiter $$
create procedure api_testor_e_procedures( in p_mysql_database varchar(8192), in p_find varchar(8192), out p_names mediumtext )
sql security invoker
begin
  declare v_names mediumtext;

  drop temporary table if exists temp_names_procedure;
  create temporary table temp_names_procedure (
    name varchar(8192)
  );

  set v_names = '';
  if p_find = '' then
    insert into temp_names_procedure select routine_name as name from information_schema.routines where routine_type = 'PROCEDURE' and routine_schema = p_mysql_database order by routine_name asc;
    select group_concat(name separator ' , ') into v_names from temp_names_procedure order by name asc;
    if v_names is null then
      set v_names = '';
    end if;
  else 
    insert into temp_names_procedure select routine_name as name from information_schema.routines where routine_type = 'PROCEDURE' and routine_schema = p_mysql_database and routine_name like p_find order by routine_name asc;
    select group_concat(name separator ' , ') into v_names from temp_names_procedure order by name asc;
    if v_names is null then
      set v_names = '';
    end if;
  end if;
  set p_names = v_names;

  drop temporary table if exists temp_names_procedure;
end;$$
delimiter ;
