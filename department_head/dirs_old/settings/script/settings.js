$(document).ready(function(){
    loadSettings();
});


function loadSettings() {
    $.post("dirs/settings/components/main.php", {
    }, function (data){
        $("#loadSettings").html(data);
        loadUserinfo();
        loadUserLogs();
    });
}


/*Function show userinformation*/
function loadUserinfo(){
    $.post("dirs/settings/actions/get_userinfo.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#user-fullname").val(response.Data.UserFullname);
            $("#user-position").val(response.Data.UserJobPosition);
            $("#user-theme").val(response.Data.Theme);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function show modal for change security*/
function changeSecurity() {
    $("#mdl-change-pass").modal('show');
}


/*Function show passwor*/
function showPassword() {
    const passwordField = document.getElementById('new-password');
    const checkbox = document.getElementById('show-password');
    passwordField.type = checkbox.checked ? 'text' : 'password';
}



/*Function for updateing change password*/
$("#frm-change-password").submit(function(event) {
    event.preventDefault();
    var Password = $("#new-password").val();
    $.post("dirs/settings/actions/update_password.php", {
        Password: Password
    }, function(data) {
        data = $.trim(data);
        if (data === "success") {
            loadSettings();
            Swal.fire({
                icon: 'success',
                title: 'Security Update',
                text: 'Success.',
                timer: 2000,
                showConfirmButton: false
            });
            $("#frm-change-password")[0].reset();
            $("#mdl-change-pass").modal('hide');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops',
                text: data,
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
});



/*Function show modal for change landline*/
function changeLandline(){
    $("#mdl-change-contact").modal('show');
    $.post("dirs/settings/actions/get_landline.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#landline").val(response.Data.Landline);
            $("#mobile").val(response.Data.MobileNumber);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}



/*Function for updateing change department contacts*/
$("#frm-change-contact").submit(function(event) {
    event.preventDefault();
    var Landline = $("#landline").val();
    var Mobile = $("#mobile").val();
    $.post("dirs/settings/actions/update_contacts.php", {
        Landline: Landline,
        Mobile: Mobile
    }, function(data) {
        data = $.trim(data);
        if (data === "success") {
            loadSettings();
            Swal.fire({
                icon: 'success',
                title: 'Department Contacts Update',
                text: 'Success',
                timer: 2000,
                showConfirmButton: false
            });
            $("#frm-change-contact")[0].reset();
            $("#mdl-change-contact").modal('hide');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops',
                text: data,
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
});






    var currentPage = 1;
    var pageSize = 100;
    var totalPages = 1;
    var display = $("#user_logs");

    function loadUserLogs(page = 1) {
        var Search = $("#search-logs").val();
        $.post("dirs/settings/actions/get_logs.php", {
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
                buildPageNumLogs();      
                updatePaginationLogs();   
            }
             else {
                toastr.error($.trim(response.Data), "Error");
            }
        });
    }


    /* Render Blocked Accounts into Table */
    function displayServices(data) {
        const display = $("#user_logs");
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

            // Determine badge style
            let badgeClass = '';
            let textClass  = '';

            if (srv.Remarks === 'Success') {
                badgeClass = 'bg-success-subtle';
                textClass  = 'text-success';
            } else {
                badgeClass = 'bg-danger-subtle';
                textClass  = 'text-danger';
            }

            display.append(`
                <a href="#" class="list-group-item list-group-item-action py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge ${badgeClass} ${textClass} me-2">
                                ${srv.Remarks}
                            </span>
                        </div>
                        <small class="text-muted">${srv.DocDate}</small>
                    </div>
                    <div class="small text-muted mt-1">
                        PC: ${srv.PcName} • IP: ${srv.IP_Address}
                    </div>
                </a>
            `);
        });
    }



    /* Pagination + Fetch Blocked Accounts */
    $("#btn-preview").on("click", function(e) {
        e.preventDefault();

        if (currentPage > 1) {
            loadUserLogs(currentPage - 1);
        }
    });

    $("#btn-next").on("click", function(e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            loadUserLogs(currentPage + 1);
        }
    });

    $("#pagination").on("click", ".page-number a", function(e) {
        e.preventDefault();
        var page = parseInt($(this).data("page"));
        loadUserLogs(page);
    });

    /*Function to count page number page 1 of and so on*/
    function updatePaginationLogs() {
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
    function buildPageNumLogs() {
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






/*Function change theme*/
// function changeTheme(themeValue) {
//     $.post("dirs/settings/actions/update_theme.php", {
//         Theme: themeValue // Key must be Theme
//     }, function(data) {
//         if(jQuery.trim(data) === "success") {
//         } else {
//             Swal.fire({
//                 icon: 'warning',
//                 title: 'Oops',
//                 text: data,
//                 timer: 3000,
//                 showConfirmButton: false
//             });
//         }
//     });
// }




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
