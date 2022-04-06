<?php
//データ操作やDB接続を担当,モデル＝テーブル
require_once('Db.php');
// セッション登録開始
session_start();
//*入力チェックにエラーがあった後、確認画面でキャンセルするとフォーム再送信の確認がでてしまう
//セッションの有効期限切れ

class Contact extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    //データベースへ登録
    public function create()
    {
        $name  = $_SESSION['name'];
        $kana  = $_SESSION['kana'];
        $tel   = $_SESSION['tel'];
        $email = $_SESSION['email'];
        $body  = $_SESSION['body'];

        try {
            //トランザクション開始(仮実行)
            $this->dbh->beginTransaction();
            //SQL文を実行する準備（prepareで構文チェック）
            $sql = "INSERT INTO contacts(name, kana, tel, email, body)
            VALUES('$name', '$kana', '$tel', '$email', '$body')";
            $stmt = $this->dbh->prepare($sql);
            //クエリを実行
            $stmt->execute();
            //本実行
            $this->dbh->commit();
        } catch (PDOException $e) {
            //仮実行をキャンセル
            $this->dbh->rollback();
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    public function findAll()
    {
        try {
            $this->dbh->beginTransaction();
            $sql = "SELECT * FROM contacts";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
            //カラム名(key)で配列を取得
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->dbh->rollback();
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
        return $result;
    }

    /*
    // contactテーブルからデータをすべて取得（20件ごと）
    public function findAll($page = 0):Array
    {
        $sql = 'SELECT';
        $sql .= ' contacts.id,';
        $sql .= ' contacts.name,';
        $sql .= ' contacts.kana,';
        $sql .= ' contacts.tel,';
        $sql .= ' contacts.email';
        $sql .= ' contacts.body,';
        $sql .= ' contacts.created_at,';
        $sql .= ' FROM contacts';
        $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }*/

     // contactsテーブルから全データ数を取得

     // @return Int $count お問い合わせの全件数
    /*
    public function countAll():Int
    {
        $sql = 'SELECT count(*) as count FROM contacts';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }*/
}
