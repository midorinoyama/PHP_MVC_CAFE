<?php
require_once('../database.php');

class Db
{
    protected $dbh;

    public function __construct($dbh = null)
    {
        if (!$dbh) { // 接続情報が存在しない場合
            $dsn = 'mysql:dbname=casteria;host=localhost;charset=utf8';
            $user = 'root';
            $password = 'xampp1235';

            // 例外処理
            try {
                $this->dbh = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
                // 接続成功
            } catch (PDOException $e) {
                echo "接続失敗: " . $e->getMessage() . "\n";
                exit();
            }
        } else { // 接続情報が存在する場合
            $this->dbh = $dbh;
        }
    }

    //データベースハンドラを参照する
    public function getDbHandler()
    {
        return $this->dbh;
    }

    //トランザクション開始(データの更新処理を仮実行)
    public function beginTransaction()
    {
        $this->dbh->beginTransaction();
    }

    //トランザクション処理の本実行
    public function commit()
    {
        $this->dbh->commit();
    }

    //トランザクション処理のキャンセル
    public function rollback()
    {
        $this->dbh->rollback();
    }
}
