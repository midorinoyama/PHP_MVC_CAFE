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
$data = $content->create();

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script defer src="../js/index.js"></script>
</head>
<body>
    <div class="main">
        <div class="container-fruid">
            <?php include("header.php") ?>
            <div class="row my-3">
                <div class="col-md-12 col-xs-12">
                    <h2 class="head-title my-3 text-center">完了画面</h2>
                    <p class="contents text-center">
                        お問い合わせ内容を送信しました。<br>
                        ありがとうございました
                    </p>
                    <div class="text-center">
                        <a class="btn btn-info btn-sm" href="./index.php">トップへ戻る</a>
                    </div>
            </div>
            </div>
            <?php include("footer.php") ?>
        </div>
    </div>
</body>
</html>