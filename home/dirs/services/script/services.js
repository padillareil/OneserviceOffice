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
                <span class="badge bg-primary mb-2 align-self-start">
                    OPEN
                </span>
            `;
            if (parseInt(srv.Srv_Status) === 2) {
                statusBadge = `
                    <span class="badge bg-danger mt-2 align-self-start">
                        CLOSED
                    </span>
                `;
            }
            // ===== Publication Badge =====
            let publicationBadge = srv.Publication === 'PB'
              ? `<span class="badge text-dark border">
                   <i class="bi bi-globe me-1"></i> Public
                 </span>`
              : `<span class="badge bg-danger-subtle text-danger border">
                   <i class="bi bi-building-lock me-1"></i> Private
                 </span>`;

            display.append(`
                <div class="col-sm-3 mb-3">
                  <div class="card h-100 border-0 shadow-sm rounded-4 service-card">
                    <div class="card-body d-flex flex-column p-4">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0 text-dark">
                          ${srv.ServiceName}
                        </h5>
                        ${statusBadge}
                      </div>
                      <hr>
                      <p class="text-muted mb-3">
                        ${srv.Description}
                      </p>
                      <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                          ${publicationBadge}
                          <span class="badge bg-light text-secondary border">
                            ${srv.ServiceType}
                          </span>
                        </div>
                        <div class="dropdown">
                          <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> Actions
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                            <li>
                              <a class="dropdown-item" href="#" onclick="editPost('${srv.Srv_id}')">
                                <i class="bi bi-pencil me-2"></i>Edit Service
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#" onclick="blockPost('${srv.Srv_id}')">
                                <i class="bi bi-ban me-2"></i>Disable Service
                              </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                              <a class="dropdown-item" href="#" onclick="setPublic('${srv.Srv_id}')">
                                <i class="bi bi-globe me-2"></i>Make Public
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#" onclick="setPrivate('${srv.Srv_id}')">
                                <i class="bi bi-building-lock me-2"></i>Make Private
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
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
        $("#mdl-create-service").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#service-id").val(response.Data.RowNum);
                $("#service-name").val(response.Data.ServiceName);
                $("#type-of-service").val(response.Data.ServiceType);
                $("#service-description").val(response.Data.Description);
                $("#btn-update").removeClass('d-none');
                $("#publish-title").html('Edit Post');
                $("#btn-submit").addClass('d-none').prop('disabled', false);
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
        $("#publish-title").html('Publish New Service');
    }




/*Function save edit Update post*/
function saveUpdate() {
    var Serviceid    = $("#service-id").val();
    var Title        = $("#service-name").val();
    var Category     = $("#type-of-service").val();
    var Description  = $("#service-description").val();

    $.post("dirs/services/actions/update_servicepost.php", {
        Serviceid   : Serviceid,
        Title       : Title,
        Category    : Category,
        Description : Description,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
           $("#frm-post")[0].reset();
           $("#mdl-create-service").modal('hide');
           loadServices();
           Swal.fire({
               icon: "success",
               title: "Post Update",
               text: "Successfully.",
               timer: 2000,
               showConfirmButton: false
           });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}