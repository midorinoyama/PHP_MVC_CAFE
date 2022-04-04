<?php
//ROOT_PATHは定数名、変更されない値（＝ドキュメントルートのpublicを表示させない）
define('ROOT_PATH', str_replace('public', '', $_SERVER["DOCUMENT_ROOT"]));

//現在のURLをhost・path・query・fragmentに分解
$parse = parse_url($_SERVER["REQUEST_URI"]);

// ファイル名が省略されていた場合は、index.phpを補填する
if (mb_substr($parse['path'], -1) === '/') { //pathの後ろが/の場合
    //path = path.現在のスクリプトのパス
    $parse['path'] .= $_SERVER["SCRIPT_NAME"];
}
require_once(ROOT_PATH.'Views'.$parse['path']);
