<?php
require("PHPMailer_v5.1/class.phpmailer.php"); 
	$email = "konbabaka@hotmail.com";
	$subject = "ทดสอบจ้า";
	$body = "เทสๆ";
	$result = smtpmail($email , $subject , $body);
	echo $result;

function smtpmail( $email , $subject , $body )
{
    $mail = new PHPMailer();
    $mail->IsSMTP();          
    $mail->CharSet = "utf-8";
	$mail->Host     = "mail.atpmail.net"; //  mail server ของเรา
    $mail->SMTPAuth = true;     //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "silver247@atpmail.net";   //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "bullet007";  //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง

    $mail->From     = "silver247@atpmail.net";  //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "ทดสอบจ้า"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
    $mail->AddAddress($email);            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
    $mail->IsHTML(false);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
    $mail->Subject     =  $subject;        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body     = $body;                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
     $result = $mail->send();        
     return $result;
}
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="email" method="post">
<input type="text" name="address"  />
<input type="text" name="subject" />
<textarea name="mailbody" cols="70" rows="5"></textarea>
<input type="submit" name="submit" value="submit" />
</form>
</body>
</html>!-->