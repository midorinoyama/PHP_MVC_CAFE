<?php
//処理振り分けを担当
require_once('../Models/Contact.php');

class ContactController
{
    private $request;   // リクエストパラメータ(GET,POST)
    private $Contact;    // Contactモデル

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->Contact = new Contact();
        // 別モデルと連携
        $dbh = $this->Contact->getDbHandler();
    }

    public function create()
    {
        $this->Contact->create();
    }

    public function index()
    {
        //モデル内のデータをコントロールで受け取らないと、Viewsでインスタンス化してもNULLになる
        $contacts = $this->Contact->findAll();
        return $contacts;
    }

    public function edit()
    {
        $edits = $this->Contact->edit();
        return $edits;
    }

    public function update()
    {
        $this->Contact->update();
    }

    public function delete()
    {
        $this->Contact->delete();
    }
}
