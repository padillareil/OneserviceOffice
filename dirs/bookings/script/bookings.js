$(document).ready(function(){
    loadBookings();
});



function loadBookings() {
    $.post("dirs/bookings/components/main.php", {
    }, function (data){
        $("#load_Bookings").html(data);
        loadRequest();
    });
}


/* Function Date Formatting */
function safeFormatDate(dateStr) {
    if (!dateStr) return "-"; // empty, null, undefined → "-"
    const d = new Date(dateStr);
    if (isNaN(d.getTime())) {
        return "-";
    }
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const day   = String(d.getDate()).padStart(2, "0");
    const year  = d.getFullYear();

    return `${month}/${day}/${year}`;
}





    var CurrentPage = 1;
    var PageSize = 20;
    var tbody = $("#load_my_bookings");

    function loadRequest(CurrentPage = 1, status = null) {

    var  Search = $("#search-booking").val();

    $.post("dirs/bookings/actions/get_bookings.php", {
        CurrentPage: CurrentPage,
        PageSize: PageSize,
        Search : Search, 
       /* Category : Category,*/
    }, function(data) {
        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            console.log("Server error.");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            loadNewTickets(response.Data);
            currentPage = CurrentPage;
        } else {
            console.log($.trim(response.Data));
        }
    });
}

/* Render Blocked Accounts into Table */
function loadNewTickets(data) {
    const tbody = $("#load_my_bookings"); 
    tbody.empty();

    if (!data || data.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    <i class="bi bi-file-earmark-text fs-3"></i><br>No Record Found.
                </td>
            </tr>
        `);
        return;
    }

    data.forEach(req => {
       if (req.Tckt_Status === 1) {
           levelBadge = `<span class="badge badge-success">OPEN</span>`;
        } else {
           levelBadge = `<span class="badge badge-danger">CLOSED</span>`;
       }

       tbody.append(`
           <tr ondblclick="loadShowBooking(${req.Req_id})">
               <td>${req.ServiceType}</td>
               <td>${req.Dpmnt}</td>
                <td>${safeFormatDate(req.ReqDate)}</td>
               <td>${levelBadge}</td>
               <td><i class="bi bi-clock-history"></i> ${req.DocDateAgo}</td>
           </tr>
       `);
   });
}

                    // <button class="btn btn-success" title="View Request" type="button" onclick="loadShowBooking('${req.Req_id}')">View</button>



/*Function show bookings*/
function loadShowBooking(Req_id){
    $("#mdl-booking").modal('show');
    $.post("dirs/bookings/actions/get_showbooking.php",{
        Req_id : Req_id
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



               // <tr>
               //     <th class="t-action">
               //         <button class="btn btn-success" type="button" onclick="acceptRequest('${req.Req_id}')">Accept</button>
               //         <button class="btn btn-danger" type="button"  onclick="rejectRequest('${req.Req_id}')">Reject</button>
               //     </th>
               //     <td>
               //          <button class="btn btn-light" type="button" onclick="copyTktNumber('${req.TicketNum}',this)"><i class="bi bi-copy"></i> ${req.TicketNum}</button>

               //     </td>
               //     <td>${req.Client}</td>
               //     <td>${req.Client}</td>
               //     <td>${req.Client}</td>
               //     <td>${req.Client}</td>
               //     <td>${req.Client}</td>
               //     <td class="text-center">${levelBadge}</td>
               // </tr>

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

// $(document).ready(function(){

//     $("#frm-crt-tckt-rpr").submit(function(event){
//         event.preventDefault();
// function save_repair_ticket(){
//     var CREATEDDATE = $("#CREATEDDATE").val();
//     var TITLE     = $("#TITLE").val();
//     var TICKETNUMBER         = $("#TICKETNUMBER").val();
//     var STATUS      = $("#STATUS").val();
//     var DEPARTMENT      = $("#DEPARTMENT").val();
//     var SUPERVISOR      = $("#SUPERVISOR").val();
//     var FULLNAME      = $("#FULLNAME").val();
//     var POSITION      = $("#POSITION").val();
//     var ATTACHMENT      = $("#ATTACHMENT").val();
//     var XDATE      = $("#XDATE").val();
//     var DESCRIPTION      = $("#DESCRIPTION").val();


//     $.post("registry/sipedept/student/actions/save_student.php", {
//         StudentName             : StudentName,
//         TITLE                   : TITLE,
//         TICKETNUMBER            : TICKETNUMBER,
//         STATUS                  : STATUS,
//         DEPARTMENT              : DEPARTMENT,
//         SUPERVISOR                  : SUPERVISOR,
//         FULLNAME                  : FULLNAME,
//         POSITION                  : POSITION,
//         ATTACHMENT                  : ATTACHMENT,
//         XDATE                  : XDATE,
//         DESCRIPTION                  : DESCRIPTION,
//     }, function(data){
//         if($.trim(data) == "OK"){
//             toastalert("Ticket Sent!");
//         }else{
//             alert("Error: " + data);
//         }
//     });
// }


// /*Automatic to pull data every 2 seconds*/
// $(document).ready(function(){
//     // Fetch every 2 seconds
//     setInterval(function(){
//         get_student();
//     }, 2000);
// });
