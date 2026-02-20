$(document).ready(function(){
    loadApplyServices();
});



function loadApplyServices() {
    $.post("dirs/apply_service/components/main.php", {
    }, function (data){
        $("#load_ApplyServices").html(data);
        loadDepartments();
        loadPostService();
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
                        <button class="btn btn-success" type="button" onclick="mdlServiceApply('${srv.ServiceType}')">Create Ticket</button>
                      </div>
                    </div>
                  </div>
                </div>
            `);
        });
    }






/*Function modal Apply Ticket*/
function mdlServiceApply() {
    $("#mdl-create-ticket").modal('show');
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

