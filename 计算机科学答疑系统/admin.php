
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			计算机科学答疑系统--后台
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
		<table class="table">
		<div align="center"><h2>管理后台</h2></div>
		<tr>
		<form class="form-inline" method="post" action="ADMIN/1.php">
			<td>
			<h2>课程管理</h2>
			</td>
			<td>
			<div class="form-group">
				<label for="ClassName">课程名</label>
				<input type="text" class="form-control" id="ClassName" placeholder="请输入课程名" name="ClassName">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="CharapterName">章节名</label>
				<input type="text" class="form-control" id="CharapterName" placeholder="请输入章节名" name="CharapterName">
			</div>
			</td>
			<td>
				<td><input type="hidden" name="type" value="class"> </td>
				<td></td>
				<td></td>
				<td>
			<button type="submit" class="btn btn-default">
				增加
			</button>
			</td>
		</form>
		</tr>
		<tr>
		<form class="form-inline" method="post" action="ADMIN/2.php">
			<td>
			<h2>教师管理</h2>
			<input type="hidden" name="type" value="teacher"> 
			</td>
			<td>
			<div class="form-group">
				<label for="teacherName">教师姓名</label>
				<input type="text" class="form-control" id="teacherName" placeholder="请输入教师姓名" name="teacherName">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="username">用户名</label>
				<input type="text" class="form-control" id="username" placeholder="请输入用户名" name="username">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="password">密码</label>
				<input type="password" class="form-control" id="password" placeholder="请输入密码" name="password">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="email">电子邮箱</label>
				<input type="email" class="form-control" id="email" placeholder="电子邮箱" name="email">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="ClassName">课程名</label>
				<input type="text" class="form-control" id="ClassName" placeholder="请输入课程名" name="ClassName">
			</div>
			</td>
			<td>
			<div class="form-group">
				<label for="introduce">简介</label>
				<input type="text" class="form-control" id="introduce" placeholder="请输入简介" name="introduce">
			</div>
			</td>
			<td>
			<button type="submit" class="btn btn-default">
				增加
			</button>
			</td>
		</form>
		</tr>
		<tr>
		<form class="form-inline" method="post" action="ADMIN/3.php">
			<td>
			<h2>学生管理</h2>
			</td>
			<td>
			<div class="form-group">
				<label for="stuName">学生用户名</label>
				<input type="text" class="form-control" id="stuName" placeholder="学生用户名" name="stuName">
			</div>
			</td>
			
				<td><input type="hidden" name="type" value="student"> </td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			<td>
			<button type="submit" class="btn btn-default">
				删除
			</button>
			</td>
		</form>
		</tr>
		</table>
	</body>
</html>
<?php





?>