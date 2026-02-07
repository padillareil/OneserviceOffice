$(document).ready(function(){
    load_Requests();
});


function load_Requests() {
    $.post("dirs/request/components/main.php", {
    }, function (data){
        $("#load_create_request").html(data);
        loadMails();
    });
}


function mdlCompose() {
    $("#modal-compose").modal('show');
}

/*Function submit request*/
$("#frm-compose").submit(function(event){
    event.preventDefault();

    var formData = new FormData();
    var Service   = $("#service_category").val();
    var Urgency   = $("#priority_level").val();
    var Purpose       = $("#purpose").val();
    var Greeetings       = $("#greetings").val();
    var Description   = $("#description").val();
    formData.append('Service', Service);
    formData.append('Urgency', Urgency);
    formData.append('Greeetings', Greeetings);
    formData.append('Purpose', Purpose);
    formData.append('Description', Description);
     var fileInput = $("#supporting_docs")[0];
      if (fileInput && fileInput.files.length > 0) {
          formData.set('Document', fileInput.files[0]); 
      }
    $.ajax({
        url: "dirs/request/actions/save_request.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
            if($.trim(data) == "OK"){
                $("#frm-compose")[0].reset();
                $("#modal-compose").modal('hide');
                load_Requests();
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Sent.",
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
        },
        error: function(err){
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred",
                showConfirmButton: true
            });
        }
    });
});



/*Function save draft base on user login*/
function saveDraft() {
    let formData = new FormData();
    let Service     = $("#service_category").val();
    let Greetings     = $("#greetings").val();
    let Urgency     = $("#priority_level").val();
    var Greeetings       = $("#greetings").val();
    let Purpose     = $("#purpose").val();
    let Description = $("#description").val();

    if (!Service || !Urgency || !Purpose) {
        Swal.fire("Incomplete", "Please fill all required fields.", "warning");
        return;
    }

    formData.append("Service", Service);
    formData.append("Greetings", Greetings);
    formData.append("Urgency", Urgency);
    formData.append("Greeetings", Greeetings);
    formData.append("Purpose", Purpose);
    formData.append("Description", Description);

    let fileInput = $("#suppoting_docs")[0];
    if (fileInput && fileInput.files.length > 0) {
        formData.append("suppoting_docs", fileInput.files[0]);
    }

    $.ajax({
        url: "dirs/request/actions/save_draft.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (res) {
            if (res.isSuccess) {
                $("#frm-compose")[0].reset();
                $("#modal-compose").modal('hide');
                emailDraft();
                Swal.fire({
                    icon: "success",
                    title: "Draft Saved",
                    text: "Success.",
                    timer: 2000,
                    showConfirmButton: false
                });

            } else {
                Swal.fire("Error", res.message, "error");
            }
        },
        error: function () {
            Swal.fire("Error", "Server error occurred.", "error");
        }
    });
}




var CurrentPage = 1;
var pageSize = 100;

function loadMails(page = 1) {
    var Pin = $("#request-id").val();
    var Search = $("#search-email").val();
    var CreatedDate = $("#created-date").val();
    var LastUpdate = $("#last-update").val();

    $.post("dirs/request/actions/get_emails.php", {
        Pin: Pin,
        CurrentPage: page,
        PageSize: pageSize,
        Search: Search,
        CreatedDate: CreatedDate,
        LastUpdate: LastUpdate
    }, function (data) {

        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            console.log("Server error.", "Error");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            renderinbox(response.Data);
            CurrentPage = page;
        } else {
           console.log($.trim(response.Data), "Error");
        }
    });
}

function renderinbox(data) {
    const container = $("#load_emails");
    container.empty();

    if (!data || data.length === 0) {
        container.html(`
            <button type="button" class="list-group-item list-group-item-action disabled text-center text-muted">
                <i class="bi bi-inbox fs-2 mb-2"></i>
                <div class="fw-bold">No Record Found.</div>
                <small class="text-muted">There are currently no request services to display.</small>
             </button>
        `);
        return;
    }

    data.forEach(req => {
        container.append(`
            <button type="button" class="list-group-item list-group-item-action" title="Urgency: ${req.Urgency}" onclick="openMessage('${req.Req_id}')">
              <div class="row align-items-center">
                <div class="col-md-1 d-flex justify-content-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input pin-important" type="checkbox" data-req-id="${req.Req_id}" ${req.Pin == 1 ? 'checked' : ''}>
                  </div>
                </div>
                <div class="col-md-8 d-flex align-items-start">
                  <i class="bi bi-envelope me-3 fs-4 text-primary"></i>
                  <div>
                    <div class="fw-bold">${req.ServiceCat}</div>
                    <div class="text-muted">${req.Purpose}</div>
                  </div>
                </div>
                <div class="col-md-3 text-end">
                  <span class="text-muted small">${req.FormattedTime}</span>
                </div>
              </div>
            </button>
        `);
    });
}



