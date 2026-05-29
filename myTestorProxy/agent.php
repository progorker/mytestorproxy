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
  $sql = "call testor_proxy_list_requests();";
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
  } else {
    g_delete_proxy( $proxy_id );
  }
}

function g_sql_quote( $text ) {
  $text = str_replace( "'", "''", $text );
  $text = str_replace( '"', "\\" . '"', $text );
  $text = str_replace( "\n", "\\" . 'n', $text );
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
