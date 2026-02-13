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

/*Search post*/
$("#search-services").on("keydown", function(e) {
    if (e.key === "Enter") {
        loadPostService();
    }
});


/*Function create services*/
function mdladdService() {
    $("#mdl-create-service").modal('show');
}


    var currentPage = 1;
    var pageSize = 8;
    var totalPages = 1;
    var display = $("#posted_service");

    function loadPostService(page = 1) {
        var Search = $("#search-services").val();
        $.post("dirs/services/actions/get_services.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search: Search
        }, function(data) {
            var response;
            try {
                response = JSON.parse(data);
            } catch (e) {
                toastr.error("Server error.", "Error");
                return;
            }
            if ($.trim(response.isSuccess) === "success") {
                displayServices(response.Data);
                currentPage = page;

                if (response.Data && response.Data.length > 0) {
                    totalPages = parseInt(response.Data[0].TotalPages);
                } else {
                    totalPages = 1;
                }
                buildPageNumbers();      
                updatePaginationUI();   
            }
             else {
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
            if (parseInt(srv.ServiceStatus) === 2) {
                statusBadge = `
                    <span class="badge bg-danger mt-2 align-self-start">
                        CLOSED
                    </span>
                `;
            }
            // ===== Publication Badge =====
            let publicationBadge = srv.Publication === 'PB'
              ? `<span class="badge bg-success-subtle text-success border">
                   <i class="bi bi-globe me-1"></i> Public
                 </span>`
              : `<span class="badge bg-danger-subtle text-danger border">
                   <i class="bi bi-person-fill-lock me-1"></i> Private
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
                          <button class="btn btn-lg rounded-pill px-3" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                            <li>
                              <a class="dropdown-item" href="#" onclick="editPost('${srv.Srv_id}')">
                                <i class="bi bi-pencil me-2"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#" onclick="blockPost('${srv.Srv_id}')">
                                <i class="bi bi-toggle-off me-2"></i>Close
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#" onclick="enableService('${srv.Srv_id}')">
                                <i class="bi bi-toggle-on me-2"></i>Open
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
                                <i class="bi bi-person-fill-lock me-2"></i>Make Private
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
    $("#btn-preview").on("click", function(e) {
        e.preventDefault();

        if (currentPage > 1) {
            loadPostService(currentPage - 1);
        }
    });

    $("#btn-next").on("click", function(e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            loadPostService(currentPage + 1);
        }
    });

    $("#pagination").on("click", ".page-number a", function(e) {
        e.preventDefault();
        var page = parseInt($(this).data("page"));
        loadPostService(page);
    });

    /*Function to count page number page 1 of and so on*/
    function updatePaginationUI() {
        $("#page-info").text("Page " + currentPage + " of " + totalPages);
        if (currentPage <= 1) {
            $("#li-prev").addClass("disabled");
        } else {
            $("#li-prev").removeClass("disabled");
        }
        if (currentPage >= totalPages) {
            $("#li-next").addClass("disabled");
        } else {
            $("#li-next").removeClass("disabled");
        }
    }

    /*Function to build list of pagination*/
    function buildPageNumbers() {
        $("#pagination li.page-number").remove(); // remove old numbers
        var prevLi = $("#btn-preview").parent();
        for (var i = 1; i <= totalPages; i++) {
            var activeClass = (i === currentPage) ? "active" : "";
            var li = `
                <li class="page-item page-number ${activeClass}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
            $(li).insertAfter(prevLi);
            prevLi = prevLi.next();
        }
    }




    /*Function edit Post*/
    function editPost(Srv_id){
        $("#mdl-create-service").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#service_id").val(response.Data.RowNum);
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

    /*Function show modal and disable post*/
    function blockPost(Srv_id) {
        $("#mdl-message-close").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#srv-id-close").val(response.Data.RowNum);
                $("#message-close").text('This action will remove the post permanently. Do you want to continue?');
            }else{
                alert(jQuery.trim(response.Data));
            }
        });
    }

    /*Function show modal and re enable post*/
    function enableService(Srv_id) {
        $("#mdl-message-open").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#srv-id-open").val(response.Data.RowNum);
                $("#message-open").text('This post will become visible to users again. Do you want to continue?');
            }else{
                alert(jQuery.trim(response.Data));
            }
        });
    }

    /*Function show modal and to set post Public*/
    function setPublic(Srv_id) {
        $("#mdl-message-public").modal('show');
        $.post("dirs/services/actions/get_edit_service.php",{
            Srv_id : Srv_id
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#srv-id-public").val(response.Data.RowNum);
                $("#message-public").text('Do you want to publish this post publicly?');
            }else{
                alert(jQuery.trim(response.Data));
            }
        });
    }

   /*Function show modal and to set post private/ All*/
   function setPrivate(Srv_id) {
       $("#mdl-message-private").modal('show');
       $.post("dirs/services/actions/get_edit_service.php",{
           Srv_id : Srv_id
       },function(data){
           response = JSON.parse(data);
           if(jQuery.trim(response.isSuccess) == "success"){
               $("#srv-id-private").val(response.Data.RowNum);
               $("#message-private").text('Do you want to make this post private?');
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



/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION******************************/
/*Function block button controlers*/
function setUpdateSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-upd").removeClass("d-none");
        $("#btn-text-upd").text(" Please wait...");
        $("#btn-update").prop("disabled", true);
        $("#btn-cancel").prop("disabled", true);
        $("#btn-clear").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-upd").addClass("d-none");
        $("#btn-text-upd").text("Commit");
        $("#btn-update").prop("disabled", false);
        $("#btn-cancel").prop("disabled", false);
        $("#btn-clear").prop("disabled", false);
        window.onbeforeunload = null;
    }
}
/*Function gather value for update*/
function saveUpdate() {
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setUpdateSpinner(true);
    var Serviceid   = $("#service_id").val();
    var Title       = $("#service-name").val();
    var Category    = $("#type-of-service").val();
    var Description = $("#service-description").val();

    lastUpdatePayload = {
        Serviceid: Serviceid,
        Title: Title,
        Category: Category,
        Description: Description
    };

    sendUpdateRequest(lastUpdatePayload);
}
/*Function to submit edit request to backend*/
function sendUpdateRequest(payload) {
    $.post("dirs/services/actions/update_servicepost.php", payload)
    .done(function(data) {
        if ($.trim(data) === "success") {
            setUpdateSpinner(false);
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
            lastUpdatePayload = null;
        } else {
            setUpdateSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data
            });
        }

    })
    .fail(function() {
        setUpdateSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });

    });
}
/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION******************************/


