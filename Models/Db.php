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
                $this->dbh = new PDO($dsn, $user, $password);
                // 接続成功
            } catch (PDOException $e) {
                echo "接続失敗: " . $e->getMessage() . "\n";
                exit();
            }
        } else { // 接続情報が存在する場合
            $this->dbh = $dbh;
        }
    }

    public function get_db_handler()
    {
        return $this->dbh;
    }

    public function begin_transaction()
    {
        $this->dbh->beginTransaction();
    }

    public function commit()
    {
        $this->dbh->commit();
    }

    public function rollback()
    {
        $this->dbh->rollback();
    }
}
