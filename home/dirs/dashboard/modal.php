<!-- Modal Reject -->
<div class="modal fade" id="modal-reject" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Are you sure you want to reject this request?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" onclick="saveRejectRequest()">YES</button>
        <button type="button" class="btn btn-sm fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal accept -->
<div class="modal fade" id="modal-accept" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Are you sure you want to accept this request?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" onclick="saveAcceptRequest()">YES</button>
        <button type="button" class="btn btn-sm fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal View Request -->
<div class="modal fade" id="modal-view-request" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle d-flex flex-column align-items-start">
        <div class="w-100 d-flex justify-content-between align-items-center">
          <h5 class="modal-title mb-0">Requisition Slip</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <small class="text-muted">Imperial Appliance Corporation</small>
      </div>

      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Apply Ticket -->
<form id="frm-ticket-content">
  <div class="modal fade" id="mdl-ticket-content" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-title-request" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5" id="mdl-ticket-number"></h1>
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
                            <img src="../assets/image/uploads/man.png" alt="Department Head Image" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
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

              <input type="text" id="ticket-id-number"><!-- Ticket number -->

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
              <small>Message Content:</small>
              <textarea  id="tikcet-description" name="tikcet-description" class="form-control" style="height: 20vh;" readonly></textarea>
              <div class="mt-2 d-none"  id="dowload-attachment">
                <button class="btn btn-outline-danger">
                  <i class="bi bi-download"></i> Download Attachment
                </button>
              </div>
              <!-- Ticket Comment by user -->
              <div class="mt-3 collapse" id="collapse-message">
                  <small>Comment:</small>
                  <textarea id="ticket_reply" name="ticket_reply" class="form-control" placeholder="Comment...." required style="height: 10vh;"></textarea>
                  <button class="btn btn-success mt-2" type="button" id="btn-save-comment">Save</button>
                  <button class="btn btn-secondary mt-2" type="button" id="btn-cancel-comment" data-bs-toggle="collapse"  href="#collapse-message">Cancel</button>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer d-flex justify-content-between align-items-center">
          <div>
            <button class="btn btn-outline-primary" data-bs-toggle="collapse"  href="#collapse-message">
              <i class="bi bi-chat-left-text"></i> Add Comment
            </button>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success" type="button" id="btn-approve" onclick="mdlApprovedPrompt()">
              <i class="bi bi-check-circle"></i> Approve
            </button>
            <button class="btn btn-primary" type="button" id="btn-standby" onclick="mdlStandByPrompt()">
              <i class="bi bi-stopwatch"></i> Stand By
            </button>
            <button class="btn btn-danger" type="button" id="btn-reject" onclick="mdlRejectPrompt()">
              <i class="bi bi-x-circle"></i> Reject
            </button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>


      </div>
    </div>
  </div>
</form>





<script>
  $(document).ready(function () {
      $('#ticket_reply').summernote({
          height: 250,
          placeholder: 'Comment....',
          toolbar: [
            ['style', ['bold', 'italic', 'underline']],  
            ['para', ['ul', 'ol']],                     
            ['insert', ['picture']]  
          ]
      });

      $('#tikcet-description').summernote({
          height: 250,
          placeholder: 'Message Content',
          toolbar: [
            ['style', ['bold', 'italic', 'underline']],  
            ['para', ['ul', 'ol']],                     
            ['insert', ['picture']]  
          ]
      });
      $('#tikcet-description').summernote('disable');
  });
</script>

<!-- MOdal Show All Client and Find -->
<div class="modal fade" id="mdl-clients" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-title-request" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5">Client Master List</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <div class="card">
         <div class="card-header py-2 bg-info">
           <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
             <div class="d-flex flex-wrap align-items-center gap-2">
               <label class="mb-0 small">Search:</label>
               <input type="search" name="search-clients" id="search-clients" class="form-control form-control-sm border-primary-subtle" placeholder="Search client..." style="width:200px;">
               <label class="mb-0 small">Branch:</label>
               <select class="form-select form-select-sm border-primary-subtle"  style="width:160px;"  id="modal-iap-branch">
                   <option selected disabled>Branch</option>
                   <option value="">All</option>
               </select>

               <label class="mb-0 small">Department:</label>
               <select class="form-select form-select-sm border-primary-subtle"  style="width:160px;"  id="modal-department-client">
                   <option value="">Department</option>
               </select>
             </div>
             <div class="d-flex align-items-center gap-2">
               <button class="btn btn-primary btn-sm" onclick="reloadModalClient()">
                 <i class="bi bi-arrow-clockwise"></i> Refresh
               </button>
             </div>
           </div>
         </div>
         <div class="card-body">
           <div class="table-responsive overscroll-auto" style="height: 55vh;">
             <table class="table table-sm table-bordered table-hover">
               <thead>
                 <tr class="table-secondary">
                   <th class="sticky-top">Client</th>
                   <th class="sticky-top">Position</th>
                   <th class="sticky-top">Branch</th>
                   <th class="sticky-top">Department</th>
                 </tr>
               </thead>
               <tbody id="client_dsplay">
                 <tr>
                   <td colspan="3" class="text-center py-5">
                     <div class="d-flex flex-column align-items-center text-muted">
                       <div class="mb-3" style="font-size: 40px; opacity: .35;">
                         <i class="bi bi-people"></i>
                       </div>
                       <div class="fw-semibold">No Client Available.</div>
                       <div class="small opacity-75">
                         Please refresh if no available client displayed.
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
               <ul class="pagination" id="pagination-client">
                   <li class="page-item">
                       <a class="page-link" href="#" id="btn-preview-client">Previous</a> <!-- Page list number -->
                   </li>
                   <li class="page-item">
                       <a class="page-link" href="#" id="btn-next-client">Next</a>
                   </li>
               </ul>
           </nav>
           <div id="page-info-client" class="mt-3 small text-muted">  <!-- Page number counting -->
           </div>
         </div>
       </div>
      </div>
    </div>
  </div>
</div>

<script>
  /*Script for Searching ticket*/
  $("#search-clients").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadClients();
      }
  });
  /* Pagination + Fetch Blocked Accounts */
  $("#btn-preview-client").on("click", function(e) {
      e.preventDefault();

      if (currentPage > 1) {
          loadClients(currentPage - 1);
      }
  });

/*Function load all important tags tickets*/
  $("#btn-next-client").on("click", function(e) {
      e.preventDefault();

      if (currentPage < totalPages) {
          loadClients(currentPage + 1);
      }
  });


  /*Function filter branch assignment*/
  $("#modal-iap-branch").on("change", function() {
      loadClients();
  });

  /*Function filter department*/
  $("#modal-department-client").on("change", function() {
      loadClients();
  });

  
  $("#pagination-client").on("click", ".page-number a", function(e) {
      e.preventDefault();
      var page = parseInt($(this).data("page"));
      loadClients(page);
  });
</script>


