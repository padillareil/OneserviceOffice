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
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="mdl-title-request">Ticket Request</h1>
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

              <input type="hidden" id="ticket-id-number"><!-- Ticket number -->

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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>





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
</script>