<?php
  include_once 'php/common.php';
  // エラー表示を有効化
  ini_set('display_errors', '1'); // ブラウザにエラーを表示
  ini_set('display_startup_errors', '1'); // PHP起動時のエラーも表示
  error_reporting(E_ALL); // すべてのエラーを表示

// デバッグ用ログ出力
  error_log("mypage_submit.php にアクセス");


  // ログイン中であることを確認
  require_login();

  // ページ遷移が正しいか確認
  if (!isset($_POST["mypage"])) {
    message("不正なリクエストです。");
    redirect("/");
  }

  // ここから
  // フォームに空欄がないか確認
  if (empty($_POST["user_name"]) || empty($_POST["email"]) || !isset($_POST["myjobs"])) {
    message("入力内容が正しくありません。");
    redirect("mypage.html");
  }

  // セッション変数からuser_idを取得
  $user_id = $_SESSION["user_id"];

  // フォームの値を変数に代入
  $user_name = $_POST["user_name"];
  $email = $_POST["email"];
  $myjobs = $_POST["myjobs"];

  // DB接続のためのクラスインスタンス作成
  $dbh = new PDO($dsn, $dbuser, $dbpass);

  // profilesテーブルでユーザIDのユーザプロフィールを検索
  $sql = "select count(*) from profiles where user_id = '$user_id'";
  $stmt = $dbh->query($sql);
  if ($stmt->fetchColumn() == 0) {
    // 検索件数が0件のときはユーザプロフィールを登録   
    $sql = "insert into profiles (user_id, user_name, email, myjobs) values ('$user_id', '$user_name', '$email', '$myjobs')";
  } else {
    // 検索件数が0件でないときはユーザプロフィールを更新       
    $sql = "update profiles set user_name = '$user_name', email = '$email', myjobs = '$myjobs' where user_id = '$user_id'";
  }
  $stmt = $dbh->query($sql);
  //ここまで

  // ユーザWebページのディレクトリ作成
  if (!file_exists($user_id)) {
    system("/bin/mkdir -m 0777 $user_id");
  }
  // ユーザWebページ：user_id/index.htmlファイル更新
  $contents = file_get_contents("template/user_template.html");
  $contents = str_replace('**user_id**', $user_id, $contents);
  $contents = str_replace('**user_name**', $user_name, $contents);
  $contents = str_replace('**email**', $email, $contents);
  $contents = str_replace('**myjobs**', $myjobs, $contents);
  file_put_contents("$user_id/index.html", $contents);

  // マイページに遷移（戻る）
  message('ユーザページを作成・更新しました。');
  redirect("mypage.html");
?>
