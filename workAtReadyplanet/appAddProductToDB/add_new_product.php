<?php

include("inc_dbconnect.php");
$sql = mysql_db_query($dbname, "SELECT * 
                                FROM ready_new_members_product_type 
                                WHERE product_type_status = 1 or product_type_status = 0 
                                ORDER BY product_type_id ASC");

if(isset($_POST[type])){
    $s = "SELECT step_price FROM ready_product WHERE step_price != ' ' && product_type_id = '$_POST[type]' ORDER BY pid DESC LIMIT 0 , 1";
    $rs = mysql_db_query($dbname, $s);
    $row = mysql_fetch_array($rs);
    echo ++$row[step_price];
    exit();
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
        <style>
            td{font-family:Tahoma,Microsoft Sans Serif;color:#333333;font-size:12px;padding-left:5px;}
        </style>
        <title>Grand Office Admin</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <style type="text/css">
            h2 {padding-top: 50px;}
        </style>
        <script>
            $(document).ready(function() {
                $("input[name='pro_price_exclude_vat']").keyup(function() {
                    $("input[name='pro_price']").val(($("input[name='pro_price_exclude_vat']").val() * 1.07).toFixed(2));
                });
                
                $("input[name='pro_price_exclude_vat']").blur(function() {
                    var zeroDefault = 0;
                    
                    if($("input[name='pro_price_exclude_vat']").val() <= 0){
                        $("input[name='pro_price_exclude_vat']").val(zeroDefault);
                        $("input[name='pro_price']").val(($("input[name='pro_price_exclude_vat']").val() * 1.07).toFixed(2));
                    }
                });
                
                $("select[name='product_type_id']").change(function() {
                    var type = $("select[name='product_type_id']").val();
                    if(type == 21 || type == 22){
                        $.post("add_new_product.php",{type: type})
                        .done(function(data){$("input[name='step_price']").val(data.trim());});
                    }
                    else {
                        $("input[name='step_price']").val("");
                    }
                });
                
                $("button[name='save']").click(function (){
                    if(!checkData()){return false;} //check input data
                    
                    $.post("add_new_product_db.php",
                            {
                                pname: $("input[name='pname']").val(),
                                pstatus: $("input[name='pstatus']:checked").val(),
                                product_type_id: $("select[name='product_type_id']").val(),
                                pro_acode: $("input[name='pro_acode']").val(),
                                pro_price: $("input[name='pro_price']").val(),
                                pro_year: $("input[name='pro_year']").val(),
                                BOI: $("input[name='BOI']:checked").val(),
                                remark: "",
                                pro_price_exclude_vat: $("input[name='pro_price_exclude_vat']").val(),
                                effective_date_from: $("input[name='effective_date_from']").val(),
                                effective_date_to: "",
                                step_price: $("input[name='step_price']").val()
                            }
                    )
                    .done(function(data) {
                        alert(data);
                        //$("#result").html(data);
                    })
                    .fail(function(xhr, textStatus, errorThrown) {
                        $("#result").html(errorThrown);
                    });
                });
            });
            
            function checkData(){
                var i = 0;
                
                if($("input[name='pname']").val() == ''){
                    $("input[name='pname']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='pname']").css({'border':''});
                    i++;
                }
                
                if($("select[name='product_type_id']").val() == ''){
                    $("select[name='product_type_id']").css({'border':'2px solid #E05353'});
                }else{
                    $("select[name='product_type_id']").css({'border':''});
                    i++;
                }
                
                if($("input[name='pro_acode']").val() == ''){
                    $("input[name='pro_acode']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='pro_acode']").css({'border':''});
                    i++;
                }
                
                if($("input[name='pro_price']").val() == '' || isNaN($("input[name='pro_price']").val()) || Math.round($("input[name='pro_price']").val()/1.07) != $("input[name='pro_price_exclude_vat']").val()){
                    $("input[name='pro_price']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='pro_price']").css({'border':''});
                    i++;
                }
                
                if($("input[name='pro_price_exclude_vat']").val() == '' || isNaN($("input[name='pro_price_exclude_vat']").val()) || $("input[name='pro_price_exclude_vat']").val() < 0){
                    $("input[name='pro_price_exclude_vat']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='pro_price_exclude_vat']").css({'border':''});
                    i++;
                }
                
                if($("input[name='pro_year']").val() == '' || isNaN($("input[name='pro_year']").val()) || $("input[name='pro_year']").val() < 0){
                    $("input[name='pro_year']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='pro_year']").css({'border':''});
                    i++;
                }
                
                if(!$("input[name='BOI']").is(':checked')){
                    $("label").css({'color':'#E05353'});
                }else{
                    $("label").css({'color':''});
                    i++;
                }
                
                if($("input[name='effective_date_from']").val() == ''){
                    $("input[name='effective_date_from']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='effective_date_from']").css({'border':''});
                    i++;
                }
                
                if(($("select[name='product_type_id']").val() == 21 || $("select[name='product_type_id']").val() == 22) && $("input[name='step_price']").val() == ''){
                    $("input[name='step_price']").css({'border':'2px solid #E05353'});
                }else{
                    $("input[name='step_price']").css({'border':''});
                    i++;
                }
                
                if(i == 9){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
    </head>
    <body>
    <center><b><h2>Add New Product</h2></center>
            <table width='30%' cellspacing='0' border='0' align='center'><br/>
                <tr>
                    <td>ชื่อสินค้า</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='pname' /></td>
                </tr>

                <tr>
                    <td>ปี</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='pro_year' maxlength="3" /></td>
                </tr>

                <tr>
                    <td>สถานะสินค้า</td>
                    <td>
                        <INPUT TYPE='Radio' Name='pstatus' Value='1' checked/>เปิด
                        <INPUT TYPE='Radio' Name='pstatus' Value='0' />ปิด
                    </td>
                </tr>

                <tr>
                    <td>กลุ่มสินค้า</td>
                    <td><select name='product_type_id'>
                            <option value=''>กรุณาเลือกกลุ่มสินค้า</option>
                        <?php
                        while ($rs = mysql_fetch_array($sql)) {
                            echo "<option value='$rs[product_type_id]'>$rs[product_type_name]</option>";
                        }
                        ?>
                        </select></td>
                </tr>

                <tr>
                    <td>รหัสบัญชี</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='pro_acode' /></td>
                </tr>

                <tr>
                    <td>ราคาก่อน vat</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='pro_price_exclude_vat' value="0" /></td>
                </tr>

                <tr>
                    <td>ราคารวม vat</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='pro_price' value="0.00" /></td>
                </tr>

                <tr>
                    <td>BOI</td>
                    <td>
                        <input type='Radio' Name='BOI' Value='B' /><label for="BOI">BOI</label>
                        <input type='Radio' Name='BOI' Value='NB' /><label for="BOI">NON-BOI</label>
                    </td>
                </tr>

                <tr>
                    <td>วันเริ่มใช้</td>
                    <td><input type='date' class='textbox' style='width:250px;' name='effective_date_from' value="<?=date("Y-m-d")?>" /></td>
                </tr>

                <tr>
                    <td>Step price</td>
                    <td><input type='text' class='textbox' style='width:250px;' name='step_price' /></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td><button name="save">Save</button></td>
                </tr>

            </table>
        <center><div id="result"></div></center>
    </body>
</html>
