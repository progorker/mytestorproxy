<?php
/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

global $g_config;

require_once __DIR__ . '/config.php';

function g_mytestorproxy_exec( $sql ) {
  global $g_config;

  $host = $g_config['mytestorproxy.host'];
  $port = $g_config['mytestorproxy.port'];
  $user = $g_config['mytestorproxy.username'];
  $pass = $g_config['mytestorproxy.password'];
  $db = $g_config['mytestorproxy.database'];

  $text = @shell_exec("mysql --disable-auto-rehash -h $host -P $port --user=$user --password=$pass -e \"use $db; $sql \" ");
  return $text;
}

function g_mytestor_exec( $sql ) {
  global $g_config;

  $host = $g_config['mytestor.host'];
  $port = $g_config['mytestor.port'];
  $user = $g_config['mytestor.username'];
  $pass = $g_config['mytestor.password'];
  $db = $g_config['mytestor.database'];

  $text = @shell_exec("mysql --disable-auto-rehash -h $host -P $port --user=$user --password=$pass -e \"use $db; $sql \" ");
  return $text;
}

function g_proxy_id_list() {
  $sql = "call testor_proxy_list_requests(1);";
  $text = g_mytestorproxy_exec( $sql );
  $lines = explode( "\n", $text );
  $result = array();
  for ( $i = 1; $i < count( $lines ); $i++ ) {
    $ln = trim( $lines[ $i ] );
    if ( $ln === '' ) continue;
    $fields = explode( "\t", $ln );
    $it = array( 'id' => $fields[0], 'code' => $fields[1] );
    $result[] = $it;
  }
  return $result;
}

function g_delete_proxy( $id ) {
  $sql = "call testor_proxy_delete(" . $id . ");";
  g_mytestorproxy_exec( $id );
}

function g_process_proxy( $item ) {
  $proxy_id = $item['id'];
  $code = $item['code'];

  if ( $code === 'api_testor_login' ) {
    g_api_testor_login( $proxy_id );
  } else if ( $code === 'api_testor_logout' ) {
    g_api_testor_logout( $proxy_id );
  } else if ( $code === 'api_testor_is_online' ) {
    g_api_testor_is_online( $proxy_id );
  } else if ( $code === 'api_testor_has_right' ) {
    g_api_testor_has_right( $proxy_id );
  } else if ( $code === 'api_testor_current_user' ) {
    g_api_testor_current_user( $proxy_id );
  } else if ( $code === 'api_testor_user_rights' ) {
    g_api_testor_user_rights( $proxy_id );
  } else if ( $code === 'api_testor_change_password' ) {
    g_api_testor_change_password( $proxy_id );
  } else if ( $code === 'api_testor_create_user' ) {
    g_api_testor_create_user( $proxy_id );
  } else if ( $code === 'api_testor_suite' ) {
    g_api_testor_suite( $proxy_id );
  } else if ( $code === 'api_testor_case' ) {
    g_api_testor_case( $proxy_id );
  } else if ( $code === 'api_testor_suite_case' ) {
    g_api_testor_suite_case( $proxy_id );
  } else if ( $code === 'api_testor_clean' ) {
    g_api_testor_clean( $proxy_id );
  } else if ( $code === 'api_testor_test' ) {
    g_api_testor_test( $proxy_id );
  } else if ( $code === 'api_testor_finish' ) {
    g_api_testor_finish( $proxy_id );
  } else if ( $code === 'api_testor_result' ) {
    g_api_testor_result( $proxy_id );
  } else if ( $code === 'api_testor_option' ) {
    g_api_testor_option( $proxy_id );
  } else if ( $code === 'api_testor_version' ) {
    g_api_testor_version( $proxy_id );
  } else if ( $code === 'api_testor_source' ) {
    g_api_testor_source( $proxy_id );
  } else if ( $code === 'api_testor_source_list' ) {
    g_api_testor_source_list( $proxy_id );
  } else if ( $code === 'api_testor_true' ) {
    g_api_testor_true( $proxy_id );
  } else if ( $code === 'api_testor_not_true' ) {
    g_api_testor_not_true( $proxy_id );
  } else if ( $code === 'api_testor_success' ) {
    g_api_testor_success( $proxy_id );
  } else if ( $code === 'api_testor_failed' ) {
    g_api_testor_failed( $proxy_id );
  } else if ( $code === 'api_testor_error' ) {
    g_api_testor_error( $proxy_id );
  } else if ( $code === 'api_testor_equals' ) {
    g_api_testor_equals( $proxy_id );
  } else if ( $code === 'api_testor_not_equals' ) {
    g_api_testor_not_equals( $proxy_id );
  } else if ( $code === 'api_testor_greater_than' ) {
    g_api_testor_greater_than( $proxy_id );
  } else if ( $code === 'api_testor_not_greater_than' ) {
    g_api_testor_not_greater_than( $proxy_id );
  } else if ( $code === 'api_testor_less_than' ) {
    g_api_testor_less_than( $proxy_id );
  } else if ( $code === 'api_testor_not_less_than' ) {
    g_api_testor_not_less_than( $proxy_id );
  } else if ( $code === 'api_testor_same' ) {
    g_api_testor_same( $proxy_id );
  } else if ( $code === 'api_testor_not_same' ) {
    g_api_testor_not_same( $proxy_id );
  } else if ( $code === 'api_testor_contains' ) {
    g_api_testor_contains( $proxy_id );
  } else if ( $code === 'api_testor_not_contains' ) {
    g_api_testor_not_contains( $proxy_id );
  } else if ( $code === 'api_testor_man' ) {
    g_api_testor_man( $proxy_id );
  } else {
    g_delete_proxy( $proxy_id );
  }
}

