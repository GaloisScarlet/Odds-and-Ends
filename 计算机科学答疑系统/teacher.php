<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
if (!isset($_COOKIE['user'])) {
	echo("<script>alert('登录超时，请重新登录');window.location=\"login.php\"</script>");
}
if (!isset($_COOKIE['authority']) && $_COOKIE['authority'] != "teacher") {
	echo("<script>alert('您无权访问此页面！');window.location=\"login.php\"</script>");
}
?>
<?php 
die('
<script>
	window.location.href="tobesolved.php";
</script>
');
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
							<a href="tobesolved.php">
								待解决问题
							</a>
						</li>
						<li>
							<a href=
							<?php
							$sql = "Select * from teacinfo where username like '" . $_COOKIE['user'] . "'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							$sql = "SELECT * FROM teachers where teacherID like '" . $row['Id'] . "'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							echo "search.php?class=" . $row['class'];
						?>
							>
								本学科问题库
							</a>
						</li>
						<li class="">
							<a href="addlib.php">
								添加知识<span class="sr-only">(current)</span>
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
							$sql = "Select * from stuinfo where username like '" . $_COOKIE['user'] . "'";
							else
							$sql = "Select * from teacinfo where username like '" . $_COOKIE['user'] . "'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							echo $row['Name'];
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
									<a href="teacher.php">
										切换教师系统
									</a>
								</li>
								<li>
									<a href="mainpage.php">
										切换学生系统
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
				
			</div>
		</div>
	</body>
</html>
<?php
mysql_close();
?>