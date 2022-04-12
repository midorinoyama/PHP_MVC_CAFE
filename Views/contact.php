<?php
require('../Controllers/ContactController.php');
$contacts = new ContactController();
$result = $contacts->index();

//初回アクセス時はPOST変数がないためエラーになる、falseの「NULL」を代入
$name = isset($_POST["name"]) ? $_POST["name"]: null;
$kana = isset($_POST["kana"]) ? $_POST["kana"]: null;
$tel = isset($_POST["tel"]) ? $_POST["tel"]: null;
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

    //先頭が0-9いずれかの数字で始まり、10桁or11桁の半角数字
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
          <h2 class="head-title my-3 text-center">お問合せ</h2>
            <?php if (!empty($errors)) {
                echo '<div class="alert alert-danger" role="alert">';
                echo implode("<br>", $errors);
                echo "</div>";
            } ?>
          <form action="./contact.php" method="post"><!--次の画面に行く方法-->
            <div class="form-group">
              <label for="name">氏名</label>
              <input type="text" class="form-control" name="name" placeholder="山田太郎" value="<?php echo $name ?>">
            </div>
            <div class="form-group">
              <label for="kana">フリガナ</label>
              <input type="text" class="form-control" name="kana" placeholder="ヤマダタロウ" value="<?php echo $kana ?>">
            </div>
            <div class="form-group">
              <label for="tel">電話番号</label>
              <input type="text" class="form-control" name="tel" placeholder="090-xxxx-xxxx" value="<?php echo $tel ?>">
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
              <input type="text" class="form-control" name="email" placeholder="xxx@email.com" value="<?php echo $email ?>">
            </div>
            <div class="form-group">
              <label for="body">内容</label>
              <textarea class="form-control" name="body" rows="8" cols="40" placeholder="お問い合わせ内容はこちらにご入力ください"><?php echo $body ?></textarea>
            </div>
            <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">送信</button>
            </div>
          </form>
        </div>
        <div class="col-md-12 col-xs-12 mx-auto">
        <h3 class="head-title my-3 text-center">お問合せ内容一覧</h3>
          <table class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr>
                <th>氏名</th>
                <th>フリガナ</th>
                <th>電話番号</th>
                <th>メールアドレス</th>
                <th>お問い合わせ内容</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody class="bg-light">
              <?php foreach ($result as $value) { ?>
                <tr>
                  <td><?php echo $value["name"];?></td>
                  <td><?php echo $value["kana"]; ?></td>
                  <td><?php echo $value["tel"]; ?></td>
                  <td><?php echo $value["email"]; ?></td>
                  <td><?php echo nl2br($value["body"]); ?></td>
                  <td><a class="btn btn-info" href = "edit.php?id=<?php echo $value["id"]; ?>">編集</a></td>
                  <td><a class="btn btn-danger" href = "delete.php?id=<?php echo $value["id"]; ?>" onclick="return confirm('本当に削除しますか?')">削除</a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php include("footer.php") ?>
    </div>
  </div>
</body>
</html>