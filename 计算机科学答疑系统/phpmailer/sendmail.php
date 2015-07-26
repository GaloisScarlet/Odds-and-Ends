<?php
/**
 * by www.phpddt.com
 */
function sendMailToStudent($stu_name, $stu_email, $stu_question, $tea_name) {
	header("content-type:text/html;charset=utf-8");
	ini_set("magic_quotes_runtime", 0);
	require 'class.phpmailer.php';
	try {
		$mail = new PHPMailer(true);
		$mail -> IsSMTP();
		$mail -> CharSet = 'UTF-8';
		//设置邮件的字符编码，这很重要，不然中文乱码
		$mail -> SMTPAuth = true;
		//开启认证
		$mail -> Port = 25;
		$mail -> Host = "smtp.163.com";
		$mail -> Username = "lyqatdl@163.com";
		$mail -> Password = "jason951116";
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail -> AddReplyTo("lyqatdl@163.com", "计算机科学答疑系统");
		//回复地址
		$mail -> From = "lyqatdl@163.com";
		$mail -> FromName = "计算机科学答疑系统";
		$to = $stu_email;
		$mail -> AddAddress($to);
		$mail -> Subject = "您的问题有了新答案";
		$mail -> Body = $stu_name . " 您好！您的问题 " . $stu_question . " 由老师 " . $tea_name . " 给出了新答案，请及时阅览！";
		$mail -> AltBody = $stu_name . " 您好！您的问题 " . $stu_question . " 由老师 " . $tea_name . " 给出了新答案，请及时阅览！";
		//当邮件不支持html时备用显示，可以省略
		$mail -> WordWrap = 80;
		// 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail -> IsHTML(true);
		$mail -> Send();
		echo '邮件已发送';
	} catch (phpmailerException $e) {
		echo "邮件发送失败：" . $e -> errorMessage();
	}
}

function sendMailToTeacher($tea_email, $stu_question, $tea_name) {
	header("content-type:text/html;charset=utf-8");
	ini_set("magic_quotes_runtime", 0);
	require 'class.phpmailer.php';
	try {
		$mail = new PHPMailer(true);
		$mail -> IsSMTP();
		$mail -> CharSet = 'UTF-8';
		//设置邮件的字符编码，这很重要，不然中文乱码
		$mail -> SMTPAuth = true;
		//开启认证
		$mail -> Port = 25;
		$mail -> Host = "smtp.163.com";
		$mail -> Username = "lyqatdl@163.com";
		$mail -> Password = "jason951116";
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail -> AddReplyTo("lyqatdl@163.com", "计算机科学答疑系统");
		//回复地址
		$mail -> From = "lyqatdl@163.com";
		$mail -> FromName = "计算机科学答疑系统";
		$to = $tea_email;
		$mail -> AddAddress($to);
		$mail -> Subject = "您有一个新的问题待解答";
		$mail -> Body = $tea_name . " 您好！有学生提出了新的问题： ".$stu_question." ，请回答！";
		$mail -> AltBody = $tea_name . " 您好！有学生提出了新的问题： ".$stu_question." ，请回答！";
		//当邮件不支持html时备用显示，可以省略
		$mail -> WordWrap = 80;
		// 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail -> IsHTML(true);
		$mail -> Send();
	} catch (phpmailerException $e) {
		echo "邮件发送失败：" . $e -> errorMessage();
	}
}
?>