<?php
  include_once 'php/common.php';

  // ページ遷移が正しいか確認
  if (!isset($_POST["login"])) {
    message("不正なリクエストです。");
    redirect("index.html");
  }

  // ここから
  // フォームに空欄がないか確認
  if (empty($_POST["user_id"]) || empty($_POST["user_pw"])) {
    message("入力内容が正しくありません。");
    redirect("login.html");
  }

  // フォームの値を変数に代入
  $user_id = $_POST["user_id"];
  $password = $_POST["user_pw"];

  // DB接続のためのクラスインスタンス作成
  $dbh = new PDO($dsn, $dbuser, $dbpass);

  // accountsテーブルでuser_idがフォームで入力されたユーザIDと等しいデータを検索
  $sql = "select * from accounts where user_id = '$user_id' and password = '$password'";
  $stmt = $dbh->query($sql);
  $account = $stmt->fetch();
  // フォームで指定されたユーザIDとパスワードのデータが検索されない場合
  if (empty($account)) {
    message("ユーザ名またはパスワードが正しくありません。");
    redirect("login.html");
  }

  // マイページへ遷移
  session_regenerate_id(true);
  $_SESSION["user_id"] = $user_id;
  redirect("mypage.html");
  //ここまで
?>