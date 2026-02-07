$(document).ready(function(){
    loadHelpService();
    
});



function loadHelpService() {
    $.post("dirs/services/components/main.php", {
    }, function (data){
        $("#services_content").html(data);
        loadDepartments();
        loadPostService();
    });
}


function loadDepartments() {
    $.post("dirs/services/actions/get_departments.php", {}, function (data) {
        const response = JSON.parse(data);
        if (response.isSuccess === "success") {
            const list = $("#departmentList");
            response.Data.forEach(dep => {
                list.append(`
                    <li class="nav-item">
                        <a href="#" class="nav-link"
                           name="department"
                           menucode="${dep.Dptmnt}">
                            <i class="bi bi-diagram-3"></i>
                            <p>${dep.Dptmnt}</p>
                        </a>
                    </li>
                `);
            });
        } else {
            alert(response.Data);
        }
    });
}





/*Function to get the department value for filtering*/
function filterDepartment(Dptmnt){
    $.post("dirs/services/actions/get_department.php",{
        Dptmnt : Dptmnt
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#department-filtered").val(response.Data.Department);
            loadPostService();
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


    var currentPage = 1;
    var pageSize = 100;
    var display = $("#posted_service");
    function loadPostService(page = 1, status = null) {
        var Search = $("#search-services").val();
        var Department = $("#department-filtered").val();
        $.post("dirs/services/actions/get_services.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search : Search,
            Department : Department,
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
                <div class="col-sm-4 mb-3">
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
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Posted by:</span>
                                    <span class="fw-medium">${srv.Fullname}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="mt-auto">
                                <button class="btn btn-outline-success" type"="button" onclick="bookNow('${srv.Srv_id}')"> Book</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });
    }




/*Function apply Booking*/
function bookNow(Srv_id){
    $("#mdl-booking").modal('show');
    $.post("dirs/services/actions/get_serviceinfo.php",{
        Srv_id : Srv_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#service-name").text(response.Data.Srv_Name);
            $("#service-description").text(response.Data.Description);
            $("#srv-time-in").text(response.Data.Opt_Start);
            $("#srv-time-out").text(response.Data.Opt_End);
            $("#posted-user").text(response.Data.Fullname + " - " +response.Data.Position);
            $("#service-id").val(response.Data.Srv_id);
            $("#service-type-chosen").val(response.Data.Srv_Type);
            $("#service-department").val(response.Data.Department)

            if (response.Data.Attch_Ctrl == 1) {
                $("#attachment-field").removeClass('d-none');
            } else {
                $("#attachment-field").addClass('d-none');
            }
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}
