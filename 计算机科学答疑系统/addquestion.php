<?php
mysql_connect("localhost", "root", "root");
mysql_select_db("compsci");
mysql_query("set character set 'utf8'");
header("Content-Type:text/html; charset=utf-8");
if(!isset($_COOKIE['user'])){
	echo ("<script>alert('登录超时，请重新登录');window.location=\"login.php\"</script>");
}
if($_COOKIE['authority']!="teacher"){
	echo ("<script>alert('无权限！');window.location=\"login.php\"</script>");
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
							$sql = "SELECT * FROM teacinfo where Id like '" . $row['Id'] . "'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							echo "search.php?class=" . $row['Class'];
						?>
							>
								本学科问题库
							</a>
						</li>
						<li class="active">
							<a href="addquestion.php">
								添加知识<span class="sr-only">(current)</span>
							</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a>
								您当前处于：教师系统
							</a>
						</li>
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
				<?php
				$sql="SELECT * FROM teacinfo WHERE `username` LIKE '".$_COOKIE['user']."'";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				?>
				<ul class="nav nav-list active">
					<li class="">
					<a href="search.php?class=<?php echo $row["Class"]  ?>">
					<h4><?php echo $row["Class"]  ?></h4>
					</a>
					</li>
					<?php
					$sql2 = "SELECT * FROM classinfo WHERE class LIKE '". $row["Class"] . "'";
					$result2 = mysql_query($sql2);
					while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
						echo "  	<div class=\"col-md-2\">
					</div>
					<div class=\"col-md-10\">
					<li class=\"\">
					<a href=\"search.php?class=" . $row["Class"] . "&character=" . $row2['character'] . "\">
					" . $row2['character'] . "
					</a>
					</li>
					</div>";
					?>
				</ul>
			</div>
			<div class="col-md-9">
				<!--  This div to write right page   -->
				<div class="col-md-10">
					<h1>
						在此添加问题
					</h1>
				</div>
				<div class="col-md-10">
					<form method="post" action="addquestion.php" class="form-horizontal">
						<div class="form-group">
							<label for="Question" class="col-sm-2 control-label">题目:</label>
							<div class="col-sm-10">
								<input type="text" name="Question" class="form-control" id="Question">
							</div>
						</div>
						<div class="form-group">
							<label for="Class" class="col-sm-2 control-label">所属学科:</label>
							<div class="col-sm-10">
								<input type="text" name="Class" class="form-control" id="Class" placeholder="<?php echo $row['Class'] ?>" value="<?php echo $row['Class'] ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="Charapter" class="col-sm-2 control-label">所属范围:</label>
							<div class="col-sm-10">
								<select class="form-control" id="Charapter" name="Charapter">
								<?php
									$sql="SELECT * FROM classinfo WHERE class LIKE '".$row['Class']."'";
									$result=mysql_query($sql);
									while($ret=mysql_fetch_array($result,MYSQL_ASSOC))
										if($row['character']!=$ret['character'])
										echo '<option value="'.$ret['character'].'">'.$ret['character'].'</option>'; 
								?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="Describe" class="col-sm-2 control-label">问题描述:</label>
							<div class="col-sm-10">
								<textarea name="Describe" class="form-control" rows="4"></textarea>																																								
							</div>
						</div>
						<div class="form-group">
							<label for="answer" class="col-sm-2 control-label">答案:</label>
							<div class="col-sm-10">
								<textarea name="answer" class="form-control" rows="10"></textarea>																																								
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
<?php
	$sql = "Select * from teacinfo where username like '" . $_COOKIE['user'] . "'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$teacherID=$row['Id'];
	if(isset($_REQUEST['answer'])){
	$sql = "INSERT INTO `compsci`.`queslib` (`Id`, `question`, `describe`, `answer`, `solved`, `stuid`, `teacher`, `dateput`, `dateout`, `class`, `character`) 
									VALUES (NULL, '".$_REQUEST['Question'] ."','".$_REQUEST['Describe']."','".$_REQUEST['answer']."',1, NULL, '".$teacherID."','".date('Y-m-d')."','".date('Y-m-d')."','".$_REQUEST['Class']."','".$_REQUEST['Charapter']."');";
	$result=mysql_query($sql);
		if($result){
			echo '<script>alert("修改成功！");location.replace(location.href);</script>';
		}
		else{
			echo '<script>alert("修改失败！");location.replace(location.href);</script>';
		}	
	}
?>
<script>
	function check() {
				if($("#Question").val()=="") {alert("问题不能为空!"); return false;}
				if($("#Experiment").val()=="") {alert("专家不能为空!");return false;}
				if($("#Charapter").val()=="") {alert("所属范围不能为空!");return false;}
				if($("#Class").val()=="") {alert("所属学科不能为空!");return false;}
				if($("#answer").val()=="") {alert("所属学科不能为空!");return false;}
				return true;
			}
</script>