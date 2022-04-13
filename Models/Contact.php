<?php
//データ操作やDB接続を担当,モデル＝テーブル
require_once('Db.php');
//セッションの期限切れ対策(入力エラー後の確認画面から戻るで値を保持できる)
session_cache_limiter("private_no_expire");
session_start();

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

    public function edit()
    {
        //レコードを特定
        $id = $_GET["id"];
        try {
            $this->dbh->beginTransaction();
            $sql = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            //$stmt->execute(array(":id" => $_GET["id"])); バインド省略可
            $stmt->execute();
            $result = 0;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->dbh->commit();
        } catch (PDOException $e) {
            $this->dbh->rollback();
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
        return $result;
    }

    public function update()
    {
        $_POST["id"]    = htmlspecialchars($_SESSION["id"], ENT_QUOTES, "UTF-8");
        $_POST["name"]  = htmlspecialchars($_SESSION["name"], ENT_QUOTES, "UTF-8");
        $_POST["kana"]  = htmlspecialchars($_SESSION["kana"], ENT_QUOTES, "UTF-8");
        $_POST["tel"]   = htmlspecialchars($_SESSION["tel"], ENT_QUOTES, "UTF-8");
        $_POST["email"] = htmlspecialchars($_SESSION["email"], ENT_QUOTES, "UTF-8");
        $_POST["body"]  = htmlspecialchars($_SESSION["body"], ENT_QUOTES, "UTF-8");

        try {
            //トランザクション開始(仮実行)
            $this->dbh->beginTransaction();
            //SQL文を実行する準備（prepareで構文チェック）
            $sql = "UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email, body = :body
            WHERE id = :id";
            //プリペアドステートメントを用意
            $stmt = $this->dbh->prepare($sql);
            //値をバインド
            $stmt->bindValue(":id", $_POST["id"], PDO::PARAM_INT);
            $stmt->bindValue(":name", $_POST["name"], PDO::PARAM_STR);
            $stmt->bindValue(":kana", $_POST["kana"], PDO::PARAM_STR);
            $stmt->bindValue(":tel", $_POST["tel"], PDO::PARAM_STR);
            $stmt->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $stmt->bindValue(":body", $_POST["body"], PDO::PARAM_STR);

            //プリペアドステートメント(クエリ)を実行
            $stmt->execute();
            //本実行
            $this->dbh->commit();
            header("Location: contact.php");
        } catch (PDOException $e) {
            //仮実行をキャンセル
            $this->dbh->rollback();
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    public function delete()
    {
        //レコードを特定
        $id = $_GET["id"];
        try {
            $this->dbh->beginTransaction();
            $sql = "DELETE FROM contacts WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->dbh->commit();
            //リダイレクト
            header("Location: contact.php");
        } catch (PDOException $e) {
            $this->dbh->rollback();
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }
}
