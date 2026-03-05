$(document).ready(function(){
    loadDashboard();
});


function loadDashboard() {
    $.post("dirs/dashboard/components/main.php", {
    }, function (data){
        $("#load_Dashboard").html(data);
        loadTicketStatus();
        loadPostService();
        // loadRequest();
    });
}

/*Function Date and Time Formating*/
function formatDate(dateStr) {
    if (!dateStr) return "";
    const d = new Date(dateStr);
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const day   = String(d.getDate()).padStart(2, "0");
    const year  = d.getFullYear();
    return `${month}/${day}/${year}`;
}


/*Function to shoall new Queueing Tickets*/
function loadTicketStatus() {
    var spinner = `<div class="spinner-border spinner-border-sm text-dark" role="status">
                       <span class="visually-hidden">Loading...</span>
                   </div>`;
    $.post("dirs/dashboard/actions/get_ticket.php", {}, function(data){
        let response = JSON.parse(data);
        if ($.trim(response.isSuccess) == "success") {
            let tickets = {
                "#queue-tickets": response.Data.QueueTicket,
                "#resolved-tickets": response.Data.ResolvedTicket,
                "#standby-tickets": response.Data.StandbyTicket,
                "#cancel-tickets": response.Data.CancelTicket
            };
            $.each(tickets, function(id, value){
                $(id).html(spinner);
                setTimeout(function(){
                    $(id).hide().text(value ?? 0).fadeIn(300);
                }, 200);
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Function Display all request tickets to your department*/
var currentPage = 1;
var pageSize = 20;
var totalPages = 1;
var display = $("#service_request");

function loadPostService(page = 1) {
    var Search = $("#search-tickets").val();
    $.post("dirs/dashboard/actions/get_requestservices.php", {
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
    const display = $("#service_request");
    display.empty();

    if (!data || data.length === 0) {
        display.html(`
            <tr>
                <td colspan="9" class="text-center py-5">
                  <div class="d-flex flex-column align-items-center text-muted">
                    <div class="mb-3" style="font-size: 40px; opacity: .35;">
                      <i class="fa fa-file"></i>
                    </div>
                    <div class="fw-semibold">No Queue Ticket Available.</div>
                    <div class="small opacity-75">
                      Please reload if no available tickets displayed.
                    </div>
                  </div>
                </td>
            </tr>
        `);
        return;
    }

    data.forEach(srv => {
        // Determine class based on status
        let statusBadge = ''; // will hold the badge HTML
        switch(srv.TicketStatus.toUpperCase()) {
            case 'OPEN':
                statusBadge = `<span class="badge bg-info-subtle text-info">${srv.TicketStatus}</span>`;
                break;
            case 'RESOLVED':
                statusBadge = `<span class="badge bg-success-subtle text-success">${srv.TicketStatus}</span>`;
                break;
            case 'STAND BY':
                statusBadge = `<span class="badge bg-primary-subtle text-primary">${srv.TicketStatus}</span>`;
                break;
            case 'REJECTED':
                statusBadge = `<span class="badge bg-danger-subtle text-danger">${srv.TicketStatus}</span>`;
                break;
            case 'CANCELLED':
                statusBadge = `<span class="badge bg-secondary-subtle text-secondary">${srv.TicketStatus}</span>`;
                break;
            default:
                statusBadge = `<span class="badge bg-light text-dark">${srv.TicketStatus}</span>`;
        }
        display.append(`
            <tr>
                <td>
                <div class="form-check ml-3">
                  <input class="form-check-input text-lg border-primary" type="checkbox" value="" id="standby-action">
                </div>
                </td>
                <td onclick="loadContent('${srv.RowNum}')">${srv.TKTNumber}</td>
                <td onclick="loadContent('${srv.RowNum}')">${srv.RequestingOffice}</td>
                <td onclick="loadContent('${srv.RowNum}')">${srv.ServiceType}</td>
                <td onclick="loadContent('${srv.RowNum}')">${srv.Branch}</td>
                <td onclick="loadContent('${srv.RowNum}')">${srv.Department}</td>
                <td onclick="loadContent('${srv.RowNum}')">${formatDate(srv.DocDate)}</td>
                <td onclick="loadContent('${srv.RowNum}')" class="text-center">${statusBadge}</td>
                <td class ="text-center">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-download"></i>    Download</a></li> <!-- Download attachments -->
                        <li><a class="dropdown-item" href="#"><i class="bi bi-check2"></i>  Approve</a></li> <!-- Approve request -->
                        <li><a class="dropdown-item" href="#"><i class="bi bi-x-lg"></i>    Reject</a></li> <!-- Reject request -->
                        <li><a class="dropdown-item" href="#"><i class="bi bi-chat-right-dots"></i> Comment</a></li> <!-- Add internal notes / comments -->
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill-check"></i>   Assign</a></li> <!-- Assign ticket to another user/department -->
                        <li><a class="dropdown-item" href="#"><i class="bi bi-exclamation-circle"></i>  Mark as Important</a></li> <!-- Optional: acknowledge ticket -->
                      </ul>
                    </div>
                </td>
            </tr>
            `);
        });
    }




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


function loadContent(RowNum) {
    $("#mdl-ticket-content").modal('show');
}


// /*Function reject get id*/
// function rejectRequest(Req_id){
//     $("#modal-reject").modal('show');
//     $.post("dirs/dashboard/actions/get_ticket.php",{
//         Req_id : Req_id
//     },function(data){
//         response = JSON.parse(data);
//         if(jQuery.trim(response.isSuccess) == "success"){
//             $("#ticket-id").val(response.Data.Req_id);
//         }else{
//             alert(jQuery.trim(response.Data));
//         }
//     });
// }


// /*Function reject request*/
// function saveRejectRequest(){
//     var Req_id = $("#ticket-id").val();
//     var ReqStatus = '3';
//     $.post("dirs/dashboard/actions/update_status.php", {
//         Req_id : Req_id,
//         ReqStatus : ReqStatus
//     },function(data){
//         if(jQuery.trim(data) == "success"){
//             $("#modal-reject").modal('hide');
//             loadDashboard();
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Success',
//                 text: 'Request Rejected.',
//                 timer: 2000,
//                 showConfirmButton: false
//             });
//         }else{
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: data,
//                 timer: 2000,
//                 showConfirmButton: false
//             });
//             alert(data); 
//         }
//     });
// }


// /*Function accept get id*/
// function acceptRequest(Req_id){
//     $("#modal-accept").modal('show');
//     $.post("dirs/dashboard/actions/get_ticket.php",{
//         Req_id : Req_id
//     },function(data){
//         response = JSON.parse(data);
//         if(jQuery.trim(response.isSuccess) == "success"){
//             $("#ticket-id").val(response.Data.Req_id);
//         }else{
//             alert(jQuery.trim(response.Data));
//         }
//     });
// }


// /*Function reject request*/
// function saveAcceptRequest(){
//     var Req_id = $("#ticket-id").val();
//     var ReqStatus = '2';
//     $.post("dirs/dashboard/actions/update_status.php", {
//         Req_id : Req_id,
//         ReqStatus : ReqStatus
//     },function(data){
//         if(jQuery.trim(data) == "success"){
//             $("#modal-reject").modal('hide');
//             loadDashboard();
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Success',
//                 text: 'Request Accepted.',
//                 timer: 2000,
//                 showConfirmButton: false
//             });
//         }else{
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: data,
//                 timer: 2000,
//                 showConfirmButton: false
//             });
//             alert(data); 
//         }
//     });
// }