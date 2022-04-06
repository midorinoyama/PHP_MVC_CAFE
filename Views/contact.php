<?php
require('../Controllers/ContactController.php');

//初回アクセス時はPOST変数がないためエラーになる、falseの「NULL」を代入
$name = isset($_POST["name"]) ? $_POST["name"]: null;
$kana = isset($_POST["kana"]) ? $_POST["kana"]: null;
$tel  = isset($_POST["tel"]) ? $_POST["tel"]: null;
$email = isset($_POST["email"]) ? $_POST["email"]: null;
$body = isset($_POST["body"]) ? $_POST["body"]: null;

$errors = [];
if (!empty($_POST)) {
    if (empty($_POST["name"])) {
        $errors[] = "お名前は必須項目です";
    } elseif (mb_strlen($_POST["name"]) > 10) {
        $errors[] = "お名前は10文字以内で入力してください";
    }

    if (empty($_POST["kana"])) {
        $errors[] = "フリガナは必須項目です";
    } elseif (mb_strlen($_POST["kana"]) > 10) {
        $errors[] = "フリガナは10文字以内で入力してください";
    }

    if (!preg_match("/^[0-9]+$/", $_POST["tel"])) {
        $errors[] = "数字0-9のみで入力してください";
    }

    if (empty($_POST["email"])) {
        $errors[] = "メールアドレスは必須項目です";
    }

    if (empty($_POST["body"])) {
        $errors[] = "お問い合わせ内容は必須項目です";
    }

    //エラーがない場合確認画面へ遷移
    if (count($errors) == 0) {
        //受け取った値をセッション変数に保持
        $_SESSION["name"]  = $_POST["name"];
        $_SESSION["kana"]  = $_POST["kana"];
        $_SESSION["tel"]   = $_POST["tel"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["body"]  = $_POST["body"];
        header("Location:confirm.php");
        exit();
    }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script defer src="../js/index.js"></script>
</head>
<body>
    <?php if (!empty($errors)) {
        echo '<div class="alert alert-danger" role="alert">';
        echo implode("<br>", $errors);
        echo "</div>";
    } ?>
  <form action="./contact.php" method="post"><!--次の画面に行く方法-->
    <label for="name">氏名</label><br>
    <input type="text" name="name" value="<?php echo $name ?>"><br/>
    <label for="kana">フリガナ</label><br/>
    <input type="text" name="kana" value="<?php echo $kana ?>"><br/>
    <label for="tel">電話番号</label><br/>
    <input type="tel" name="tel" value="<?php echo $tel ?>"><br/>
    <label for="email">メールアドレス</label><br/>
    <input type="email" name="email" value="<?php echo $email ?>"><br/>
    <label for="body">内容</label><br/>
    <textarea name="body" rows="8" cols="40"><?php echo $body ?></textarea><br/>
    <input type="submit" value="送信">
  </form>
</body>
</html>