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
  <nav class="navbar">
    <a class="navbar-brand" href="#">留言板</a>
    <div class="collapse.navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a href="index.php" class="viewText nav-item">瀏覽留言</a>
        <a href="post.php" class="writeText nav-item">我要留言</a>
      </div>
    </div>
    <a class="btn btn-outline-dark loginButton" href="login.php" role="button">登入管理</a>
  </nav>
      <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
          <img src="images/talk.gif" alt="我要留言" width="80" height="80"><span class="heading">留言</span>
        <p>標題<input type="text" name="boardsubject" id="boardsubject"></p>
              <p>姓名<input type="text" name="boardname" id="boardname"></p>
              <p>性別
                <input name="boardsex" type="radio" id="radio" value="男" checked>男
                <input type="radio" name="boardsex" id="radio2" value="女">女
              </p>
              <p>郵件<input type="text" name="boardmail" id="boardmail"></p>
              <p>網站<input type="text" name="boardweb" id="boardweb"></p>
              <p><textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea></p>
        <input name="action" type="hidden" id="action" value="add">
              <input type="submit" name="button" class="btn btn-outline-dark" value="送出留言">
              <input type="reset" name="button2" class="btn btn-outline-dark" value="重設資料">
              <input type="button" name="button3" class="btn btn-outline-dark" value="回上一頁" onClick="window.history.back();">
      </form>
    </div>
  </table>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>