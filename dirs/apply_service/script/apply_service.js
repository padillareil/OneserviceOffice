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
    loadTeamsAppliedDepartment(); /*For display filter department requested*/
}


/*Function load resolved tickets*/
function loadresolved() {
    $("#mdl-req-resolved").modal('show');
    loadTeamsApplied_Resolved();
    loadResolvedApplication();
}

/*Function load cancelled tickets*/
function loadreqCancel() {
    $("#mdl-req-cancelled").modal('show');
    loadTeamsApplied_Rejected();
    loadRejectedApplication();
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


/********************************************************************************Modal Team In Queue Tickets*********************************************************************************/

    /*Function Display all staff requested to other departments*/
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
        var DateFrom = $("#date-from-open").val();
        var DateTo = $("#date-to-open").val();
        /* Show spinner */
        display.html(spinner);
        /* Delay request 200ms */
        setTimeout(function(){

            $.post("dirs/apply_service/actions/get_team_open_tickets.php", {
                CurrentPage: page,
                PageSize: pageSize,
                Search: Search,
                Staff: Staff,
                Department: Department,
                DateFrom: DateFrom,
                DateTo: DateTo
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
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view applied tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
                        </div>
                      </div>
                    </td>
                </tr>
            `);
            return;
        }

        data.forEach(tkt => {
            // Determine class based on status
            let statusBadge = ''; // will hold the badge HTML
            switch(tkt.TicketStatus.toUpperCase()) {
                case 'OPEN':
                    statusBadge = `<span class="badge bg-info-subtle text-info">${tkt.TicketStatus}</span>`;
                    break;
                case 'RESOLVED':
                    statusBadge = `<span class="badge bg-success-subtle text-success">${tkt.TicketStatus}</span>`;
                    break;
                case 'STAND BY':
                    statusBadge = `<span class="badge bg-primary-subtle text-primary">${tkt.TicketStatus}</span>`;
                    break;
                case 'REJECTED':
                    statusBadge = `<span class="badge bg-danger-subtle text-danger">${tkt.TicketStatus}</span>`;
                    break;
                case 'CANCELLED':
                    statusBadge = `<span class="badge bg-secondary-subtle text-secondary">${tkt.TicketStatus}</span>`;
                    break;
                default:
                    statusBadge = `<span class="badge bg-light text-dark">${tkt.TicketStatus}</span>`;
            }

            display.append(`
                <tr ondblclick='findCustomerRecord("${tkt.SysNum}")'>
                    <td>${tkt.TKTNumber}</td>
                    <td>${tkt.Department}</td>
                    <td>${tkt.Branch}</td>
                    <td>${formatDate(tkt.DocDate)}</td>
                    <td>${statusBadge}</td>
                </tr>
                `);
            });
        }




   /*Function to count page number page 1 of and so on*/
   function updateModalTeamsPagination() {
       $("#pagination-open-ticket").text("Page " + currentPage + " of " + totalPages);
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
       $("#page-info-openticket li.page-number").remove(); // remove old numbers
       var prevLi = $("#btn-previewopen-ticket").parent();
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


    /*load Imperial Branches*/
    function loadTeamsAppliedDepartment() {
      $.post("dirs/apply_service/actions/get_applied_department.php", {}, function(data) {
        const response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
          const branches = response.Data;
          $("#open-ticket-department").html('<option selected value="">All</option>');
          branches.forEach(dpt => {
            $("#open-ticket-department").append(
              $("<option>", {
                value: dpt.TKTDepartment,
                text: dpt.TKTDepartment
              })
            );
          });


          const teams = response.Teams;
          $("#open-ticket-staff").html('<option selected value="">All</option>');
          teams.forEach(team => {
            $("#open-ticket-staff").append(
              $("<option>", {
                value: team.UserFullname,
                text: team.UserFullname
              })
            );
          });
        } else {
          alert($.trim(response.Data));
        }
      });
    }

/********************************************************************************Modal Team In Queue Tickets*********************************************************************************/



/********************************************************************************Modal Resolved Tickets created by Teams*********************************************************************/
    /*Function Display all staff requested to other departments resolved*/
    var currentPage = 1;
    var pageSize = 20;
    var totalPages = 1;
    var display = $("#teams_resolved_tickets");

    function loadTeamsApplied_Resolved(page = 1) {
        var spinner = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <p>Loading...</p>
                  <div class="spinner-border spinner-border-sm text-dark" role="status"></div>
                </td>
            </tr>
        `;
        var Search = $("#search-resolve").val();
        var Department = $("#resolved-ticket-department").val();
        var Staff = $("#staff-resolved-ticket").val();
        var DateFrom = $("#date-from-resolved").val();
        var DateTo = $("#date-to-resolved").val();
        /* Show spinner */
        display.html(spinner);
        /* Delay request 200ms */
        setTimeout(function(){

            $.post("dirs/apply_service/actions/get_team_resolved_tickets.php", {
                CurrentPage: page,
                PageSize: pageSize,
                Search: Search,
                Staff: Staff,
                Department: Department,
                DateFrom: DateFrom,
                DateTo: DateTo
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
                    displayTeamsResolved_Tickets(response.Data);
                    currentPage = page;

                    if (response.Data && response.Data.length > 0) {
                        totalPages = parseInt(response.Data[0].TotalPages);
                    } else {
                        totalPages = 1;
                    }

                    buildTeamsOpnNUmberResolved();
                    updateModalTeamsPaginationResolved();

                } else {
                    display.html("");
                    toastr.error($.trim(response.Data), "Error");
                }

            });
        }, 200); // 200ms delay
    }


    /* Render Blocked Accounts into Table */
    function displayTeamsResolved_Tickets(data) {
        const display = $("#teams_resolved_tickets");
        display.empty();

        if (!data || data.length === 0) {
            display.html(`
                <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view applied tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
                        </div>
                      </div>
                    </td>
                </tr>
            `);
            return;
        }

        data.forEach(tkt => {
            // Determine class based on status
            let statusBadge = ''; // will hold the badge HTML
            switch(tkt.TicketStatus.toUpperCase()) {
                case 'OPEN':
                    statusBadge = `<span class="badge bg-info-subtle text-info">${tkt.TicketStatus}</span>`;
                    break;
                case 'RESOLVED':
                    statusBadge = `<span class="badge bg-success-subtle text-success">${tkt.TicketStatus}</span>`;
                    break;
                case 'STAND BY':
                    statusBadge = `<span class="badge bg-primary-subtle text-primary">${tkt.TicketStatus}</span>`;
                    break;
                case 'REJECTED':
                    statusBadge = `<span class="badge bg-danger-subtle text-danger">${tkt.TicketStatus}</span>`;
                    break;
                case 'CANCELLED':
                    statusBadge = `<span class="badge bg-secondary-subtle text-secondary">${tkt.TicketStatus}</span>`;
                    break;
                default:
                    statusBadge = `<span class="badge bg-light text-dark">${tkt.TicketStatus}</span>`;
            }

            display.append(`
                <tr ondblclick='findCustomerRecord("${tkt.SysNum}")'>
                    <td>${tkt.TKTNumber}</td>
                    <td>${tkt.Department}</td>
                    <td>${tkt.Branch}</td>
                    <td>${formatDate(tkt.DocDate)}</td>
                    <td>${statusBadge}</td>
                </tr>
                `);
            });
        }


     /*Function to count page number page 1 of and so on*/
     function updateModalTeamsPaginationResolved() {
         $("#pagination-r-application").text("Page " + currentPage + " of " + totalPages);
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
     function buildTeamsOpnNUmberResolved() {
         $("#page-info-r-application li.page-number").remove(); // remove old numbers
         var prevLi = $("#btn-preview-r-application").parent();
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


     /*load Resolved Tickets Department and staffs*/
     function loadResolvedApplication() {
       $.post("dirs/apply_service/actions/get_applied_department.php", {}, function(data) {
         const response = JSON.parse(data);
         if ($.trim(response.isSuccess) === "success") {
           const branches = response.Data;
           $("#resolved-ticket-department").html('<option selected value="">All</option>');
           branches.forEach(dpt => {
             $("#resolved-ticket-department").append(
               $("<option>", {
                 value: dpt.TKTDepartment,
                 text: dpt.TKTDepartment
               })
             );
           });


           const teams = response.Teams;
           $("#staff-resolved-ticket").html('<option selected value="">All</option>');
           teams.forEach(team => {
             $("#staff-resolved-ticket").append(
               $("<option>", {
                 value: team.UserFullname,
                 text: team.UserFullname
               })
             );
           });
         } else {
           alert($.trim(response.Data));
         }
       });
     }



/********************************************************************************Modal Resolved Tickets created by Teams*********************************************************************/




     /********************************************************************************Modal Reject Tickets created by Teams*********************************************************************/
         /*Function Display all staff requested to other departments rejected*/
         var currentPage = 1;
         var pageSize = 20;
         var totalPages = 1;
         var display = $("#teams_rejected_tickets");

         function loadTeamsApplied_Rejected(page = 1) {
             var spinner = `
                 <tr>
                     <td colspan="5" class="text-center py-5">
                         <p>Loading...</p>
                       <div class="spinner-border spinner-border-sm text-dark" role="status"></div>
                     </td>
                 </tr>
             `;
             var Search = $("#search-rejected").val();
             var Department = $("#reject-ticket-department").val();
             var Staff = $("#staff-reject-ticket").val();
             var DateFrom = $("#date-from-reject").val();
             var DateTo = $("#date-to-reject").val();
             /* Show spinner */
             display.html(spinner);
             /* Delay request 200ms */
             setTimeout(function(){

                 $.post("dirs/apply_service/actions/get_team_reject_tickets.php", {
                     CurrentPage: page,
                     PageSize: pageSize,
                     Search: Search,
                     Staff: Staff,
                     Department: Department,
                     DateFrom: DateFrom,
                     DateTo: DateTo
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
                         displayTeamsReject_Tickets(response.Data);
                         currentPage = page;

                         if (response.Data && response.Data.length > 0) {
                             totalPages = parseInt(response.Data[0].TotalPages);
                         } else {
                             totalPages = 1;
                         }

                         buildTeamsOpnNUmberReject();
                         updateModalTeamsPaginationReject();

                     } else {
                         display.html("");
                         toastr.error($.trim(response.Data), "Error");
                     }

                 });
             }, 200); // 200ms delay
         }


         /* Render Blocked Accounts into Table */
         function displayTeamsReject_Tickets(data) {
             const display = $("#teams_rejected_tickets");
             display.empty();

             if (!data || data.length === 0) {
                 display.html(`
                     <tr>
                         <td colspan="5" class="text-center py-5">
                           <div class="d-flex flex-column align-items-center text-muted">
                             <div class="mb-3" style="font-size: 40px; opacity: .35;">
                               <i class="bi bi-sliders"></i>
                             </div>
                             <div class="fw-semibold">Filter to view applied tickets.</div>
                             <div class="small opacity-75">
                               Please filter and apply if no tickets displayed.
                             </div>
                           </div>
                         </td>
                     </tr>
                 `);
                 return;
             }

             data.forEach(tkt => {
                 // Determine class based on status
                 let statusBadge = ''; // will hold the badge HTML
                 switch(tkt.TicketStatus.toUpperCase()) {
                     case 'OPEN':
                         statusBadge = `<span class="badge bg-info-subtle text-info">${tkt.TicketStatus}</span>`;
                         break;
                     case 'RESOLVED':
                         statusBadge = `<span class="badge bg-success-subtle text-success">${tkt.TicketStatus}</span>`;
                         break;
                     case 'STAND BY':
                         statusBadge = `<span class="badge bg-primary-subtle text-primary">${tkt.TicketStatus}</span>`;
                         break;
                     case 'REJECTED':
                         statusBadge = `<span class="badge bg-danger-subtle text-danger">${tkt.TicketStatus}</span>`;
                         break;
                     case 'CANCELLED':
                         statusBadge = `<span class="badge bg-secondary-subtle text-secondary">${tkt.TicketStatus}</span>`;
                         break;
                     default:
                         statusBadge = `<span class="badge bg-light text-dark">${tkt.TicketStatus}</span>`;
                 }

                 display.append(`
                     <tr ondblclick='findCustomerRecord("${tkt.SysNum}")'>
                         <td>${tkt.TKTNumber}</td>
                         <td>${tkt.Department}</td>
                         <td>${tkt.Branch}</td>
                         <td>${formatDate(tkt.DocDate)}</td>
                         <td>${statusBadge}</td>
                     </tr>
                     `);
                 });
             }


          /*Function to count page number page 1 of and so on*/
          function updateModalTeamsPaginationReject() {
              $("#pagination-rejected-application").text("Page " + currentPage + " of " + totalPages);
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
          function buildTeamsOpnNUmberReject() {
              $("#page-info-rejected li.page-number").remove(); // remove old numbers
              var prevLi = $("#btn-preview-rejected").parent();
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


          /*load Resolved Tickets Department and staffs*/
          function loadRejectedApplication() {
            $.post("dirs/apply_service/actions/get_applied_department.php", {}, function(data) {
              const response = JSON.parse(data);
              if ($.trim(response.isSuccess) === "success") {
                const branches = response.Data;
                $("#rejected-ticket-department").html('<option selected value="">All</option>');
                branches.forEach(dpt => {
                  $("#rejected-ticket-department").append(
                    $("<option>", {
                      value: dpt.TKTDepartment,
                      text: dpt.TKTDepartment
                    })
                  );
                });


                const teams = response.Teams;
                $("#staff-rejected-ticket").html('<option selected value="">All</option>');
                teams.forEach(team => {
                  $("#staff-rejected-ticket").append(
                    $("<option>", {
                      value: team.UserFullname,
                      text: team.UserFullname
                    })
                  );
                });
              } else {
                alert($.trim(response.Data));
              }
            });
          }

     /********************************************************************************Modal Resolved Tickets created by Teams*********************************************************************/
