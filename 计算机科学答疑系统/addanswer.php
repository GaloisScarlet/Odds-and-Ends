<?php
require 'phpmailer/sendmail.php';
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
if(!isset($_COOKIE['user'])){
	echo ("<script>alert('登录超时，请重新登录');window.location=\"login.php\"</script>");
}
if($_COOKIE['authority']=='teacher'){
	die('<script>window.location.href="addquestion.php"</script>');
}
$sql="SELECT * FROM stuinfo WHERE username like '".$_COOKIE['user']."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$studentID=$row['Id'];
?>
<?php
if (isset($_REQUEST["Class"]) && isset($_REQUEST["Charapter"]) && isset($_REQUEST["Question"]) && isset($_REQUEST["Describe"])) {
	$sql="SELECT * FROM teacinfo WHERE Name LIKE '".$_REQUEST['Experiment']."' AND  Class LIKE '".$_REQUEST['Class']."'";
	$result = mysql_query($sql);
	$row0 = mysql_fetch_array($result, MYSQL_ASSOC);
	$teacherID=$row0['Id'];
	$sql = "INSERT INTO `compsci`.`queslib` 
	(`Id`, `question`, `describe`, `answer`, `solved`, `stuid`, `teacher`, `dateput`, `dateout`, `class`, `character`)
	 VALUES
	  (NULL, '" . mysql_real_escape_string($_REQUEST["Question"])."','". mysql_real_escape_string($_REQUEST["Describe"])."',NULL,0,".$studentID.",'".$teacherID."','".date('Y-m-d')."',NULL,'" . $_REQUEST["Class"] . "','".$_REQUEST["Charapter"]."');";
	$result = mysql_query($sql);
	if ($result) {
		sendMailToTeacher($row0['email'], $_REQUEST['Question'], $_REQUEST["Experiment"]);
		echo '<script>alert("提交成功，正在跳转至主页...")</script>';
		die("<script>setTimeout(window.location=\"mainpage.php\",3)</script>");
	}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			计算机科学答疑系统
		</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/usually.css"/>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/addanswerajax.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/usually_actions.js" type="text/javascript" charset="utf-8"></script>
		<!---------------------------------------------------------------------->
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
					</button>
					<a class="navbar-brand" href="mainpage.php">
						CSES
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="teacherInfo.php">
								专家清单
							</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								知识库
								<span class="caret">
								</span>
							</a>
							<ul class="dropdown-menu">
								<?php $sql = "Select distinct class from classinfo";
								$result = mysql_query($sql);
								while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
									echo "<li>
								<a href=\"search.php?class=".$row["class"]."\">
								" . $row["class"] . "
								</a>
								</li>";
								?>
							</ul>
						</li>
						<li class="active">
							<a href="addanswer.php">
								提交问题 <span class="sr-only">(current)</span>
							</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<form class="navbar-form navbar-left" role="search" method="get" action="search.php">
							<div class="form-group">
								<input type="text" class="form-control" name="find" placeholder="搜索题目">
							</div>
							<button type="submit" class="btn btn-default">
								搜索
							</button>
						</form>
						<li>
							<a>欢迎您，<?php
							if($_COOKIE['authority']=="student")
							$sql = "Select * from stuinfo where username like '" . mysql_real_escape_string($_COOKIE['user']) . "'";
							else
							$sql = "Select * from teacinfo where username like '" . mysql_real_escape_string($_COOKIE['user']) . "'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							echo htmlentities($row['Name'],ENT_NOQUOTES,'UTF-8') ;
								?></a>	
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								选项
								<span class="caret">
								</span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="myquestion.php" onclick="">
										我的问题
									</a>
								</li>
								<li>
									<a href="login.php" onclick="javascript:clearCookie();">
										退出登录
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<div class="row">
			<div class="col-md-3">
				<!--  This div to write left page    -->
				<h3>
					课程清单
				</h3>
				<ul class="nav nav-list active">
					<?php $sql = "Select distinct class from classinfo";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						echo "  <li class=\"\">
					<a href=\"search.php?class=" . $row["class"] . "\">
					<h4>" . $row["class"] . "</h4>
					</a>
					</li>";
						echo "  <ul class=\"nav nav-list\">";
						$sql2 = "SELECT * FROM classinfo WHERE class LIKE '" . $row["class"] . "'";
						$result2 = mysql_query($sql2);
						while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
							echo "  	<div class=\"col-md-2\">
					</div>
					<div class=\"col-md-10\">
					<li class=\"\">
					<a href=\"search.php?class=" . $row["class"] . "&character=" . $row2['character'] . "\">
					" . $row2['character'] . "
					</a>
					</li>
					</div>";
					echo "</ul>";
					}
					?>
				</ul>
			</div>
			<div class="col-md-9">
				<!--  This div to write right page   -->
				<div class="col-md-10">
					<h1>
						在此添加你的问题
					</h1>
				</div>
				<div class="col-md-10">
					<form method="post" action="addanswer.php" class="form-horizontal">
						<div class="form-group">
							<label for="Question" class="col-sm-2 control-label">题目:</label>
							<div class="col-sm-10">
								<input type="text" name="Question" class="form-control" id="Question" placeholder="在此键入你的问题">
							</div>
						</div>
						<div class="form-group">
							<label for="Class" class="col-sm-2 control-label">所属学科:</label>
							<div class="col-sm-10">
								<select class="form-control" id="Class" name="Class">
									<?php
										$sql = "Select distinct class from classinfo";
										$result = mysql_query($sql);
										echo "<option></option>";
										while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
											echo "<option value=\"".$row["class"] ."\">
											" . $row["class"] . "
											</option>";									
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="Charapter" class="col-sm-2 control-label">所属范围:</label>
							<div class="col-sm-10">
								<select class="form-control" id="Charapter" name="Charapter">
									<option></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="Experiment" class="col-sm-2 control-label">回答专家:</label>
							<div class="col-sm-10">
								<select class="form-control" id="Experiment" name="Experiment">
									<option></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="Describe" class="col-sm-2 control-label">问题描述:</label>
							<div class="col-sm-10">
								<textarea name="Describe" class="form-control" rows="8" placeholder="在此详细描述你的问题..."></textarea>																																								
							</div>
						</div>
						<div class="form-group" align="right">
							<button type="submit" class="btn btn-default" onclick="check()">
								提交
							</button>
							<button type="button" class="btn btn-default">
								清空
							</button>
						</div>
					</form>
				</div>
			</div>
	</body>
</html>
<script>
	function check() {
				if($("#Question").val()=="") {alert("问题不能为空!"); return false;}
				if($("#Experiment").val()=="") {alert("专家不能为空!");return false;}
				if($("#Charapter").val()=="") {alert("所属范围不能为空!");return false;}
				if($("#Class").val()=="") {alert("所属学科不能为空!");return false;}
				return true;
			}
</script>
