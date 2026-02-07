$(document).ready(function(){
    loadServices();
    
});


function loadServices() {
    $.post("dirs/services/components/main.php", {
    }, function (data){
        $("#load_Services").html(data);
        loadPostService();
    });
}


/*Function create services*/
function mdladdService() {
    $("#mdl-create-service").modal('show');
}


    var currentPage = 1;
    var pageSize = 100;
    var display = $("#posted_service");

    function loadPostService(page = 1, status = null) {

        $.post("dirs/services/actions/get_services.php", {
            CurrentPage: page,
            PageSize: pageSize
        }, function(data) {
            let response;
            try {
                response = JSON.parse(data);
            } catch (e) {
                toastr.error("Server error.", "Error");
                return;
            }

            if ($.trim(response.isSuccess) === "success") {
                displayServices(response.Data);
                currentPage = page;
            } else {
                toastr.error($.trim(response.Data), "Error");
            }
        });
    }

    /* Render Blocked Accounts into Table */
    function displayServices(data) {
        const display = $("#posted_service");
        display.empty();

        if (!data || data.length === 0) {
            display.html(`
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-file-earmark-text fs-3"></i><br>
                    No Services Found.
                </div>
            `);
            return;
        }

        data.forEach(srv => {
            let statusBadge = `
                <span class="badge bg-success mb-2 align-self-start">
                    Available
                </span>
            `;
            if (parseInt(srv.Srv_Status) === 2) {
                statusBadge = `
                    <span class="badge bg-danger mt-2 align-self-start">
                        Not Available
                    </span>
                `;
            }
            display.append(`
                <div class="col-sm-2 mb-3">
                    <div class="card card-shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title fw-semibold mb-1">
                                ${srv.Srv_Name}
                            </h4>

                            ${statusBadge}

                            <h5 class="card-text text-muted mb-2">
                                ${srv.Description}
                            </h5>
                            <div class="mt-auto pt-2 border-top">
                                <small class="text-muted fw-semibold d-block mb-1">
                                    <i class="bi bi-clock"></i> Available Time
                                </small>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">From:</span>
                                    <span class="fw-medium">${srv.Opt_Start}</span>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">To:</span>
                                    <span class="fw-medium">${srv.Opt_End}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="justify-content-end d-flex">
                                <button class="btn btn-outline-primary btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="editPost('${srv.Srv_id}')">
                                  <i class="bi bi-pencil"></i>  Edit
                                </button>
                            </div
                        </div>
                    </div>
                </div>
            `);
        });
    }




    /* Pagination + Fetch Blocked Accounts */
    $("#btn-preview-rev").on("click", function() {
        if (currentPage > 1) {
            loadPostService(currentPage - 1);
        } else {
            toastr.info("You're already on the first page.");
        }
    });


    $("#btn-next-rev").on("click", function() {
        loadPostService(currentPage + 1);
    });


    /*Function edit Post*/
    function editPost(Srv_id){
        $("#mdl-upd-service").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#service_id").val(response.Data.Srv_id);
                $("#upd-service-name").val(response.Data.Srv_Name);
                $("#upd-type-of-service").val(response.Data.Srv_Type);
              /*  $("#upd-operate-time-start").val(response.Data.Opt_Start);
                $("#upd-operate-time-end").val(response.Data.Opt_End);*/
                $("#upd-service-description").val(response.Data.Description);
            }else{
                alert(jQuery.trim(response.Data));
            }
        });
    }


    /*Function resetbuttons behavior*/
    function resetButtons() {
        $("#btn-submit").removeClass('d-none');
        $("#btn-update").addClass('d-none');
        $("#frm-post")[0].reset();
    }

