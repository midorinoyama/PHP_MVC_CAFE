<?php
require('../Controllers/ContactController.php');
//ダイレクトアクセス禁止
$referer = $_SERVER["HTTP_REFERER"];
$url = "edit-confirm.php";
if (!strstr($referer, $url)) {
    header("Location: contact.php");
    exit;
}

$contacts = new ContactController();
$data = $contacts->update();
