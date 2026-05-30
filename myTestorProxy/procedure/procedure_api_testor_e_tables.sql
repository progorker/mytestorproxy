/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

drop procedure if exists api_testor_e_tables;
delimiter $$
create procedure api_testor_e_tables( in p_mysql_database varchar(8192), in p_find varchar(8192), out p_names mediumtext )
sql security invoker
begin
  declare v_names mediumtext;

  drop temporary table if exists temp_names_table;
  create temporary table temp_names_table (
    name varchar(8192)
  );

  set v_names = '';
  if p_find = '' then
    insert into temp_names_table select table_name as name from information_schema.tables where table_schema = p_mysql_database order by table_name asc;
    select group_concat(name separator ' , ') into v_names from temp_names_table order by name asc;
    if v_names is null then
      set v_names = '';
    end if;
  else 
    insert into temp_names_table select table_name as name from information_schema.tables where table_schema = p_mysql_database and table_name like p_find order by table_name asc;
    select group_concat(name separator ' , ') into v_names from temp_names_table order by name asc;
    if v_names is null then
      set v_names = '';
    end if;
  end if;
  set p_names = v_names;

  drop temporary table if exists temp_names_table;
end;$$
delimiter ;
