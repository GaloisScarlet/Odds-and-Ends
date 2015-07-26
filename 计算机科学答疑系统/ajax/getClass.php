<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
if (isset($_REQUEST["class"])) {
	$class = $_REQUEST["class"];
	$sql = "SELECT * FROM classinfo where class like '" . $class . "'";
	$result = mysql_query($sql);
	$return = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$return .= "|" . $row["character"];
	}
	echo $return;
} else if (isset($_REQUEST["getteacher"])) {
	$class = $_REQUEST["getteacher"];
	$sql = "SELECT * FROM teacinfo where Class like '" . $class . "'";
	$result = mysql_query($sql);
	$return = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$return .= "|". $row["Name"];
	}
	echo $return;
}
?>