$(document).ready(function(){
    loadApplyServices();
});



function loadApplyServices() {
    $.post("dirs/apply_service/components/main.php", {
    }, function (data){
        $("#load_ApplyServices").html(data);
        loadDepartments();
        loadPostService();

        loadTeamsApplied_Open();
    });
}


/*Function load request queing*/
function loadreqQueue() {
    $("#mdl-req-queue").modal('show');
}

/*Function load resolved tickets*/
function loadresolved() {
    $("#mdl-req-resolved").modal('show');
}

/*Function load cancelled tickets*/
function loadreqCancel() {
    $("#mdl-req-cancelled").modal('show');
}


/*function load Departments*/
function loadDepartments() {
    $.post("dirs/apply_service/actions/get_departments.php", {}, function (data) {
        const response = JSON.parse(data);
        if (response.isSuccess === "success") {
            const list = $("#departmentList");
            list.find("li.nav-item:not(:first):not(:nth-child(2))").remove();
            response.Data.forEach(dep => {
                list.append(`
                    <li class="nav-item">
                        <a href="#" class="nav-link"
                           name="department"
                           menucode="${dep.Department}">
                            <i class="bi bi-diagram-3"></i>
                            <p>${dep.Department}</p>
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
function filterDepartment(Department){
    $.post("dirs/apply_service/actions/get_department.php",{
        Department : Department
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
        $.post("dirs/apply_service/actions/get_services.php", {
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
            display.append(`
                <div class="col-sm-3 mb-3">
                  <div class="card h-100 border-0 card-shadow rounded-4 service-card">
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
                          <span class="badge bg-light text-secondary border">
                            ${srv.ServiceType}
                          </span>
                        </div>
                        <button class="btn btn-success" type="button" onclick="mdlServiceApply('${srv.Srv_id}')">Create Ticket</button>
                      </div>
                    </div>
                  </div>
                </div>
            `);
        });
    }






/*function mdlServiceApply() {
    $("#mdl-create-ticket").modal('show');
}
*/

    function showLoader() {
        $('#card-loader').removeClass('d-none');
        $('#card-content').addClass('d-none');
    }

    function hideLoader() {
        $('#card-loader').addClass('d-none');
        $('#card-content').removeClass('d-none');
    }


    async function mdlServiceApply(Srv_id) {
        $("#mdl-create-ticket").modal('show');
        $.post("dirs/apply_service/actions/get_tickets.php", {
            Srv_id: Srv_id
        })
        .done(function (data) {
            let response = JSON.parse(data);
            if ($.trim(response.isSuccess) === "success") {
                $("#ticket-subject").val(response.Data.ServiceName);

                $("#type-of-request").val(response.Data.ServiceType);
                $("#description").text(response.Data.Description);
                $("#manager-position").text(response.Data.UserJobPosition);
                $("#manager-department").text(response.Data.Department);
                $("#manager-name").text(response.Data.UserFullname);
                $("#ticket-id-number").val(response.Data.RowNum);
                hideLoader();
            } else {
                showLoader();
                alert($.trim(response.Data));
            }
        })
        .fail(function () {
            showLoader();
            Swal.fire({
                icon: "warning",
                title: "Oops!",
                text: "Please check, No internet connection.",
                timer: 2000,
                showConfirmButton: false
            });

        });

    }




    /*Function Display all clients requested to the department*/
    var currentPage = 1;
    var pageSize = 20;
    var totalPages = 1;
    var display = $("#teams_open_tickets");

    function loadTeamsApplied_Open(page = 1) {
        var spinner = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <p>Loading...</p>
                  <div class="spinner-border spinner-border-sm text-dark" role="status"></div>
                </td>
            </tr>
        `;
        var Search = $("#search-request").val();
        var Department = $("#open-ticket-department").val();
        var Staff = $("#open-ticket-staff").val();
        /* Show spinner */
        display.html(spinner);
        /* Delay request 200ms */
        setTimeout(function(){

            $.post("dirs/apply_service/actions/get_team_open_tickets.php", {
                CurrentPage: page,
                PageSize: pageSize,
                Search: Search,
                Staff: Staff,
                Department: Department
            }, function(data){

                let response;

                try {
                    response = JSON.parse(data);
                } catch (e) {
                    display.html("");
                    toastr.error("Server error.", "Error");
                    return;
                }

                if ($.trim(response.isSuccess) === "success") {

                    displayTeamsOpen_Tickets(response.Data);
                    currentPage = page;

                    if (response.Data && response.Data.length > 0) {
                        totalPages = parseInt(response.Data[0].TotalPages);
                    } else {
                        totalPages = 1;
                    }

                    buildTeamsOpnNUmber();
                    updateModalTeamsPagination();

                } else {
                    display.html("");
                    toastr.error($.trim(response.Data), "Error");
                }

            });
        }, 200); // 200ms delay
    }


    /* Render Blocked Accounts into Table */
    function displayTeamsOpen_Tickets(data) {
        const display = $("#teams_open_tickets");
        display.empty();

        if (!data || data.length === 0) {
            display.html(`
                <tr>
                    <td colspan="4" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-people"></i>
                        </div>
                        <div class="fw-semibold">No Record Found.</div>
                        <div class="small opacity-75">
                          No client records exist.
                        </div>
                      </div>
                    </td>
                </tr>
            `);
            return;
        }

        data.forEach(client => {
            display.append(`
                <tr ondblclick='findCustomerRecord("${client.SysNum}")'>
                    <td>${client.Fullname}</td>
                    <td>${client.Position}</td>
                    <td>${client.Branch}</td>
                    <td>${client.Department}</td>
                </tr>
                `);
            });
        }




    /*Function to count page number page 1 of and so on*/
    function updateModalTeamsPagination() {
        $("#pagination-t-application").text("Page " + currentPage + " of " + totalPages);
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
    function buildTeamsOpnNUmber() {
        $("#page-info-t-application li.page-number").remove(); // remove old numbers
        var prevLi = $("#btn-preview-client").parent();
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


// function load_modal(valueStudentID, valueOperation){
//     $("#modal-add-student").modal('show');
//     $("#frm-add-student").attr("operation", valueOperation);
//     $("#frm-add-student").attr("studentid", valueStudentID);

//     if(valueOperation==0){
//         $("#frm-add-student").trigger("reset");
//         $("#material_header").html("New Student");
//         $("#btn_save").html("Save");
//     }else if(valueOperation==1){
//         $("#material_header").html("Update Student");
//         $("#btn_save").html("Update");
//         get_student(valueStudentID);
//     }
// }

// function get_student(StudentID){
//     $.post("registry/sipedept/student/actions/get_student.php",{
//         StudentID : StudentID
//     },function(data){
//         response = JSON.parse(data);
//         if(jQuery.trim(response.isSuccess) == "success"){
//             $("#StudentName").val(response.Data.StudentName);
//             $("#Address").val(response.Data.Address);
//             $("#Age").val(response.Data.Age);
//             $("#Status").val(response.Data.Status);
//         }else{
//             alert(jQuery.trim(response.Data));
//         }
//     });
// }


// /*get api*/
// function get_student(StudentID) {
//     $.getJSON("registry/sipedept/student/actions/get_student.php", { StudentID: StudentID })
//         .done(function(response) {
//             if (response.isSuccess === "success") {
//                 $("#StudentName").val(response.Data.StudentName);
//                 $("#Address").val(response.Data.Address);
//                 $("#Age").val(response.Data.Age);
//                 $("#Status").val(response.Data.Status);
//             } else {
//                 alert(response.Data);
//             }
//         })
//         .fail(function(jqXHR, textStatus, errorThrown) {
//             console.error("AJAX Error:", textStatus, errorThrown);
//             alert("Failed to retrieve student information. Please try again.");
//         });
// }




// function update_student() {
//     var StudentID   = $("#frm-add-student").attr("studentid");
//     var StudentName = $("#StudentName").val();
//     var Address     = $("#Address").val();
//     var Age         = $("#Age").val();
//     var Status      = $("#Status").val();

//     $.post("registry/sipedept/student/actions/update_student.php", {
//         StudentID   : StudentID,
//         StudentName : StudentName,
//         Address     : Address,
//         Age         : Age,
//         Status      : Status,
//     }, function(data) {
//         if(jQuery.trim(data) === "success") {
//             $("#modal-add-student").modal('hide');
//             load_student_list(); 
//             alert('Update successful');
//         } else {
//             alert(data);
//         }
//     });
// }


// function delete_student(StudentID){
//     $.post("registry/sipedept/student/actions/delete_student.php", {
//         StudentID : StudentID
//     },function(data){
//         if(jQuery.trim(data) == "success"){
//             $("#modal-add-student").modal('hide');
//             load_student_list();
//             alert('delete success');   
//         }else{
//             alert(data); 
//         }
//     });
// }

// function save_student(){
//     var StudentName = $("#StudentName").val();
//     var Address     = $("#Address").val();
//     var Age         = $("#Age").val();
//     var Status      = $("#Status").val();

//     $.post("registry/sipedept/student/actions/save_student.php", {
//         StudentName : StudentName,
//         Address     : Address,
//         Age         : Age,
//         Status      : Status,
//     }, function(data){
//         if($.trim(data) == "OK"){
//             alert("Student added.");
//             $("#modal-add-student").modal("hide");
//             load_student_list();
//         }else{
//             alert("Error: " + data);
//         }
//     });
// }

