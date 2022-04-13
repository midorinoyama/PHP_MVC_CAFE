<?php
require('../Controllers/ContactController.php');
//ダイレクトアクセス禁止
$referer = $_SERVER["HTTP_REFERER"];
$url = "contact.php";
if (!strstr($referer, $url)) {
    header("Location: contact.php");
    exit;
}

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
      <div class="row">
        <div class="col-md-6 col-xs-12 mx-auto">
          <h2 class="head-title my-3 text-center">確認画面</h2>
          <form action="./complete.php" method="post"><!--次の画面に行く方法-->
            <div class="form-group">
              <label for="name">氏名</label>
              <div class="form-control" readonly>
                <?php echo htmlspecialchars($_SESSION["name"], ENT_QUOTES, "UTF-8") ?>
              </div>
            </div>
            <div class="form-group">
              <label for="kana">フリガナ</label>
              <div class="form-control" readonly>
                <?php echo htmlspecialchars($_SESSION["kana"], ENT_QUOTES, "UTF-8") ?>
              </div>
            </div>
            <div class="form-group">
              <label for="tel">電話番号</label>
              <div class="form-control" readonly>
                <?php echo htmlspecialchars($_SESSION["tel"], ENT_QUOTES, "UTF-8") ?>
              </div>
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
              <div class="form-control" readonly>
                <?php echo htmlspecialchars($_SESSION["email"], ENT_QUOTES, "UTF-8") ?>
              </div>
            </div>
            <div class="form-group">
              <label for="body">内容</label>
              <!--インデントを入れると行頭に空白が入るため注意-->
              <textarea class="form-control" rows="8" cols="40" readonly><?php echo htmlspecialchars($_SESSION["body"], ENT_QUOTES, "UTF-8"); ?></textarea>
            </div>
            <div class="form-group text-center">
              <input type="button" onclick="history.back()" value="キャンセル">
              <button type="submit" class="btn btn-primary">送信</button>
            </div>
          </form>
        </div>
      </div>
      <?php include("footer.php") ?>
    </div>
  </div>
</body>
</html>