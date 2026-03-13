<!-- Modal Request Queue -->
<div class="modal fade" id="mdl-req-queue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="team-req-mdl-title">Team Applied Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-request" id="search-request" class="form-control form-control-sm" placeholder="Search request..." style="width: 200px;">
              <select class="form-select form-select-sm" style="width: 180px;" title="Requested Department" id="open-ticket-department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 180px;" title="Prepared by Staff" id="open-ticket-staff">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from-open" id="date-from-open" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to-open" id="date-to-open" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success" onclick="loadTeamsApplied_Open()">Apply</button>
              <button type="button" class="btn btn-sm btn-primary" onclick="refreshAllOpenTicket()">Refresh</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th class="sticky-top">Ticket No.</th>
                    <th class="sticky-top">Department</th>
                    <th class="sticky-top">Client</th>
                    <th class="sticky-top">Date</th>
                    <th class="sticky-top">Status</th>
                  </tr>
                </thead>
                <tbody id="teams_open_tickets">
                
                </tbody>
              </table>
            </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between align-items-center">
        <nav>
          <ul class="pagination" id="pagination-open-ticket">
             <li class="page-item" id="li-prev">
                 <a class="page-link" href="#" id="btn-previewopen-ticket">Previous</a> 
             </li>
             <li class="page-item" id="li-next">
                 <a class="page-link" href="#" id="btn-nextviewopen-ticket">Next</a>
             </li>
          </ul>
        </nav> 
        <div id="page-info-openticket" class="mt-3 small text-muted">  
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  /*Script for Searching ticket*/
  $("#search-request").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadTeamsApplied_Open();
      }
  });

  /*Function filter tickets teams applied*/
  $("#open-ticket-department").on("change", function() {
      loadTeamsApplied_Open();
  });

  /*Function filter staff ticket applied*/
  $("#open-ticket-staff").on("change", function() {
      loadTeamsApplied_Open();
  });

  /*Function reload Open Ticket modal*/
  function refreshAllOpenTicket() {
    loadTeamsApplied_Open();
    $("#search-request").val('');
    $("#open-ticket-department").val('');
    $("#open-ticket-staff").val('');
    $("#date-from-open").val('');
    $("#date-to-open").val('');


  }
</script>



<!-- Resolved Ticekts Modal -->
<div class="modal fade" id="mdl-req-resolved" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Team Resolved Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-resolve" id="search-resolve" class="form-control form-control-sm" placeholder="Search request..." style="width: 150px;">
              <select class="form-select form-select-sm" style="width: 150px;" title="Requested Department" id="resolved-ticket-department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 150px;" title="Prepared by Staff" id="staff-resolved-ticket">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from-resolved" id="date-from-resolved" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to-resolved" id="date-to-resolved" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success" onclick="loadTeamsApplied_Resolved()">Apply</button>
              <button type="button" class="btn btn-sm btn-primary" onclick="refreshAllResolvedTicket()">Refresh</button>
              <button type="button" class="btn btn-sm btn-danger">Clear</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="teams_resolved_tickets">
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <nav>
               <ul class="pagination" id="pagination-r-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-r-application">Previous</a> 
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-r-application">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-r-application" class="mt-3 small text-muted">  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  /*Script for Searching ticket*/
  $("#search-resolve").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadTeamsApplied_Resolved();
      }
  });

  /*Function filter tickets teams applied*/
  $("#resolved-ticket-department").on("change", function() {
      loadTeamsApplied_Resolved();
  });

  /*Function filter staff ticket applied*/
  $("#staff-resolved-ticket").on("change", function() {
      loadTeamsApplied_Resolved();
  });

  /*Function reload Open Ticket modal*/
  function refreshAllResolvedTicket() {
    loadTeamsApplied_Resolved();
    $("#search-resolve").val('');
    $("#resolved-ticket-department").val('');
    $("#staff-resolved-ticket").val('');
    $("#date-from-resolved").val('');
    $("#date-to-resolved").val('');


  }
</script>