/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR CLOASING POST******************************/
/*Function block button controlers*/
function setCloseSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-close").removeClass("d-none");
        $("#btn-text-close").text(" Please wait...");
        $("#btn-submit-close").prop("disabled", true);
        $("#btn-cancel-close").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-close").addClass("d-none");
        $("#btn-text-close").text("Yes");
        $("#btn-submit-close").prop("disabled", false);
        $("#btn-cancel-close").prop("disabled", false);
        window.onbeforeunload = null;
    }
}
/*Function gather value for update*/
function btnClose() {
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setCloseSpinner(true);
    var Serviceid   = $("#srv-id-close").val();
    var Status      = 2;

    lastUpdatePayload = {
        Serviceid: Serviceid,
        Status: Status
    };

    sendCloseRequest(lastUpdatePayload);
}
/*Function to submit edit request to backend*/
function sendCloseRequest(payload) {
    $.post("dirs/services/actions/update_poststatus.php", payload)
    .done(function(data) {
        if ($.trim(data) === "success") {
            setCloseSpinner(false);
            $("#mdl-message-close").modal('hide');
            loadServices();
            Swal.fire({
                icon: "success",
                title: "Post Closed",
                text: "Successfully.",
                timer: 2000,
                showConfirmButton: false
            });
            lastUpdatePayload = null;
        } else {
            setCloseSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: data
            });
        }

    })
    .fail(function() {
        setCloseSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });

    });
}
/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR CLOASING POST******************************/


