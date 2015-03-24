<?php
include ("../../inc_checkerror.php");
include("../../inc_dbconnectOOP.php");
header('Content-Type: text/html; charset=TIS-620');

if (isset($_GET[accessType]) && ($_GET[accessType] == "edit" || $_GET[accessType] == "view")) {
    $sql = "SELECT * FROM ready_saveform_report WHERE id = '$_GET[noReport]'";
    $query = $dbConnect_libra->query($sql);
    
    if($query->num_rows == 0){
        echo "Error!!";
        exit();
    }
    
    $row = $query->fetch_array();
}
$canSave = ($_GET[accessType] == "view") ? "style='display: none; margin-right: 5%;'" : "style='margin-right: 5%;'";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Report editor</title>
        <link rel="import" href="customize_report_lib.html">
    </head>
    <body unresolved style="background-color: #f5f5f5;">
        <h4 style="margin-left: 90%;">Report Editor</h4>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-horizontal" align='center'>
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-4">Date:</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dateFrom" value="<?=$row[dateFrom]?>" />
                            </div>

                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dateTo" value="<?=$row[dateTo]?>" />
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-4">Report type:</label>
                            <div class="col-sm-4">
                                <select id="reportType" class="form-control">
                                    <option value='0' <?php if($row[type] == 0) echo "selected";?>>Clearing</option>
                                    <option value='1' <?php if($row[type] == 1) echo "selected";?>>Landing</option>
                                    <!--<option value='2' <?php if($row[type] == 2) echo "selected";?>>Leading</option>-->
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button name="search" style="margin-right: 5%;" class="btn btn-primary col-sm-2" title="Search">
                                    <i class="fa fa-search"></i>
                                </button>

                                <button name="save" class="btn btn-default col-sm-2" title="Save" disabled <?=$canSave?>>
                                    <i class="fa fa-floppy-o"></i>
                                </button>
                                
                                <a name="exportExcel" href="#" class="btn btn-default col-sm-2 disabled" title="Export">
                                    <i class="fa fa-file-excel-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="modal fade beforeSave" tabindex="-1" role="dialog" aria-labelledby="responseDialog" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content col-md-12">
                            <div class="modal-header">
                                <h3 class="modal-title">Do you want to save this report?</h3>
                            </div>

                            <div class="modal-body">
                                <form role="form">
                                    <div class="form-group">
                                        <input type="text" name="name" value="<?=$row[name]?>" placeholder="Name" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea name="description" style="min-height: 74px;" placeholder="Description here..." class="form-control"><?=$row[description]?></textarea>
                                    </div>
                                </form>

                                <div class="response"></div>
                            </div>

                            <div class="modal-footer">
                                <button name="saveReport" class="btn btn-primary col-sm-offset-7 col-sm-2">
                                    <i class="fa fa-floppy-o"></i>
                                </button>
                                
                                <button type="button" class="btn btn-default col-sm-2" data-dismiss="modal">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="config" value='<?=$row[config]?>'>
                <input type="hidden" id="noReport" value="<?=$_GET[noReport]?>">
                <input type="hidden" id="accessType" value="<?=$_GET[accessType]?>">
            </div>
            
            <div class="container-fluid" id="result"></div>
        </div>
    </body>
    
    <script type="text/javascript" src="../excellentexport.min.js"></script>
    <script type="text/javascript" src="customize_report_controller.js"></script>
    <script>
        $(document).ready(function () {
            autosize($("textarea[name='description']"));
            
            if($("#accessType").val() == "view" || $("#accessType").val() == "edit"){
                prepareData("load");
            }
                
            $("button[name='search']").click(function () {
                prepareData("search");
            });

            $("button[name='save']").click(function () {
                $(".beforeSave").modal("show");
            });
            
            $("a[name='exportExcel']").click(function () {
                var namesaveReport = createExportNameReport();
                    
                $("a[name='exportExcel']").prop("download", namesaveReport +".xls");
                return ExcellentExport.excel(this, 'resTable', 'Sheet1');
            });

            $("button[name='saveReport']").click(function () {
                var accessType = ($("#accessType").val() == "edit") ? "edit" : "save";
                
                prepareData(accessType);
            });
        });
    </script>
</html>