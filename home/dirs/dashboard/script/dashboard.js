$(document).ready(function(){
    loadDashboard();
});


function loadDashboard() {
    $.post("dirs/dashboard/components/main.php", {
    }, function (data){
        $("#load_Dashboard").html(data);
        loadTicketStatus();
        loadPostService();
        loadImperialAppliancesBranch();
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
function loadPostService(page = 1, Important = null) {

    var spinner = `
    <tr>
        <td colspan="8" class="text-center py-5">
            <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
            <div class="mt-2">Loading...</div>
        </td>
    </tr>
    `;

    var Search = $("#search-tickets").val();
    var Status = $("#ticket-filter-status").val();
    var Branch = $("#iap-branch-dashboard").val();
    var DateFrom = $("#date-from").val();
    var DateTo = $("#date-to").val();

    display.html(spinner);

    setTimeout(function(){

        $.post("dirs/dashboard/actions/get_requestservices.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search: Search,
            Important: Important,
            Status: Status,
            Branch: Branch,
            DateFrom: DateFrom,
            DateTo: DateTo
        }, function(data){

            let response;

            try {
                response = JSON.parse(data);
            } catch (e) {
                display.html(`<tr><td colspan="9" class="text-center text-danger py-4">Server Error</td></tr>`);
                toastr.error("Server error.", "Error");
                return;
            }

            if ($.trim(response.isSuccess) === "success") {

                displayServices(response.Data);
                currentPage = page;

                totalPages = (response.Data && response.Data.length > 0)
                    ? parseInt(response.Data[0].TotalPages)
                    : 1;

                buildPageNumbers();
                updatePaginationUI();

            } else {

                display.html(`<tr><td colspan="9" class="text-center text-muted py-4">No data found</td></tr>`);
                toastr.error($.trim(response.Data), "Error");

            }

        });

    }, 200);
}

/* Render Blocked Accounts into Table */
function displayServices(data) {
    const display = $("#service_request");
    display.empty();

    if (!data || data.length === 0) {
        display.html(`
            <tr>
                <td colspan="8" class="text-center py-5">
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

        // Determine Important check display
        let statusCheckBox = '';
        let disabledAttr = '';

        // Only allow checkbox for TicketStatus O (Open) or S (Stand By)
        if (srv.TicketStatus === 'OPEN' || srv.TicketStatus === 'STAND BY') {
            // Determine if checked based on Important value
            switch (srv.Important) {
                case 'Y':
                    statusCheckBox = 'checked';
                    break;
                case 'N':
                default:
                    statusCheckBox = '';
            }
            disabledAttr = ''; // enabled
        } else {
            // Any other status → checkbox disabled
            statusCheckBox = '';
            disabledAttr = 'disabled';
        }
        display.append(`
            <tr>
                <td>
                <div class="form-check ml-3">
                  <input class="form-check-input text-lg border-primary" type="checkbox"
                             ${statusCheckBox} ${disabledAttr}
                             onchange="updateImportant('${srv.SysNum}', this)">
                </div>
                </td>
                <td ondblclick='loadContent("${srv.SysNum}")'>${srv.TKTNumber}</td>
                <td ondblclick='loadContent("${srv.SysNum}")'>${srv.RequestingOffice}</td>
                <td ondblclick='loadContent("${srv.SysNum}")'>${srv.ServiceType}</td>
                <td ondblclick='loadContent("${srv.SysNum}")'>${srv.Branch}</td>
                <td class="text-center" ondblclick='loadContent("${srv.SysNum}")'>${formatDate(srv.DocDate)}</td>
                <td ondblclick='loadContent("${srv.SysNum}")' class="text-center">${statusBadge}</td>
                <td class ="text-center">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="dwnloadAttachment('${srv.SysNum}')"><i class="bi bi-download"></i>    Download</a></li> <!-- Download attachments -->
                        <li><a class="dropdown-item" href="#" onclick="mdlApprovedAction('${srv.SysNum}')"><i class="bi bi-check2"></i>  Approve</a></li> 
                        <li><a class="dropdown-item" href="#" onclick="mdlRejectAction('${srv.SysNum}')"><i class="bi bi-x-lg"></i>    Reject</a></li> 
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill-check"></i>   Assign</a></li>
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



/*Function show Ticket Content*/
function loadContent(SysNum){
    $("#mdl-ticket-content").modal('show');

    $.post("dirs/dashboard/actions/get_ticketcontent.php",{
        SysNum : SysNum
    },function(data){
        let response = JSON.parse(data);

        if($.trim(response.isSuccess) == "success"){
            $("#card-content").removeClass('d-none');

            $("#ticket-subject").val(response.Data.ServiceName);
            $("#type-of-request").val(response.Data.ServiceType);
            $("#description").text(response.Data.Instruction);
            $("#mdl-ticket-number").text(response.Data.TKTNumber);

            $("#ticket-id-number").val(response.Data.TKTNumber);
            $("#tikcet-description").summernote('code', response.Data.MsgContent);

            $("#manager-name").text(response.Data.UserFullname);
            $("#manager-position").text(response.Data.UserJobPosition);
            $("#manager-department").text(response.Data.UserDepartment);

            if(response.Data.Attachment === null){
                $("#dowload-attachment").addClass('d-none');
            }else{
                $("#dowload-attachment").removeClass('d-none');
            }

            /*Button actions condition here that if status is reject and cancelled must button will be hidden*/

            if (response.Data.TicketStatus === 'REJECTED' || response.Data.TicketStatus === 'CANCELLED') {
                $("#btn-add-response").addClass('d-none');
                $("#btn-add-approve").addClass('d-none');
                $("#btn-add-standby").addClass('d-none');
                $("#btn-add-reject").addClass('d-none');

            }else{
                $("#rejection-fields").removeClass('d-none');
                $("#btn-add-response").removeClass('d-none');
                $("#btn-add-approve").removeClass('d-none');
                $("#btn-add-standby").removeClass('d-none');
                $("#btn-add-reject").removeClass('d-none');
            }

        }else{
            alert($.trim(response.Data));
        }
    });
}




/*Function reject ticket*/
function mdlRejectPrompt() {
    Swal.fire({
        icon: "warning",
        title: "Do you want to reject this Ticket?",
        text: "This action cannot be undone.",
        showCancelButton: true,
        confirmButtonText: "Commit",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745", /*success color code*/
        cancelButtonColor: "#6c757d"
    }).then((result) => {
        if (result.isConfirmed) {
            rejectTicket(); 
        }
    });
}

/*Function reject ticket*/
function rejectTicket() {
    var  Ticket  = $("#ticket-id-number").val();
    var  Action = "Rejected";
    var Comment = $('#ticket_reply').summernote('code');
    $.post("dirs/dashboard/actions/update_actionticket.php", {
        Ticket   : Ticket,
        Action   : Action,
        Comment  : Comment,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#mdl-ticket-content").modal('hide');
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Ticket Rejected",
                text: "Successfully rejected.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function approved ticket*/
function mdlApprovedPrompt() {
    Swal.fire({
        icon: "warning",
        title: "Do you want to approved this Ticket?",
        text: "This action cannot be undone.",
        showCancelButton: true,
        confirmButtonText: "Commit",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745", /*success color code*/
        cancelButtonColor: "#6c757d"
    }).then((result) => {
        if (result.isConfirmed) {
            approvedTicket(); 
        }
    });
}

/*Function approved ticket*/
function approvedTicket() {
    var  Ticket  = $("#ticket-id-number").val();
    var  Action = "Approved";
    var Comment = $('#ticket_reply').summernote('code');
    $.post("dirs/dashboard/actions/update_actionticket.php", {
        Ticket   : Ticket,
        Action   : Action,
        Comment  : Comment,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#mdl-ticket-content").modal('hide');
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Ticket Approved",
                text: "Successfully approved.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function standby ticket*/
function mdlStandByPrompt() {
    Swal.fire({
        icon: "warning",
        title: "Do you want to stand by this Ticket?",
        text: "This action cannot be undone.",
        showCancelButton: true,
        confirmButtonText: "Commit",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745", /*success color code*/
        cancelButtonColor: "#6c757d"
    }).then((result) => {
        if (result.isConfirmed) {
            standbyTicket(); 
        }
    });
}

/*Function standby ticket*/
function standbyTicket() {
    var  Ticket  = $("#ticket-id-number").val();
    var  Action = "Standby";
    var Comment = $('#ticket_reply').summernote('code');
    $.post("dirs/dashboard/actions/update_actionticket.php", {
        Ticket   : Ticket,
        Action   : Action,
        Comment  : Comment,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#mdl-ticket-content").modal('hide');
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Ticket Stand by",
                text: "Successfully stand by.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


// Side Table Actions buttons shortcuts ********************************************************************************************************************//

/*Function show swlfire prompt*/
function mdlApprovedAction(SysNum){
    Swal.fire({
        icon: "warning",
        title: "Do you want to approved this Ticket?",
        text: "This action cannot be undone.",
        showCancelButton: true,
        confirmButtonText: "Commit",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745", /*success color code*/
        cancelButtonColor: "#6c757d"
    }).then((result) => {
        if (result.isConfirmed) {
            approveTicketAction(); 
        }
    });
    $.post("dirs/dashboard/actions/get_ticketcontent.php",{
        SysNum : SysNum
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#side-ticket-number").val(response.Data.TKTNumber);
        }else{
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function approved ticket*/
function approveTicketAction() {
    var  Ticket  = $("#side-ticket-number").val();
    var  Action = "Approved";
    var Comment = $('#ticket_reply').summernote('code');
    $.post("dirs/dashboard/actions/update_actionticket.php", {
        Ticket   : Ticket,
        Action   : Action,
        Comment  : Comment,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Ticket Approved",
                text: "Successfully approved.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}

/*Function show swlfire prompt for reject*/
function mdlRejectAction(SysNum){
    Swal.fire({
        icon: "warning",
        title: "Do you want to reject this Ticket?",
        text: "This action cannot be undone.",
        showCancelButton: true,
        confirmButtonText: "Commit",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745", /*success color code*/
        cancelButtonColor: "#6c757d"
    }).then((result) => {
        if (result.isConfirmed) {
            rejectTicketAction(); 
        }
    });
    $.post("dirs/dashboard/actions/get_ticketcontent.php",{
        SysNum : SysNum
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#side-ticket-number").val(response.Data.TKTNumber);
        }else{
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function rejectd ticket*/
function rejectTicketAction() {
    var  Ticket  = $("#side-ticket-number").val();
    var  Action = "Rejected";
    var Comment = $('#ticket_reply').summernote('code');
    $.post("dirs/dashboard/actions/update_actionticket.php", {
        Ticket   : Ticket,
        Action   : Action,
        Comment  : Comment,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Ticket Rejected",
                text: "Successfully rejected.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function update add important*/
function addTicktImportant(SysNum) {
    var ImprtntValue = 'Y';
    $.post("dirs/dashboard/actions/update_important.php", {
        SysNum   : SysNum,
        ImprtntValue   : ImprtntValue
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            loadDashboard(); 
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Set as Important.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error.",
                text: data
            });
        }
    });
}


/*Function checkbox behavior for important and not*/
function updateImportant(SysNum, checkbox) {
    var ImprtntValue = checkbox.checked ? 'Y' : 'N';
    $.post("dirs/dashboard/actions/update_important.php", {
        SysNum       : SysNum,
        ImprtntValue : ImprtntValue
    }, function(data) {
        if($.trim(data) === "success") {
            loadPostService();
            Swal.fire({
                icon: "success",
                title: "Success",
                text: ImprtntValue === 'Y' ? "Set as Important." : "Removed from Important.",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data
            });
        }
    });
}
/*********************************************************FIND Client*/

/*Function for refresh button on modal displays and fields*/
function reloadModalClient() {
    loadImperialAppliancesBranch();
    loadDepartments();
    loadClients();
    $("#search-clients").val('');
}



/*load Imperial Branches*/
function loadImperialAppliancesBranch() {
  $.post("dirs/dashboard/actions/get_branches.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#modal-iap-branch").html('<option selected value="">All</option>');
      branches.forEach(branch => {
        $("#modal-iap-branch").append(
          $("<option>", {
            value: branch.Branch,
            text: branch.Branch
          })
        );
      });

      $("#iap-branch-dashboard").html('<option selected value="">All</option>');
      branches.forEach(branch => {
        $("#iap-branch-dashboard").append(
          $("<option>", {
            value: branch.Branch,
            text: branch.Branch
          })
        );
      });
    } else {
      alert($.trim(response.Data));
    }
  });
}

/*load Department client departments*/
function loadDepartments() {
  $.post("dirs/dashboard/actions/get_departments.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#modal-department-client").html('<option selected value="">All</option>');
      branches.forEach(dpmnt => {
        $("#modal-department-client").append(
          $("<option>", {
            value: dpmnt.Department,
            text: dpmnt.Department
          })
        );
      });
    } else {
      alert($.trim(response.Data));
    }
  });
}


/*Function load all Client Master List*/
function loadFindClient() {
    $("#mdl-clients").modal('show');
    loadClients();
    loadDepartments();
}

/*Function Display all clients requested to the department*/
var currentPage = 1;
var pageSize = 20;
var totalPages = 1;
var display = $("#client_dsplay");

function loadClients(page = 1) {
    var spinner = `
        <tr>
            <td colspan="4" class="text-center py-5">
                <p>Loading...</p>
              <div class="spinner-border spinner-border-sm text-dark" role="status"></div>
            </td>
        </tr>
    `;
    var Search = $("#search-clients").val();
    var Department = $("#modal-department-client").val();
    var Branch = $("#modal-iap-branch").val();
    /* Show spinner */
    display.html(spinner);
    /* Delay request 200ms */
    setTimeout(function(){

        $.post("dirs/dashboard/actions/get_myclients.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search: Search,
            Branch: Branch,
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

                displayAllClients(response.Data);
                currentPage = page;

                if (response.Data && response.Data.length > 0) {
                    totalPages = parseInt(response.Data[0].TotalPages);
                } else {
                    totalPages = 1;
                }

                buildClientPageNumbers();
                updateModalPagination();

            } else {
                display.html("");
                toastr.error($.trim(response.Data), "Error");
            }

        });
    }, 200); // 200ms delay
}


/* Render Blocked Accounts into Table */
function displayAllClients(data) {
    const display = $("#client_dsplay");
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
function updateModalPagination() {
    $("#page-info-client").text("Page " + currentPage + " of " + totalPages);
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
function buildClientPageNumbers() {
    $("#pagination-client li.page-number").remove(); // remove old numbers
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


/*Function get the client info for search records*/
function findCustomerRecord(SysNum){
    $.post("dirs/dashboard/actions/get_findcustomer.php",{
        SysNum : SysNum
    },function(data){
        let response = JSON.parse(data);
        if($.trim(response.isSuccess) === "success"){

            $("#mdl-clients").modal('hide');
            $("#search-tickets").val(response.Data.Fullname);
            loadPostService(); 
        }else{

            alert($.trim(response.Data));

        }

    });

}



/*Function save response for comment*/
function saveResponse() {
    var btnSave = $("#btn-save-comment");
    var btnCancel = $("#btn-cancel-comment");
    var originalText = btnSave.html();
    var spinner = `<span class="spinner-border spinner-border-sm me-2" role="status"></span> Saving...`;
    btnSave.prop("disabled", true).html(spinner);
    btnCancel.prop("disabled", true);
    var TiketNum = $("#ticket-id-number").val();
    var ResponseTicket = $('#ticket_reply').summernote('code');
    var Status = 'X';
    $.post("dirs/dashboard/actions/update_comment_response.php", {
        TiketNum: TiketNum,
        ResponseTicket: ResponseTicket,
        Status: Status
    }, function(data) {

        if($.trim(data) === "success") {
            $("#mdl-ticket-content").modal('hide');
            $('#ticket_reply').summernote('code', '');
            $("#frm-ticket-content")[0].reset();

            // close collapse
            var collapseElement = document.getElementById('collapse-message');
            var collapseInstance = bootstrap.Collapse.getOrCreateInstance(collapseElement);
            collapseInstance.hide();

            loadDashboard();
            Swal.fire({
                icon: "success",
                title: "Sent",
                text: "Successfully sent.",
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
        // Restore buttons
        btnSave.prop("disabled", false).html(originalText);
        btnCancel.prop("disabled", false);
    });
}


/***********************************Downloading File Attachment*****************************************************/
/*Function Donwload Attahment*/
// function dwnloadAttachment(SysNum){
//     $.post("dirs/dashboard/actions/get_download_attachment.php",{
//         SysNum : SysNum
//     },function(data){
//         response = JSON.parse(data);
//         if(jQuery.trim(response.isSuccess) == "success"){
//             $("#").val(response.Data.Attachment);
//         }else{
//             Swal.fire({
//                 icon: "error",
//                 title: "Error",
//                 text: data,
//                 timer: 2000,
//                 showConfirmButton: false
//             });
//         }
//     });
// }
