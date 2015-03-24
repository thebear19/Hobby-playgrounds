<?php
session_start();
include("inc_dbconnect.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Split Bank Statement</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://www.jacklmoore.com/js/jquery.autosize.js"></script>
        <script>
            $(document).ready(function () {
                $("textarea[name='detail']").autosize();//textarea autosize
                
                $("button[name='preview']").click(function() {
                    data = prepareData();
                    if(data != false){
                        $("button[name='submit']").show();
                        $("button[name='close']").hide();
                        jqSendData(data,"bank_statement_split_preview.php");
                    }
                    else{
                        alert("กรุณากรอกข้อมูลให้ครบและถูกต้องครบถ้วน");
                    }
                });
                
                $("button[name='submit']").click(function() {
                    data = prepareData();
                    if(data != false){
                        jqSendData(data,"bank_statement_split_sendmail.php");
                        $("button[name='submit']").hide();
                        $("button[name='close']").show();
                    }
                    else{
                        alert("กรุณากรอกข้อมูลให้ครบและถูกต้องครบถ้วน");
                    }
                });
            });
            
            function showRefNo (){
                if($("select[name='payment_by']").val() == 4 || $("select[name='payment_by']").val() == 6){//Mail Order หรือ Payment Gateway
                    $("#refRow").show("fast");
                }
                else{
                    $("input[name='refNo']").val("");
                    $("#refRow").hide("fast");
                }
            }
            
            function jqSendData (input,url){
                $("#result").html("Loading...");
                $.post(url,
                    {
                        input: input
                    }
                )
                .done(function(data) {
                    $("#result").html(data);
                })
                .fail(function(xhr, textStatus, errorThrown) {
                    $("#result").html(errorThrown);
                });
            }
            
            function prepareData (){
                var i = 0;
                
                if($("input[name='transferDate']").val() == ''){
                    $("input[name='transferDate']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("input[name='transferDate']").css({'border':''});
                    i++;
                }
                
                if($("input[name='amount']").val() == '' || $("input[name='amount']").val() <= 0 || isNaN($("input[name='amount']").val())){
                   $("input[name='amount']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("input[name='amount']").css({'border':''});
                    i++;
                }
                
                if($("select[name='bank']").val() == ''){
                    $("select[name='bank']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='bank']").css({'border':''});
                    i++;
                }
                
                if($("select[name='payment_by']").val() == ''){
                    $("select[name='payment_by']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='payment_by']").css({'border':''});
                    i++;
                }
                
                if($("input[name='refNo']").val() == '' && ($("select[name='payment_by']").val() == 4 || $("select[name='payment_by']").val() == 6)){
                    $("input[name='refNo']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("input[name='refNo']").css({'border':''});
                    i++;
                }
                
                if($("textarea[name='detail']").val() == ''){
                    $("textarea[name='detail']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("textarea[name='detail']").css({'border':''});
                    i++;
                }
                
                if(i == 6){
                    var data = [
                        $("input[name='transferDate']").val(),
                        $("input[name='amount']").val(),
                        $("select[name='bank']").val(),
                        $("select[name='payment_by']").val(),
                        $("input[name='refNo']").val(),
                        $("textarea[name='detail']").val()
                    ];
                    return data;
                }else{
                    return false;
                }
            }
        </script>
    </head>
    <body>
    <center><h2>Bank Statement Split</h2></center>
        <table width="95%" cellspacing="0" border="0" align="center">
            <tr>
                <!--#####################ฝั่งซ้าย ฟอร์มกรอกข้อมูล####################-->
                <td width='50%' align='left' valign='top'>
                    <table width="100%" cellspacing="0" border="0" style="border:1px solid #555555;" cellpadding="3" align="right" bgcolor="#FAFAFA">
                        <tr>
                            <td colspan="2" align='center' bgcolor='#999999' style='font-weight: bold;color:#FFFFFF;'>แจ้งแตกยอดรับชำระ</td>
                        </tr>
                        <tr>
                            <td align = "right" style = "padding-right:5px">วันที่โอนเงิน : </td>
                            <td>
                                <input style="width:242px;" type="text" name="transferDate" onfocus="(this.type = 'date')" onblur="(this.type = 'text')" placeholder="วันที่โอนเงิน" />
                            </td>
                        </tr>

                        <tr>
                            <td align = "right" style = "padding-right:5px">จำนวนเงินรวม : </td>
                            <td><input style="width:242px;" type="text" name="amount" maxlength="9" placeholder="จำนวนเงินรวม" /> ฿</td>
                        </tr>

                        <tr>
                            <td align = "right" style = "padding-right:5px">ธนาคาร : </td>
                            <td>
                                <select name="bank" style="width:246px;" >
                                    <option value="">กรุณาเลือกธนาคาร</option>
                                    <?php
                                    $sql_bank = "SELECT * FROM ready_account_bank ORDER BY bank_id ASC";
                                    $se_bank = mysql_db_query($dbname, $sql_bank);
                                    while ($re_bank = mysql_fetch_array($se_bank)) {
                                        echo "<option value='$re_bank[bank_name]'>$re_bank[bank_name] $re_bank[bank_description]</option>";
                                    }
                                    ?>				
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td align = "right" style = "padding-right:5px">ช่องทางการชำระเงิน : </td>
                            <td>
                                <select name="payment_by" onchange="showRefNo()">
                                    <option value="">กรุณาเลือกช่องทางการชำระเงิน</option>
                                    <?php
                                    $sql_payment = "SELECT * FROM ready_account_payment ORDER BY weight DESC";
                                    $se_payment = mysql_db_query($dbname, $sql_payment);
                                    while ($re_payment = mysql_fetch_array($se_payment)) {
                                        echo "<option value='$re_payment[pay_id]'>$re_payment[payment_by] ($re_payment[remark])</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr id="refRow" style="display: none">
                            <td align = "right" style = "padding-right:5px">เลขที่อ้างอิง : </td>
                            <td><input style="width:242px;" type="text" name="refNo" placeholder="เลขที่อ้างอิง" /></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" align='center'><u>รายละเอียดของแต่ละยอดเงินที่ต้องการให้แตก</u></td>
                        </tr>
                        
                        <tr>
                            <td align='center' colspan="2"><textarea name="detail" style="width: 80%; height: 100px"></textarea></td>
                        </tr>
                        
                        <tr>
                            <td align='center' colspan="2"><button name="preview" >Preview</button></td>
                        </tr>
                    
                    </table>   
                </td>

                <!--#####################ฝั่งขวา Mail Preview####################-->
                <td width="50%" valign='top'>
                    <table width="100%" cellspacing="0" border="0" style="border:1px solid #555555;" cellpadding="3" align="right" bgcolor="#FAFAFA">
                        <tr>
                            <td align='center' bgcolor='#0066CC' style='font-weight: bold;color:#FFFFFF;'>Mail Preview</td>
                        </tr>
                        
                        <tr>
                            <td><div id="result"></div></td>
                        </tr>
                        
                        <tr>
                            <td align='center'>
                                <button name="submit" style="display: none" >Send mail</button>
                                <button name="close" style="display: none" onClick='self.close()' >Close</button>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>