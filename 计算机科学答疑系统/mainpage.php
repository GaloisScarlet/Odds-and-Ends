<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
if (!isset($_COOKIE['user'])) {
	echo("<script>alert('登录超时，请重新登录');window.location=\"login.php\"</script>");
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
					<a class="navbar-brand" href="#">
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
						<li class="">
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
						<?php
						if($_COOKIE['authority']=='teacher')
						echo '<li>'.'<a>'.'您当前处于：学生系统'.	'</a>'.'</li>';
						?>
						<li>
							<a>欢迎您，<?php
							if ($_COOKIE['authority'] == "student")
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
							<?php
								if($_COOKIE['authority']=='teacher'){
								echo '<li>
								<a href="teacher.php">
										切换教师系统
									</a>
								</li>
								<li>
									<a href="mainpage.php">
										切换学生系统
									</a>
								</li>';
								}
							?>
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
				<ol class="breadcrumb">
					<li>
						<a href="#">
							首页
						</a>
					</li>
				</ol>
				<!-- 显示问题  -->
				<div class="col-md-10">
					<div>
					<h3>最新问题：</h3>
					<?php
					$sql = "SELECT * FROM `queslib` ORDER BY dateout DESC";
					$result = mysql_query($sql);
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					for ($i = 0; $i < 3; ) {
						if (($row["solved"] == 1)&&++$i)
							echo "
							<div class=\"panel panel-default\">
							<a href=\"result.php?id=" . $row['Id'] . "\">
							<div class=\"panel-heading\">
							" . htmlentities(trim(substr($row["question"], 0, 200)),ENT_NOQUOTES,'UTF-8') . "
							</div>
							</a>
							<div class=\"panel-body\">
							" . htmlentities(trim(substr($row["describe"],0,200)),ENT_NOQUOTES,'UTF-8') . "
							</div>
							</div>";
						$row = mysql_fetch_array($result, MYSQL_ASSOC);
					}
					?>
					</div>
					<div>
						<h3>专家推荐：</h3>
						<?php
							$sql = "SELECT * FROM `teacinfo` ORDER BY RAND()";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
						?>
						<div class="row">
							<div class="col-lg-4">
								<img class="img-circle" src="img/<?php echo $row['Id'] ; ?>.jpg" alt="" width="140" height="140">
								<h2><?php echo $row['Name']; ?></h2>
								<p>答疑方向：<?php echo $row['Class']  ?></p>
								<p><?php echo trim(substr($row['introduce'],0,200)); ?></p>
								<?php $row = mysql_fetch_array($result, MYSQL_ASSOC); ?>
							</div>
							<div class="col-lg-4">
								<img class="img-circle" src="img/<?php echo $row['Id'] ; ?>.jpg" alt="" width="140" height="140">
								<h2><?php echo $row['Name']; ?></h2>
								<p>答疑方向：<?php echo $row['Class']  ?></p>
								<p><?php echo trim(substr($row['introduce'],0,200)); ?></p>
								<?php $row = mysql_fetch_array($result, MYSQL_ASSOC); ?>
							</div>
							<div class="col-lg-4">
								<img class="img-circle" src="img/<?php echo $row['Id'] ; ?>.jpg" alt="" width="140" height="140">
								<h2><?php echo $row['Name']; ?></h2>
								<p>答疑方向：<?php echo $row['Class']  ?></p>
								<p><?php echo trim(substr($row['introduce'],0,200)); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>