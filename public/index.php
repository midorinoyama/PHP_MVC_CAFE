<?php
//publicが最初に読み込まれるルート、publicを空白に置き換える
define('ROOT_PATH', str_replace('public', '', $_SERVER["DOCUMENT_ROOT"]));
//パースは解析する
$parse = parse_url($_SERVER["REQUEST_URI"]);
// ファイル名が省略されていた場合は、index.phpを補填する
if (mb_substr($parse['path'], -1) === '/') {
    $parse['path'] .= $_SERVER["SCRIPT_NAME"];
}
require_once(ROOT_PATH.'Views'.$parse['path']);