/*Function load all drafts*/
function emailDraft() {
    $.post(
        "dirs/request/actions/get_drafts.php",
        {},
        function (response) {
            const $list = $("#load_emails");
            $list.empty();

            if (response.isSuccess === "success" && response.Data.length) {

                response.Data.forEach((draft, i) => {
                    const req = draft.request || {}; // Fallback in case request is missing
                    const service = req.service || 'No Service';
                    const purpose = req.purpose || 'No Purpose';
                    const formattedTime = draft.created_at
                        ? new Date(draft.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                        : '';

                    $list.prepend(`
                        <button type="button" class="list-group-item list-group-item-action" onclick="reapplyDraft('${draft.file}')">
                            <div class="row align-items-center">
                                <div class="col-md-8 d-flex align-items-start">
                                    <i class="bi bi-file-earmark-text me-3 fs-4 text-secondary"></i>
                                    <div>
                                        <div class="fw-bold">${service}</div>
                                        <div class="text-muted">${purpose}</div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="text-muted small">${formattedTime}</span>
                                </div>
                            </div>
                        </button>
                    `);
                });

            }
        },
        "json"
    );
}



/*Function date formater*/
function formatTime(timeString) {
    if (!timeString) return ''; 
    let parts = timeString.split(':'); 
    let hours = parseInt(parts[0], 10);
    let minutes = parseInt(parts[1], 10);
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; 
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return hours + ':' + minutes + ' ' + ampm;
}

/*Function date convertion into string*/
function formatDate(mysqlDate) {
    if (!mysqlDate) return '';
    let dateObj = new Date(mysqlDate);
    let options = { month: 'short', day: 'numeric', year: 'numeric' };
    return dateObj.toLocaleDateString('en-US', options);
}


function openMessage(Req_id) {
    $("#message-content").removeClass('d-none');
    $("#message-empty").empty(); // clear previous message if any

    $.post("dirs/request/actions/get_message.php", {
        Req_id: Req_id
    }, function(data) {
        let response = JSON.parse(data);

        if (jQuery.trim(response.isSuccess) === "success") {
            $("#req-date").text(
                formatDate(!response.Data.EditDate ? response.Data.ReqDate : response.Data.EditDate)
            );

            $("#req-time").text(
                formatTime(!response.Data.EditTime ? response.Data.ReqTime : response.Data.EditTime)
            );

            /*Edited condition*/
            if (response.Data.EditTime) {
                $("#edited-status").removeClass("d-none");
            } else{
                $("#edited-status").addClass("d-none");
            }
            $("#user-greetings").text(response.Data.Greetings);
            $("#ticket-number").text(response.Data.TicketNum);
            $("#Age").text(response.Data.Urgency);
            $("#request-subject").text(response.Data.Purpose);
            $("#description-body").text(response.Data.Description);
            $("#user-fullname").text(response.Data.Fullname);
            $("#user-position").text(response.Data.Position);
            $("#request-id").val(response.Data.Req_id);


            // Hide empty message
            $("#message-empty").addClass('d-none');
        } else {
            // Show No Data Available message
            $("#message-empty").removeClass('d-none').html(`
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                    <h5 class="text-muted fw-bold mb-1">No Data Available</h5>
                    <p class="text-muted small">There is currently no content to display.</p>
                </div>
            `);

        }
    });
}


/*Function validation question edit modal*/
function editRequest() {
    $("#modal-edit").modal('show');
}




/*Function retrieve information*/
function edRequest(){
    $("#modal-edit").modal('hide');
    $("#modal-compose").modal('show');
    var Req_id = $("#request-id").val();
    $.post("dirs/request/actions/get_reqclone.php",{
        Req_id : Req_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#greetings").val(response.Data.Greetings);
            $("#request-id").val(response.Data.Req_id);
            $("#service_category").val(response.Data.ServiceCat).prop("disabled",true);
            $("#priority_level").val(response.Data.Urgency);
            $("#purpose").val(response.Data.Purpose);
            $("#description").val(response.Data.Description);
            $("#suppoting_docs").val(response.Data.Document);
            $("#mdl-title").html('Edit Requisition Slip');
            $("#btn-submit").addClass('d-none');
            $("#btn-update").removeClass('d-none');
        }else{
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}


/*Function edit request*/
function saveEdit(){
    var Req_id = $("#request-id").val();
    var Service   = $("#service_category").val();
    var Urgency   = $("#priority_level").val();
    var Purpose   = $("#purpose").val();
    var Greeetings  = $("#greetings").val();
    var Description  = $("#description").val();
    $.post("dirs/request/actions/update_editrequest.php", {
        Req_id : Req_id,
        Service : Service,
        Purpose : Purpose,
        Urgency : Urgency,
        Greeetings : Greeetings,
        Description : Description,
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#frm-compose")[0].reset();
            $("#modal-compose").modal('hide');
            load_Requests();        
            Swal.fire({
               icon: "success",
               title: "Success",
               text: "Edit Success.",
               timer: 2000,
               showConfirmButton: false
           });
        }else{
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}



/*Function validation to clone request*/
function cloneRequest() {
    $("#modal-clone").modal('show');
}


/*Function retrieve information*/
function cloRequest(){
    $("#modal-clone").modal('hide');
    $("#modal-compose").modal('show');
    var Req_id = $("#request-id").val();
    $.post("dirs/request/actions/get_reqclone.php",{
        Req_id : Req_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#greetings").val(response.Data.Greetings);
            $("#request-id").val(response.Data.Req_id);
            $("#service_category").val(response.Data.ServiceCat).prop("disabled",true);
            $("#priority_level").val(response.Data.Urgency);
            $("#purpose").val(response.Data.Purpose);
            $("#description").val(response.Data.Description);
            $("#suppoting_docs").val(response.Data.Document);
            $("#mdl-title").html('Clone Requisition Slip');
            // $("#btn-draft").addClass('d-none');
        }else{
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}

$(".button-close").on("click", function () {
    resetButtons();
});

/*Function reset fields condition*/
function resetButtons() {
    $("#frm-compose")[0].reset();
    $("#btn-draft").removeClass('d-none');
    $("#service_category").val(response.Data.ServiceCat).prop("disabled",false);
}



/*Function delete request*/
function deleteRequest() {
    $("#modal-delete").modal('show');
}

/*Function delete request*/
function delRequest(){
    var Req_id = $("#request-id").val();
    $.post("dirs/request/actions/update_request.php", {
        Req_id : Req_id
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-delete").modal('hide');
            load_Requests();
            loadMails();        
            Swal.fire({
               icon: "success",
               title: "Success",
               text: "Request Deleted.",
               timer: 2000,
               showConfirmButton: false
           });
        }else{
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data,
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}


/* Checkbox change event */
$(document).on("change", ".pin-important", function () {
    var Req_id = $(this).data("req-id");
    var Pin = $(this).is(":checked") ? 1 : 0; // 1 if checked, 0 if unchecked
    updPin(Req_id, Pin);
});

function updPin(Req_id, Pin){
    $.post("dirs/request/actions/update_pin.php", 
        { Req_id: Req_id, Pin: Pin }, 
        function(data){
            if($.trim(data) == "success"){
                // Optional: update UI feedback here
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    );
}



/*Filter Important request*/
function loadImportant() {
    $("#request-id").val('1');
    loadMails();
}





function reapplyDraft(draft_id) {
    $("#modal-compose").modal('show');

    $.post(
        "dirs/request/actions/get_reapplydraft.php",
        { draft_id: draft_id },
        function (response) {
            if (response.isSuccess === "success") {
                const req = response.Data.request || {};
                $("#greetings").val(req.greetings || '');
                $("#service_category").val(req.service || '');
                $("#priority_level").val(req.urgency || '');
                $("#purpose").val(req.purpose || '');
                $("#description").val(req.description || '');
                $("#mdl-title").text('Draft Requisition Slip');
            } else {
                alert(response.Data);
            }
        },
        "json"
    );
}



