<!-- Modal Apply Booking -->
<form id="frm-update">
  <div class="modal fade" id="mdl-booking" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Booking -
            <span id="ticket-id">TKT-0001</span>
          </h1>
        </div>
        <div class="modal-body">
          <div class="card card-shadow h-100 mb-3">
            <div class="card-body d-flex flex-column">
              <h4 class="card-title fw-semibold mb-1" id="service-name">
              </h4>
              <h5 class="card-text text-muted mb-2" id="service-description">
              </h5>
              <div class="mt-auto pt-2 border-top">
                <small class="text-muted fw-semibold d-block mb-1">
                  <i class="bi bi-clock"></i> Available Time
                </small>
                <div class="d-flex justify-content-between small">
                  <span class="text-muted">From:</span>
                  <span class="fw-medium" id="srv-time-in"></span>
                </div>
                <div class="d-flex justify-content-between small">
                  <span class="text-muted">To:</span>
                  <span class="fw-medium" id="srv-time-out"></span>
                </div>
                <div class="d-flex justify-content-between small">
                  <span class="text-muted">Posted:</span>
                  <span class="fw-medium" id="posted-user"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-2">
            <textarea class="form-control" id="description" name="Description" placeholder="Application Description" maxlength="200" required style="height: 20vh;" readonly></textarea>
            <small class="text-muted">200 Max Characters.</small>
          </div>
          <div class="mt-3 d-none" id="attachment-field">
            <label for="attach-file">Attachment :</label>
            <input type="file" name="attach-file" id="attach-file" class="form-control" accept=".jpeg,.png,.jpg,.xls,.doc,.pdf,.xlsx">
          </div>

          <div id="view-reject-response" class="mb-3">
              <div class="d-flex justify-content-end mb-2">
                  <button
                      class="btn btn-outline-primary btn-sm"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseResponse"
                      aria-expanded="false"
                      aria-controls="collapseResponse"
                  >
                      <i class="bi bi-eye"></i> View Response
                  </button>
              </div>
              <div class="collapse" id="collapseResponse">
                  <div class="card shadow-sm">
                      <div class="card-body">
                          <p class="mb-3 text-muted">
                              Some placeholder content for the collapse component.
                              This panel is hidden by default but revealed when the user activates the relevant trigger.
                          </p>

                          <hr>

                          <div class="d-flex justify-content-between align-items-center">
                              <div>
                                  <h6 class="mb-0">Reil P. Padilla</h6>
                                  <small class="text-muted">Software Developer</small>
                              </div>

                              <div class="text-end">
                                  <small class="text-muted d-block">01/27/2026</small>
                                  <small class="text-muted">8:30 AM</small>
                              </div>
                          </div>
                      </div>

                  </div>
                 <!--  <div class="card shadow-sm">
                      <div class="card-body text-center py-5">

                          <i class="bi bi-chat-square-text fs-1 text-muted mb-3"></i>

                          <p class="mb-0 text-muted">
                              No response available
                          </p>

                          <small class="text-muted">
                              This request has not received a response yet.
                          </small>

                      </div>
                  </div> -->

              </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn-update">Update</button>
          <button type="submit" class="btn btn-success" id="btn-save">Save</button>
          <button type="submit" class="btn btn-danger" id="btn-cancel">Cancel</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="service-id" name="Serviceid">
  <input type="hidden" id="service-type-chosen" name="SrvType">
  <input type="hidden" id="service-department" name="Department">
</form>
