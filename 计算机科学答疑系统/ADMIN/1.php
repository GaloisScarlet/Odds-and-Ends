<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
?>
<?php
	$sql="INSERT INTO `compsci`.`classinfo` (`Id`, `class`, `character`) VALUES (NULL, '".$_REQUEST["ClassName"]."', '".$_REQUEST["CharapterName"]."')";
	$result=mysql_query($sql);
	if($result) echo '<script>alert("修改成功");location.href = "javascript:history.go(-1);"</script>';
	else echo '<script>alert("修改失败");location.href = "javascript:history.go(-1);"</script>';
?>