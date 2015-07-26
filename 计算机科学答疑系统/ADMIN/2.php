<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
?>
<?php
$sql="INSERT INTO `compsci`.`teacinfo` (`Id`, `username`, `password`, `email`, `Name`, `Class`, `introduce`) VALUES (NULL, '".$_REQUEST["username"]."', '".$_REQUEST["password"]."', '".$_REQUEST["email"]."', '".$_REQUEST["teacherName"]."', '".$_REQUEST["ClassName"]."', '".$_REQUEST["introduce"]."')";
$result=mysql_query($sql);
if($result) echo '<script>alert("修改成功");location.href = "javascript:history.go(-1);"</script>';
else echo '<script>alert("修改失败");location.href = "javascript:history.go(-1);"</script>';
?>