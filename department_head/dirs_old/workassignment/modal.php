<!-- Modal Set Branch Assignment -->
<form id="frm-set-assignment">
  <div class="modal fade" id="mdl-set-branch-assignment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Set Branch Assignment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
              <label class="form-label">Staff</label>
              <select class="form-select" id="staff-name" required>
                <option value="">Select Staff</option>
              </select>
            </div>
            <div class="mb-2">
              <label class="form-label">Branch</label>
              <select class="form-select" id="iap-branch" required>
                <option value="">Select Branch</option>
              </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="btn-submit">
              <span id="btn-text">Done</span>
              <span class="spinner-border spinner-border-sm ms-2 d-none" id="btn-spinner"></span>
          </button>
          <button type="button" class="btn btn-secondary" id="btn-cancel" data-bs-dismiss="modal">
              Close
          </button>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  $("#frm-set-assignment").submit(function(event){
      event.preventDefault();

      var Fullname = $("#staff-name").val();
      var Branch   = $("#iap-branch").val();

      const $btnSubmit  = $("#btn-submit");
      const $btnCancel  = $("#btn-cancel");
      const $btnText    = $("#btn-text");
      const $btnSpinner = $("#btn-spinner");
      const $modal      = $("#mdl-set-branch-assignment");
      $btnSubmit.prop("disabled", true);
      $btnCancel.prop("disabled", true);
      $btnText.text("Saving...");
      $btnSpinner.removeClass("d-none");
      $modal.modal({ backdrop: 'static', keyboard: false });

      $.post("dirs/workassignment/actions/save_branch_assignment.php", {
          Fullname : Fullname,
          Branch   : Branch
      }, function(data){
          if($.trim(data) === "OK"){
              $("#frm-set-assignment")[0].reset();
              Swal.fire({
                  icon: "success",
                  title: "Success",
                  text: "Successfully Set.",
                  timer: 2000,
                  showConfirmButton: false
              });
              $modal.modal("hide");
          }else{

              Swal.fire({
                  icon: "warning",
                  title: "Oops!",
                  text: data
              });
              $btnSubmit.prop("disabled", false);
              $btnCancel.prop("disabled", false);
          }

      }).fail(function(){
          Swal.fire({
              icon: "error",
              title: "Server Error",
              text: "Please try again."
          });
          $btnSubmit.prop("disabled", false);
          $btnCancel.prop("disabled", false);
      }).always(function(){
          $btnSpinner.addClass("d-none");
          $btnText.text("Done");

      });

  });
</script>