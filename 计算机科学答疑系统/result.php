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
						<li class="dropdown active">
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
			<?php
			$sql = "SELECT *  FROM `queslib` WHERE `Id` = " . $_GET['id'];
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			?>
			<div class="col-md-9">
				<!--  This div to write right page   -->
				<div class="col-md-10">
					<h4><?php
					if (isset($_COOKIE['authority']) && $_COOKIE['authority'] == 'teacher')
						echo "题目ID：" . $_GET['id'];
					?></h4>
					<h1><?php echo htmlentities($row['question'],ENT_NOQUOTES,'UTF-8') ?></h1>
				</div>
				<div class="col-md-6">
				<h4>
					问题类型:<?php echo $row['class']."-".$row['character']    ?>
				</h4>
				</div>
				<div class="col-md-4">
					<h4>
						答疑教师:<?php 
					$sql="SELECT * FROM teacinfo WHERE Id like '".$row['teacher']."'";
					$result=mysql_query($sql);
					$row2=mysql_fetch_array($result,MYSQL_ASSOC);
					echo $row2['Name'];
					?>
					</h4>
				</div>
				<div class="col-md-2">
				<h4>
					<?php
					$isme=false;
					if($_COOKIE['authority']=='teacher'){
						$sql="SELECT * FROM teacinfo WHERE username like '".$_COOKIE['user']."'";
						$result=mysql_query($sql);
						$result=mysql_fetch_array($result, MYSQL_ASSOC);
						$sql="SELECT * FROM teacinfo WHERE Id like '".$result['Id']."'";
						$result=mysql_query($sql);
						while (!$isme&&$row2= mysql_fetch_array($result, MYSQL_ASSOC)){
							if($row2['Class']==$row['class']) $isme=true;
						}
					}
					if($_COOKIE['authority']=='student'){
						$sql="SELECT * FROM stuinfo WHERE username like '".$_COOKIE['user']."'";
						$result=mysql_query($sql);
						$result=mysql_fetch_array($result, MYSQL_ASSOC);
						$stuID=$result['Id'];
						if($row['stuid']==$stuID)$isme=true;
					}
					if($isme&&$_COOKIE['authority']=="teacher"){
						echo "<h4>";
						echo '<a href="addlib.php?id='.$_GET['id'].'">';
						echo '编辑问题';
						echo "</a>";
						echo "</h4>";
					}
					if($isme&&$_COOKIE['authority']=="student"){
						echo "<h4>";
						echo '<a href="chgquestion.php?id='.$_GET['id'].'">';
						echo '编辑问题';
						echo "</a>";
						echo "</h4>";
					}
					?>
				</h4>
				</div>
				<div class="col-md-10" style="height: 300px;">
					<h4><?php echo "具体描述：".htmlentities($row['describe'],ENT_NOQUOTES,'UTF-8')  ?></h4>
				</div>
				<div class="col-md-10" style="height: 500px;">
					<h5><?php echo "答：".htmlentities($row['answer'],ENT_NOQUOTES,'UTF-8')  ?></h5>
				</div>
		</div>
	</body>
</html>