<?php
require('../Controllers/ContactController.php');
$edits = new ContactController();
$result = $edits->edit();

//記述無しでも直接アクセスできない（記述すると編集できなくなる）
// $referer = $_SERVER["HTTP_REFERER"];
// $url = "contact.php";
// if (!strstr($referer, $url)) {
//     header("Location: contact.php");
//     exit;
// }

$errors = [];
if (!empty($_POST)) {
    if (empty($_POST["name"])) {
        $errors[] = "氏名は必須項目です";
    } elseif (mb_strlen($_POST["name"]) > 10) {
        $errors[] = "氏名は10文字以内で入力してください";
    }

    if (empty($_POST["kana"])) {
        $errors[] = "フリガナは必須項目です";
    } elseif (mb_strlen($_POST["kana"]) > 10) {
        $errors[] = "フリガナは10文字以内で入力してください";
    }

    //先頭が0-9いずれかの数字で始まり、残り9桁or10桁の半角数字
    if ($_POST["tel"] != "" && !preg_match("/^[0-9]{10,11}$/", $_POST["tel"])) {
        $errors[] = "電話番号は数字0-9のみで入力してください";
    }

    if (empty($_POST["email"])) {
        $errors[] = "メールアドレスは必須項目です";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "メールアドレスを正しい形式で入力してください";
    }

    if (empty($_POST["body"])) {
        $errors[] = "お問い合わせ内容は必須項目です";
    }

    //エラーがない場合確認画面へ遷移
    if (count($errors) === 0) {
        if (!empty($_GET["id"])) {
            $_SESSION["id"] = $_GET["id"];
        }
        //受け取った値をセッション変数に保持
        $_SESSION["name"]  = $_POST["name"];
        $_SESSION["kana"]  = $_POST["kana"];
        $_SESSION["tel"]   = $_POST["tel"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["body"]  = $_POST["body"];
        header("Location:edit-confirm.php");
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script defer src="../js/validate.js"></script>
</head>
<body>
  <div class="main">
    <div class="container-fruid">
      <?php include("header.php") ?>
      <div class="row">
        <div class="col-md-6 col-xs-12 mx-auto">
          <h2 class="head-title my-3 text-center">詳細画面</h2>
            <?php if (!empty($errors)) {
                echo '<div class="alert alert-danger" role="alert">';
                echo implode("<br>", $errors);
                echo "</div>";
            } ?>
            <?php foreach ($result as $user) {
            } ?>
            <form action="" method="post" name="contact_form"><!--次の画面に行く方法-->
                <div class="form-group">
                    <label for="name">氏名</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $user["name"]; ?>">
                </div>
                <div class="form-group">
                    <label for="kana">フリガナ</label>
                    <input type="text" class="form-control" name="kana" value="<?php echo $user["kana"]; ?>">
                </div>
                <div class="form-group">
                    <label for="tel">電話番号</label>
                    <input type="text" class="form-control" name="tel" value="<?php echo $user["tel"]; ?>">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $user["email"]; ?>">
                </div>
                <div class="form-group">
                    <label for="body">内容</label>
                    <textarea class="form-control" name="body" rows="8" cols="40" ><?php echo $user["body"]; ?></textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" onclick="check()">編集する</button>
                </div>
          </form>
        </div>
      </div>
      <?php include("footer.php") ?>
    </div>
  </div>
</body>
</html>