function g_sql_quote( $text ) {
  $text = str_replace( "'", "''", $text );
  $text = str_replace( '"', "\\" . '"', $text );
  $text = str_replace( "\n", "\\" . 'n', $text );
  $text = str_replace( "\r", "\\" . 'r', $text );
  $text = str_replace( "\t", "\\" . 't', $text );
  return $text;
}

function g_sql_quote_json( $text ) {
  $text = str_replace( "'", "''", $text );
  $text = str_replace( '"', "\\" . '"', $text );
  return $text;
}

function g_api_testor_login( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $username = g_sql_quote($obj['username']);
  $password = g_sql_quote($obj['password']);
  $sql = "set @v_token = '_'; call api_testor_login( @v_token, '$username', '$password' ); select @v_token;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $token = trim($lines[1]);
  $text = g_sql_quote("token: $token\n");
  $json = g_sql_quote( json_encode( array( 'token' => $token ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_logout( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $sql = "set @v_token = '$token'; call api_testor_logout( @v_token );";
  $text = g_mytestor_exec($sql);
  $text = g_sql_quote('');
  $json = g_sql_quote('{}');
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_is_online( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $sql = "set @v_token = '$token'; set @v_online = api_testor_is_online( @v_token ); select @v_online;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $result = trim($lines[1]);
  $text = g_sql_quote("result: $result\n");
  $json = g_sql_quote( json_encode( array( 'result' => $result ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_has_right( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $right_code = g_sql_quote($obj['right_code']);
  $sql = "set @v_token = '$token'; set @v_right_code = '$right_code'; set @v_right = api_testor_has_right( @v_token, @v_right_code ); select @v_right;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $result = trim($lines[1]);
  $text = g_sql_quote("result: $result\n");
  $json = g_sql_quote( json_encode( array( 'result' => $result ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_current_user( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $sql = "set @v_token = '$token'; set @v_user_id = -1; set @v_username = ''; call api_testor_current_user( @v_token, @v_user_id, @v_username ); select @v_user_id, @v_username;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $user_id = $fields[0];
  $username = $fields[1];
  $text = g_sql_quote("user_id: $user_id\nusername: $username\n");
  $json = g_sql_quote( json_encode( array( 'user_id' => $user_id, 'username' => $username ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_user_rights( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $sql = "set @v_token = '$token'; set @v_api_call = -1; set @v_user_make = -1; set @v_user_demo = -1; set @v_storage_full = -1; call api_testor_user_rights( @v_token, @v_api_call, @v_user_make, @v_user_demo, @v_storage_full ); select @v_api_call, @v_user_make, @v_user_demo, @v_storage_full;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $api_call = $fields[0];
  $user_make = $fields[1];
  $user_demo = $fields[2];
  $storage_full = $fields[3];
  $text = g_sql_quote("api_call: $api_call\nuser_make: $user_make\nuser_demo: $user_demo\nstorage_full: $storage_full\n");
  $json = g_sql_quote( json_encode( array( 'api_call' => $api_call, 'user_make' => $user_make, 'user_demo' => $user_demo, 'storage_full' => $storage_full ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_change_password( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $password = g_sql_quote($obj['password']);
  $sql = "set @v_token = '$token'; set @v_password = '$password'; call api_testor_change_password( @v_token, @v_password );";
  $text = g_mytestor_exec($sql);
  $text = g_sql_quote('');
  $json = g_sql_quote('{}');
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_create_user( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $username = g_sql_quote($obj['username']);
  $password = g_sql_quote($obj['password']);
  $api_call = g_sql_quote($obj['api_call']);
  $user_make = g_sql_quote($obj['user_make']);
  $user_demo = g_sql_quote($obj['user_demo']);
  $quota = g_sql_quote($obj['quota']);
  $sql = "set @v_token = '$token'; set @v_username = '$username'; set @v_password = '$password'; set @v_api_call = cast('$api_call' as signed); set @v_user_make = cast('$user_make' as signed); set @v_user_demo = cast('$user_demo' as signed); set @v_quota = cast('$quota' as signed); call api_testor_create_user( @v_token, @v_username, @v_password, @v_api_call, @v_user_make, @v_user_demo, @v_quota );";
  $text = g_mytestor_exec($sql);
  $text = g_sql_quote('');
  $json = g_sql_quote('{}');
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_suite( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $code = g_sql_quote($obj['code']);
  $sql = "set @v_token = '$token'; set @v_code = '$code'; set @v_suite_id = -1; call api_testor_suite( @v_token, @v_suite_id, @v_code ); select @v_suite_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $suite_id = $fields[0];
  $text = g_sql_quote("suite_id: $suite_id\n");
  $json = g_sql_quote( json_encode( array( 'suite_id' => $suite_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_case( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $code = g_sql_quote($obj['code']);
  $sql = "set @v_token = '$token'; set @v_code = '$code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = -1; call api_testor_case( @v_token, @v_case_id, @v_suite_id, @v_code ); select @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $case_id = $fields[0];
  $text = g_sql_quote("case_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_suite_case( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_code = g_sql_quote($obj['suite_code']);
  $case_code = g_sql_quote($obj['case_code']);
  $sql = "set @v_token = '$token'; set @v_suite_code = '$suite_code'; set @v_case_code = '$case_code'; set @v_suite_id = -1; set @v_case_id = -1; call api_testor_suite_case( @v_token, @v_suite_id, @v_case_id, @v_suite_code, @v_case_code ); select @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $suite_id = $fields[0];
  $case_id = $fields[1];
  $text = g_sql_quote("suite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_clean( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); call api_testor_clean( @v_token, @v_suite_id );";
  $text = g_mytestor_exec($sql);
  $text = g_sql_quote('');
  $json = g_sql_quote('{}');
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_test( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $condition = g_sql_quote($obj['condition']);
  $message = g_sql_quote($obj['message']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_condition = cast('$condition' as signed); set @v_message = '$message'; call api_testor_test( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_condition, @v_message ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_finish( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); call api_testor_finish( @v_token, @v_suite_id );";
  $text = g_mytestor_exec($sql);
  $data = array( 'errors' => [], 'status' => [], 'hints' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 3 ) {
      if ( trim( $fields[0] ) === 'case' ) continue;
      $it = array( 'case' => $fields[0], 'test' => $fields[1], 'message' => $fields[2] );
      array_push( $data['errors'], $it );
    } else if ( count( $fields ) === 8 ) {
      if ( trim( $fields[0] ) === 'version' ) continue;
      $it = array( 'version' => $fields[0], 'status' => $fields[1], 'code' => $fields[2], 'id' => $fields[3], 'success_count' => $fields[4], 'failed_count' => $fields[5], 'test_count' => $fields[6], 'case_count' => $fields[7] );
      array_push( $data['status'], $it );
    } else if ( count( $fields ) === 2 ) {
      if ( trim( $fields[0] ) === 'To re-print:' ) continue;
      $it = array( 'reprint' => $fields[0], 'get_source' => $fields[1] );
      array_push( $data['hints'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( str_replace("\\\\n", "__nl__", json_encode( $data ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_result( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); call api_testor_result( @v_token, @v_suite_id );";
  $text = g_mytestor_exec($sql);
  $data = array( 'errors' => [], 'status' => [], 'hints' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 3 ) {
      if ( trim( $fields[0] ) === 'case' ) continue;
      $it = array( 'case' => $fields[0], 'test' => $fields[1], 'message' => $fields[2] );
      array_push( $data['errors'], $it );
    } else if ( count( $fields ) === 8 ) {
      if ( trim( $fields[0] ) === 'version' ) continue;
      $it = array( 'version' => $fields[0], 'status' => $fields[1], 'code' => $fields[2], 'id' => $fields[3], 'success_count' => $fields[4], 'failed_count' => $fields[5], 'test_count' => $fields[6], 'case_count' => $fields[7] );
      array_push( $data['status'], $it );
    } else if ( count( $fields ) === 2 ) {
      if ( trim( $fields[0] ) === 'To re-print:' ) continue;
      $it = array( 'reprint' => $fields[0], 'get_source' => $fields[1] );
      array_push( $data['hints'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( str_replace("\\\\n", "__nl__", json_encode( $data ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_option( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $data = g_sql_quote($obj['data']);
  $code = g_sql_quote($obj['code']);
  $remove = g_sql_quote($obj['remove']);
  if ( $data === 'NULL' || $data === 'null' || $data === '"NULL"' || $data === '"null"' ) {
    $data = 'NULL';
  } else {
    $data = "'$data'";
  }
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_data = $data; set @v_code = '$code'; set @v_remove = cast('$remove' as signed); call api_testor_option( @v_token, @v_suite_id, @v_data, @v_code, @v_remove ); select @v_data;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $data = $fields[0];
  if ( strpos( $code, 'ver:' ) === 0 ) {
    $data = str_replace( '"', '__dq__', $data . '' );
    $data = str_replace( ':', '__cl__', $data . '' );
    $data = str_replace( ':', '__mn__', $data . '' );
  }
  $text = g_sql_quote("data: $data\n");
  $json = g_sql_quote( json_encode( array( 'data' => $data ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_version( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $cur_ver = g_sql_quote($obj['cur_ver']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_cur_ver = cast('$cur_ver' as signed); call api_testor_version( @v_token, @v_suite_id, @v_cur_ver );";
  $text = g_mytestor_exec($sql);
  $text = g_sql_quote('');
  $json = g_sql_quote('{}');
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_source( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_code = g_sql_quote($obj['case_code']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_code = '$case_code'; call api_testor_source( @v_token, @v_suite_id, @v_case_code );";
  $text = g_mytestor_exec($sql);
  $data = array( 'kvs' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 2 ) {
      if ( trim( $fields[0] ) === 'Key' ) continue;
      $it = array( 'key' => $fields[0], 'value' => $fields[1] );
      array_push( $data['kvs'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( json_encode( $data ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_source_list( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $page_no = g_sql_quote($obj['page_no']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_page_no = cast('$page_no' as signed); call api_testor_source_list( @v_token, @v_suite_id, @v_page_no );";
  $text = g_mytestor_exec($sql);
  $data = array( 'kvs' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 4 ) {
      if ( trim( $fields[0] ) === 'rel_key' ) continue;
      $it = array( 'rel_key' => $fields[0], 'abs_key' => $fields[1], 'rel_value' => $fields[2], 'abs_value' => $fields[3] );
      array_push( $data['kvs'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( json_encode( $data ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_true( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $condition = g_sql_quote($obj['condition']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_condition = cast('$condition' as signed); call api_testor_true( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_condition ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_not_true( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $condition = g_sql_quote($obj['condition']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_condition = cast('$condition' as signed); call api_testor_not_true( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_condition ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_success( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $page_no = g_sql_quote($obj['page_no']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_page_no = cast('$page_no' as signed); call api_testor_success( @v_token, @v_suite_id, @v_page_no );";
  $text = g_mytestor_exec($sql);
  $data = array( 'successes' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 3 ) {
      if ( trim( $fields[0] ) === 'case' ) continue;
      $it = array( 'case' => $fields[0], 'test' => $fields[1], 'message' => $fields[2] );
      array_push( $data['successes'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( str_replace("\\\\n", "__nl__", json_encode( $data ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_failed( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $page_no = g_sql_quote($obj['page_no']);
  $sql = "set @v_token = '$token'; set @v_suite_id = cast('$suite_id' as signed); set @v_page_no = cast('$page_no' as signed); call api_testor_failed( @v_token, @v_suite_id, @v_page_no );";
  $text = g_mytestor_exec($sql);
  $data = array( 'faileds' => [] );
  $lines = explode("\n", $text);
  foreach ( $lines as $ln ) {
    $ln = trim($ln);
    if ( $ln === '' ) continue;
    $fields = explode("\t", $ln);
    if ( count( $fields ) === 3 ) {
      if ( trim( $fields[0] ) === 'case' ) continue;
      $it = array( 'case' => $fields[0], 'test' => $fields[1], 'message' => $fields[2] );
      array_push( $data['faileds'], $it );
    }
  }
  $text = g_sql_quote($text);
  $json = g_sql_quote( str_replace("\\\\n", "__nl__", json_encode( $data ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_error( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $message = g_sql_quote($obj['message']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_message = '$message'; call api_testor_error( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_message ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_number( $proxy_id, $proc ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $operand = g_sql_quote($obj['operand']);
  $value = g_sql_quote($obj['value']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_operand = $operand; set @v_value = $value; call $proc( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_operand, @v_value ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_string( $proxy_id, $proc ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $token = g_sql_quote($obj['token']);
  $test_code = g_sql_quote($obj['test_code']);
  $suite_id = g_sql_quote($obj['suite_id']);
  $case_id = g_sql_quote($obj['case_id']);
  $operand = g_sql_quote($obj['operand']);
  $value = g_sql_quote($obj['value']);
  $sql = "set @v_token = '$token'; set @v_test_code = '$test_code'; set @v_suite_id = cast('$suite_id' as signed); set @v_case_id = cast('$case_id' as signed); set @v_operand = '$operand'; set @v_value = '$value'; call $proc( @v_token, @v_test_id, @v_suite_id, @v_case_id, @v_test_code, @v_operand, @v_value ); select @v_test_id, @v_suite_id, @v_case_id;";
  $text = g_mytestor_exec($sql);
  $lines = explode("\n", $text);
  $ln = trim($lines[1]);
  $fields = explode("\t", $ln);
  $test_id = $fields[0];
  $suite_id = $fields[1];
  $case_id = $fields[2];
  $text = g_sql_quote("test_id: $test_id\nsuite_id: $suite_id\ncase_id: $case_id\n");
  $json = g_sql_quote( json_encode( array( 'test_id' => $test_id, 'suite_id' => $suite_id, 'case_id' => $case_id ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_api_testor_equals( $proxy_id ) {
  $proc = 'api_testor_equals';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_not_equals( $proxy_id ) {
  $proc = 'api_testor_not_equals';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_greater_than( $proxy_id ) {
  $proc = 'api_testor_greater_than';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_not_greater_than( $proxy_id ) {
  $proc = 'api_testor_not_greater_than';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_less_than( $proxy_id ) {
  $proc = 'api_testor_less_than';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_not_less_than( $proxy_id ) {
  $proc = 'api_testor_not_less_than';
  g_api_testor_number( $proxy_id, $proc );
}

function g_api_testor_same( $proxy_id ) {
  $proc = 'api_testor_same';
  g_api_testor_string( $proxy_id, $proc );
}

function g_api_testor_not_same( $proxy_id ) {
  $proc = 'api_testor_not_same';
  g_api_testor_string( $proxy_id, $proc );
}

function g_api_testor_contains( $proxy_id ) {
  $proc = 'api_testor_contains';
  g_api_testor_string( $proxy_id, $proc );
}

function g_api_testor_not_contains( $proxy_id ) {
  $proc = 'api_testor_not_contains';
  g_api_testor_string( $proxy_id, $proc );
}

function g_api_testor_man( $proxy_id ) {
  $sql = "set @v_json = '{}'; set @v_text = ''; call testor_proxy_get_request($proxy_id, @v_json, @v_text); select @v_json;";
  $text = g_mytestorproxy_exec($sql);
  $lines = explode( "\n", $text );
  $json = trim($lines[1]);
  $obj = json_decode( $json, true );
  $module = g_sql_quote($obj['module']);
  $kind = g_sql_quote($obj['kind']);
  $code = g_sql_quote($obj['code']);
  $sql = "set @v_man = ''; call api_testor_man( '$module', '$kind', '$code', @v_man ); select @v_man as manual\\G";
  $text = g_mytestor_exec($sql);
  $pos = strpos( $text, 'manual:' );
  if ( $pos !== false ) {
    $text = trim( substr( $text, $pos + 7 ) );
  } else {
    $text = trim( $text );
  }
  $text = "\n" . $text . "\n";
  $text = str_replace( "\n", "__nl__", $text );
  $text = str_replace( "\r", "__cr__", $text );
  $text = str_replace( '"', "__dq__", $text );
  $text = str_replace( "'", "__sq__", $text );
  $text = str_replace( "`", "__td__", $text );
  $text = str_replace( "\\", "__sl__", $text );
  $man = $text;
  $text = g_sql_quote( $text );
  $json = g_sql_quote( json_encode( array( 'man' => $man ) ) );
  $sql = "set @v_json = '$json'; set @v_text = '$text'; call testor_proxy_reply($proxy_id, @v_json, @v_text);";
  g_mytestorproxy_exec( $sql );
}

function g_halt() {
  $text = @file_get_contents( __DIR__ . '/agent.sig' );
  $text = strtolower( trim( $text ) );
  if ( $text == 'y' ) return true;
  return false;
}

echo "\n[A] Started myTestorProxy ...\n";

while ( ! g_halt() ) {
  $reqs = g_proxy_id_list();
  foreach ( $reqs as $item ) {
    g_process_proxy( $item );
  }
  sleep( $g_config['sleep_time'] );
}

echo "\n[A] Finished myTestorProxy ...\n";
?>
