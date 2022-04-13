<?php

// ドライバ呼び出しを使用してデータベースに接続（DB接続情報）
$dsn = 'mysql:dbname=casteria;host=localhost;charset=utf8';
$user = 'root';
$password = 'xampp1235';

// 例外処理
try {
    //接続に成功
    $dbh = new PDO($dsn, $user, $password, [
        //エラーが起こった際に、例外(PDOException)をなげる
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //配列のパターン設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
} catch (PDOException $e) {
    //接続に失敗した場合にメッセージ表示
    echo "接続失敗:" . $e->getMessage(). "\n";
    exit();
}
