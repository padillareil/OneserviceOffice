$(document).ready(function(){
    loadSettings();
});


function loadSettings() {
    $.post("dirs/settings/components/main.php", {
    }, function (data){
        $("#loadSettings").html(data);
        loadUserinfo();
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