/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR OPEN POST******************************/
/*Function block button controlers*/
function setOpenSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-open").removeClass("d-none");
        $("#btn-text-open").text(" Please wait...");
        $("#btn-submit-open").prop("disabled", true);
        $("#btn-cancel-open").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-open").addClass("d-none");
        $("#btn-text-open").text("Yes");
        $("#btn-submit-open").prop("disabled", false);
        $("#btn-cancel-open").prop("disabled", false);
        window.onbeforeunload = null;
    }
}
/*Function gather value for update*/
function btnOpen() {
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setOpenSpinner(true);
    var Serviceid   = $("#srv-id-open").val();
    var Status      = 1;

    lastUpdateOpen = {
        Serviceid: Serviceid,
        Status: Status
    };

    sendOpenRequest(lastUpdateOpen);
}
/*Function to submit edit request to backend*/
function sendOpenRequest(payload) {
    $.post("dirs/services/actions/update_poststatus.php", payload)
    .done(function(data) {
        if ($.trim(data) === "success") {
            setOpenSpinner(false);
            $("#mdl-message-open").modal('hide');
            loadServices();
            Swal.fire({
                icon: "success",
                title: "Post Open",
                text: "Successfully.",
                timer: 2000,
                showConfirmButton: false
            });
            lastUpdateOpen = null;
        } else {
            setOpenSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: 'This post is already open.'
            });
        }

    })
    .fail(function() {
        setOpenSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });

    });
}
/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR OPEN POST******************************/


/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR PUBLIC POST******************************/
/*Function block button controlers*/
function setPublicSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-public").removeClass("d-none");
        $("#btn-text-public").text(" Please wait...");
        $("#btn-submit-public").prop("disabled", true);
        $("#btn-cancel-public").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-public").addClass("d-none");
        $("#btn-text-public").text("Yes");
        $("#btn-submit-public").prop("disabled", false);
        $("#btn-cancel-public").prop("disabled", false);
        window.onbeforeunload = null;
    }
}
/*Function gather value for update*/
function btnPublic() {
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setPublicSpinner(true);
    var Serviceid   = $("#srv-id-public").val();
    var Status      = 'PB';

    lastUpdateOpen = {
        Serviceid: Serviceid,
        Status: Status
    };

    sendPublicRequest(lastUpdateOpen);
}
/*Function to submit edit request to backend*/
function sendPublicRequest(payload) {
    $.post("dirs/services/actions/update_posting.php", payload)
    .done(function(data) {
        if ($.trim(data) === "success") {
            setPublicSpinner(false);
            $("#mdl-message-public").modal('hide');
            loadServices();
            Swal.fire({
                icon: "success",
                title: "Post Public",
                text: "Successfully.",
                timer: 2000,
                showConfirmButton: false
            });
            lastUpdateOpen = null;
        } else {
            setPublicSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: 'This post is already posted public.'
            });
        }

    })
    .fail(function() {
        setPublicSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });

    });
}
/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR PUBLIC POST******************************/


/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR PUBLIC POST******************************/
/*Function block button controlers*/
function setPrivateSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-private").removeClass("d-none");
        $("#btn-text-private").text(" Please wait...");
        $("#btn-submit-private").prop("disabled", true);
        $("#btn-cancel-private").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-private").addClass("d-none");
        $("#btn-text-private").text("Yes");
        $("#btn-submit-private").prop("disabled", false);
        $("#btn-cancel-private").prop("disabled", false);
        window.onbeforeunload = null;
    }
}
/*Function gather value for update*/
function btnPrivate() {
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setPrivateSpinner(true);
    var Serviceid   = $("#srv-id-private").val();
    var Status      = 'PV';

    lastUpdateOpen = {
        Serviceid: Serviceid,
        Status: Status
    };

    sendPrivateRequest(lastUpdateOpen);
}
/*Function to submit edit request to backend*/
function sendPrivateRequest(payload) {
    $.post("dirs/services/actions/update_posting.php", payload)
    .done(function(data) {
        if ($.trim(data) === "success") {
            setPrivateSpinner(false);
            $("#mdl-message-private").modal('hide');
            loadServices();
            Swal.fire({
                icon: "success",
                title: "Post Private",
                text: "Successfully.",
                timer: 2000,
                showConfirmButton: false
            });
            lastUpdateOpen = null;
        } else {
            setPrivateSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: 'This post is already posted private.'
            });
        }

    })
    .fail(function() {
        setPrivateSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });

    });
}
/*************************UPDATE FUNCTION WITH NETWORK CONNECTION VALIDATION FOR PUBLIC POST******************************/