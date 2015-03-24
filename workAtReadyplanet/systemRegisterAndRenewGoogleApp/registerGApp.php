<!DOCTYPE html>
<html>
    <title>Register Google App</title>
    <head>
        <meta charset="utf-8" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <?php
        include "../inc_dbconnect.php";
        $sql = " SELECT a.*, b.Domain_name, b.hostserver, b.Web_name
		 FROM ready_new_members a
		 INNER JOIN members_area b ON a.DomainNameNoDot = b.Domain_name
                 WHERE a.ID = '$No'";
        $query = mysql_db_query ($dbname,$sql);
        $row = mysql_fetch_array($query);
        
        $sqlY = "SELECT b.pro_year FROM ready_new_members_detail a, ready_product b
                 WHERE a.ready_product_pid = b.pid AND a.ready_new_members_id = '$No'
                 AND ( b.pro_pcode = '57PB' || b.pro_pcode = 'PB' )";
        $queryY = mysql_db_query($dbname, $sqlY);
        $rowY = mysql_fetch_array($queryY);
        
        //-------------------------แปลงเป็น UTF8 ---------------------------
        $row[DomainName] = iconv("tis-620", "utf-8", $row[DomainName]);
        $fullname = iconv("tis-620", "utf-8", $row[FirstName]." ".$row[LastName]);
        $row[Organization] = iconv("tis-620", "utf-8", $row[Organization]);
        $row[Province] = iconv("tis-620", "utf-8", $row[Province]);
        $row[Country] = iconv("tis-620", "utf-8", $row[Country]);
        $row[Address] = iconv("tis-620", "utf-8", $row[Address]);
        //----------------------------------------------------------------------------------------------
 
        //---------------------------------เช็คภาษา + แบ่งที่อยู่เป็น 2 ส่วน เขตและที่อยู่ส่วนที่เหลือ (วิธีด้านล่างอาจมี bug ไม่แนะนำให้นำไปใช้ต่อ)---------------------------------------------------
        $enMatch = "([a-z])";
        $thMacth = "([ก-ฮ])";
        if (preg_match("/{$enMatch}/", $row[Address])) {
            $pos = strripos($row[Address], ",");
            if (preg_match("/,/", $row[Address]) && $pos > strlen($row[Address]) / 2) {
                $local = preg_split("/[,]+/", $row[Address]);
            }
            elseif (preg_match("/./", $row[Address]) && substr_count($row[Address], ".") > 1) {
                $local = preg_split("/[.]+/", $row[Address]);
            }
            elseif (preg_match("/\s/", $row[Address])) {
                $local = preg_split("/[\s]+/", $row[Address]);
            }
            $max = count($local);
            $local = ($local[$max - 1] != '') ? $local[$max - 1] : $local[$max - 2];
        }
        elseif (preg_match("/{$thMatch}/", $row[Address])) {
            $local = preg_split("/[\s]+/", $row[Address]);
            $local = $local[count($local) - 1];
        }
        $pos = strripos($row[Address], $local);
        $row[Address] = substr($row[Address], 0, $pos - 1);
        $local = ltrim($local);
        //------------------------------------------END---------------------------------------------------------------------------
        ?>
        <script>
            $(document).ready(function() {
                //Dynamic button จะเห็นปุ่มนี้ก็ตัวเมื่อกด submit
                $('#result').on('click', "button[name='verify']", function(){
                    $("#result").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                    $.post("ResellerAPI.php",
                            {//---------------Send data
                                verify: ""
                            }
                    )
                    .done(function(data) {//-------------Retrieve data
                        var JSONArray = $.parseJSON(data);
                        
                        if(JSONArray.hasOwnProperty('error')){
                            $("#result").html(JSONArray.error.message + " <button name='verify'>Try again</button>");
                        }
                        else if(JSONArray.hasOwnProperty('results')){
                            $("#result").html("");
                            alert ("ยืนยันโดเเมนสำเร็จ เสร็จสิ้นกระบวนการ !!");
                            window.close();
                        }
                    })
                    .fail(function(xhr, textStatus, errorThrown) {
                        $("#result").html(errorThrown + " <button name='verify'>Try again</button>");
                    });
                });
                
                $("button[name='create']").click(function() {
                    var checkSum = 0;
                    var check = false;

                    //----------------------------------Check Input------------------------------------------
                    if ($("input[name='id']").val() == "") {
                        $("#error_id").html("<font color='red'>กรุณากรอกโดเมน</font>");
                    }
                    else {
                        $("#error_id").html("");
                        checkSum++;
                    }
                    if ($("input[name='name']").val() == "") {
                        $("#error_name").html("<font color='red'>กรุณากรอกชื่อผู้ติดต่อ</font>");
                    }
                    else {
                        $("#error_name").html("");
                        checkSum++;
                    }
                    if ($("input[name='orgName']").val() == "") {
                        $("#error_org").html("<font color='red'>กรุณากรอกชื่อองค์กร</font>");
                    }
                    else {
                        $("#error_org").html("");
                        checkSum++;
                    }
                    if ($("input[name='maxSeat']").val() == "" || isNaN($("input[name='maxSeat']").val()) || $("input[name='maxSeat']").val() <= 0) {
                        $("#error_seat").html("<font color='red'>กรุณากรอกจำนวนผู้ใช้ให้ถูกต้อง</font>");
                    }
                    else {
                        $("#error_seat").html("");
                        checkSum++;
                    }
                    if ($("input[name='year']").val() == "" || isNaN($("input[name='year']").val()) || $("input[name='year']").val() <= 0) {
                        $("#error_year").html("<font color='red'>กรุณากรอกจำนวนปีให้ถูกต้อง</font>");
                    }
                    else {
                        $("#error_year").html("");
                        checkSum++;
                    }
                    if ($("input[name='address']").val() == "") {
                        $("#error_add").html("<font color='red'>กรุณากรอกที่อยู่</font>");
                    }
                    else {
                        $("#error_add").html("");
                        checkSum++;
                    }
                    if ($("input[name='locality']").val() == "") {
                        $("#error_local").html("<font color='red'>กรุณากรอกเขต/อำเภอ</font>");
                    }
                    else {
                        $("#error_local").html("");
                        checkSum++;
                    }
                    if ($("input[name='region']").val() == "") {
                        $("#error_re").html("<font color='red'>กรุณากรอกจังหวัด</font>");
                    }
                    else {
                        $("#error_re").html("");
                        checkSum++;
                    }
                    if ($("input[name='postCode']").val() == "") {
                        $("#error_post").html("<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>");
                    }
                    else {
                        $("#error_post").html("");
                        checkSum++;
                    }
                    if ($("select[name='country']").val() == "") {
                        $("#error_country").html("<font color='red'>กรุณาเลือกประเทศ</font>");
                    }
                    else {
                        $("#error_country").html("");
                        checkSum++;
                    }
                    if ($("input[name='phone']").val() == "") {
                        $("#error_phone").html("<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>");
                    }
                    else {
                        $("#error_phone").html("");
                        checkSum++;
                    }
                    if ($("input[name='altEmail']").val() == "") {
                        $("#error_mail").html("<font color='red'>กรุณากรอกอีเมลสำรอง</font>");
                    }
                    else {
                        $("#error_mail").html("");
                        checkSum++;
                    }
                    //----------------------------------------------------------------------------

                    if (checkSum == 12) {
                        check = true;
                    }

                    if (check) {
                        var id = $("input[name='id']").val();
                        var name = $("input[name='name']").val();
                        var orgName = $("input[name='orgName']").val();
                        var maxSeat = $("input[name='maxSeat']").val();
                        var year = $("input[name='year']").val();
                        var address = $("input[name='address']").val();
                        var locality = $("input[name='locality']").val();
                        var region = $("input[name='region']").val();
                        var postCode = $("input[name='postCode']").val();
                        var country = $("select[name='country']").val();
                        var phone = $("input[name='phone']").val();
                        var altEmail = $("input[name='altEmail']").val();
                        var domainNoDot = $("input[name='domainNoDot']").val();
                        var fullDomain = $("input[name='fullDomain']").val();
                        var serverType = $("input[name='serverType']").val();
                        
                        $("#result").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                        $.post("ResellerAPI.php",
                                {//---------------Send data
                                    create: "",
                                    id: id,
                                    name: name,
                                    orgName: orgName,
                                    maxSeat: maxSeat,
                                    year: year,
                                    address: address,
                                    locality: locality,
                                    region: region,
                                    postCode: postCode,
                                    country: country,
                                    phone: phone,
                                    altEmail: altEmail,
                                    domainNoDot: domainNoDot,
                                    fullDomain: fullDomain,
                                    serverType: serverType
                                }
                        )
                        .done(function(data) {//-------------Retrieve data
                            var JSONArray = $.parseJSON(data);
                            //$("#result").html(JSONArray);
                            //var details = "การลงทะเบียนเสร็จสิ้น กรุณาทำตามขั้นตอนต่อไปนี้เพื่อทำการตั้งค่า Host<br />1. คลิก <a href='"+JSONArray+"' target='_blank'>Change Host Information</a><br />2. ตรวจสอบ TXT, CNAME และ MX<br />3. กดปุ่ม [Change Host Infomation] ในหน้านั้นรอจนเสร็จสิ้น<br />4. กด [Verify domain] เป็นอันเสร็จสิ้นการตั้งค่า Host<br /><br />";//<center><button name='verify'>Verify domain</button></center>
                            
                            //check response from resellAPI connector
                            if(JSONArray.hasOwnProperty('error')){
                                $("#result").html(JSONArray.error.message);
                            }
                            else if(JSONArray.hasOwnProperty('results')){
                                var details = "การลงทะเบียนเสร็จสิ้น กรุณาทำตามขั้นตอนต่อไปนี้<br />1. คลิก <a href='"+JSONArray.results+"' target='_blank'>Change Host Information</a><br />2. กด <button name='verify'>Verify domain</button> <br />";                        
                                $("#result").html(details);
                            }
                        })
                        .fail(function(xhr, textStatus, errorThrown) {
                            $("#result").html(errorThrown);
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id="result">
            <fieldset id="registerForm" style="width:450px;">
                <legend>Register Google App</legend>
                <table>
                    <tr>
                        <td style="width:150px;">โดเมน</td>
                        <td><input type="text" name="id" style="width:300px;" value="<?=$row[DomainName]?>" /><div id="error_id"></div></td>
                    </tr>
                    <tr>
                        <td>ชื่อผู้ติดต่อ</td>
                        <td><input type="text" name="name" style="width:300px;" value="<?=$fullname?>" /><div id="error_name"></div></td>
                    </tr>
                    <tr>
                        <td>ชื่อองค์กร</td>
                        <td><input type="text" name="orgName" style="width:300px;" value="<?=$row[Organization]?>" /><div id="error_org"></div></td>
                    </tr>
                    <tr>
                        <td>จำนวนผู้ใช้</td>
                        <td><input type="text" name="maxSeat" style="width:300px;" /><div id="error_seat"></div></td>
                    </tr>
                    <tr>
                        <td>จำนวนปีที่ใช้บริการ</td>
                        <td><input type="text" name="year" style="width:300px;" value="<?=$rowY[pro_year]?>" /><div id="error_year"></div></td>
                    </tr>
                    <tr>
                        <td>ที่อยู่</td>
                        <td><input type="text" name="address" style="width:300px;" value="<?=$row[Address]?>" /><div id="error_add"></div></td>
                    </tr>
                    <tr>
                        <td>เขต/อำเภอ</td>
                        <td><input type="text" name="locality" style="width:300px;" value="<?=$local?>" /><div id="error_local"></div></td>
                    </tr>
                    <tr>
                        <td>จังหวัด</td>
                        <td><input type="text" name="region" style="width:300px;" value="<?=$row[Province]?>" /><div id="error_re"></div></td>
                    </tr>
                    <tr>
                        <td>รหัสไปรษณีย์</td>
                        <td><input type="text" name="postCode" style="width:300px;" value="<?=$row[ZipCode]?>" /><div id="error_post"></div></td>
                    </tr>
                    <tr>
                        <td>ประเทศ</td>
                        <td><select name="country">
                                <option value="">กรุณาเลือกประเทศ</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, The Democratic Republic of The</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Cote D'ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and Mcdonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libyan Arab Jamahiriya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="AN">Netherlands Antilles</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Reunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="SH">Saint Helena</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and The Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and The South Sandwich Islands</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH" <?php if(strcmp($row[Country],"Thailand")){echo "selected='selected'";} ?>>Thailand</option>
                                <option value="TL">Timor-leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.S.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select><div id="error_country"></div></td>
                    </tr>
                    <tr>
                        <td>เบอร์โทรศัพท์</td>
                        <td><input type="text" name="phone" style="width:300px;" value="<?=$row[Phone]?>" /><div id="error_phone"></div></td>
                    </tr>
                    <tr>
                        <td>อีเมลสำรอง</td>
                        <td><input type="text" name="altEmail" style="width:300px;" value="yupawadee@readyplanet.com" /><div id="error_mail"></div></td>
                    </tr>
                    <tr><td colspan="2"><center><button name="create">Submit</button></center></td></tr>
                </table>
                <input type="hidden" name="domainNoDot" value="<?=$row[Domain_name]?>" /> <!-- คนละตัวกับที่ใช้ domain ด้านบน-->
                <input type="hidden" name="fullDomain" value="<?=$row[Web_name]?>" />
                <input type="hidden" name="serverType" value="<?=$row[hostserver]?>" />
            </fieldset>
        </div>
    </body>
</html>