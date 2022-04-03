<?php
//処理振り分けを担当
//require_once(ROOT_PATH .'Models/Contact.php');

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
        $dbh = $this->Contact->get_db_handler();
    }

    public function index()
    {
        $page = 0;
        if (isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $contacts = $this->Contact->findAll($page);
        $contacts_count = $this->Contact->countAll();
        $params = [
            'contacts' => $contacts,
            'pages' => $contacts_count / 20,
            'page' => $page // ページ番号
        ];
        return $params;
    }
}
