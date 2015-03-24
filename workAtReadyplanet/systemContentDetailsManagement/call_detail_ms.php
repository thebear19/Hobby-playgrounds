<?php
session_start();
include ("../inc_checkerror.php");
include("../inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

if (isset($listContact)) {
    $sqlDetailType = mysql_db_query($dbname, "SELECT ID, Name FROM contact_detail_type where CountryID = 1 ORDER BY sort ASC ");
    $i = 0;
    while ($rDetailType = mysql_fetch_array($sqlDetailType)) {

        $sqlDetailItem = mysql_db_query($dbname, "SELECT * FROM contact_detail_item where TypeID = $rDetailType[ID] && status != 2 ORDER BY sort ASC ");
        $num = mysql_num_rows($sqlDetailItem);

        if ($num != 0) {
            echo "<h3>$rDetailType[Name]<span class='plus-button'><a href='call_detail_add.php?typeID=$rDetailType[ID]'><i class='fa fa-plus'></i></a></span></h3>";

            echo "<div><ul class='sort'>";
            
            $x = 1;
            while ($rDetailItem = mysql_fetch_array($sqlDetailItem)) {
                if ($rDetailItem[Name] == '') {
                    $sqlSubItem = mysql_db_query($dbname, "SELECT * FROM contact_detail_subitem where itemID = $rDetailItem[ID] && status != 2 ORDER BY sort ASC");
                    $num = mysql_num_rows($sqlSubItem);
                    
                    if($num != 0){
                        //echo "<li data-id='$x' data-name='$rDetailItem[TypeID]'><div class='accordion'><h3>$rDetailItem[Detail]</h3><div><ul class='sortRow'>";
                        
                        $y = 1;
                        while ($rSubItem = mysql_fetch_array($sqlSubItem)) {
                            $isOn = ($rSubItem[status]) ? "class='delete-button-on'" : "class='delete-button-off'";
                            $content = "$rSubItem[Detail]";
                            echo "<li data-id='$y' data-name='$i-$rDetailItem[TypeID]-$rDetailItem[ID]'><span class='text'>$content</span>
                                    <span class='edit-button'><a href='call_detail_add.php?typeID=$rDetailType[ID]&subID=$rDetailItem[ID]&name=$rSubItem[Name]&isEdit=1'><i class='fa fa-pencil'></i></a></span>
                                    <span class='delete-button'><a href='#' id='$rSubItem[Name]' $isOn><i class='fa fa-circle'></i></a></span></li>";
                            
                            $y++;
                        }
                        
                        //echo "</ul></div></div></li>";
                    }
                } else {
                    $isOn = ($rDetailItem[status]) ? "class='delete-button-on'" : "class='delete-button-off'";
                    $content = "$rDetailItem[Detail]";
                    echo "<li data-id='$x' data-name='$i-$rDetailItem[TypeID]-$rDetailItem[TypeID]'><span class='text'>$content</span>
                            <span class='edit-button'><a href='call_detail_add.php?typeID=$rDetailType[ID]&subID=$rDetailItem[ID]&name=$rDetailItem[Name]&isEdit=1'><i class='fa fa-pencil'></i></a></span>
                            <span class='delete-button $isOn'><a href='#' id='$rDetailItem[Name]' $isOn><i class='fa fa-circle'></i></a></span></li>";
                }
                $x++;
            }
            echo "</ul></div>";

            $i++;
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Grand Office Admin</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
        
        <script src="http://johnny.github.io/jquery-sortable/js/jquery-sortable-min.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script>
            $(document).ready(function() {
                accordion(1);
            });
            
            $(window).focus(function() {
                self.location.reload();
            });
            
            function accordion(input){
                properties = 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=850,height=620,left=47.5,top=20';
                
                $.post("call_detail_ms.php",{listContact: ''})
                .done(function(data) {
                    //var index = $("h3").index($(".ui-state-active"));//retrive index of current panel
                    
                    $(".accordion").html(data);
                    
                    if(input){
                        $(".accordion").accordion({
                            heightStyle: 'content',
                            autoHeight: false,
                            collapsible: true
                        });
                    }else{
                        $(".accordion").accordion().accordion("destroy");
                        $(".accordion").accordion({
                            heightStyle: 'content',
                            autoHeight: false,
                            collapsible: true
                        });
                    }
                    
                    $('.plus-button a').click(function () {
                        window.open($(this).attr("href"),"",properties);//url,name,pro
                    });
                    
                    $('.edit-button a').click(function (e) {
                        e.preventDefault();//block default link
                        window.open($(this).attr("href"),"",properties);//url,name,pro
                    });
                    
                    $('.delete-button a').click(function () {
                        $.post("call_detail_delete.php",{deleteItem: $(this).attr("id")})
                        .done(function(data) {
                            alert(data);
                        });
                        if($(this).attr("class") == "delete-button-on"){
                            $(this).switchClass( "delete-button-on", "delete-button-off");
                        }
                        else{
                            $(this).switchClass( "delete-button-off", "delete-button-on");
                        }
                    });
                    
                    
                    $(".sort").sortable({
                        group: 'sort',
                        onDrop: function (item, container, _super) {
                            var clonedItem = $('<li/>').css({height: 0});
                            item.before(clonedItem);
                            clonedItem.animate({'height': item.height()});
    
                            item.animate(clonedItem.position(), function  () {
                                clonedItem.detach();
                                _super(item);
                            });
                            
                            
                            var data = $(".sort").sortable("serialize").get();

                            $.ajax({
                                    data: {"setData": data, "typeChange": item.attr("data-name")},
                                    type: 'POST',
                                    url: 'call_detail_sort.php'
                            })
                            .done(function(data) {console.log(data);});
                        }
                    });
                });
            }
        </script>
        
        <style type="text/css">
            .accordion .text { width: 470px; display: inline-block; }
             
            .plus-button { float: right; }
            .plus-button a { color: #000000 !important; }
            .plus-button a:hover { color: #FDFCDA !important; }
             
            .delete-button { float: right; }
            .delete-button a:hover { color: #000000 !important; }
            .delete-button-on { color: #00E66C !important; }
            .delete-button-off { color: #E44444 !important; }
             
            .edit-button { float: right; }
            .edit-button a { color: #000000; padding:10px; }
            .edit-button a:hover { color: #FF5252; }
             
            .ui-accordion .ui-icon { display: none; }
            .ui-accordion .ui-accordion-header { padding-left: 10px; padding-top: 1px; padding-bottom: 1px; font-weight: bold; font-size: 15px; color: #ffffff; background:#CC9933; }
            .ui-accordion .ui-accordion-header a {color: #ffffff; }
            .ui-accordion .ui-accordion-content { font-size: 15px; padding-left: 0; }
            .ui-button { float: right; padding: 0; }
            .ui-widget-content{ background:#FDFCDA; }
            li { list-style-type: none; border-bottom:1px solid #F7F4F4; padding:2px; margin:2px; }
            
            
            .dragged {
                position: absolute;
                opacity: 0.5;
                z-index: 2000;
            }
            
        </style>
    </head>
    <body>
    <center><h2>Contact Detail Manage System</h2></center>
        <table width="95%" cellspacing="0" border="0" align="center">
            <tr>
                <td width="25%" valign='top'></td>
                
                <!--#####################ฟอร์มกรอกข้อมูล####################-->
                <td width='50%' align='center' valign='top'>
                    <table width="100%" cellspacing="0" border="0" style="border:1px solid #555555;" cellpadding="3" align="right" bgcolor="#FAFAFA">
                        <tr>
                            <td colspan="2" align='center' bgcolor='#999999' style='font-weight: bold;color:#FFFFFF;'>Menu</td>
                        </tr>
                        
                        <tr>
                            <td><div class="accordion"></div></td>
                        </tr>
                    </table>   
                </td>

                <td width="25%" valign='top'></td>
            </tr>
        </table>
    </body>
</html>