<!------------------------------------------------------- Resolved Ticekts Modal -------------------------------------------------------------------------------------->
<div class="modal fade" id="mdl-req-cancelled" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Team Cancelled Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-rejected" id="search-rejected" class="form-control form-control-sm" placeholder="Search request..." style="width: 150px;">
              <select class="form-select form-select-sm" style="width: 150px;" title="Requested Department" id="rejected-ticket-department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 150px;" title="Prepared by Staff" id="staff-rejected-ticket">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from-rejected" id="date-from-rejected" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to-rejected" id="date-to-rejected" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success" onclick="loadTeamsApplied_Rejected()">Apply</button>
              <button type="button" class="btn btn-sm btn-primary" onclick="refreshAllRejectedTicket()">Refresh</button>
              <button type="button" class="btn btn-sm btn-danger">Clear</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="teams_rejected_tickets">
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <nav>
               <ul class="pagination" id="pagination-rejected-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-rejected">Previous</a> 
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-rejected">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-rejected" class="mt-3 small text-muted">  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  /*Script for Searching ticket*/
  $("#search-rejected").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadTeamsApplied_Rejected();
      }
  });

  /*Function filter tickets teams applied*/
  $("#rejected-ticket-department").on("change", function() {
      loadTeamsApplied_Rejected();
  });

  /*Function filter staff ticket applied*/
  $("#staff-rejected-ticket").on("change", function() {
      loadTeamsApplied_Rejected();
  });

  /*Function reload Open Ticket modal*/
  function refreshAllRejectedTicket() {
    loadTeamsApplied_Rejected();
    $("#search-resolve").val('');
    $("#rejected-ticket-department").val('');
    $("#staff-rejected-ticket").val('');
    $("#date-from-rejected").val('');
    $("#date-to-rejected").val('');


  }
</script>
<!------------------------------------------------------- Resolved Ticekts Modal -------------------------------------------------------------------------------------->



<!-- Resolved Ticekts Modal -->
<!-- <div class="modal fade" id="mdl-req-cancelled" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="team-req-mdl-title">Team Cancelled Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-resolve" id="search-resolve" class="form-control form-control-sm" placeholder="Search request..." style="width: 150px;">
              <select class="form-select form-select-sm" style="width: 150px;" title="Requested Department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 150px;" title="Prepared by Staff">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success">Apply</button>
              <button type="button" class="btn btn-sm btn-primary">Refresh</button>
              <button type="button" class="btn btn-sm btn-danger">Clear</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hovered">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view cancelled tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <nav>
               <ul class="pagination" id="pagination-cancel-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-cancel-application">Previous</a> 
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-cancel-application">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-cancel-application" class="mt-3 small text-muted">  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->


<!-- Modal Apply Ticket -->
<!-- <form id="frm-apply-ticket">
  <div class="modal fade" id="mdl-create-ticket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-title-request" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="mdl-title-request">Create Ticket</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="card mb-2 position-relative">
                <div class="card-body position-relative">
                  <div id="card-loader" class="d-none flex-column justify-content-center align-items-center text-center" style="min-height: 250px;">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <div class="fw-semibold">Loading...</div>
                    <small class="text-muted">Please wait</small>
                  </div>
                  <div id="card-content" class="d-none">
                    <div class="row align-items-start">
                      <div class="col-md-9 pe-md-4">
                        <i>Please read the instruction below <span class="text-danger">*</span></i>
                        <p id="description"></p>
                      </div>
                      <div class="col-md-3 ps-md-4">
                        <div class="text-center">
                          <div class="mb-3">
                            <img src="assets/image/uploads/man.png" alt="Department Head Image" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                          </div>
                          <h6 class="fw-bold mb-1" id="manager-name"></h6>
                          <div class="fw-semibold text-primary" id="manager-position"></div>
                          <div class="small text-muted" id="manager-department"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <input type="hidden" id="ticket-id-number">

              <div class="row justify-content-between d-flex">
                <div class="col-md-4">
                  <div class="form-input mb-3">
                    <label class="form-label" for="ticket-subject">Subject:</label>
                    <input type="text" name="ticket-subject" id="ticket-subject" class="form-control bg-white" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-input mb-3">
                    <label class="form-label" for="type-of-request">Type of Request:</label>
                    <input type="text" name="type-of-request" id="type-of-request" class="form-control bg-white" disabled>
                  </div>
                </div>
              </div>
              <textarea id="ticket-description" name="ticket-description" class="form-control" placeholder="Describe your info here..." required style="height: 20vh;"></textarea>
              <div class="mt-3">
                  <label class="form-label fw-semibold d-block" for="ticket-attachment">
                    Attachment: <span class="text-danger"><i>(Optional Only if needed.)</i></span>
                  </label>
                  <input type="file" id="ticket-attachment" name="ticket-attachment" class="d-none" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg">
                  <button type="button" class="btn btn-link btn-sm" onclick="document.getElementById('ticket-attachment').click();">
                      <i class="bi bi-paperclip me-1"></i> Upload Attachment
                  </button>
                  <div id="file-preview" class="mt-2"></div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex align-items-center">
                
                <button type="submit" class="btn btn-success me-2" id="btn-submit-ticket">
                  <i class="bi bi-send"></i> 
                  <span id="btn-text">Submit Ticket</span>
                  <span id="btn-spinner" class="spinner-border spinner-border-sm" 
                        role="status" aria-hidden="true" 
                        style="display:none;"></span>
                </button>

                <button type="button" class="btn btn-danger me-2" 
                        data-bs-dismiss="modal" id="btn-cancel">
                  <i class="bi bi-x-circle"></i> Cancel
                </button>

                <button type="button" class="btn btn-secondary ms-auto" id="btn-reset" onclick="resetDescription()">
                  <i class="bi bi-arrow-clockwise"></i> Clear
                </button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form> -->



