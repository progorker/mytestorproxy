<?php
/*
 * Copyright (c) 2026 Dinh Thoai Tran <zinospetrel@sdf.org>
 * All rights reserved.
 *
 * + Source URL: https://github.com/progorker/pgk_mytestorproxy/
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

function g_ppattern( $p_module, $p_kind, $p_code, $p_variant ) {
  $module = g_escape( $p_module );
  $kind = g_escape( $p_kind );
  $code = g_escape( $p_code );
  $variant = g_escape( $p_variant );
  $sql = "set @v_pattern = '_'; set @v_module = mytestorproxy.api_testor_unescape('$module'); set @v_kind = mytestorproxy.api_testor_unescape('$kind'); set @v_code = mytestorproxy.api_testor_unescape('$code'); set @v_variant = mytestorproxy.api_testor_unescape('$variant'); call mytestorproxy.api_testor_pattern( @v_module, @v_kind, @v_code, @v_variant, @v_pattern ); select @v_pattern as pattern\\G";
  $text = g_mytestorproxy_exec( $sql );
  $uid = substr( strrev( uniqid() ), 0, 4 );
  $path = '/tmp/' . $uid . '.txt';
  file_put_contents( $path, $text );
  echo "\n";
  echo "======] myTestor -:- pattern [=====\n\n";
  echo "File: $path\n\n";
  echo "===================================\n\n";
  echo $text;
  echo "\n";
  echo "======] myTestor -:- pattern [=====\n\n";
  echo "File: $path\n\n";
  echo "===================================\n\n";
}

function g_pattern( $p_module, $p_kind, $p_code, $p_variant ) {
  $module = g_escape( $p_module );
  $kind = g_escape( $p_kind );
  $code = g_escape( $p_code );
  $variant = g_escape( $p_variant );
  $sql = "set @v_pattern = '_'; set @v_module = api_testor_unescape('$module'); set @v_kind = api_testor_unescape('$kind'); set @v_code = api_testor_unescape('$code'); set @v_variant = api_testor_unescape('$variant'); call api_testor_pattern( @v_module, @v_kind, @v_code, @v_variant, @v_pattern ); select @v_pattern as pattern\\G";
  $text = g_mytestor_exec( $sql );
  $uid = substr( strrev( uniqid() ), 0, 4 );
  $path = '/tmp/' . $uid . '.txt';
  file_put_contents( $path, $text );
  echo "\n";
  echo "======] myTestor -:- pattern [=====\n\n";
  echo "File: $path\n\n";
  echo "===================================\n\n";
  echo $text;
  echo "\n";
  echo "======] myTestor -:- pattern [=====\n\n";
  echo "File: $path\n\n";
  echo "===================================\n\n";
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

function g_escape( $sql ) {
  $sql = str_replace( "_", "_._us_._", $sql );
  $sql = str_replace( "\n", "__nl__", $sql );
  $sql = str_replace( "\r", "__cr__", $sql );
  $sql = str_replace( "\t", "__tb__", $sql );
  $sql = str_replace( "\\", "__sl__", $sql );
  $sql = str_replace( '"', "__dq__", $sql );
  $sql = str_replace( "'", "__sq__", $sql );
  $sql = str_replace( "`", "__td__", $sql );
  return $sql;
}

function g_unescape( $sql ) {
  $sql = str_replace( "__nl__", "\n", $sql );
  $sql = str_replace( "__cr__", "\r", $sql );
  $sql = str_replace( "__tb__", "\t", $sql );
  $sql = str_replace( "__sl__", "\\", $sql );
  $sql = str_replace( "__dq__", '"', $sql );
  $sql = str_replace( "__sq__", "'", $sql );
  $sql = str_replace( "__td__", "`", $sql );
  $sql = str_replace( "_._us_._", "_", $sql );
  return $sql;
}

function g_help() {
  echo "\n";
  echo "======] myTestor -:- pattern [=====\n\n";
  echo "php pattern.php [p|c] <module> <kind> <code> <variant>\n\n";
  echo "===================================\n\n";
}

$aidx = 1;
$num_args = 4;

if ( $aidx + $num_args > $argc ) {
  g_help();
  exit();
}

$srv = $argv[ $aidx ];
if ( $srv === 'p' || $srv === 'c' ) {
  $aidx++;
  if ( $aidx + $num_args > $argc ) {
    g_help();
    exit();
  }
} else {
  $srv = 'c';
}
if ( $srv === 'p' ) {
  g_ppattern( $argv[ $aidx ], $argv[ $aidx + 1 ], $argv[ $aidx + 2 ], $argv[ $aidx + 3 ] );
} else {
  g_pattern( $argv[ $aidx ], $argv[ $aidx + 1 ], $argv[ $aidx + 2 ], $argv[ $aidx + 3 ] );
}
?>