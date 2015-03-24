<?php
// Set Message Web Site
include("/home/dev01/2010_readyplanet_com/grandadmin/quotation_sales_data_new.php");
$messageweb = "## เพื่อลดและป้องกันความผิดพลาดเนื่องจากการไม่ได้รับอีเมล ##<br/>
## ดังนั้น อีเมลฉบับนี้ อาจมีการส่งมาให้ท่านมากกว่า 1 ครั้ง ##<br/>
## โปรดอ่าน คำแนะนำด้านล่างอย่างละเอียด ##<br/>

เรื่อง การแจ้งเตือนการต่ออายุบริการ Google Apps for Business<br/><br/>

เรียน คุณ $detail[FirstName]<br/><br/>

ขณะนี้ Google Apps for Business ( $row[domain] ) ของท่าน กำลังจะหมดอายุภายในวันที่  $expired_date (ปี-เดือน-วัน)<br/>
หากท่านประสงค์จะต่ออายุบริการ สามารถทำได้โดย<br/><br/>

ชำระค่าต่ออายุบริการ Google Apps for Business ($row[numSeats] ผู้ใช้) ด้วยราคาต่อไปนี้<br/>
ระยะเวลา 1 ปี ราคา $renew_gapp_1y บาท<br/>
ระยะเวลา 2 ปี ราคา $renew_gapp_2y บาท<br/>
ระยะเวลา 3 ปี ราคา $renew_gapp_3y บาท<br/>
***ถ้าท่านต้องการหัก ณ ที่จ่าย ราคานี้รวม vat 7% แล้ว หัก ณ ที่จ่าย 3% (ค่าบริการ)***<br/><br/>
	
*** หมายเหตุ : ในกรณีที่ท่านใช้โดเมนเนมกับ ReadyPlanet ราคานี้ได้รวมราคาต่ออายุโดเมนเนมเรียบร้อยแล้ว<br/><br/>

ทางบริษัทฯต้องขออภัยเป็นอย่างสูง หากท่านได้ชำระค่าบริการต่ออายุก่อนที่จะไดัรับอีเมลฉบับนี้ <br/><br/><br/>


วิธีชำระเงิน<br/><br/>

1. ชำระออนไลน์ ผ่านบัตรเครดิต (ปลอดภัย) โดยคลิ๊กที่นี่<br/>
    &nbsp;&nbsp;http://www.readyplanet.com/Member-Area/Payment.html<br/><br/>

------------------------<br/>
หรือ<br/>
2. ชำระด้วยการโอนเงินเข้าบัญชีธนาคาร<br/><br/>

ชื่อบัญชี บริษัท เรดดี้แพลนเน็ต จำกัด บัญชี ออมทรัพย์<br/>
ธนาคาร กสิกรไทย สาขา ถ.สุขาภิบาล 3 เลขที่บัญชี 735-2-29271-5 หรือ<br/>
ธนาคาร กรุงเทพ สาขา ถ.สุขาภิบาล 3 เลขที่บัญชี 056-0-185266 หรือ<br/>
ธนาคาร ไทยพาณิชย์ สาขา ถ.สุขาภิบาล 3 เลขที่บัญชี 136-2-12270-6 หรือ<br/>
ธนาคาร กรุงไทย สาขา ถ.สุขาภิบาล 2 เลขที่บัญชี 197-1-10016-1 หรือ<br/>
ธนาคาร กรุงศรีอยุธยา สาขา ถ.สุขาภิบาล 2 เลขที่บัญชี 296-1-19001-6<br/><br/>

หมายเหตุ...!!!!!!!! แล้วแฟกซ์ใบเสร็จการโอนเงินมาที่ fax ".$fax_office2."<br/>
พร้อมลงชื่อและที่อยู่เบอร์โทร เพื่อเป็นการยืนยัน<br/>
--------------------------<br/><br/>
		
กรณีหักภาษี ณ ที่จ่าย ให้ระบุที่อยู่ดังต่อไปนี้<br/>
เลขประจำตัวผู้เสียภาษีอากร 0105543071964<br/>
บริษัท เรดดี้แพลนเน็ต จำกัด<br/>
202 อาคาร เลอ คองคอร์ด ชั้น 9 ห้อง 903<br/>
ถนนรัชดาภิเษก แขวงห้วยขวาง เขตห้วยขวาง<br/>
กรุงเทพมหานคร 10310<br/><br/>
		
หากมีข้อสงสัยประการใด โปรดติดต่อ โทร. ".$tel_office." (auto), 02-917-9612-4<br/>
ตลอด 24 ชั่วโมง ทุกวัน<br/>
http://www.ReadyPlanet.com<br/>
บริการเว็บสำเร็จรูปพร้อมใช้ แห่งแรกของไทย<br/><br/>

Support Team<br/>
ReadyPlanet Co.,Ltd.<br/>
202 Le Concorde Tower, 9th Floor, Room 903, Ratchadapisek Road, Huaykwang, Huaykwang, Bangkok 10310 http://www.ReadyPlanet.com<br/>
E-mail : info@readyplanet.com, support@ReadyPlanet.com<br/>
Tel. : ".$tel_office." (auto), 02-917-9612-4, Fax. : ".$fax_office2."<br/><br/>

-------------------------------------------------------------------------------------------------------<br/><br/>
				
## To avoid any mistake might be happened , ##<br/>
## probably you will receive this e-mail for several time. ## <br/>
## Please read carefully the below information. ##<br/><br/>
		
Subject: Notices for Google Apps for Business Service Renewal.<br/><br/>

Dear Mr. $detail[FirstName] ,<br/><br/>
		
Please be informed that your Google Apps for Business( $row[domain] )  are being expired on $expired_date.<br/><br/>

If you would like to renew your Google Apps for Business( $row[numSeats] user ) please settle the payment into our account.<br/>
THB $renew_gapp_1y for one year,<br/>
THB $renew_gapp_2y for two years and<br/>
THB $renew_gapp_3y for three years<br/><br/>

Please select the process of payment as follow:-<br/><br/>

1.. Payment Online system. ( High security)<br/>
     http://www.readyplanet.com/Member-Area/Payment-Online.php<br/><br/>

------------------------<br/><br/>

2.. Transfer the money into our account<br/><br/>

Account Name: ReadyPlanet Co., Ltd<br/>
Type of account: Saving<br/><br/>

Kasikorn Bank Public Company Limited Branch:  Sukhapiban 3 road Account No: 735-2-29271-5  or<br/>
Bangkok Bank Public Company LimitedBranch:  Sukhapiban 3 road Account No: 056-0-18526-6  or<br/>
Siam Commercial Bank Public Company Limited Branch:  Sukhapiban 3 road Account No: 136-2-12270-6  or<br/>
KrungThai Bank Public Company Limited Branch:  Sukhapiban 2 road Account No: 197-1-10016-1<br/>
KrungSri Bank Public Company Limited Branch:  Sukhapiban 2 road Account No: 296-1-19001-6<br/><br/><br/>

	
Remark:<br/>
Please fax us the slip payment with your signature, address and telephone number to ".$fax_office2.".<br/>
-------------------------- <br/><br/>
		
Once again thank you for using our service. If you have any questions,<br/>
please contact us at ".$tel_office." (auto), 02-917-9612-4  anytime. <br/><br/>
		
With best regards,<br/><br/>
		
ReadyPlanet Team<br/>
E-mail : info@readyplanet.com<br/><br/><br/>

		
P.S. please accept our apology if the process of Website Service Renewal<br/>
has done before we send this mail to you.<br/>												
";
?>