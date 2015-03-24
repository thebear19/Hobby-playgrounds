<?php
include ("../../inc_checkerror.php");
header('Content-Type: text/html; charset=TIS-620');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Training Report (Classic & Easy)</title>
        <link rel="import" href="easyclassic_report_lib.html">
    </head>
    <body style="background-color: #f5f5f5;">
        <h4 style="margin-left: 90%;">Training Report (Classic & Easy)</h4>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-horizontal" align='center'>
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-4">Date:</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dateFrom" />
                            </div>

                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dateTo" />
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-4">Course:</label>
                            <div class="col-sm-4">
                                <select id="course" class="form-control"></select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-4">Attend Status:</label>
                            <div class="col-sm-4">
                                <select id="attendStatus" class="form-control">
                                    <option value="0">All</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            <div class="col-sm-offset-5 col-sm-4">
                                <button name="search" style="margin-right: 5%;" class="btn btn-primary col-sm-2">
                                    <i class="fa fa-search"></i>
                                </button>
                                
                                <a name="exportExcel" href="#" class="btn btn-default col-sm-2 disabled">
                                    <i class="fa fa-file-excel-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container-fluid" id="result"></div>
            
            <div id="resultForExport" style="display: none"></div>
        </div>
    </body>
    
    <script type="text/javascript" src="../excellentexport.min.js"></script>
    <script type="text/javascript" src="easyclassic_report_controller.js"></script>
    <script>
        $(document).ready(function () {
            prepareData("option");
            
            $("button[name='search']").click(function () {
                prepareData("search");
                $("a[name='exportExcel']").removeClass("disabled");
            });

            $("a[name='exportExcel']").click(function () {
                var course = $("#course option:selected").text();
                
                $("a[name='exportExcel']").prop("download", "trainingReport_classic_easy_["+ course +"].xls");
                return ExcellentExport.excel(this, 'reportTableForExport', 'Sheet1');
            });
        });
    </script>
</html>