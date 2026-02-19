$(document).ready(function(){
    load_student_list();

    $("#frm-add-student").submit(function(event){
        event.preventDefault();

        if($("#frm-add-student").attr('operation')==0){
            save_student();
        }else{
            update_student();
        }

        return false;
    })
});

document.getElementById("Student_FilterKey").onkeypress = function(event){
    if (event.keyCode == 13 || event.which == 13){
        load_student_list();
    }
}

function load_student_list() {
    const Student_FilterKey = $("#Student_FilterKey").val();
    $.post("registry/sipedept/student/components/student_list.php", {
        Student_FilterKey :Student_FilterKey
    }, function (data){
        $("#load_student_list").html(data);
    });
}

function load_modal(valueStudentID, valueOperation){
    $("#modal-add-student").modal('show');
    $("#frm-add-student").attr("operation", valueOperation);
    $("#frm-add-student").attr("studentid", valueStudentID);

    if(valueOperation==0){
        $("#frm-add-student").trigger("reset");
        $("#material_header").html("New Student");
        $("#btn_save").html("Save");
    }else if(valueOperation==1){
        $("#material_header").html("Update Student");
        $("#btn_save").html("Update");
        get_student(valueStudentID);
    }
}

function get_student(StudentID){
    $.post("registry/sipedept/student/actions/get_student.php",{
        StudentID : StudentID
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#StudentName").val(response.Data.StudentName);
            $("#Address").val(response.Data.Address);
            $("#Age").val(response.Data.Age);
            $("#Status").val(response.Data.Status);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*get api*/
function get_student(StudentID) {
    $.getJSON("registry/sipedept/student/actions/get_student.php", { StudentID: StudentID })
        .done(function(response) {
            if (response.isSuccess === "success") {
                $("#StudentName").val(response.Data.StudentName);
                $("#Address").val(response.Data.Address);
                $("#Age").val(response.Data.Age);
                $("#Status").val(response.Data.Status);
            } else {
                alert(response.Data);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            alert("Failed to retrieve student information. Please try again.");
        });
}




function update_student() {
    var StudentID   = $("#frm-add-student").attr("studentid");
    var StudentName = $("#StudentName").val();
    var Address     = $("#Address").val();
    var Age         = $("#Age").val();
    var Status      = $("#Status").val();

    $.post("registry/sipedept/student/actions/update_student.php", {
        StudentID   : StudentID,
        StudentName : StudentName,
        Address     : Address,
        Age         : Age,
        Status      : Status,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#modal-add-student").modal('hide');
            load_student_list(); 
            alert('Update successful');
        } else {
            alert(data);
        }
    });
}


function delete_student(StudentID){
    $.post("registry/sipedept/student/actions/delete_student.php", {
        StudentID : StudentID
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-add-student").modal('hide');
            load_student_list();
            alert('delete success');   
        }else{
            alert(data); 
        }
    });
}

function save_student(){
    var StudentName = $("#StudentName").val();
    var Address     = $("#Address").val();
    var Age         = $("#Age").val();
    var Status      = $("#Status").val();

    $.post("registry/sipedept/student/actions/save_student.php", {
        StudentName : StudentName,
        Address     : Address,
        Age         : Age,
        Status      : Status,
    }, function(data){
        if($.trim(data) == "OK"){
            alert("Student added.");
            $("#modal-add-student").modal("hide");
            load_student_list();
        }else{
            alert("Error: " + data);
        }
    });
}

$(document).ready(function(){

    $("#frm-crt-tckt-rpr").submit(function(event){
        event.preventDefault();
function save_repair_ticket(){
    var CREATEDDATE = $("#CREATEDDATE").val();
    var TITLE     = $("#TITLE").val();
    var TICKETNUMBER         = $("#TICKETNUMBER").val();
    var STATUS      = $("#STATUS").val();
    var DEPARTMENT      = $("#DEPARTMENT").val();
    var SUPERVISOR      = $("#SUPERVISOR").val();
    var FULLNAME      = $("#FULLNAME").val();
    var POSITION      = $("#POSITION").val();
    var ATTACHMENT      = $("#ATTACHMENT").val();
    var XDATE      = $("#XDATE").val();
    var DESCRIPTION      = $("#DESCRIPTION").val();


    $.post("registry/sipedept/student/actions/save_student.php", {
        StudentName             : StudentName,
        TITLE                   : TITLE,
        TICKETNUMBER            : TICKETNUMBER,
        STATUS                  : STATUS,
        DEPARTMENT              : DEPARTMENT,
        SUPERVISOR                  : SUPERVISOR,
        FULLNAME                  : FULLNAME,
        POSITION                  : POSITION,
        ATTACHMENT                  : ATTACHMENT,
        XDATE                  : XDATE,
        DESCRIPTION                  : DESCRIPTION,
    }, function(data){
        if($.trim(data) == "OK"){
            toastalert("Ticket Sent!");
        }else{
            alert("Error: " + data);
        }
    });
}


/*Automatic to pull data every 2 seconds*/
$(document).ready(function(){
    // Fetch every 2 seconds
    setInterval(function(){
        get_student();
    }, 2000);
});
