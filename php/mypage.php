<?php
  include_once 'common.php';

  // セッション変数からuser_idを取得
  $user_id = $_SESSION["user_id"];
  if (!$user_id) {
    http_response_code(401);
    echo "不正なリクエストです。";
    exit();
  }

  // DB接続のためのクラスインスタンス作成
  $dbh = new PDO($dsn, $dbuser, $dbpass);

  // profilesテーブルから指定したユーザのデータを検索
  $sql = "SELECT user_id, user_name, email, myjobs FROM profiles WHERE user_id = '$user_id'";
  $stmt = $dbh->query($sql);
  if ($stmt->rowCount() > 0) {
    $data = $stmt->fetch();
  } else {
    $data['user_id'] = $user_id;
    $data['user_name'] = '';
    $data['email'] = '';
    $data['myjobs'] = '';
  }

  // ユーザのデータをJSON形式で出力
  echo json_encode($data);
?>
