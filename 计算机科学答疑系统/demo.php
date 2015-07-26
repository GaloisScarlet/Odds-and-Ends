<?php
function sendmail($student_email,$student_name,$student_question,$teacher_name) {
	require_once ('phpmailer/class.phpmailer.php');
	require_once ("phpmailer/class.smtp.php");
	$mail = new PHPMailer();
	$mail -> CharSet = "UTF-8";
	//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
	$mail -> IsSMTP();
	// 设定使用SMTP服务
	$mail -> SMTPAuth = true;
	// 启用 SMTP 验证功能
	$mail -> SMTPSecure = "ssl";
	// SMTP 安全协议
	$mail -> Host = "smtp.163.com";
	// SMTP 服务器
	$mail -> Port = 25;
	// SMTP服务器的端口号
	$mail -> Username = "lyqatdl";
	// SMTP服务器用户名
	$mail -> Password = "jason951116";
	// SMTP服务器密码
	$mail -> SetFrom('lyqatdl@163.com', '计算机科学答疑系统');
	// 设置发件人地址和名称
	$mail -> AddReplyTo('lyqatdl@163.com', '计算机科学答疑系统');
	// 设置邮件回复人地址和名称
	$mail -> Subject = '您的问题已被解答';
	// 设置邮件标题
	$mail -> AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
	// 可选项，向下兼容考虑
	$mail -> MsgHTML('您的问题： '.$student_question.' 已被专家： '.$teacher_name." 回答，请及时进入系统查看！");
	// 设置邮件内容
	$mail -> AddAddress($student_email, $student_name);
	//$mail->AddAttachment("images/phpmailer.gif"); // 附件
	if (!$mail -> Send()) {
		echo "发送失败：" . $mail -> ErrorInfo;
	} else {
		echo "恭喜，邮件发送成功！";
	}
}
sendmail("1085612037@qq.com", "刘宇擎", "这里是问题", "这里是教师");
?>