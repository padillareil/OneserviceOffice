<!-- Modal Create Service-->
<form id="frm-post">
  <div class="modal fade" id="mdl-create-service" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="publish-title">Publish New Service</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label for="service-name">Service Title</label>
            <input type="text" name="service-name" id="service-name" class="form-control" placeholder="Enter short title" autocomplete="off" required>
          </div>
          <div class="form-input mb-3">
            <label for="type-of-service">Service Category</label>
            <select class="form-select" id="type-of-service" required>
              <option selected value="">Select Category</option>
              <option value="Assistance">Need Help</option>
              <option value="Inquiry">Question</option>
              <option value="Request">New Request</option>
              <option value="Resolution">Issue Fix</option>
              <option value="Escalation">Escalation</option>
              <option value="Approval">Approval Needed</option>
              <option value="Coordination">Coordination</option>
              <option value="Verification">Verification</option>
              <option value="Documentation">Documentation</option>
            </select>
          </div>
          <input type="hidden" name="service_id" id="service_id"> <!-- service id base on the used -->
          <div class="form-input mb-3">
            <label for="service-description">Additional Information</label>
            <textarea class="form-control" name="service-description" id="service-description"placeholder="Describe your intruction here."maxlength="300" required style="height: 20vh;"></textarea>
            <small class="text-muted">Maximum 300 characters</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-danger" id="btn-clear">Clear</button>
          <button type="submit" class="btn btn-success" id="btn-submit">
            <span id="btn-text-submit">Publish</span>
            <span id="btn-spinner-submit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
          </button>


          <button type="button" class="btn btn-primary d-none" id="btn-update" onclick="saveUpdate()">
            <span id="btn-text-upd">Save Changes</span>
            <span id="btn-spinner-upd" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel" onclick="resetButtons()">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
/****************************Form Function sending request****************************************/
var lastSubmitPayload = null;
/*Function for btn control spinner for submit*/
function setSubmitSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-submit").removeClass("d-none");
        $("#btn-text-submit").text(" Please wait...");
        $("#btn-submit").prop("disabled", true);
        $("#btn-cancel").prop("disabled", true);
        $("#btn-clear").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-submit").addClass("d-none");
        $("#btn-text-submit").text("Commit");
        $("#btn-submit").prop("disabled", false);
        $("#btn-cancel").prop("disabled", false);
        $("#btn-clear").prop("disabled", false);
        window.onbeforeunload = null;
    }
}

/*Function to submit request*/
function sendRequest(payload) {
    $.post("dirs/services/actions/save_post.php", payload)
    .done(function(data) {
        if ($.trim(data) === "OK") {
            setSubmitSpinner(false);
            $("#frm-post")[0].reset();
            $("#mdl-create-service").modal('hide');
            loadServices();
            Swal.fire({
                icon: "success",
                title: "Service Published",
                text: "Successfully.",
                timer: 2000,
                showConfirmButton: false
            });
            lastSubmitPayload = null;
        } else {
            setSubmitSpinner(false);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data
            });
        }

    })
    .fail(function() {
        setSubmitSpinner(false);
        Swal.fire({
            icon: "warning",
            title: "Connection Lost",
            text: "Will retry automatically when online"
        });
    });
}

/*Function submit post service created*/
$("#frm-post").submit(function(event){
    event.preventDefault();
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setSubmitSpinner(true);
    var Title       = $("#service-name").val();
    var Category    = $("#type-of-service").val();
    var Description = $("#service-description").val();
    lastSubmitPayload = {
        Title: Title,
        Category: Category,
        Description: Description
    };
    sendRequest(lastSubmitPayload);
});
/*Auto retry when connection restored*/
window.addEventListener("online", function () {
    if (lastSubmitPayload !== null) {
      console.log("Retrying submit...");
      setSubmitSpinner(true);
      sendRequest(lastSubmitPayload);
    }
});

/****************************Form Function sending request****************************************/
</script>


<!-- Modal prompt for close -->
<div class="modal fade" id="mdl-message-close" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-center" id="message-close"></p>
      </div>
      <input type="hidden" id="srv-id-close">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success btn-controls" id="btn-submit-close" onclick="btnClose()">
          <span id="btn-text-close">Yes</span>
          <span id="btn-spinner-close" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal" id="btn-cancel-close">No</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal prompt for open -->
<div class="modal fade" id="mdl-message-open" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-center" id="message-open"></p>
      </div>
      <input type="hidden" id="srv-id-open">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success btn-controls" id="btn-submit-open" onclick="btnOpen()">
          <span id="btn-text-open">Yes</span>
          <span id="btn-spinner-open" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal" id="btn-cancel-open">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal prompt for Public -->
<div class="modal fade" id="mdl-message-public" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-center" id="message-public"></p>
      </div>
      <input type="hidden" id="srv-id-public">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success btn-controls" id="btn-submit-public" onclick="btnPublic()">
          <span id="btn-text-public">Yes</span>
          <span id="btn-spinner-public" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal" id="btn-cancel-public">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal prompt for Private -->
<div class="modal fade" id="mdl-message-private" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-center" id="message-private"></p>
      </div>
      <input type="hidden" id="srv-id-private">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success btn-controls" id="btn-submit-private" onclick="btnPrivate()">
          <span id="btn-text-private">Yes</span>
          <span id="btn-spinner-private" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal" id="btn-cancel-private">No</button>
      </div>
    </div>
  </div>
</div>

