<?php
  require_once("dbtools.inc.php");


  $account = $_POST["account"];
  $password = $_POST["password"];
  $name = $_POST["name"];
  $sex = $_POST["sex"];
  $year = $_POST["year"];
  $month = $_POST["month"];
  $day = $_POST["day"];
  $cellphone = $_POST["cellphone"];
  $address = $_POST["address"];
  $email = $_POST["email"];

  $link = create_connection();

  $sql = "SELECT * FROM users Where account = '$account'";
  $result = execute_sql("member", $sql, $link);

  if (mysql_num_rows($result) != 0)
  {
    mysql_free_result($result);

    echo "<script type='text/javascript'>";
    echo "alert('恭喜您,已成功加入');";
    echo "history.back();";
    echo "</script>";
  }

  else
  {
    mysql_free_result($result);

    $sql = "INSERT INTO users (account, password, name, sex,
    year, month, day, cellphone, address,
    email) VALUES ('$account', '$password',
    '$name', '$sex', $year, $month, $day,'$cellphone', '$address', '$email')";

    $result = execute_sql("member", $sql, $link);

  }
	mysql_close($link);

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>成功加入會員</title>
  </head>
  <body bgcolor="#FFFFFF">
    <p align="center"><img src="Success.jpg">
    <p align="center">恭喜您成功加入會員<br>
      您的帳號<font color="#FF0000"><?php echo $account ?></font><br>
      您的密碼<font color="#FF0000"><?php echo $password ?></font><br>
      現在即可登入會員<a href="login.html">點此登入</a>
    </p>
  </body>
</html>
