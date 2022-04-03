<?php
//データ操作やDB接続を担当,モデル＝テーブル
// require_once(ROOT_PATH .'Models/Db.php');

class Contact extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
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
    }

     // contactsテーブルから全データ数を取得

     // @return Int $count お問い合わせの全件数

    public function countAll():Int
    {
        $sql = 'SELECT count(*) as count FROM contacts';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
}
