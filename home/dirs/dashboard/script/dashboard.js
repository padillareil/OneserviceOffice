$(document).ready(function(){
    loadDashboard();
});


function loadDashboard() {
    $.post("dirs/dashboard/components/main.php", {
    }, function (data){
        $("#load_Dashboard").html(data);
        loadRequest();
    });
}


/*Function reject get id*/
function rejectRequest(Req_id){
    $("#modal-reject").modal('show');
    $.post("dirs/dashboard/actions/get_ticket.php",{
        Req_id : Req_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#ticket-id").val(response.Data.Req_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function reject request*/
function saveRejectRequest(){
    var Req_id = $("#ticket-id").val();
    var ReqStatus = '3';
    $.post("dirs/dashboard/actions/update_status.php", {
        Req_id : Req_id,
        ReqStatus : ReqStatus
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-reject").modal('hide');
            loadDashboard();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Request Rejected.',
                timer: 2000,
                showConfirmButton: false
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
            alert(data); 
        }
    });
}


/*Function accept get id*/
function acceptRequest(Req_id){
    $("#modal-accept").modal('show');
    $.post("dirs/dashboard/actions/get_ticket.php",{
        Req_id : Req_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#ticket-id").val(response.Data.Req_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function reject request*/
function saveAcceptRequest(){
    var Req_id = $("#ticket-id").val();
    var ReqStatus = '2';
    $.post("dirs/dashboard/actions/update_status.php", {
        Req_id : Req_id,
        ReqStatus : ReqStatus
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-reject").modal('hide');
            loadDashboard();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Request Accepted.',
                timer: 2000,
                showConfirmButton: false
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
            alert(data); 
        }
    });
}