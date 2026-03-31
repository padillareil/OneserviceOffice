$(document).ready(function(){
    load_Ticket_lookUp();
});

function load_Ticket_lookUp() {
    $.post("dirs/ticket_lookup/components/main.php", {
    }, function (data){
        $("#load_ticket_list").html(data);
        loadImperialAppliancesBranch();
    });
}


/*load Imperial Branches*/
function loadImperialAppliancesBranch() {
  $.post("dirs/ticket_lookup/actions/get_branches.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#branch").html('<option selected value="">All</option>');
      branches.forEach(branch => {
        $("#branch").append(
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

/*Function Date and Time Formating*/
function formatDate(dateStr) {
    if (!dateStr) return "";
    const d = new Date(dateStr);
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const day   = String(d.getDate()).padStart(2, "0");
    const year  = d.getFullYear();
    return `${month}/${day}/${year}`;
}

/*Function Display all request tickets to your department*/
var currentPage = 1;
var pageSize = 20;
var totalPages = 1;
var display = $("#display_all_tickets");
function loadFindTicket(page = 1) {

    var spinner = `
    <tr>
        <td colspan="7" class="text-center py-5">
            <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
            <div class="mt-2">Loading...</div>
        </td>
    </tr>
    `;

    var Search = $("#search-ticketnumber").val();
    var Branch = $("#branch").val();
    var DateFrom = $("#date-from").val();
    var DateTo = $("#date-to").val();

    display.html(spinner);

    setTimeout(function(){

        $.post("dirs/ticket_lookup/actions/get_findticket.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search: Search,
            Branch: Branch,
            DateFrom: DateFrom,
            DateTo: DateTo
        }, function(data){

            let response;

            try {
                response = JSON.parse(data);
            } catch (e) {
                display.html(`<tr><td colspan="7" class="text-center text-danger py-4">Server Error</td></tr>`);
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

                display.html(`<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>`);
                toastr.error($.trim(response.Data), "Error");

            }

        });

    }, 200);
}

/* Render Blocked Accounts into Table */
function displayServices(data) {
    const display = $("#display_all_tickets");
    display.empty();

    if (!data || data.length === 0) {
        display.html(`
            <tr>
                <td colspan="7" class="text-center py-5">
                  <div class="d-flex flex-column align-items-center text-muted">
                    <div class="mb-3" style="font-size: 40px; opacity: .35;">
                      <i class="fa fa-file"></i>
                    </div>
                    <div class="fw-semibold">No Record Found.</div>
                    <div class="small opacity-75">
                      Sorry, this ticket was not available.
                    </div>
                  </div>
                </td>
            </tr>
        `);
        return;
    }

    data.forEach(srv => {
        display.append(`
            <tr ondblclick="reviewTicket('${srv.SysNum}')">
                <td>${srv.TKTNumber}</td>
                <td>${srv.Branch}</td>
                <td>${srv.RequestingOffice}</td>
                <td>${srv.ServiceType}</td>
                <td class="text-center">${formatDate(srv.DocDate)}</td>
                <td class="text-center">${srv.UserFullname}</td>
                <td class="text-center">${formatDate(srv.ApprvdDocDate)}</td>
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
function reviewTicket(SysNum){
    $("#mdl-ticket-content").modal('show');

    $.post("dirs/ticket_lookup/actions/get_ticketcontent.php",{
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