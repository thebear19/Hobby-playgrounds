<?php
session_start();
include("../inc_dbconnect.php");
include("../inc_checkerror.php");
include("../config_saleTeamAll.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

$companyRow = $invoice->getCompany($_GET[sp]);
$saleRow = $invoice->getSale($admin_id);
if($saleRow[position_id] == 7 && $saleRow[random_status] == "operation" && $saleRow[active_status] == 1){
    $customerRow = $invoice->getCustomerQA($_GET[customerID], $_GET[newmemberid]);
    $web_name_webpro = $invoice->getDomain($_GET[newmemberid], 1);
}else{
    $customerRow = $invoice->getCustomerQA($_GET[customerID]);
    $web_name_webpro = $invoice->getDomain($_GET[newmemberid]);
}

$qaNo = $invoice->nextQA();

$isSP = $_GET[sp];

$now = new DateTime('NOW');
$now = $now->format("Y-m-d");

if($isSP == 2){
    $saleRow[admin_name_en] = ucfirst(strtolower("$saleRow[admin_name_en]"));
    $saleRow[admin_lastname_en] = ucfirst(strtolower("$saleRow[admin_lastname_en]"));
    $saleName = "$saleRow[admin_name_en] $saleRow[admin_lastname_en]";
}else{
    $saleName = "$saleRow[admin_name_th] $saleRow[admin_lastname_th]";
}
?>

<head>
    <title>Quotation</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://www.jacklmoore.com/js/jquery.autosize.js"></script>
    
    <script src="invoice.js"></script>
    
    <meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
    <style>
        td,div,p{font:13px Microsoft Sans Serif,Tahoma;color:#000000;}
        h1{display:inline;font:35px Arial,Verdana;color:#000000;font-weight:bold;}
        h2{display:inline;font:13px Microsoft Sans Serif,Tahoma;color:#000000;font-weight:bold;}
        h3{display:inline;font:20px Microsoft Sans Serif,Tahoma;color:#000000;font-weight:bold;}
        td.border{border:1px solid #000000;}
    </style>
</head>
<body id="result" bgcolor="#CCCCCC">
<form action="" method="post" id="quotationForm" >
<table width="780" border="0" cellspacing="10" cellpadding="0" align="center" bgcolor="#FFFFFF">
    <tr>
        <td width="50%">
            <table width="100%" border="0">
                <tr>
                    <td width="20%">Company :</td>
                    <td><?=$companyRow[name]?></td>
                </tr>
            
                <tr>
                    <td>Address :</td>
                    <td><?="$companyRow[address] $companyRow[province] $companyRow[zipcode]"?></td>
                </tr>

                <tr>
                    <td>Tel :</td>
                    <td><?=$tel_us?></td>
                </tr>

                <tr>
                    <td>Fax :</td>
                    <td><?=$fax_us?></td>
                </tr>

                <tr>
                    <td>Email :</td>
                    <td>
                        <a href="mailto:info@readyplanet.com" target="_blank">info@readyplanet.com</a>
                    </td>
                </tr>

                <tr>
                    <td>Tax ID :</td>
                    <td>0105543071964</td>
                </tr>
            </table>
        </td>
        
        

        <td align="right" valign='top' style="padding-right:15px;">
            <h1>Quotation</h1><br />
            <h3>No. QA<?=$qaNo?></h3>
        </td>
    </tr>

    <tr>
        <td colspan="2" height="15"></td>
    </tr>

    <tr valign="top">
        <td width="50%" style="padding-left:10px;">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td width="37%" valign="top" nowrap>
                        <b>Attention : </b>
                    </td>

                    <td valign="top" nowrap>
                        <input type="text" class="textbox" name="attention" style="width:210px;" value="<?="$customerRow[FirstName] $customerRow[LastName]"?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Company : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:210px;" name="company" value="<?=$customerRow[Organization]?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Address : </b></td>
                    <td valign="top">
                        <textarea class="textbox" style="width:210px;height:60px;" name="add"><?=$customerRow[Address]?></textarea>
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Province : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:210px;" name="province" value="<?=$customerRow[Province]?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Zipcode : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:160px;" name="zip" value="<?=$customerRow[ZipCode]?>">
                    </td>
                </tr>		

                <tr>
                    <td valign="top"><b>Tel : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:160px;" name="tel" value="<?=$customerRow[Phone]?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Fax : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:160px;" name="fax" value="<?=$customerRow[Fax]?>">
                    </td>
                </tr>
                
                <tr>
                    <td valign="top"><b>Domain : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:160px;" name="domain" value="<?=$web_name_webpro?>">
                    </td>
                </tr>
                
                <tr>
                    <td valign="top"><b>Customer Type : </b></td>
                    <td valign="top">
                        <select name='customer_type' onchange="holdingTax();">
                            <option value=''>Please select</option>
                            <?php
                            $cusRow = $invoice->getCustomerType();
                            foreach ($cusRow as $customer) {
                                echo "<option value='$customer[0]' $checkCus>$customer[0]</option>";
                            }
                            ?>
                        </select>
                        <font style="color:#FF0000">*</font>
                    </td>
                    
                </tr>
                        
	
                <tr>
                    <td valign="top"><b>Business Type : </b></td>
                    <td valign="top">
                        <select name='business_type'>
                            <option value=''>Please select</option>
                            <?php
                            $buRow = $invoice->getBusinessType();
                            foreach ($buRow as $business) {
                                echo "<option value='$business[0]' $checkBu>$business[0]</option>";
                            }
                            ?>
                        </select>
                        <font style="color:#FF0000">*</font>
                    </td>
                    
                </tr>                
            </table>
        </td>

        
        <td width="50%">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td width="25%" valign="top" nowrap><b>From : </b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:210px;" name="attention_sale" value="<?=$saleName?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Tel : </b></td>
                    <td valign="top"><?=$tel_us?>
                        &nbsp;Ext&nbsp;
                        <input type="text" class="textbox" style="width:45px;" name="tel_ext" maxlength="4" value="<?=$saleRow[admin_tel_int]?>">
                    </td>
                </tr>
                
                <tr>
                    <td valign="top"><b>Direct line :</b></td>
                    <td valign="top">
                        <input type="text" class="textbox" style="width:140px;" name="directLine" value="<?=$saleRow[admin_direct]?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Fax : </b></td>
                    <td valign="top"><?=$fax_us?></td>
                </tr>
                
                <tr>
                    <td valign="top"><b>Create Date : </b></td>
                    <td valign="top"><?=$now?></td>
                </tr>

                <tr>
                    <td valign="top" nowrap><b>Valid Until :</b></td>
                    <td valign="top">
                        <input type="date" name="validUntil" class="textbox" size="25" style="width:140px;" value = "">
                        <font style="color:#FF0000">*</font>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" height="10"></td>
    </tr>

    <tr>
        <td colspan="2" valign="top">
            <?php
            if ($position_id == 7 and ( !in_array($admin_name, $arr_sale_team_all))) {
                $apply_contact = "9999-00-00";
                $exp_contact = "0000-00-00";
                $qr_contact_cus = mysql_db_query($dbname, "select * from adword_contract_customer where DomainName='$web_name_webpro'");
                $num_row_contract_cus = mysql_num_rows($qr_contact_cus);
                if ($num_row_contract_cus > 0) {
                    while ($rs_contact_cus = mysql_fetch_array($qr_contact_cus)) {
                        $rs_apply_contact = $rs_contact_cus[StartDate];
                        $rs_exp_contact = $rs_contact_cus[EndDate];
                        if ($rs_apply_contact < $apply_contact) {
                            $apply_contact = $rs_apply_contact;
                        }
                        if ($rs_exp_contact > $exp_contact) {
                            $exp_contact = $rs_exp_contact;
                        }
                    }
                    //คำนวนวันหมดอายุเกิน 6 เดือนหรือยัง
                    $datenow = date("Y-m-d");
                    $cal_age_contract = (strtotime($datenow) - strtotime($exp_contact)) / ( 60 * 60 * 24 );
                    $renew_clickcost_date = $cal_age_contract / 30;
                    //echo "$renew_clickcost_date<br>";
                    //เชคก่อนเลยหมดอายุเกิน 6 เดือนหรือไม่ ถ้าเกินได้ราคาไปเลย 9630
                    if ($renew_clickcost_date >= 6) {
                        $product57 = "yes";
                        //}elseif($renew_clickcost_date <0 and $apply_contact >="2014-01-01"){
                        //	$product57 = "yes";
                    } else {

                        //หายอดชำระครั้งล่าสุด
                        $qr_clearing_clickcost = mysql_db_query($dbname, "select * from ready_office_clearing a  " .
                                "inner join ready_new_members b on a.newmemberid=b.ID  " .
                                "where (b.Product_Description like '%XA%' or  b.Product_Description like '%ZA%' or b.Product_Description like '%ZB%' or  b.Product_Description like '%ZC%' or b.Product_Description like '%AC%' or b.Product_Description like '%AA%' or b.Product_Description like '%BB%' or b.Product_Description like '%ZZ%') and b.status >'0' and b.DomainName='$web_name_webpro' order by b.ID DESC limit 0,1");
                        $count_qr_clearing_clickcost = mysql_num_rows($qr_clearing_clickcost);

                        // มีการชำระเงินด้วยราคาเก่า
                        if ($count_qr_clearing_clickcost > 0) {
                            $rs_qr_clearing_clickcost = mysql_fetch_array($qr_clearing_clickcost);

                            $qr_price_clearing = mysql_db_query($dbname, "select * from ready_new_members_detail where ready_new_members_id='$rs_qr_clearing_clickcost[ID]' and ready_product_pro_pcode IN ('XA','ZA','ZB','ZC','AC','AA','BB','ZZ')");
                            $num_qr_price_clearing = mysql_num_rows($qr_price_clearing);
                            if ($num_qr_price_clearing > 0) {
                                while ($rs_price_clearing = mysql_fetch_array($qr_price_clearing)) {

                                    $price_clearing_clickcost = $rs_price_clearing[price_decimal];
                                    $no_clearing_clickcost = $rs_price_clearing[ready_new_members_id];
                                    $date_clearing_clickcost = $rs_price_clearing[clearing_date];
                                    $product_clearing_clickcost = $rs_price_clearing[ready_product_pname];
                                    $table_width = 50;
                                    $product57 = "no";
                                }
                            } else {
                                //				echo "$rs_qr_clearing_clickcost[ID] => $rs_qr_clearing_clickcost[pay_on_date]<br>";
                                $product57 = "yes";
                                $table_width = 40;
                            }


                            // ไม่เคยชำระเงินด้วยราคาเก่า
                        } else {
                            $product57 = "yes";
                            $table_width = 40;
                        }
                    }
                    //echo "$table_width<br>";
                    echo "<table width='$table_width%' align='right' cellspacing='0' border='0'>";
                    if ($price_clearing_clickcost) {
                        echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #F5F5F5'>ราคาแพ็คเกจล่าสุด  </td>  <td style='background-color: #F5F5F5;font-weight:bold'>: $price_clearing_clickcost (No.$no_clearing_clickcost)</td></tr>";
                        echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #F5F5F5'>วันที่ชำระล่าสุด  </td>  <td style='background-color: #F5F5F5'>: $date_clearing_clickcost</td></tr>";
                        echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #F5F5F5'>สินค้า  </td>  <td style='background-color: #F5F5F5'>: $product_clearing_clickcost</td></tr>";
                    }

                    echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #99FF66'>วันเริ่มสัญญาครั้งแรก  </td>  <td style='background-color: #99FF66'>: $apply_contact</td></tr>";
                    echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #CCFFFF'>วันหมดอายุสัญญาล่าสุด</td>  <td style='background-color: #CCFFFF'>: $exp_contact</td></tr>";
                    if ($cal_age_contract < 0) {
                        echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #FF9933'>ยังไม่หมดอายุ</td>  <td style='background-color: #FF9933'></td></tr>";
                    } else {
                        echo "<tr><td  style='font-family:Tahoma;font-size:12px;font-weight:bold;background-color: #FF9933'>หมดอายุแล้ว</td>  <td style='background-color: #FF9933'>: $cal_age_contract วัน</td></tr>";
                    }
                    echo "</table>";
                } else {
                    $product57 = "yes";
                    echo "<table width='100%' align='right' cellspacing='0' border='0'>";
                    echo "<tr><td align='right'  style='font-family:Tahoma;font-size:14px;font-weight:bold;background-color: #FF9933'>ไม่มีข้อมูลสัญญาของ www.$web_name_webpro กรุณาตรวจสอบค่ะ</td>  <td style='background-color: #FF9933'></td></tr>";
                    echo "</table>";
                }
            }
            ?>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="center"><b>Product Detail</b></td>
    </tr>

    <tr>
        <td colspan="2" valign="top">
            <table width="90%" cellpadding="2" cellspacing="0" border="1" bordercolor="#000000" style="border-collapse:collapse;" align="center">
                <tr align="center">
                    <td><div style="font-size:12px;font-weight:bold;">Item</div></td>
                    <td><div style="font-size:12px;font-weight:bold;">Service</div></td>
                    <td><div style="font-size:12px;font-weight:bold;">Price / Unit</div></td>
                    <td colspan="2"><div style="font-size:12px;font-weight:bold;">Unit(s)</div></td>
                    <td>
                        <div style="font-size:12px;font-weight:bold;">
                            Total (<input type="text" name="monetary" style="width:50px;" value="Baht">)
                        </div>
                    </td>
                </tr>

                    <?php 
                    //####################### ดึง QA จาก ตารางเก่ายังต้องแก้ไขเพิ่มเติม ####################
                    for($k=0;$k<10;$k++){
                        $index = $k+1;
                        ?>
                <tr align = "left" valign = "bottom">
                    <td align = "center" valign="top">
                        <input type = "text" name = "item[]" style = "width:50px;" value = "<?=$index?>">
                    </td>
	
                    <td valign="top">
                        <select name="service[]" style = "width:450px" onChange = "showPrices(<?=$k?>);showNote(<?=$k?>);">
                            <option value="">---------- Please Select Service ----------</option>

                                <?php
                                $seprogroup="  SELECT * FROM ready_new_members_product_type WHERE quotation_status = 1 ";
                                if(($position_id==7 && (!in_array($admin_name,$arr_sale_team_all)))){//---sale Webpro
                                    $seprogroup.=" AND (product_type_id=7 || product_type_id=8 || product_type_id=18)";
                                }else if($position_id==19){//---renew
                                    $seprogroup.=" AND (product_type_id=6 || product_type_id=5 || product_type_id=18)";
                                }else{
                                    $seprogroup.=" AND (product_type_id !=6) AND (product_type_id !=26)";
                                }
	
                                $seprogroup.=" ORDER BY product_type_order DESC, product_type_id ASC";
	
                                $rstype=mysql_db_query($dbname,$seprogroup);
	
                                while ($arrtype = mysql_fetch_array($rstype)){
                                    $producttype_id=$arrtype[product_type_id];
                                    $producttype=$arrtype[product_type_name];
                                ?>	
                            <optgroup label = "<?=$producttype?>"> 
                                <?php
		
                                if($product57=="yes" and $arrtype['product_type_id']==8){
                                    $seproduct = "SELECT * FROM ready_product WHERE  product_type_id = '$arrtype[product_type_id]'  AND effective_date_to ='2012-01-01' ";    
                                }else{
                                    $seproduct = "SELECT * FROM ready_product WHERE  product_type_id = '$arrtype[product_type_id]' AND ( (effective_date_from <= '$UserCurrentDate'
                                            AND effective_date_to >= '$UserCurrentDate') OR (effective_date_from = 'NULL' AND effective_date_to = 'NULL') OR
                                            (effective_date_from <= '$UserCurrentDate' AND effective_date_to = 'NULL') )  ";
                                }
		
		
                                if(($position_id==1 || $position_id==10  || $admin_name=='Witida' )&& $arrtype['product_type_id']==18){//----sale Website
                                    $seproduct.=" AND (pid=662 || pid=666  || pid=668 || pid=669 || pid=673 || pid=665  || pid=673 )"; 
                                }else if(($position_id==7 && (!in_array($admin_name,$arr_sale_team_all)))&& $arrtype['product_type_id']==18){//---sale Webpro
                                    $seproduct.=" AND (pid=666 || pid=673 || pid=665 || pid=667)";
                                }else if(($position_id==0)&& $arrtype['product_type_id']==18){
                                    $seproduct.=" AND (pid=663 || pid=667 || pid=673 || pid=665)";
                                }else if(($position_id==19)&& $arrtype['product_type_id']==18){//renew
                                    $seproduct.=" AND (pid=663 || pid=673 || pid=665)";
                                }else if(($position_id==19)&& $arrtype['product_type_id']==5){//renew
                                    $seproduct.=" AND (pid=658 || pid=659)";
                                }
		
                                $seproduct.=" ORDER BY pro_order DESC, pid ASC";
                                $rsta = mysql_db_query ($dbname,$seproduct);
		
                                while ($arra = mysql_fetch_array($rsta)){
                                    $pname = $arra[pname];
                                    $pid = $arra[pid];
                                    $pro_price = $arra[pro_price_exclude_vat];
                                    $pro_acode = $arra[pro_acode];
                                    $corporationTax = $arra[corporationTax];
                                    $officialTax = $arra[officialTax];
                                    
                                    $value = "$pid-$pro_price-$producttype_id-$arra[BOI]-$corporationTax-$officialTax";
                                    $product_single_code = $arra["pro_pcode_single"];
			
                                    ?>
                                <option value = "<?=$value?>">
                                    <?php echo $pname." --- (" . "$arra[pro_acode]".") --- (" . $arra["BOI"] .")";?>
                                </option>
                                    <?php } ?>
                            </optgroup>
                                <?php } ?>
                        </select>
                        
                        <textarea name='itemNote[]' cols='53' style="display: none" placeholder="Note here..."></textarea>
                    </td>
	
                    <td colspan='2' valign="top" align='center'>
                        <input type='textbox' align='top' name='price[]' value = '' style='width:90px;' onclick='calculate(<?=$k?>);calculatesum();holdingTax();' onkeyup='calculate(<?=$k?>);calculatesum();holdingTax();' >
                    </td>
        
                    <td align='center' valign="top">
                        <input type='textbox' name='unit[]' value = '' style='width:90px;' onclick='calculate(<?=$k?>);calculatesum();holdingTax();' onkeyup='calculate(<?=$k?>);calculatesum();holdingTax();'>
                    </td>
        
                    <td align='center' valign="top">
                        <input type='textbox' name='amount[]' value = '' style='width:110px;' readonly='readonly'>
                    </td>
                </tr>

                    <?php }?>
                <tr align="center">
                    <td colspan="3" rowspan="5" valign="top">
                        note : <textarea style='padding-left:5px;' name='note' cols='73'></textarea>
                        
                        <input type="text" name="thaiword" style="width:416px;display: none;"  value = "">
                        <!--ซ่อน thaiword เพราะขณะนี้ไม่ได้ใช้-->
                    </td>
            
                    <td colspan="2">
                        <div style="font-size:14px;font-weight:bold;" align="left">Total</div>
                    </td>

                    <td>
                        <input type="text" name="totalprice" style="width:110px;" value = "" readonly='readonly'>
                    </td>
                </tr>

                <tr align="center">
                    <td colspan="2">
                        <div style="font-size:14px;font-weight:bold;" align="left">
                            Vat 
                            <input type="text" name="vatSp" style="width:30px;text-align:center;" value="7" onclick='calculatesum();calTax();' onkeyup='calculatesum();calTax();'>%
                        </div>         
                    </td>

                    <td>
                        <input type="text" name="vatprice" style="width:110px;" value = "" readonly='readonly'>
                    </td>
                </tr>

                <tr align="center">
                    <td colspan="2">
                        <div style="font-size:14px;font-weight:bold;" align="left">Grand Total</div>
                    </td>

                    <td>
                        <input type="text" name="nettotalprice" style="width:110px;" value = "" readonly='readonly'>
                    </td>
                </tr>
                
                <tr align="center" name="wtTax" style="display: none">
                    <td colspan="2">
                        <div style="font-size:14px;font-weight:bold;" align="left">
                            Withholding Tax <!--(
                            <input type="text" name="wtSpecial" style="width:30px;text-align:center;" value="0" onclick='calTax();' onkeyup='calTax();'>%)-->
                        </div>
                    </td>

                    <td>
                        <input type="text" name="withholdingTax" style="width:110px;" value="0" onclick='calTax();' onkeyup='calTax();'>
                    </td>
                </tr>

                <tr align="center" name="wtTax" style="display: none">
                    <td colspan="2">
                        <div style="font-size:14px;font-weight:bold;" align="left">Net Amount</div>
                    </td>

                    <td>
                        <input type="text" name="netAmount" style="width:110px;" value="0" readonly='readonly'>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <div style="margin:20 0 40 0;" align="center">
                <input type="button" name="submit" value=" Save ">
                <!--<input type="button" name="preview" value=" Preview ">-->
            </div>
        </td>
    </tr>
</table>
    
    <input type="hidden" name="qno" value="<?=$qaNo?>" />
    <input type="hidden" name="companyID" value="<?=$isSP?>" />
    <input type="hidden" name="adminID" value="<?=$admin_id?>" />
    <input type="hidden" name="cusID" value="<?=$_GET[customerID]?>" />
    <input type="hidden" name="issue" value="<?=$now?>" />
    <input type="hidden" name="creatorCom" value="<?=$companyRow[name]?>" />
    <input type="hidden" name="creatorAdd" value="<?="$companyRow[address] $companyRow[province] $companyRow[zipcode]"?>" />
    <input type="hidden" name="saleID" value="<?=$SaleID?>" />
    
    
    
</form>
</body>

<script>
$(document).ready(function () {
    var viewportwidth = document.documentElement.clientWidth;
    var previewWindow;

    $("select[name='service[]']").each(function(key) {
        if ($(this).val() != "" && $("input[name='companyID']").val() == 2) {
            $("textarea[name^='itemNote']").eq(key).show();
        } 
    });
        
    $("textarea").each(function() {
        $(this).autosize();//textarea autosize
    });

    if ($("input[name='totalprice']").val() != "") {
        calculatesum();
        holdingTax();
    }

    $("input[name='submit']").click(function () {
        if (confirm("Do you want to save this quotation?")) {
            if ($("select[name='customer_type']").val() == "" || $("select[name='business_type']").val() == "") {
                alert("Please select Business Type and Customer Type");
                return false;
            }
            
            if($("input[name='validUntil']").val() == ""){
                alert("Please select Valid Until");
                return false;
            }

            window.onbeforeunload = null;// if saving then block check tigger

            var form = $("#quotationForm").serialize();

            $.ajax({
                url: 'quotation_saved.php',
                type: 'POST',
                async: false,
                success: function (res) {
                    console.log(res);
                    alert(res);
                    opener.document.location.reload();
                    self.close();
                },
                error: function (e) {
                    console.log(e);
                },
                data: form,
                cache: false
            });
        }
    });

    $("input[name='preview']").click(function () {
        var form = $("#quotationForm").serialize();

        $.ajax({
            url: 'quotation_preview.php',
            type: 'POST',
            async: false,
            success: function (res) {
                previewWindow = window.open('', 'Preview Quotation', 'height=780, width=853, left=' + (viewportwidth - 300) + ', top=0');
                previewWindow.document.open();
                previewWindow.document.write(res);
                previewWindow.focus();
            },
            error: function (e) {
                console.log(e);
            },
            data: form,
            cache: false
        });
    });
});
</script>