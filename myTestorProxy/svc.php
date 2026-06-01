<?php
/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/mytestorproxy/
 *
 * + License: GPL-2.0
 */

global $g_config, $g_cur_ver, $g_token, $g_sleep_time;

require_once __DIR__ . '/svc-cfg.php';

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

function g_login() {
  global $g_config, $g_token;
  $username = $g_config['worked.username'];
  $password = $g_config['worked.password'];
  $sql = "set @v_token = '_'; set @v_username = '$username'; set @v_password = '$password'; call mytestorproxy.api_testor_login( @v_token, @v_username, @v_password ); select @v_token;";
  $text = g_mytestorproxy_exec( $sql );
  $lines = explode( "\n", $text );
  $g_token = trim( $lines[1] );
}

function g_read_cur_ver() {
  global $g_config;
  $data_dir = $g_config['data_dir'];
  $inf_dir = $data_dir . '/ver/inf';
  @mkdir( $inf_dir, 0777, true );
  $inf_file = $inf_dir . '/cur.lst';
  $text = @file_get_contents( $inf_file );
  $text = trim( $text );
  return intval( $text );
}

function g_update_cur_ver() {
  $inf_dir = $data_dir . '/ver/inf';
  @mkdir( $inf_dir, 0777, true );
  $inf_file = $inf_dir . '/cur.lst';
  @file_put_contents( $inf_file, $g_cur_ver );
}

function g_cur_ver() {
  global $g_config, $g_token;
  $suite_code = $g_config['worked.suite_code'];
  $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); set @v_data = NULL; call mytestorproxy.api_testor_option( @v_token, @v_suite_id, @v_data, 'ver:cur', false ); select @v_data;";
  $text = g_mytestorproxy_exec( $sql );
  $text = trim( $text );
  if ( $text === '' ) return 1;
  $lines = explode( "\n", $text );
  if ( count( $lines ) < 2 ) return 1;
  $str = trim( $lines[1] );
  $str = str_replace( '"', '', $str );
  return intval( $str );
}

function g_halt() {
  global $g_config;
  $data_dir = $g_config['data_dir'];
  $text = @file_get_contents( $data_dir . '/svc.sig' );
  $text = strtolower( trim( $text ) );
  if ( $text == 'y' ) return true;
  return false;
}

function g_test_results() {
  global $g_config, $g_token;
  $suite_code = $g_config['worked.suite_code'];
  $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); call mytestorproxy.api_testor_result( @v_token, @v_suite_id )\\G";
  $text = g_mytestorproxy_exec( $sql );
  return $text;
}

function g_test_json( $ver ) {
  global $g_config, $g_token;
  $suite_code = $g_config['worked.suite_code'];
  $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); set @v_data = NULL; call mytestorproxy.api_testor_option( @v_token, @v_suite_id, @v_data, 'ver:$ver', false ); select @v_data;";
  $text = g_mytestorproxy_exec( $sql );
  $text = trim( $text );
  if ( $text === '' ) return false;
  $lines = explode( "\n", $text );
  $str = trim( $lines[1] );
  if ( $str[0] === '"' ) {
    $str = substr( $str, 1 );
  }
  if ( $str[strlen($str) - 1] === '"' ) {
    $str = substr( $str, 0, strlen( $str ) - 1 );
  }
  $str = str_replace( '__dq__', '"',  $str . '' );
  $str = str_replace( '__cl__', ':', $str . '' );
  $str = str_replace( '__mn__', ':', $str . '' );
  $nstr = '';
  $pos = strpos( $str, '"c":"' );
  if ( $pos !== false ) {
    $nstr = substr( $str, 0, $pos + 5 );
    $str = substr( $str, $pos + 5 );
    $pos = strpos( $str, ' -:- ' );
    if ( $pos !== false ) {
      $nstr .= substr( $str, $pos + 5 );
    } else {
      $nstr .= $str;
    }
  } else {
    $nstr = $str;
  }
  return $nstr;
}

function g_test_success() {
  global $g_config, $g_token;
  $suite_code = $g_config['worked.suite_code'];
  $all_text = '';
  $no = 1;
  do {
    $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); call mytestorproxy.api_testor_success( @v_token, @v_suite_id, $no )\\G";
    $text = g_mytestorproxy_exec( $sql );
    $all_text .= "\n" . $text;
    $no++;
  } while ( trim( $text ) !== '' );
  return $all_text;
}

