<?php 
function GetSQLValueString($theValue, $theType) {
  switch ($theType) {
    case "string":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
      break;
    case "int":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
      break;
    case "email":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
      break;
    case "url":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_URL) : "";
      break;      
  }
  return $theValue;
}

if(isset($_POST["action"])&&($_POST["action"]=="add")){
	require_once("connMysql.php");	
	$query_insert = "INSERT INTO board (boardname ,boardsex ,boardsubject ,boardtime ,boardmail ,boardweb ,boardcontent) VALUES (?, ?, ?, NOW(), ?, ?, ?)";
	$stmt = $db_link->prepare($query_insert);
	$stmt->bind_param("ssssss",
		GetSQLValueString($_POST["boardname"], "string"),
		GetSQLValueString($_POST["boardsex"], "string"),
		GetSQLValueString($_POST["boardsubject"], "string"),
		GetSQLValueString($_POST["boardmail"], "email"),
		GetSQLValueString($_POST["boardweb"], "url"),
		GetSQLValueString($_POST["boardcontent"], "string"));
	$stmt->execute();
	$stmt->close();
	$db_link->close();
	//重新導向回到主畫面
	header("Location: index.php");
}	
?>
<html>
  <head>
    <title>訪客留言版</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script language="javascript">
    function checkForm(){
      if(document.formPost.boardsubject.value==""){
        alert("請填寫標題!");
        document.formPost.boardsubject.focus();
        return false;
      }
      if(document.formPost.boardname.value==""){
        alert("請填寫姓名!");
        document.formPost.boardname.focus();
        return false;
      }	
      if(document.formPost.boardmail.value!=""){
        if(!checkmail(document.formPost.boardmail)){
          document.formPost.boardmail.focus();
          return false;
        }
      } 
      if(document.formPost.boardcontent.value==""){
        alert("請填寫留言內容!");
        document.formPost.boardcontent.focus();
        return false;
      }
        return confirm('確定送出嗎？');
    }

    function checkmail(myEmail) {
      var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(filter.test(myEmail.value)){
        return true;
      }
      alert("電子郵件格式不正確");
      return false;
    }
    </script>
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
          <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
            <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr valign="top">
                <td width="80" align="center"><img src="images/talk.gif" alt="我要留言" width="80" height="80"><span class="heading">留言</span></td>
                <td>
            <p>標題<input type="text" name="boardsubject" id="boardsubject"></p>
                  <p>姓名<input type="text" name="boardname" id="boardname"></p>
                  <p>性別
                    <input name="boardsex" type="radio" id="radio" value="男" checked>男
                    <input type="radio" name="boardsex" id="radio2" value="女">女
                  </p>
                  <p>郵件<input type="text" name="boardmail" id="boardmail"></p>
                  <p>網站<input type="text" name="boardweb" id="boardweb"></p>
                </td>
                <td align="right">
                  <p><textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea></p>
                </td>
              </tr>
              <tr valign="top">
                <td colspan="3" align="center" valign="middle">
            <input name="action" type="hidden" id="action" value="add">
                  <input type="submit" name="button" id="button" value="送出留言">
                  <input type="reset" name="button2" id="button2" value="重設資料">
                  <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();"></td>
              </tr>
            </table>
          </form>
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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>