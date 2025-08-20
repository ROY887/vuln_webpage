<?php
  session_start();

  // DB接続情報
  $dsn = 'mysql:dbname=web;host=localhost';
  $dbuser = 'jikken';
  $dbpass = 'jikken';

  // メッセージダイアログ
  function message($message)
  {
    echo "<script>alert('$message');</script>";
  }

  // リダイレクトして終了
  function redirect($location)
  {
    echo "<script>location.href='$location';</script>";
    exit();
  }

  // ログイン中であることの確認
  function require_login()
  {
    if (!isset($_SESSION["user_id"])) {
      message("ログインしてください。");
      redirect("login.html");
    }
  }
?>
