<?
include "connect.php";
include "button.php";
?>
<html>
<style type="text/css">
table .info{
	background:#ffffff;
	border-width:1px;
	border-style:solid;
	border-color:black;
}
</style>
<body>
<table width="800" border="0" align="center">
<tr><td>
<h3>รายงานข้อมูลเชิงสถิติ</h3>
<br/>
4.1 รายงานจำนวนโครงการที่ดำเินการแ้ล้วเสร็จ โครงการที่อยู่ระหว่างดำเนินการ โครงการที่ยังไม่ถึงกำหนดดำเนินการ โครงการที่ขอยกเลิก จำแนกตามสำนักและกอง
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td rowspan="2" width="320">สำนักและกอง</td>
	<td rowspan="2" width="120">แล้วเสร็จ</td>
	<td colspan="2" width="120" height="30">อยู่ระหว่างดำเนินการ</td>
	<td rowspan="2" width="120">ขอยกเลิก</td>
	<td rowspan="2" width="120">รวม</td>
</tr>
<tr align="center">
	<td width="60">เป็นไปตามกำหนด</td>
	<td width="60">ล่าช้ากว่ากำหนด</td>
</tr>
<tr height="35">
	<td>1.) สำนักบริหารกลาง(สบก.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>2.) กองการประชุมคณะรัฐมนตรี(กปค.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>3.) สำนักนิติธรรม(สนธ.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>4.) สำนักบริหารงานสารสนเทศ(สบส.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>5.) สำนักวิเคราะห์เรื่องเสนอคณะรัฐมนตรี(สวค.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>6.) สำนักส่งเสริมและประสานงานคณะรัฐมนตรี(สปค.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>7.) สำนักอาลักษณ์และเครื่องราชอิสริยาภรณ์(สอค.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>8.) กลุ่มพัฒนาระบบบริหาร(กพร.)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td align="center">รวม</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>
4.2 รายงานจำนวนโครงการที่ดำเินินการแล้วเสร็จ โครงการที่อยู่ระหว่างดำเนินการ โครงการที่ยังไม่ถึงกำหนดดำเนินการ โครงการที่ขอยกเลิก จำแนกตามยุทธศาสตร์
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td rowspan="2" width="320">ยุทธศาสตร์ของ สลค.</td>
	<td rowspan="2" width="120">แล้วเสร็จ</td>
	<td colspan="2" width="120" height="30">อยู่ระหว่างดำเนินการ</td>
	<td rowspan="2" width="120">ขอยกเลิก</td>
	<td rowspan="2" width="120">รวม</td>
</tr>
<tr align="center">
	<td width="60">เป็นไปตามกำหนด</td>
	<td width="60">ล่าช้ากว่ากำหนด</td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td align="center">รวม</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>
4.3 รายงานภาพรวมงบประมาณโครงการจำแนกตามแหล่งงบประมษณ
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="200">แหล่งงบประมาณ</td>
	<td width="200">งบประมาณที่ได้รับจัดสรร (บาท/%)</td>
	<td width="200">งบประมาณที่เบิกจ่ายแล้ว (บาท/%)</td>
	<td width="200">คงเหลือ (บาท/%)</td>
</tr>
<tr height="35">
	<td>งบประมาณประจำปี...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>งบมูลนิธิคอนราด อาเดนาวร์</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>เงินกันปี...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>เงินกันปี...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td align="center">รวม</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>

4.4 รายงานภาพรวมงบประมาณโครงการจำแนกตามยุทธศาสตร์
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="200">แหล่งงบประมาณ</td>
	<td width="200">งบประมาณที่ได้รับจัดสรร (บาท/%)</td>
	<td width="200">งบประมาณที่เบิกจ่ายแล้ว (บาท/%)</td>
	<td width="200">คงเหลือ (บาท/%)</td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>ยุทธศาสตร์ที่...</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td align="center">รวม</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>
4.5 รายงานภาพรวมงบประมาณโครงการจำแนกตามสำนักและกอง
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="260">แหล่งงบประมาณ</td>
	<td width="190">งบประมาณที่ได้รับจัดสรร (บาท/%)</td>
	<td width="190">งบประมาณที่เบิกจ่ายแล้ว (บาท/%)</td>
	<td width="150">คงเหลือ (บาท/%)</td>
