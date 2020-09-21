<?php
  $db_host = "192.168.2.200";
  $db_username = "suistude_board";
  $db_password = "b123yz36";
  $db_name = "suistude_board";
  $db_link=@new mysqli($db_host, $db_username, $db_password, $db_name);
  if($db_link->connect_error != ""){
    echo "資料庫連結失敗";
  }else{
    $db_link->query("SET NAME 'utf8'");
  }
 ?>
