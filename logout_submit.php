<?php
  include_once 'php/common.php';

  $_SESSION = array();
  session_destroy();
  redirect("index.html");
?>