function g_test_failed() {
  global $g_config, $g_token;
  $suite_code = $g_config['worked.suite_code'];
  $all_text = '';
  $no = 1;
  do {
    $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); call mytestorproxy.api_testor_failed( @v_token, @v_suite_id, $no )\\G";
    $text = g_mytestorproxy_exec( $sql );
    $all_text .= "\n" . $text;
    $no++;
  } while ( trim( $text ) !== '' );
  return $all_text;
}

function g_save_ver( $ver ) {
  global $g_config;
  $ver_json = g_test_json( $ver );
  if ( $ver_json === false ) return;
  $data_dir = $g_config['data_dir'];
  $inf_dir = $data_dir . '/ver/inf';
  @mkdir( $inf_dir, 0777, true );
  file_put_contents( $inf_dir . '/' . $ver . '.text', g_test_results() );
  file_put_contents( $inf_dir . '/' . $ver . '.s.text', g_test_success() );
  file_put_contents( $inf_dir . '/' . $ver . '.f.text', g_test_failed() );
  file_put_contents( $inf_dir . '/' . $ver . '.json', $ver_json );
}

function g_backup_ver( $ver ) {
  global $g_config, $g_token;
  $ver_json = g_test_json( $ver );
  if ( $ver_json === false ) return;
  $suite_code = $g_config['worked.suite_code'];
  $data_dir = $g_config['data_dir'];
  $dld_dir = $data_dir . '/ver/dld';
  @mkdir( $dld_dir, 0777, true );
  $tmp_dir = $data_dir . '/ver/tmp/' . $ver;
  @mkdir( $tmp_dir, 0777, true );
  $ver_dir = $tmp_dir . '/' . $ver;
  @mkdir( $ver_dir, 0777, true );
  echo "\n[B] Backup v.$ver ...\n";
  $data = [];
  $no = 1;
  do {
    $cnt = 0;
    $sql = "set @v_token = '$g_token'; set @v_suite_id = -1; call mytestorproxy.api_testor_suite( @v_token, @v_suite_id, '$suite_code' ); call mytestorproxy.api_testor_source_list( @v_token, @v_suite_id, $no );";
    $text = g_mytestorproxy_exec( $sql );
    if ( trim( $text ) !== '' ) {
      $lines = explode("\n", $text);
      foreach ( $lines as $ln ) {
        $ln = trim($ln);
        if ( $ln === '' ) continue;
        $fields = explode("\t", $ln);
        if ( count( $fields ) === 4 ) {
          if ( trim( $fields[0] ) === 'rel_key' ) continue;
          $it = array( 'rel_key' => $fields[0], 'abs_key' => $fields[1], 'rel_value' => $fields[2], 'abs_value' => $fields[3] );
          array_push( $data, $it );
          $cnt++;
        }
      }
    }
    $no++;
  } while ( $cnt > 0 );
  $flist = "";
  foreach ( $data as $it ) {
    $ln = $it['rel_value'];
    $sr = $data_dir . $ln;
    if ( ! file_exists( $sr ) ) continue;
    $fn = $ver_dir . $ln;
    $fd = dirname( $fn );
    @mkdir( $fd, 0777, true );
    file_put_contents( $fn, file_get_contents( $sr ) );
    echo "\n[BI] $ln ...";
    $flist .= "\n$ln";
  }
  file_put_contents( "$tmp_dir/$ver/files.lst", trim( $flist ) );
  $cmd = "cd $tmp_dir && zip -r $dld_dir/$ver.zip $ver";
  @shell_exec( $cmd );
  echo "\n[B] Zip to $dld_dir/$ver.zip ... ";
  $cmd = "rm -rf $tmp_dir";
  @shell_exec( $cmd );
}

echo "[SVC] Started Source Version Controller ...\n";

g_login();

echo "Token: ", $g_token, "\n";
$g_cur_ver = g_cur_ver();
echo "Version: ", $g_cur_ver, "\n";
$g_sleep_time = $g_config['worked.sleep_time'];

while ( ! g_halt() ) {
  $ver = g_cur_ver();
  if ( $ver > $g_cur_ver ) {
    echo "\n[U] cur.ver: $g_cur_ver --> new.ver: $ver\n";
    g_save_ver( $ver );
    g_backup_ver( $ver );
    $g_cur_ver = $ver;
  }
  sleep( $g_sleep_time );
}

echo "[SVC] Finished Source Version Controller ...\n";
?>