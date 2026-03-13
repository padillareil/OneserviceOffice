$(document).ready(function(){
    load_Ticket_reports();
});


function load_Ticket_reports() {
    $.post("dirs/reports/components/main.php", {
    }, function (data){
        $("#loadReports").html(data);
    });
}

