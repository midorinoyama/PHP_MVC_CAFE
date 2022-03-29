<?php
// セッション登録開始
session_start();

// データベースに接続
//require('../database.php')

$mode = "input";
if (isset($_POST["back"]) && $_POST["back"]) {
  //
} elseif (isset($_POST["confirm"]) && $_POST["confirm"]) {
    // 受け取った値をセッション変数に保持、キャンセルで戻ったページで表示
    $_SESSION["name"]  = $_POST["name"];
    $_SESSION["kana"]  = $_POST["kana"];
    $_SESSION["tel"]   = $_POST["tel"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["body"]  = $_POST["body"];
    $mode = "confirm";
} elseif (isset($_POST["send"]) && $_POST["send"]) {
    $mode = "send";
} else {
    //  セッションの初期化
    $_SESSION["name"]  = "";
    $_SESSION["kana"]  = "";
    $_SESSION["tel"]   = "";
    $_SESSION["email"] = "";
    $_SESSION["body"]  = "";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問合せフォーム</title>
</head>
<body>
<?php if ($mode == "input") { ?>
  <!--GETでアクセスされた時は入力画面表示-->
  <form action="./contact.php" method="post"><!--次の画面に行く方法-->
    <label for="name">氏名</label><br>
    <input type="text" name="name" value="<?php echo $_SESSION["name"] ?>"><br/>
    <label for="kana">フリガナ</label><br/>
    <input type="text" name="kana" value="<?php echo $_SESSION["kana"] ?>"><br/>
    <label for="tel">電話番号</label><br/>
    <input type="tel" name="tel" value="<?php echo $_SESSION["tel"] ?>"><br/>
    <label for="email">メールアドレス</label><br/>
    <input type="email" name="email" value="<?php echo $_SESSION["email"] ?>"><br/>
    <label for="body">内容</label><br/>
    <textarea name="body" rows="8" cols="40"><?php echo $_SESSION["body"] ?></textarea><br/>
    <input type="submit" name="confirm" value="送信">
  </form>
<?php } elseif ($mode == "confirm") { ?>
  <!--POSTでアクセスされた時は確認画面表示-->
  <form action="./contact.php" method="post"><!--次の画面に行く方法-->
    <label for="name">氏名</label><br/>
    <?php echo $_SESSION["name"] ?><br/>
    <label for="kana">フリガナ</label><br/>
    <?php echo $_SESSION["kana"] ?><br/>
    <label for="tel">電話番号</label><br/>
    <?php echo $_SESSION["tel"] ?><br/>
    <label for="email">メールアドレス</label><br/>
    <?php echo $_SESSION["email"] ?><br/>
    <label for="body">内容</label><br/>
    <!--nl2br関数でフォームに入力された改行を表示-->
    <?php echo nl2br($_SESSION["body"]) ?><br/>
    <input type="submit" name="back" value="キャンセル">
    <input type="submit" name="send" value="送信">
  </form>
<?php } else { ?>
    <!--完了画面-->
    <p>お問い合わせ内容を送信しました。</p>
    <p>ありがとうございました。</p>
    <input type="submit" name="top" value="トップへ">
<?php } ?>

</body>
</html>