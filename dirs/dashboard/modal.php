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