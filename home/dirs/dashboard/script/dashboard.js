$(document).ready(function(){
    loadDashbaord();
});


function loadDashbaord() {
    $.post("dirs/dashboard/components/main.php", {
    }, function (data){
        $("#load_Dashboard").html(data);
    });
}
