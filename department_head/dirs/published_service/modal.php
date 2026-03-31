<!-- Modal Add Category -->
<div class="modal fade" id="mdl-published-post" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-category-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add-category-modal">Post a Service</h1>
      </div>
      <div class="modal-body">
      <div class="modal-body">
        <div class="form-input mb-3">
          <label for="service-name">Service name</label>
          <input type="text" name="service-name" id="service-name" class="form-control" autocomplete="off" required>
        </div>
        <div class="form-input mb-3">
          <label for="type-of-service">Type of Service</label>
          <select class="form-select" id="type-of-service" required>
            <option selected value="">--</option>
            <option value="Assistance">Assistance</option>
            <option value="Approval">Approval</option>
            <option value="Coordination">Coordination</option>
            <option value="Documentation">Documentation</option>
            <option value="Escalation">Escalation</option>
            <option value="Inquiry">Inquiry</option>
            <option value="Request">New Request</option>
            <option value="Resolution">Resolution</option>
            <option value="Verification">Verification</option>
          </select>
        </div>
        <input type="hidden" name="service_id" id="service_id"> <!-- service id base on the used -->
        <div class="form-input mb-3">
          <label for="service-description">Content</label>
          <textarea class="form-control" name="service-description" id="service-description"placeholder="Supporting instruction."maxlength="300" required style="height: 20vh;"></textarea>
          <small class="text-muted">Maximum 300 characters</small>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <div class="justify-content-end d-flex gap-2">
          <button class="btn btn-success btn-sm" type="submit">Post</button>
          <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" type="reset">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
