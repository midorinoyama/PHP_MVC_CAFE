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
        $name  = htmlspecialchars($_SESSION["name"], ENT_QUOTES, "UTF-8");
        $kana  = htmlspecialchars($_SESSION["kana"], ENT_QUOTES, "UTF-8");
        $tel   = htmlspecialchars($_SESSION["tel"], ENT_QUOTES, "UTF-8");
        $email = htmlspecialchars($_SESSION["email"], ENT_QUOTES, "UTF-8");
        $body  = htmlspecialchars($_SESSION["body"], ENT_QUOTES, "UTF-8");

        try {
            //トランザクション開始(仮実行)
            $this->dbh->beginTransaction();
            //SQL文を実行する準備（prepareで構文チェック）
            $sql = "INSERT INTO contacts(name, kana, tel, email, body)
            VALUES(:name, :kana, :tel, :email, :body)";
            //プリペアドステートメントを用意
            $stmt = $this->dbh->prepare($sql);
            //値をバインド
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":kana", $kana, PDO::PARAM_STR);
            $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":body", $body, PDO::PARAM_STR);

            //プリペアドステートメント(クエリ)を実行
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
            $sql = "SELECT * FROM contacts ORDER BY created_at ASC";
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
