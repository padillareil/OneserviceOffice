<!-- Modal Create Service-->
<form id="frm-add-account">
  <div class="modal fade" id="mdl-add-account" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-title">Add Account</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-2">
            <label for="fullname">Fullname</label>
            <input type="text" name="fullname" id="fullname" class="form-control" autocomplete="off" required>
          </div>
          <div class="form-input mb-2">
            <label for="staff-position">Position</label>
            <input type="text" name="staff-position" id="staff-position" class="form-control" autocomplete="off" required>
          </div>
          <div class="form-input mb-2">
            <label for="staff-username">Username</label>
            <input type="text" name="staff-username" id="staff-username" class="form-control" autocomplete="off" required>
          </div>
          <div class="form-input mb-2">
            <label for="staff-password">Password</label>
            <input type="password" name="staff-password" id="staff-password" class="form-control" required>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="show-password">
            <label class="form-check-label" for="show-password">Show Password</label>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="btn-submit">
            <span id="btn-text-submit">Save</span>
            <span id="btn-spinner-submit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
          </button>
          <button type="button" class="btn btn-primary d-none" id="btn-update" onclick="saveUpdate()">
            <span id="btn-text-upd">Save Changes</span>
            <span id="btn-spinner-upd" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel" onclick="resetButtons()">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $(document).ready(function () {
    $("#show-password").on("change", function () {
      const type = $(this).is(":checked") ? "text" : "password";
      $("#staff-password").attr("type", type);
    });
  });

/****************************Form Function sending request****************************************/
var lastSubmitPayload = null;
/*Function for btn control spinner for submit*/
function setSubmitSpinner(isSubmitting) {
    if (isSubmitting) {
        $("#btn-spinner-submit").removeClass("d-none");
        $("#btn-text-submit").text(" Please wait...");
        $("#btn-submit").prop("disabled", true);
        $("#btn-cancel").prop("disabled", true);
        window.onbeforeunload = function () {
            return "Please wait, your request is being processed.";
        };
    } else {
        $("#btn-spinner-submit").addClass("d-none");
        $("#btn-text-submit").text("Save");
        $("#btn-submit").prop("disabled", false);
        $("#btn-cancel").prop("disabled", false);
        window.onbeforeunload = null;
    }
}

/*Function to submit request*/
function saveNewAccount(payload) {
    $.post("dirs/accounts/actions/save_account.php", payload)
    .done(function(data) {
        if ($.trim(data) === "OK") {
            setSubmitSpinner(false);
            $("#frm-add-account")[0].reset();
            $("#mdl-add-account").modal('hide');
            loadAccounts();
            Swal.fire({
                icon: "success",
                title: "New Staff Added",
                text: "Successfully new account created.",
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
$("#frm-add-account").submit(function(event){
    event.preventDefault();
    if (!navigator.onLine) {
        Swal.fire("Offline", "No internet connection", "info");
        return;
    }
    setSubmitSpinner(true);
    var Fullname    = $("#fullname").val();
    var Position    = $("#staff-position").val();
    var Username    = $("#staff-username").val();
    var Password    = $("#staff-password").val();

    lastSubmitPayload = {
        Fullname: Fullname,
        Position: Position,
        Username: Username,
        Password: Password
    };
    saveNewAccount(lastSubmitPayload);
});
/*Auto retry when connection restored*/
window.addEventListener("online", function () {
    if (lastSubmitPayload !== null) {
      console.log("Retrying submit...");
      setSubmitSpinner(true);
      saveNewAccount(lastSubmitPayload);
    }
});

/****************************Form Function sending request****************************************/
</script>