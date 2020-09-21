<?php
  require_once("connMysql.php");
  $pageRow_records = 5; //預設每頁比數
  $num_pages = 1; //預設頁數
  if(isset($_GET['page'])){
    $num_pages = $_GET['page'];
  }
  $startRow_records = ($num_pages-1)*$pageRow_records;
  $query_Recboard = "SELECT * FROM board ORDER BY boardertime DESC";
  $query_limit_Recboard=$query_Recboard." LIMIT {$startRow_records}, {$pageRow_records}";
  $RecBoard = $db_link->query($query_limit_Recboard);
  $all_Recboard = $db_link->query($query_Recboard);
  $total_records = $all_Recboard->num_rows;
  $totalPages = ceil($total_records/$pageRow_records);
?>
<html>
  <head>
  <title>訪客留言版</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor="#ffffff">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
          <tr>
            <td><img name="board_r1_c1" src="images/board_r1_c1.jpg" width="465" height="36" border="0" alt=""></td>
            <td><a href="index.php"><img name="board_r1_c5" src="images/read.jpg" width="110" height="36" border="0" alt="瀏覽留言"></a></td>
            <td><a href="post.php"><img name="board_r1_c7" src="images/post.jpg" width="110" height="36" border="0" alt="我要留言"></a></td>
            <td width="15"><img name="board_r1_c8" src="images/board_r1_c8.jpg" width="15" height="36" border="0" alt=""></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><img name="board_r2_c1" src="images/board_r2_c1.jpg" width="700" height="28" border="0" alt=""></td>
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
            <td background="images/botbg.jpg"><a href="login.php"><img name="board_r4_c2" src="images/login.jpg" width="77" height="31" border="0" alt="登入管理"></a></td>
            <td width="15"><img name="board_r4_c8" src="images/board_r4_c8.jpg" width="15" height="31" border="0" alt=""></td>
          </tr>
        </table></td>
    </tr>
  </table>
  </body>
</html>
<?php
$db_link->close();
?>
