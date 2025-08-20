<?php
  include_once 'php/common.php';

  // ページ遷移が正しいか確認
  if (!isset($_POST["signup"])) {
    message("不正なリクエストです。");
    redirect("index.html");
  }

  // ここから
  // フォームに空欄がないか確認
  if (empty($_POST["user_id"]) || empty($_POST["user_pw"])) {
    message("入力内容が正しくありません。");
    redirect("signup.html");
  }

  // フォームの値を変数に代入
  $user_id = $_POST["user_id"];
  $password = $_POST["user_pw"];

  // DB接続のためのクラスインスタンス作成
  $dbh = new PDO($dsn, $dbuser, $dbpass);

  // accountsテーブルにユーザIDとパスワードを登録
  $sql = "insert into accounts (user_id, password) values ('$user_id', '$password')";
  // 例外処理（フォームで入力されたユーザIDがaccountsテーブルに登録済み）
  try {
    $stmt = $dbh->query($sql);
  } catch(Exception $e) {
    message("このユーザは登録できません。");
    redirect("signup.html");
  }

  // ログインページへ遷移
  message('ユーザ登録が完了しました。');
  redirect("login.html");
  //ここまで
?>