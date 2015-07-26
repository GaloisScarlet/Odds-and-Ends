<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
?>
<?php
$sql="DELETE FROM stuinfo WHERE username like '".$_REQUEST["stuName"]."'";
$result=mysql_query($sql);
if($result) echo '<script>alert("修改成功");location.href = "javascript:history.go(-1);"</script>';
else echo '<script>alert("修改失败");location.href = "javascript:history.go(-1);"</script>';
?>