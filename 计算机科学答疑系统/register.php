<!DOCTYPE html>
<?php
header("Content-Type:text/html; charset=utf-8");
if(isset($_POST["username"])){
$con = mysql_connect("localhost","root","root");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("compsci", $con);
mysql_query("set character set 'utf8'");
if(isset($_POST["username"]))
$sql="SELECT * FROM stuinfo WHERE username LIKE '".$_POST["username"]."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if(!empty($row)){
	echo('<script>alert("用户名已存在,请重新输入");</script>');
	die("<script>location.replace(location.href)</script>");
	return ;
}
$sql="INSERT INTO stuinfo (username, password, email,Name)
VALUES
('".$_POST['username']."','".$_POST['password']."','".$_POST['email']."','".$_POST['name']."')";
if (!mysql_query($sql,$con))
{
die('Error: ' . mysql_error());
}
mysql_close($con);
setcookie("user",$_POST["username"],time()+3600);
setcookie("authority","student",time()+3600);
echo "<script>window.location.href='mainpage.php'</script>";
}else{
	
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
		<!---------------------------------------------------------------------->
		<script type="text/javascript">
			function clearInput () {
				$("#username").val("");
				$("#password").val("");
				$("#password2").val("");
				$("#name").val("");
				$("#email").val("");
			}
			function check() {
				if($("#username").val()=="") {alert("用户名不能为空!"); return false;}
				if($("#password").val()=="") {alert("密码不能为空!");return false;}
				if($("#name").val()=="") {alert("姓名不能为空!");return false;}
				if($("#email").val()=="") {alert("电子邮箱不能为空!");return false;}
				if($("#password").val()!=$("#password").val()) {alert("两次密码不一致!");return false;}
				return true;
			}
		</script>
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
									<li class="">
										<a href="login.php">
											登录
										</a>
									</li>
									<li class="active">
										<a href="register.php">
											注册
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="inner cover">
						<form class="form-horizontal" method="post" action="register.php">
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label">用户名:</label>
								<div class="col-sm-10">
									<input id="username" type="text" class="form-control" name="username" placeholder="Username"/>
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">姓名:</label>
								<div class="col-sm-10">
									<input id="name" type="text" class="form-control" name="name" placeholder="Name"/>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-2 control-label">密码:</label>
								<div class="col-sm-10">
									<input id="password" type="password" class="form-control" name="password" placeholder="Password"/>
								</div>
							</div>
							<div class="form-group">
								<label for="password2" class="col-sm-2 control-label">重复密码:</label>
								<div class="col-sm-10">
									<input id="password2" type="password" class="form-control" name="password2" placeholder="Password"/>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Email:</label>
								<div class="col-sm-10">
									<input id="email" type="email" class="form-control" name="email" placeholder="Email"/>
								</div>
							</div>
							<div class="form-group" align="right">
								<div class="col-sm-offset-2 col-sm-10" >
									<button type="submit" class="btn btn-primary" onclick="return check();">
										注册
									</button>
									<button type="button" class="btn btn-primary" onclick="clearInput();">
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
