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
                            <img src="assets/image/uploads/noimage.avif" alt="Department Head Image" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
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
                <small>Message Content:</small>
                <textarea  id="tikcet-description" name="tikcet-description" class="form-control" style="height: 20vh;" readonly></textarea>
                <div class="mt-2 d-none"  id="dowload-attachment">
                  <button class="btn btn-outline-danger">
                    <i class="bi bi-download"></i> Download Attachment
                  </button>
                </div>
                <!-- Ticket Comment by user -->
                <div class="mt-3 collapse" id="collapse-message">
                    <small>Response:</small>
                    <textarea id="ticket_reply" name="ticket_reply" class="form-control" placeholder="Comment...." style="height: 10vh;"></textarea>
                    
                </div>

            </div>
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
            placeholder: 'Message response....',
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