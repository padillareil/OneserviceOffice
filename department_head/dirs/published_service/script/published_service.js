$(document).ready(function(){
    loadPublishedServices();
});


function loadPublishedServices() {
    $.post("dirs/published_service/components/main.php", {
    }, function (data){
        $("#load_Services").html(data);
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