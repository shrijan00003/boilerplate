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
					We received a request to reset your password for your {site_name} account: {email}. <br>
					<br>
					To reset the password, simply click the button below to confirm your password reset request.
					<br>
					<br>
					<a href="{confirmation_url}" title="Confirm Password Resets" style="
					padding: 7px 6px;
				    background: #4479BA;
				    color: #FFF;
				    text-decoration:none;
				    border: solid 1px #20538D;
					">
						Confirm Password Reset
					</a>
					<br>
					<br>
					Or, paste this link into your browser: <br>
					<a href="{confirmation_url}">{confirmation_url}</a>
					<br>
					<br>
					If you didn't ask to reset your password, Don't worry!!! Your password is still safe and you can ignore this email.<br><br>
					--<br>
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