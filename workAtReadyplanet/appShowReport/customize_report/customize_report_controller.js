var url = "customize_report_model.php";
//var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.gchart_renderers);

//google.load("visualization", "1", {packages:["corechart", "charteditor"]});

function prepareData(typeOperation, row) {
    if(typeOperation != "listAllReport" && typeOperation != "deleteReport"){
        var dateFrom = $("#dateFrom").val();
        var dateTo = $("#dateTo").val();
        var reportType = $("#reportType").val();
        var config = $("#config").val().replace(/[\s]/gi, ''); //delete space
        var reportName = $("input[name='name']").val().replace(/[^a-zA-Z¡-ÎÐ-ì0-9 ]/gi, ''); //check special char
        var reportDescription = $.trim($("textarea[name='description']").val().replace(/[\s]/gi, ' ').replace(/[^a-zA-Z¡-ÎÐ-ì0-9 ]/gi, '')); //check special char
        var noReport = $("#noReport").val();
    }
    
    
    if(typeOperation == "search" || typeOperation == "load"){
        var data = {type: typeOperation, dateFrom: dateFrom, dateTo: dateTo, reportType: reportType};
    }
    else if(typeOperation == "save" || typeOperation == "edit"){
        var data = {type: typeOperation, dateFrom: dateFrom, dateTo: dateTo,
            reportType: reportType, reportName: reportName, reportDescription: reportDescription,
            config: config, noReport: noReport};
    }
    else if(typeOperation == "listAllReport"){
        url = "report/customize_report/customize_report_model.php";
        
        var data = {type: typeOperation};
    }
    else if (typeOperation == "deleteReport") {
        var data = {type: typeOperation, noReport: row};
    }
    else{
        alert("ERROR: Type operation is mismatch.");
        return false;
    }
    
    
    actionData(url, data, typeOperation, config);
}

function createExportNameReport(){
    var dateFrom = $("#dateFrom").val();
    var dateTo = $("#dateTo").val();
    var namesaveReport = $("input[name='name']").val();
    var reportType = $("#reportType option:selected").text();
                
    if(namesaveReport.length < 1){
        namesaveReport = reportType + "_report_" + dateFrom +"to"+ dateTo;
    }
    
    return namesaveReport;
}

function actionData(url, dataForSend, typeOperation, savedConfig) {
    $.ajax({
        url: url,
        data: dataForSend,
        type: "POST",
        async: true,
        beforeSend: function(){
            if(typeOperation == "search" || typeOperation == "load"){
                $("button[name='search']").html("<i class='fa fa-cog fa-spin'></i>");//Loading...
                $("button[name='search']").prop('disabled', true);
            }
        },
        success: function (getData) {
            if(typeOperation == "search"){
                showReport(getData);
            }
            else if(typeOperation == "load"){
                showSavedReport(getData, savedConfig);
            }
            else if(typeOperation == "save" || typeOperation == "edit"){
                responStatusSaveReport(getData);
            }
            else if(typeOperation == "listAllReport"){
                $('#listReport').html(getData);
                $('#reportTable').DataTable();
            }
            else if (typeOperation == "deleteReport") {
                alert($.trim(getData));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(JSON.stringify(jqXHR) + "\n" + errorThrown);
            alert("ERROR !!");
        },
        complete: function (){
            if(typeOperation == "search" || typeOperation == "load"){
                $("button[name='search']").prop('disabled', false);
                $("button[name='search']").html("<i class='fa fa-search'></i>");
                $("button[name='save']").prop('disabled', false);
                $("a[name='exportExcel']").removeClass("disabled");
            }
        }
    });
}

function showReport(data){
    $("#result").html(data);
    $("#result").pivotUI($("#pivot"),
        {
            rows: "",
            cols: "",
            onRefresh: function(config) {
                var config_copy = JSON.parse(JSON.stringify(config));
                        
                //delete some values which are functions
                delete config_copy["aggregators"];
                delete config_copy["renderers"];
                delete config_copy["derivedAttributes"];
                        
                //delete some bulky default values
                delete config_copy["rendererOptions"];
                delete config_copy["localeStrings"];
                        
                $("#config").val(JSON.stringify(config_copy, undefined, 2));
            }
        }
    );
}

function showSavedReport(data, savedConfig){
    var savedConfig = JSON.parse(savedConfig);
    savedConfig["onRefresh"] = function(config) {
        var config_copy = JSON.parse(JSON.stringify(config));
                        
        //delete some values which are functions
        delete config_copy["aggregators"];
        delete config_copy["renderers"];
        delete config_copy["derivedAttributes"];
                        
        //delete some bulky default values
        delete config_copy["rendererOptions"];
        delete config_copy["localeStrings"];
                        
        $("#config").val(JSON.stringify(config_copy, undefined, 2));
    };
    
    
    $("#result").html(data);
    $("#result").pivotUI($("#pivot"), savedConfig);
}

function responStatusSaveReport(data){
    $('.response').html(data);
}