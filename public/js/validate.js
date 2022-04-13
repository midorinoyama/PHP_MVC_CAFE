function check() {
  let message = [];

  if (contact_form.name.value == "") {
    message.push("氏名は必須項目です");
  //JavaScriptではelseif(1単語)はない
  } else if (contact_form.name.value.length > 10) {
    message.push("氏名は10文字以内で入力してください");
  }

  if (contact_form.kana.value == "") {
    message.push("フリガナは必須項目です");
  } else if (contact_form.kana.value.length > 10) {
    message.push("フリガナは10文字以内で入力してください");
  }

  if (contact_form.tel.value != "") {
    if (!contact_form.tel.value.match(/^[0-9]{10,11}$/)) {
      message.push("電話番号は数字0-9で入力してください");
    }
  }

  if (contact_form.email.value == "") {
    message.push("メールアドレスは必須項目です");
  } else if (!contact_form.email.value.match(/.+@.+\..+/)) {
    message.push("メールアドレスの形式が不正です");
  }

  if (contact_form.body.value == "") {
    message.push("お問い合わせ内容は必須項目です");
  }

  if (message.length > 0) {
    alert(message);
    return;
  }

  alert("入力チェックOK");
}