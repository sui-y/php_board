<?php
  $db_link=@new mysqli("localhost", "suistude_board", "b123yz36", "suistude_board");
  if($db_link->connect_error != ""){
    echo "資料庫連結失敗";
  }else{
    $db_link->query("SET NAME 'utf8'");
  }
 ?>
