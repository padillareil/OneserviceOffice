$(document).ready(function(){
    loadPublishedServices();
});


function loadPublishedServices() {
    $.post("dirs/published_service/components/main.php", {
    }, function (data){
        $("#load_Services").html(data);
        loadAvailableServices();
    });
}


/*Collapse controller script*/
function showCategoryList() {
    $("#published_ticket_list").toggleClass("d-none");

    $("#main_ticket_container")
        .toggleClass("col-md-10 col-md-8");
}

/*Function show modal category*/
function createPost() {
    $("#mdl-published-post").modal('show');
}


/*Function show details of service*/
function openServiceInfo(ServiceId){
    $.post("dirs/published_service/actions/get_post.php",{
        ServiceId : ServiceId
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){

            $("#mdl-post-info").modal('show');


            // $("#StudentName").val(response.Data.StudentName);
            // $("#Address").val(response.Data.Address);
            // $("#Age").val(response.Data.Age);
            // $("#Status").val(response.Data.Status);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}
