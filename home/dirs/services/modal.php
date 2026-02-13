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
              <option value="New Request">New Request</option>
              <option value="Resolution">Issue Fix</option>
              <option value="Escalation">Escalation</option>
              <option value="Approval">Approval Needed</option>
              <option value="Coordination">Coordination</option>
              <option value="Verification">Verification</option>
              <option value="Documentation">Documentation</option>
            </select>
          </div>
          <div class="form-input mb-3">
            <label for="service-description">Additional Information</label>
            <textarea class="form-control" name="service-description" id="service-description"placeholder="Describe your intruction here."maxlength="300" required style="height: 20vh;"></textarea>
            <small class="text-muted">Maximum 300 characters</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-danger" id="btn-clear">Clear</button>
          <button type="submit" class="btn btn-success" id="btn-submit">Publish</button>
          <button type="button" class="btn btn-success d-none" onclick="saveUpdate()" id="btn-update">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel" onclick="resetButtons()">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Use for updating id for publishing -->
<input type="hidden" id="service-id">
<script>
  /*Function submmit post service created*/
  $("#frm-post").submit(function(event){
      event.preventDefault();
      var Title        = $("#service-name").val();
      var Category     = $("#type-of-service").val();
      var Description  = $("#service-description").val();


      $.post("dirs/services/actions/save_post.php", {
          Title: Title,
          Category: Category,
          Description: Description
      }, function(data) {

          if ($.trim(data) === "OK") {
              $("#frm-post")[0].reset();
              $("#mdl-create-service").modal('hide');
              loadServices();

              Swal.fire({
                  icon: "success",
                  title: "Success",
                  text: "Service Posted.",
                  timer: 2000,
                  showConfirmButton: false
              });

          } else {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: data,
                  timer: 2000,
                  showConfirmButton: false
              });
          }
      });
  });
</script>