</tr>
<tr height="35">
	<td>สำนักบริหารกลาง(สบก.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>กองการประชุมคณะรัฐมนตรี(กปค.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>สำนักนิติธรรม(สนธ.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>สำนักบริหารงานสารสนเทศ(สบส.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>สำนักวิเคราะห์เรื่องเสนอคณะรัฐมนตรี(สวค.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>สำนักส่งเสริมและประสานงานคณะรัฐมนตรี(สปค.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>สำนักอาลักษณ์และเครื่องราชอิสริยาภรณ์(สอค.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>กลุ่มพัฒนาระบบบริหาร(กพร.)</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td align="center">รวม</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>
4.6 รายงานภาพรวมงบประมาณการเบิกจ่ายงบประมาณจำแนกตามแหล่งงบประมาณ และสำนักและกอง
<br/>
<center>ประมาณการเบิกจ่ายงบประมาณของโครงการที่ใช้งบประมาณรายจ่ายประจำปี 25..</center>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="50" rowspan="2">สำนัก</td>
	<td rowspan="2">งบประมาณที่ได้รับจัดสรร</td>
	<td rowspan="2">เบิกจ่ายแล้ว</td>
	<td colspan="8">ประมาณการเบิกจ่ายรายเดือน</td>
	<td rowspan="2">กันไว้เบิกปี 25..</td>
	<td rowspan="2">รวมค่าใช้จ่าย</td>
	<td rowspan="2">คงเหลือคืนคลัง</td>
</tr>
<tr height="30">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>1.) สบก.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>2.) กปค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>3.) สนธ.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>4.) สบส.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>5.) สวค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>6.) สปค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>7.) สอค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>8.) กพร.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td colspan="2" align="center">ร้อยละ</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td colspan="2" align="center">ร้อยละสะสม</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>
<br/>
<center>ประมาณการเบิกจ่ายงบประมาณของโครงการที่ใช้งบประมาณมูลนิธิคอนราด อาเดนาวร์ ประจำปี 25..</center>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="50" rowspan="2">สำนัก</td>
	<td rowspan="2">งบประมาณที่ได้รับจัดสรร</td>
	<td rowspan="2">เบิกจ่ายแล้ว</td>
	<td colspan="8">ประมาณการเบิกจ่ายรายเดือน</td>
	<td rowspan="2">กันไว้เบิกปี 25..</td>
	<td rowspan="2">รวมค่าใช้จ่าย</td>
	<td rowspan="2">คงเหลือคืนคลัง</td>
</tr>
<tr height="30">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="30">
	<td>1.) สบก.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>2.) กปค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>3.) สนธ.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>4.) สบส.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>5.) สวค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>6.) สปค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>7.) สอค.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>8.) กพร.</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td colspan="2" align="center">ร้อยละ</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td colspan="2" align="center">ร้อยละสะสม</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>
<br/>
<center>ภาพรวมประมาณการเบิกจ่ายงบประมาณรายเดือนของโครงการ ประจำปี 25..</center>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="50" rowspan="2">โครงการ</td>
	<td rowspan="2">สำนัก</td>
	<td rowspan="2">ระยะเวลาดำเนินการ</td>
	<td rowspan="2">งบประมาณที่ได้รับจัดสรร</td>
	<td rowspan="2">ประเภทงบ</td>
	<td rowspan="2">เบิกจ่ายแล้ว</td>
	<td colspan="12">ประมาณการเบิกจ่ายรายเดือน</td>
	<td rowspan="2">กันไว้เบิกปี 25..</td>
	<td rowspan="2">รวมค่าใช้จ่าย</td>
	<td rowspan="2">คงเหลือคืนคลัง</td>
</tr>
<tr>
	<td>ตค</td>
	<td>พย</td>
	<td>ธค</td>
	<td>มค</td>
	<td>กพ</td>
	<td>มีค</td>
	<td>เมย</td>
	<td>พค</td>
	<td>มิย</td>
	<td>กค</td>
	<td>สค</td>
	<td>กย</td>
</tr>
<tr height="35">
	<td>1.) โครงการ...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>

<br/>

<h3>รายงานข้อมูลแบบแสดงรายการ</h3>
<br/>
5.1 รายชื่อโครงการ
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td width="50">โครงการ</td>
	<td>สำนัก/กอง</td>
	<td>ยุทธศาสตร์</td>
	<td>แหล่งงบประมาณ</td>
	<td>ประเภทงบประมาณ</td>
	<td>ลักษณะโครงการ</td>
	<td>งบประมาณ</td>
	<td>งบประมาณที่ใช้ไป</td>
	<td>งบประมาณคงเหลือ</td>
	<td>สถานะโครงการ</td>
</tr>
<tr height="35">
	<td>1.) โครงการ...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>
<br/>
5.2 Gantt chart รายโครงการ
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td rowspan="2">โครงการ</td>
	<td rowspan="2">สำนัก/กอง</td>
	<td rowspan="2">งบประมาณ</td>
	<td rowspan="2">ลักษณะโครงการ</td>
	<td colspan="12">แผนการดำเนินการ</td>
	<td rowspan="2">สถานะโครงการ</td>
</tr>
<tr>
	<td>ตค</td>
	<td>พย</td>
	<td>ธค</td>
	<td>มค</td>
	<td>กพ</td>
	<td>มีค</td>
	<td>เมย</td>
	<td>พค</td>
	<td>มิย</td>
	<td>กค</td>
	<td>สค</td>
	<td>กย</td>
</tr>
<tr height="35">
	<td>1.) โครงการ...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>
<br/>
5.3 Gantt chart รายโครงการ กิจกรรมภายใต้โครงการ
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="info">
<tr align="center">
	<td rowspan="2">โครงการ</td>
	<td rowspan="2">สำนัก/กอง</td>
	<td rowspan="2">งบประมาณ</td>
	<td rowspan="2">ลักษณะโครงการ</td>
	<td colspan="12">แผนการดำเนินการ</td>
	<td rowspan="2">สถานะโครงการ</td>
</tr>
<tr>
	<td>ตค</td>
	<td>พย</td>
	<td>ธค</td>
	<td>มค</td>
	<td>กพ</td>
	<td>มีค</td>
	<td>เมย</td>
	<td>พค</td>
	<td>มิย</td>
	<td>กค</td>
	<td>สค</td>
	<td>กย</td>
</tr>
<tr height="35">
	<td>1.) โครงการ...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>&nbsp;&nbsp;1.1.) กิจกรรม...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>&nbsp;&nbsp;1.2.) กิจกรรม...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr height="35">
	<td>&nbsp;&nbsp;1.3.) กิจกรรม...</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>
</td></tr>
</table>
</body>
</html>