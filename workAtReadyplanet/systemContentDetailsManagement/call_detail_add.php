<?php
session_start();
include("../inc_dbconnect.php");

if(isset($_GET[isEdit]) && $_GET[isEdit] == 1){
    $sql = "SELECT a. * FROM 
            (SELECT * FROM contact_detail_item
                UNION ALL 
            SELECT * FROM contact_detail_subitem) AS a
            WHERE Name = '$_GET[name]'";
    $query = mysql_db_query($dbname, $sql);
    $rowE = mysql_fetch_array($query);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=TIS-620'>
        <title>Grand Office Admin</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../invoice/autosize.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
        <style>
                #modeHtml textarea { -webkit-transition: height 0.2s; -moz-transition: height 0.2s; transition: height 0.2s; }
        </style>
        <script>
            var hasSubType = ["12","16","18","19"];
            
            $(document).ready(function () {
                autosize($("textarea[name='htmlCode']"));//textarea autosize
                showSubType();
                showMode();
                
                $('body').on('click', 'input[name="submit"]', function(){
                    if(checkdata()){
                        var form = new FormData($('#newContent')[0]);// Get the form data
                        
                        // Make the ajax call
                        $.ajax({
                            url: 'call_detail_add_db.php',
                            type: 'POST',
                            xhr: function() {
                                var myXhr = $.ajaxSettings.xhr();
                                if(myXhr.upload){
                                    myXhr.upload.addEventListener('progress',progress, false);
                                }
                                return myXhr;
                            },
                            beforeSend: function(){
                                $('progress').show();
                            },
                            success: function (res) {
                                console.log(res);
                                alert(res);
                                if (res.search("Error") == -1) {
                                    window.close();
                                }
                            },
                            error: function (e) {
                                alert(e);
                            },
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });
            
            function checkdata(){
                var i = 0;
                
                if($("input[name='name']").val() == ''){
                    $("input[name='name']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("input[name='name']").css({'border':''});
                    i++;
                }
                
                if($("select[name='typeContent']").val() == ''){
                    $("select[name='typeContent']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='typeContent']").css({'border':''});
                    i++;
                }
                
                if($.inArray($("select[name='typeContent']").val(), hasSubType) !== -1 && $("select[name='subTypeContent']").val() == ''){
                    $("select[name='subTypeContent']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='subTypeContent']").css({'border':''});
                    i++;
                }
                
                if(!$("input[name='type']:checked").val()){
                    $("input[name='type']+ label").animate({'background-color':'#E05353'});
                }
                else{
                    $("input[name='type']+ label").animate({'background-color':''});
                    
                    if($("input[name='type']:checked").val() == "file"){
                        if($("input[name='pdf']").val() == '' && $("input[name='image']").val() == ''){
                            alert("Please select a file to upload.");
                        }else{
                            i++;
                        }
                    }
                    else if($("input[name='type']:checked").val() == "html"){
                        if($("textarea[name='htmlCode']").val() == ''){
                            $("textarea[name='htmlCode']").css({'border':'2px solid #E05353'});
                        }else{
                            $("textarea[name='htmlCode']").css({'border':''});
                            i++;
                        }
                    }
                }
                
                if(i == 4){return true;}else{return false;}
            }
            
            function progress(e){
                if(e.lengthComputable){
                    $('progress').attr({value:e.loaded,max:e.total});
                    if(e.loaded == e.total){
                        $('progress').hide();
                    }
                }
            }

            function showSubType() {
                var check = $("select[name='typeContent']").val();
                var sub = $("input[name='subID']").val();
                if ($.inArray(check, hasSubType) !== -1) {
                    $.post("call_detail_add_subG.php",
                        {
                            typeID: check,
                            subID: sub
                        }
                    )
                    .done(function(data) {
                        $("#result").html(data);
                        $("#subType").show("fast");
                    });
                }
                else {
                    $("select[name='subTypeContent']").val("");
                    $("#subType").hide();
                }
            }
            
            function showMode() {
                var check = $("input[name='type']:checked").val();
                
                if (check == "file") {
                    $("#modeHtml").hide();
                    $("tr[name='modeFile']").show("fast");
                    $("textarea[name='htmlCode']").val("");
                }
                else if (check == "html"){
                    $("tr[name='modeFile']").hide();
                    $("#modeHtml").show("fast");
                    $("textarea[name='htmlCode']").trigger('autosize.resize');
                    $("input[name='image']").val("");
                    $("input[name='pdf']").val("");
                }
            }
        </script>
    </head>
    <body>
        <center><h2>Add new content</h2></center>
        <form enctype="multipart/form-data" id="newContent">
            <table cellspacing="0" border="0" align="center">
            <tr>
                <td align='right'>Group : </td>
                <td>
                    <select name="typeContent" onchange="showSubType()">
                        <option value="">Please select</option>
                        <?php
                        $qu = mysql_db_query($dbname, "SELECT ID,Name FROM contact_detail_type ORDER BY sort ASC");
                        while ($row = mysql_fetch_array($qu)) {
                            if($row[ID] != 13 && $row[ID] != 15){
                                $checked = ($row[ID] == $_GET[typeID])? "selected" : "";
                                echo "<option value='$row[ID]' $checked>$row[Name]</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr id="subType" style="display: none">
                <td align='right'>SubGroup : </td>
                <td>
                    <div id="result"></div>
                </td>
            </tr>

            <tr>
                <td align='right'>Name : </td>
                <td>
                    <input type="text" name="name" value="<?=$rowE[Detail]?>" style="width: 98%;" />
                </td>
            </tr>
            
            <tr>
                <td align='right'>Type : </td>
                <td>
                    <input type="radio" id="typeMode" name="type" value="file" onclick="showMode()" />
                    <label for="typeMode">PDF or Image</label>
                    <input type="radio" id="typeMode" name="type" value="html" onclick="showMode()" <?php if(isset($_GET[isEdit])){echo "checked";}?> />
                    <label for="typeMode">HTML Code</label>
                </td>
            </tr>

            <tr name="modeFile" style="display: none">
                <td align='right'>Image File :</td>
                <td>
                    <input type="file" accept="image/jpeg" name="image" />
                </td>
            </tr>

            <tr name="modeFile" style="display: none">
                <td align='right'>PDF File :</td>
                <td>
                    <input type="file" accept=".xls,.xlsx,.doc,.docx,application/pdf" name="pdf" />
                </td>
            </tr>

            <tr id="modeHtml" style="display: none">
                <td colspan="2">HTML Code :<br/><textarea name="htmlCode" style="width: 100%; height: 100px" align='center'><?=$rowE[sendmailContent]?></textarea></td>
            </tr>
            
            <tr>
                <td colspan="2" align='center'><input type="button" value="Submit" name="submit" /></td>
            </tr>
            </table>
            
            <input type="hidden" name="isEdit" value="<?=$_GET[isEdit]?>" />
            <input type="hidden" name="subID" value="<?=$_GET[subID]?>" />
            <input type="hidden" name="varName" value="<?=$_GET[name]?>" />
        </form>
        <center><progress value="0" max="100" style="display: none"></progress></center>
    </body>
</html>