<script>
$(document).ready(function () {
    $('#ticket-description').summernote({
        height: 250,
        placeholder: 'Describe your info here...',
        toolbar: [
          ['style', ['bold', 'italic', 'underline']],  
          ['para', ['ul', 'ol']],                     
          ['insert', ['picture']]  
        ]
    });
});

function resetDescription() {
    $('#ticket-description').summernote('reset'); 
    $('#ticket-attachment').val('');
    $('#file-preview').empty();
}
$('#ticket-attachment').on('change', function () {
    const file = this.files[0];
    const preview = $('#file-preview');
    preview.empty();

    if (file) {

        // Convert bytes to readable size
        function formatSize(bytes) {
            if (bytes >= 1024 * 1024) {
                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';  
            } else {
                return (bytes / 1024).toFixed(2) + ' KB';
            }
        }

        const fileSize = formatSize(file.size);

        preview.html(`
            <span class="badge bg-primary">
                ${file.name} ~ ${fileSize}
                <i class="bi bi-x" 
                   style="cursor:pointer;"
                   onclick="removeFile()"></i>
            </span>
        `);
    }
});



function removeFile() {
    $('#ticket-attachment').val('');
    $('#file-preview').empty();
}

/* Function: Submit Ticket with File Upload */
$("#frm-apply-ticket").submit(function(event) {
    event.preventDefault();

    // Elements
    var $btnSubmit = $("#btn-submit-ticket");
    var $btnText   = $("#btn-text");
    var $btnSpinner = $("#btn-spinner");
    var $btnCancel = $("#btn-cancel");
    var $modal = $("#mdl-create-ticket");

    // ====== START LOADING STATE ======
    $btnSubmit.prop("disabled", true);
    $btnCancel.prop("disabled", true);
    $btnText.text("Loading... Please wait...");
    $btnSpinner.show();
    $modal.modal({ backdrop: 'static', keyboard: false });
    $modal.css('cursor', 'not-allowed');

    // ====== FORM DATA ======
    var formData = new FormData();
    formData.append("Description", $("#ticket-description").val());
    formData.append("TicketNumber", $("#ticket-id-number").val());

    // File attachment (only 1 file allowed)
    var fileInput = $("#ticket-attachment")[0];
    if (fileInput.files.length > 0) {
        formData.append("Attachment", fileInput.files[0]);
    }

    // ====== AJAX POST ======
    $.ajax({
        url: "dirs/apply_service/actions/save_submitticket.php",
        type: "POST",
        data: formData,
        processData: false, // Important for file upload
        contentType: false, // Important for file upload
        success: function(data) {
            data = $.trim(data);

            if (data === "OK") {
                // Reset form
                $("#frm-apply-ticket")[0].reset();
                $("#file-preview").empty(); // clear displayed file badge
                $modal.modal('hide');
                resetDescription();
                Swal.fire({
                    icon: "success",
                    title: "Successfully Submitted",
                    text: "Please monitor your ticket in Team Applications.",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Oops!",
                    text: data
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Unable to submit ticket. Please try again."
            });
        },
        complete: function() {
            // ====== RESET BUTTONS ======
            $btnSubmit.prop("disabled", false);
            $btnCancel.prop("disabled", false);
            $btnText.text("Submit Ticket");
            $btnSpinner.hide();
            $modal.css('cursor', 'default');
        }
    });
});

/*function resetForm() {
    $("#frm-apply-ticket")[0].reset();
    $('#ticket-description').summernote('code', '');
    $('#ticket-attachment').val('');
    $('#file-preview').empty();
}*/
</script>



