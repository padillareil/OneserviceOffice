<form id="frm-compose">
  <div class="modal fade" id="modal-compose" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content">
        <div class="modal-header bg-light">
          <h1 class="modal-title text-primary fs-5" id="mdl-title">
            Requisition Slip
          </h1>
          <button type="button" class="btn-close button-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">Service Category</label>
              <select class="form-select" id="service_category" required>
                <option value="" selected disabled>--Select Department--</option>
                <option value="IT">IT & Technical Support</option>
                <option value="Facilities">Facilities & Maintenance</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Urgency</label>
              <select class="form-select" id="priority_level" required>
                <option value="Low">Low (General Inquiry)</option>
                <option value="Medium" selected>Medium (Standard Request)</option>
                <option value="High">High (Immediate Action Required)</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Purpose</label>
              <input type="text" class="form-control" id="purpose" maxlength="50" required>
              <small>Max 50 characters.</small>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Greetings</label>
              <input type="text" name="greetings" id="greetings" class="form-control" maxlength="200" placeholder="Good Day!">
              <small>Max 200 characters.</small>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Description</label>
              <textarea class="form-control" rows="4" id="description" maxlength="200"></textarea>
              <small>Max 200 characters.</small>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Supporting Document</label>
              <input type="file" class="form-control" id="suppoting_docs">
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0">
          <div class="me-auto">
            <button type="button" id="btn-draft" class="btn btn-outline-secondary" onclick="saveDraft()">Save Draft</button>
          </div>
          <button type="submit" id="btn-submit" class="btn btn-success px-4">Submit</button>
          <button type="button" id="btn-update" class="btn btn-success px-4 d-none" onclick="saveEdit()">Save</button>
          <button type="reset" id="btn-reset" class="btn btn-outline-danger">Clear</button>
          <button type="button" class="btn btn-secondary button-close" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>



<!-- Modal Edit VAlidation -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="logoutConfirmationLabel"  role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p>Do you want to edit this request?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" onclick="edRequest()">Yes</button>
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Clone VAlidation -->
<div class="modal fade" id="modal-clone" tabindex="-1" aria-labelledby="logoutConfirmationLabel"  role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p>Do you clone this request?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" onclick="cloRequest()">Yes</button>
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete VAlidation -->
<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="logoutConfirmationLabel"  role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p>Do you want to delete this request?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" onclick="delRequest()">Yes</button>
        <button type="button" class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>