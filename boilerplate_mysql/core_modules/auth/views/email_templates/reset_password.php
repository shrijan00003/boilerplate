<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="background:#EBEBEB;padding:25px;font-family:sans-serif; line-height:125%;font-size:100%">
		<table align="center" width="700" background="#FFFFFF" style="text-align:left;background:#fff;" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%" bgcolor="" style="padding:15px;border:1px solid #000000;border-bottom:0px">
					<h2>{site_name}</h2>
				</td>
			</tr>
			<tr>
				<td style="padding:15px;border-right:1px solid #000000;border-left:1px solid #000000;line-height:175%">
					<!--CONTENT STARTS HERE-->
					Hello <strong>{username}</strong>, <br><br>
					This email confirms that your password has been reset.<br>Please find your new access credentials as follow:
					<br><br>
					Username: <strong>{username}</strong><br>
					Password: <strong>{password}</strong><br>
					<br>
					--<br/>
					Thank you.<br>
					{site_name} Admin<br>
					<br>
					<hr>
					<span style="font-size:90%;color:#aaa">
						Some Message
					</span>
				</td>
			</tr>
			<tr>
				<td width="100%" align="center" bgcolor="" style="border:1px solid #000000;border-top:0px">&nbsp;</td>
			</tr>
		</table>
		<center><span style="font-size:12px;line-height:150%;color:#999"><br>{site_name} &copy; {year}. All Rights Reserved. <br>
		</span>
</center>
</body>
</html>