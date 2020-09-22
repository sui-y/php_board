<?php
  require_once("connMysql.php");
  $pageRow_records = 5;
  //預設頁數
  $num_pages = 1;
  //若已經有翻頁，將頁數更新
  if (isset($_GET['page'])) {
    $num_pages = $_GET['page'];
  }
  //本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
  $startRow_records = ($num_pages -1) * $pageRow_records;
  //未加限制顯示筆數的SQL敘述句
  $query_RecBoard = "SELECT * FROM board ORDER BY boardtime DESC";
  //加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
  $query_limit_RecBoard = $query_RecBoard." LIMIT {$startRow_records}, {$pageRow_records}";
  //以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
  $RecBoard = $db_link->query($query_limit_RecBoard);
  //以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
  $all_RecBoard = $db_link->query($query_RecBoard);
  //計算總筆數
  $total_records = $all_RecBoard->num_rows;
  //計算總頁數=(總筆數/每頁筆數)後無條件進位。
  $total_pages = ceil($total_records/$pageRow_records);
?>
<html>
  <head>
  <title>訪客留言版</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  </head>
  <body bgcolor="#ffffff">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
          <tr>
            <a class="btn btn-outline-dark" href="index.php" role="button">瀏覽留言</a>
            <a class="btn btn-outline-dark" href="post.php" role="button">我要留言</a>
            <td width="15"><img name="board_r1_c8" width="15" height="36" border="0" alt=""></td>
          </tr>
        </table></td>
    </tr>
    <tr>
    </tr>
    <tr>
      <td background="images/board_r3_c1.jpg"><div id="mainRegion">
          <?php	while($row_RecBoard=$RecBoard->fetch_assoc()){ ?>
          <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr valign="top">
              <td width="60" align="center" class="underline">
                <?php if($row_RecBoard["boardsex"]=="男"){;?>
                  <img src="images/male.png" alt="我是男生" width="49" height="49">
                <?php }else{?>
                  <img src="images/female.png" alt="我是女生" width="49" height="49">
                <?php }?>
                <br>
                <span class="postname"><?php echo $row_RecBoard["boardname"];?></span>
              </td>
              <td class="underline">
                  <span class="smalltext">[<?php echo $row_RecBoard["boardid"];?>]</span>
                  <span class="heading"> <?php echo $row_RecBoard["boardsubject"];?></span>
                  <p><?php echo nl2br($row_RecBoard["boardcontent"]);?></p>
                  <p align="right" class="smalltext">
                  <?php echo $row_RecBoard["boardtime"];?>
                  <?php if($row_RecBoard["boardmail"]!=""){?>
                  <a href="mailto:<?php echo $row_RecBoard["boardmail"];?>"><img src="images/email-a.png" alt="電子郵件" width="16" height="16" border="0" align="absmiddle"></a>
                  <?php }?>
                  <?php if($row_RecBoard["boardweb"]!=""){?>
                  <a href="<?php echo $row_RecBoard["boardweb"];?>"><img src="images/home-a.png" alt="個人網站" width="16" height="16" border="0" align="absmiddle"></a>
                  <?php }?>
                  </p>
                </td>
            </tr>          
          </table>
          <?php }?>
          <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td valign="middle"><p>資料筆數：<?php echo $total_records;?></p></td>
              <td align="right"><p>
                  <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
                  <a href="?page=1">第一頁</a> | <a href="?page=<?php echo $num_pages-1;?>">上一頁</a> |
                  <?php }?>
                  <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
                  <a href="?page=<?php echo $num_pages+1;?>">下一頁</a> | <a href="?page=<?php echo $total_pages;?>">最末頁</a>
                  <?php }?>
                </p></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr>
      <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
          <tr>
            <td width="15"><img name="board_r4_c1" src="images/board_r4_c1.jpg" width="15" height="31" border="0" alt=""></td>
            <a class="btn btn-outline-dark" href="login.php" role="button">登入管理</a>
            <td width="15"><img name="board_r4_c8" src="images/board_r4_c8.jpg" width="15" height="31" border="0" alt=""></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
<?php
$db_link->close();
?>
