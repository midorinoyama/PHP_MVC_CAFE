<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問合せ</title>
</head>
<body>
<?php if ($_POST){ ?>
  <form action="/.contact.php" method="post">
    <label for="name">氏名</label>
    <?php echo $_POST["name"] ?><br/>
    <label for="kana">フリガナ</label><br/>
    <?php echo $_POST["kana"] ?><br/>
    <label for="tel">電話番号</label><br/>
    <?php echo $_POST["tel"] ?><br/>
    <label for="email">メールアドレス</label><br/>
    <?php echo $_POST["email"] ?><br/>
    <label for="body">内容</label><br/>
    <?php echo $_POST["body"] ?><br/>
    <input type="submit" name="back" value="キャンセル">
    <input type="submit" name="send" value="送信">
  </form>
  <!--確認画面-->
<?php } else { ?>
  <!--入力画面-->
  <form action="/.contact.php" method="post">
    <label for="name">氏名</label><br/>
    <input type="text" name="name" value=""><br/>
    <label for="kana">フリガナ</label><br/>
    <input type="text" name="kana" value=""><br/>
    <label for="tel">電話番号</label><br/>
    <input type="tel" name="tel" value=""><br/>
    <label for="email">メールアドレス</label><br/>
    <input type="email" name="email" value=""><br/>
    <label for="body">内容</label><br/>
    <textarea name="body" rows="2" cols="40"></textarea><br/>
    <input type="submit" name="confirm" value="送信">
  </form>
<?php } ?>

</body>
</html>