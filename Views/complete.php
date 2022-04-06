<?php
require('../Controllers/ContactController.php');
//ダイレクトアクセス禁止
$referer = $_SERVER["HTTP_REFERER"];//ユーザー側のアクセス元ページ
$url = "confirm.php";//こちらが指定するアクセス元ページ
//指定するアクセス元と違った場合、引数の$urlに遷移させる
if (!strstr($referer, $url)) {
    header("Location: contact.php");
    exit;
}

//*confirm画面でcreateすると、編集した場合、編集前の情報もDBに登録される
$content = new ContactController();
$all = $content->create();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Casteria</title>
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script defer src="../js/index.js"></script>
</head>
<body>
  <h3>完了画面</h3>
    <p>お問い合わせ内容を送信しました。</p>
    <p>ありがとうございました。</p>
    <a href="./index.php">トップへ</a>
</body>
</html>