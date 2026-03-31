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
          <button class="btn btn-success" type="submit" id="btn-submit">
              <span id="btn-text">Save</span>
              <span id="btn-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel">Cancel</button>
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
    $("#frm-add-account").submit(function(event){
    event.preventDefault();
    var btnSave   = $("#btn-submit");
    var btnCancel = $("#btn-cancel");
    var originalText = btnSave.html();
    var spinner = `<span class="spinner-border spinner-border-sm me-2" role="status"></span> Saving...`;
    btnSave.prop("disabled", true).html(spinner);
    btnCancel.prop("disabled", true);
    var Fullname = $("#fullname").val();
    var Position = $("#staff-position").val();
    var Username = $("#staff-username").val();
    var Password = $("#staff-password").val();
    var Role = 3;

    $.post("dirs/accounts/actions/save_account.php",{

        Fullname : Fullname,
        Position : Position,
        Username : Username,
        Password : Password,
        Role : Role

    }, function(data){

        if($.trim(data) == "OK"){

            $("#mdl-add-account").modal('hide');
            $("#frm-add-account")[0].reset();

            loadAccounts();

            Swal.fire({
                icon: "success",
                title: "Success",
                text: "New Staff Added.",
                timer: 2000,
                showConfirmButton: false
            });

        }else{

            Swal.fire({
                icon: "error",
                title: "Error",
                text: data
            });

        }

        btnSave.prop("disabled", false).html(originalText);
        btnCancel.prop("disabled", false);

    });

});

/****************************Form Function sending request****************************************/
</script>