<!DOCTYPE html>
<?php
	if(isset($_REQUEST["username"])&&isset($_REQUEST["password"])){
		header("content-type:text/html;charset=utf-8");
		$dbh=new PDO("mysql:host=localhost;port=3306;dbname=compsci","root","root");
		$dbh->exec("SET CHARACTER SET utf-8");
		if($_REQUEST["inlineRadioOptions"]=="teacher")
		$result=$dbh->query("SELECT * FROM teacinfo WHERE username LIKE '".trim($_REQUEST["username"])."'");
		else 
		$result=$dbh->query("SELECT * FROM stuinfo WHERE username LIKE '".trim($_REQUEST["username"])."'");
		$row=$result->fetch();
		if(!$row["password"]) echo "<script>alert(\"用户名不存在！\")</script>";
		else if($row["password"]!=$_REQUEST["password"])
			echo "<script>alert(\"密码错误\")</script>";
		else{
			setcookie("user",$row["username"],time()+3600);
			setcookie("authority",$_REQUEST["inlineRadioOptions"],time()+3600);
			if($_REQUEST["inlineRadioOptions"]=="student")echo "<script>window.location.href='mainpage.php'</script>";
			if($_REQUEST["inlineRadioOptions"]=="teacher")echo "<script>window.location.href='teacher.php'</script>";
			die();
		}
		$dbh=NULL;
	}else if(isset($_COOKIE['user'])&&isset($_COOKIE['authority'])){
		if($_COOKIE['authority']=="student")echo "<script>window.location.href='mainpage.php'</script>";
		if($_COOKIE['authority']=="teacher")echo "<script>window.location.href='tobesolved.php'</script>";
	}
?>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			欢迎来到计算机科学答疑系统
		</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/login.css"/>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/usually_actions.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			function clearInput () {
				$("#username").val("");
				$("#password").val("");
			}
		</script>
		<!---------------------------------------------------------------------->
	</head>
	<body>
		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand">
								计算机科学答疑系统
							</h3>
							<nav>
								<ul class="nav masthead-nav">
									<li class="active">
										<a href="login.php">
											登录
										</a>
									</li>
									<li>
										<a href="register.php">
											注册
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="inner cover">
						<form class="form-horizontal" method="post" action="login.php">
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label">用户名:</label>
								<div class="col-sm-10">
									<input id="username" type="text" class="form-control" name="username" placeholder="Username"/>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-2 control-label">密码:</label>
								<div class="col-sm-10">
									<input id="password" type="password" class="form-control" name="password" placeholder="Password"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="teacher" checked="checked">
									教师用户
									<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="student" >
									学生用户
								</div>
							</div>
							<div class="form-group" align="right">
								<div class="col-sm-offset-2 col-sm-10" >
									<button type="submit" class="btn btn-primary" onclick="check();">
										登录
									</button>
									<button type="button" class="btn btn-primary" onclick="javascript:clearInput();">
										清空
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	function check() {
				if($("#username").val()=="") {alert("用户名不能为空!"); return false;}
				if($("#password").val()=="") {alert("密码不能为空!");return false;}
				return true;
			}
</script>
