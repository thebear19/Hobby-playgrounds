<?php
session_start();
include("../inc_dbconnect.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

$saleRow = $invoice->getSale($_POST[adminID]);
$companyRow = $invoice->getCompany($_POST[companyID]);

foreach ($_POST[itemNote] as &$value) {
    $value = $invoice->convertBigText($value);
}

?>
<head>
    <title>Quotation</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style>
        td,div,p{font:11px Microsoft Sans Serif,Tahoma;color:#000000;}
        h1{display:inline;font:35px Arial,Verdana;color:#000000;font-weight:bold;}
        h2{display:inline;font:13px Microsoft Sans Serif,Tahoma;color:#000000;font-weight:bold;}
        h3{display:inline;font:20px Microsoft Sans Serif,Tahoma;color:#000000;font-weight:bold;}
        td.border{border:1px solid #000000;}
    </style>
</head>
<body bgcolor="#CCCCCC">
    <table width="780" border="0" cellspacing="10" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
            <td colspan="2" height="8"></td>
        </tr>
        
        <tr>
            <td width="48%"><img src="../../images/ReadyPlanet-logo-2013.png" width="40%" /></td>
            <td width="52%">&nbsp;</td></tr>
        <tr>
            <td>
                <h2><?=$companyRow[name]?></h2><br />
                <?="$companyRow[address] $companyRow[province] $companyRow[zipcode]"?><br />
                <?= "Tel : " . $tel_us . ", &nbsp;Fax : " . $fax_us . " " ?><br />
                Email : <a href="mailto:info@readyplanet.com" target="_blank">info@readyplanet.com</a><br />
                Tax ID : 0105543071964 <br />
            </td>
            <td align="right" valign='top' style="padding-right:15px;">
                <h1>Quotation</h1><br />
                <h3>No. QA<?=$_POST[qno]?></h3>
            </td>
        </tr>

        <tr valign="top">
            <td style="padding-left:10px;">
                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                        <td width="20%" valign="top" nowrap><b>Attention : </b></td>
                        <td valign="top" nowrap><?=iconv("utf-8", "tis-620", $_POST[attention])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Company : </b></td>
                        <td valign="top"><?=iconv("utf-8", "tis-620", $_POST[company])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Address : </b></td>
                        <td valign="top"><?=iconv("utf-8", "tis-620", $_POST[add])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Province : </b></td>
                        <td valign="top"><?=iconv("utf-8", "tis-620", $_POST[province])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Zipcode : </b></td>
                        <td valign="top"><?=$_POST[zip]?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Tel : </b></td>
                        <td valign="top"><?=$_POST[tel]?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Fax : </b></td>
                        <td valign="top"><?=$_POST[fax]?></td>
                    </tr>
                    
                </table>
            </td>
            <td>
                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                        <td width="25%" valign="top"><b>From : </b></td>
                        <td valign="top"><?=iconv("utf-8", "tis-620", $_POST[attention_sale])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Tel : </b></td>
                        <td valign="top"><?=$tel_office . ' Ext ' . $_POST[tel_ext]?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Direct line : </b></td>
                        <td valign="top"><?=$_POST[directLine]?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Fax : </b></td>
                        <td valign="top"><?=$fax_us?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top"><b>Create Date : </b></td>
                        <td valign="top"><?=$invoice->convertDate($_POST[issue])?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top" nowrap><b>Valid Until : </b></td>
                        <td valign="top"><?=$invoice->convertDate($_POST[validUntil])?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding-left:10px;padding-bottom:5px;"><B>We are pleased to submit you the following service quotation : </b></td>
        </tr>
       
            <tr>
                <td colspan="2" valign="top">

                    <table width="96%" cellpadding="2" cellspacing="0" border="0" bordercolor="#000000" style="border-collapse:collapse;" align="center">
                        <tr align="center">
                            <td class="border" style="border-left:0px;" width="1%" align='center'><h6>Item</h6></td>
                            <td class="border" width="10%" align='center'><h6>Product Code</h6></td>
                            <td class="border" width="81%" align='center'><h6>Service</h6></td>
                            <td class="border" width="10%" align='center'><h6>*BOI / NB </h6></td>
                            <td class="border" width="11%" align='center'><h6>Price / Unit</h6></td>
                            <td class="border" colspan="2" width="8%" align='center'><h6>Unit(s)</h6></td>
                            <td class="border" style="border-right:0px;" width="1%" align='center'>
                                <h6>Total<br/>(<?=$_POST[monetary]?>)</h6>
                            </td>
                        </tr>

                        <?php
                        for($index = 0, $itemcount = 1;$index < 10;$index++){
                            if($_POST[service][$index] != ''){
                                $service = explode("-", $_POST[service][$index]);
                                $productRow = $invoice->getProduct($service[0]);
                                
                                if($productRow[pname] == 'Facebook Advertising Cost'){$checkFAC == TRUE;}
                                
                                ?>

                                <tr align="center" valign="top">
                                    <td><?=$itemcount?></td>
                                    <td align="center" style="padding-left:5px;"><?=$productRow[pro_acode]?></td>
                                    <td align="left" style="padding-left:5px;">
                                        <?=nl2br($productRow[pname])?><br/><?=$_POST[itemNote][$index]?>
                                    </td>
                                    <td align="center"><?php if($productRow[BOI] == 'B'){echo "BOI";$countBOI++;}else{echo "Non-BOI";}?></td>
                                    <td align="right" style="padding-right:10px;"><?=number_format($_POST[price][$index],2,'.',',')?></td>
                                    <td align="center" colspan="2"><?=$_POST[unit][$index]?></td>
                                    <td align="right"><?=number_format($_POST[amount][$index],2,'.',',')?></td>
                                </tr>
                        <?php
                                $itemcount++;
                            }
                        }
                        
                        if ($_POST[note]) { ?>			
                            <tr align="center" valign="top">
                                <td></td>
                                <td colspan='2' align="left" cellpadding="0" cellspacing="10"><?=iconv("utf-8", "tis-620", nl2br($_POST[note]))?></td>
                            </tr>
                        <?php } ?>
	
                        <tr align="center">
                            <td colspan="3"></td>
                            <td colspan="3" style="border-bottom:1px dotted #000000;" align="left"><b>Sub Total</b></td>
                            <td colspan="2" style="border-bottom:1px dotted #000000;"  align="right">
                                <?=number_format($_POST[totalprice], 2, '.', ',')?>
                            </td>
                        </tr>
                        
                        <tr align="center">
                            <td colspan="3"></td>
                            <td colspan="3" style="border-bottom:1px solid #000000;" align="left"><b>Vat (<?=$_POST[vatSp]?>%)</b></td>
                            <td colspan="2" style="border-bottom:1px solid #000000;"  align="right">
                                <?php if($_POST[vatprice] == 0){echo '-';}else{echo number_format($_POST[vatprice],2,'.',',');}?>
                            </td>
                        </tr>
                        
                        <tr align="center">
                            <td colspan="3"></td>
                            <td colspan="3" style="border-bottom:3px double #000000;" align="left"><b>Grand Total</b></td>
                            <td colspan="2" style="border-bottom:3px double #000000;" align="right">
                                <?=number_format($_POST[nettotalprice], 2, '.', ',')?>
                            </td>
                        </tr>
                        
                        <tr align="left"><td colspan='8' style='border-bottom:2px solid #000000;'></td></tr>
                        
                        <tr>
                            <td colspan='8'>
                                <?php
                                echo "<br>หมายเหตุ";
                                
                                if ($_POST[withholdingTax] > 0) {
                                    echo "<br> - หักภาษี ณ ที่จ่ายเป็นจำนวน ".number_format($_POST[withholdingTax],2,'.',',')."บาท 
                                            ยอดคงเหลือ ".number_format($_POST[netAmount],2,'.',',')."บาท";
                                    
                                    echo "<br> - ในกรณีที่ลูกค้าได้หักภาษี ณ ที่จ่ายไว้ในวันชำระเงิน กรุณาส่งหนังสือรับรองการหัก ณ ที่จ่ายจำนวน 2 ฉบับมายัง บริษัทฯ ภายใน 7 วัน<br />เมื่อทางบริษัทฯ ได้รับเอกสารครบถ้วนแล้ว จะจัดส่ง \"ใบกำกับภาษี\" ไปให้ลูกค้าทางไปรษณีย์ทันที";
                                }
                                
                                if ($countBOI > 0) {
                                    echo "<br> - * สินค้า \"BOI\" ลูกค้าไม่ต้องหักภาษี ณ ที่จ่าย";
                                }
                                
                                if ($checkFAC) {
                                    echo "<br> - เงื่อนไขเรื่องระยะเวลาการให้บริการ facebook : งบประมาณที่ชําระมาสามารถใช้บริการได้ไม่เกิน 1 ปี นับจากวันที่โฆษณาเริ่มแสดงบนหน้า facebook ";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>

            <?php
            if ($saleRow[position_id] == '7' || $admin_name == "Areesa" || $admin_name == "Chatchawan") {
                echo "<tr valign='top'>";
                echo "<td colspan='6'><h2>***</h2><u>เงื่อนไขเรื่องระยะเวลาการให้บริการตามแพคเกจ</u> :
                    ระยะเวลาบริการโฆษณาเว็บไซต์ เริ่มนับเมื่อโฆษณาขึ้นแสดงบนกูเกิลในวันแรก จนถึงระยะเวลาครบตามแพคเกจ กรณีหยุดโฆษณาชั่วคราวในช่วงเวลาของแพคเกจนั้นๆ 
                    ขอสงวนสิทธิในการเลื่อนระยะเวลาบริการ ราคาค่าบริหารจัดการนี้ สำหรับลูกค้าที่ใช้วงเงินค่าคลิกโฆษณาไม่เกิน 50,000 บาทต่อเดือนเท่านั้น</td>";
                echo "</tr>";
            }
            ?>

            <tr valign="top">
                <td colspan="2">
                    
                    <?php if($_POST[companyID] == 1){ ?>

                    <h2><u>การชำระเงิน</u></h2>
                    <br />
                    <br />
                    โอนเงินผ่านธนาคารเข้าบัญชีชื่อ&quot;บริษัท เรดดี้แพลนเน็ต จำกัด&quot;
                    <br />
                    <table width="60%" cellpadding="0" cellpadding="3" border="0">
                        <tr>
                            <td>ธนาคารกสิกรไทย</td>
                            <td>สาขาถนนรามคำแหง 151</td>	
                            <td>บัญชีออมทรัพย์</td>
                            <td>เลขที่ 735-2-29271-5</td>
                        </tr>
                        <tr>
                            <td>ธนาคารไทยพาณิชย์ </td>
                            <td>สาขาถนนรามคำแหง (สัมมากร)</td>
                            <td>บัญชีออมทรัพย์</td>
                            <td>เลขที่ 136-2-12270-6</td>
                        </tr>
                        <tr>
                            <td>ธนาคารกรุงเทพ</td>
                            <td>สาขาถนนรามคำแหง (สุขาภิบาล 3)</td>
                            <td>บัญชีออมทรัพย์</td>
                            <td>เลขที่ 056-0-18526-6</td>
                        </tr>
                        <tr>
                            <td>ธนาคารกรุงไทย</td>
                            <td>สาขาสุขาภิบาล 2</td>
                            <td>บัญชีออมทรัพย์</td>
                            <td>เลขที่ 197-1-10016-1</td>
                        </tr>
                        <tr>
                            <td>ธนาคารกรุงศรีอยุธยา</td>
                            <td>สาขาสุขาภิบาล 2</td>
                            <td>บัญชีออมทรัพย์</td>
                            <td>เลขที่ 296-1-19001-6</td>
                        </tr>
                        <tr>
                            <td>ธนาคารธนชาต</td>
                            <td>สาขารัชดา-ห้วยขวาง</td>
                            <td>บัญชีกระแสรายวัน</td>
                            <td>เลขที่ 295-3-00826-4</td>
                        </tr>
                    </table>
                    <?= "(กรุณาส่งหลักฐานการโอนเงินทาง Fax " . $fax_us . " เพื่อการตรวจเช็คและยืนยัน)" ?>
                    <?php                     
                    }else{ ?>
                        <h2><u>Payment Method</u></h2>
                        <br />
                        <br />
                        Please make a money transfer to "Readyplanet Co.,Ltd" account as follows :
                        <br />
                        <table width="60%" cellpadding="0" cellpadding="3" border="0">
                            <tr>
                                <td>Siam Commercial Bank</td>
                                <td>Ramkhamhaeng 151 Road Branch</td>	
                                <td>Saving account</td>
                                <td># 136-2-12270-6</td>
                            </tr>
                            
                            <tr>
                                <td>Krungthai Bank</td>
                                <td>Sukhaphiban 3 Branch</td>
                                <td>Saving account</td>
                                <td># 197-1-10016-1</td>
                            </tr>
                        </table>
                   <?php }?>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">

                    <table width="90%">
                        <tr height="1" valign="bottom">
                            <td width="55%">
                                <span style="font-size:13px;"><b>Approved by</b> ______________________________</span>
                            </td>
                            
                            <td>
                                <span style="font-size:13px;">
                                    <b>Proposed by </b> 
                                        <?php if ($saleRow[SaleID] != 99) { 
                                            print "<img src='../../images/signature"; 
                                            print $saleRow[SaleID]; 
                                            print ".gif' hspace='15'>"; 
                                            
                                        } else { 
                                            print " ____________________________"; 
                                            
                                        } ?>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><span style="margin:0 0 0 100;">(  </span><span style='margin:0 0 0 180;'> )</span></td>
                            <td><div style="margin:0 0 0 105;"> ( <?=iconv("utf-8", "tis-620", $_POST[attention_sale])?> ) </div></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="60">&nbsp;</td>
            </tr>
    </table>
</body>