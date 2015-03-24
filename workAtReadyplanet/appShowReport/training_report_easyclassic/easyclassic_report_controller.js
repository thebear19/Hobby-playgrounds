var url = "easyclassic_report_model.php";

function prepareData(typeOperation) {
    var dateFrom = $("#dateFrom").val();
    var dateTo = $("#dateTo").val();
    var course = $("#course").val();
    var attendStatus = $("#attendStatus").val();
    
    var data = {type: typeOperation, dateFrom: dateFrom, dateTo: dateTo, course: course, attendStatus: attendStatus};
    
    actionData(url, data, typeOperation);
}

function actionData(url, dataForSend, type) {
    $.ajax({
        url: url,
        data: dataForSend,
        type: "POST",
        async: true,
        beforeSend: function(){
            if(type == "search"){
                $("button[name='search']").html("<i class='fa fa-cog fa-spin'></i>");//Loading...
                $("button[name='search']").prop('disabled', true);
            }
        },
        success: function (getData) {
            if(type == "search"){
                showReport(getData);
            }
            else if(type == "option"){
                $("#course").html(getData);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(JSON.stringify(jqXHR) + "\n" + errorThrown);
            alert("ERROR !!");
        },
        complete: function (){
            if(type == "search"){
                $("button[name='search']").prop('disabled', false);
                $("button[name='search']").html("<i class='fa fa-search'></i>");
            }
        }
    });
}

function showReport(data){
    $("#result").html(data);
    $("#resultForExport").html(data);
    $('#result > #reportTable').DataTable();
    $('#resultForExport > #reportTable').prop('id', "reportTableForExport");
}