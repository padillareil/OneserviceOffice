<!-- Modal Create Service-->
<form id="frm-post">
  <div class="modal fade" id="mdl-create-service" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Post Service</h1>
        </div>
        <div class="modal-body">
              <div class="form-input mb-3">
                <label for="service-name">Service name :</label>
                <input type="text" name="service-name" id="service-name" class="form-control border-warning" autocomplete="off" required>
              </div>
              <div class="form-input mb-3">
                <label for="type-of-service">Service Type :</label>
                <select class="form-select border-warning" id="type-of-service" required>
                  <option selected value="">--Type of Service--</option>
                  <option value="Assistance">Assistance</option>
                  <option value="Inquiry">Inquiry</option>
                  <option value="Request">Request</option>
                  <option value="Resolution">Resolution</option>
                  <option value="Escalation">Escalation</option>
                  <option value="Approval">Approval</option>
                  <option value="Coordination">Coordination</option>
                  <option value="Verification">Verification</option>
                  <option value="Documentation">Documentation</option>
                </select>
              </div>
              <div class="row mb-3 ">
                <div class="form-input col-md-6">
                  <label for="service-available">Availabilty :</label>
                  <select class="form-select border-warning" id="service-available" required>
                    <option value="1">Available</option>
                    <option value="2">Not-Available</option>
                  </select>
                </div>
                <div class="form-input col-md-6">
                  <label for="attachment-control">Allow Attachments :</label>
                  <select class="form-select border-warning" id="attachment-control" required>
                    <option selected value="">--</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <h3>Operating Hours:</h3>
                <div class="col-md-6">
                  <label for="operate-time-start">Start :</label>
                  <input type="time" name="operate-time-start" id="operate-time-start" class="form-control border-warning" required>
                </div>
                <div class="col-md-6">
                  <label for="operate-time-end">End :</label>
                  <input type="time" name="operate-time-end" id="operate-time-end" class="form-control border-warning" required>
                </div>
              </div>
              <div class="form-input mb-3">
                <label for="service-description">Description :</label>
                <textarea class="form-control border-warning" name="service-description" id="service-description" placeholder="Instructions" maxlength="200" required style="height: 20vh;"></textarea>
                <small class="text-muted">200 Max. Characters.</small>
              </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-danger" id="btn-clear">Clear</button>
          <button type="submit" class="btn btn-success" id="btn-submit">Post</button>
          <button type="button" class="btn btn-success d-none" onclick="saveUpdate()" id="btn-update">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel" onclick="resetButtons()">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>



<script>
/*Script for Preview Image*/
  /*var uploadInput = document.getElementById("service-guideline");
  var previewImg  = document.getElementById("image-preview");
  uploadInput.addEventListener("change", function() {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });*/



  /*Function submmit post service created*/
  $("#frm-post").submit(function(event){
      event.preventDefault();

      var Service      = $("#service-name").val();
      var Type         = $("#type-of-service").val();
      var Availability = $("#service-available").val();
      var Start        = $("#operate-time-start").val();
      var End          = $("#operate-time-end").val();
      var Description  = $("#service-description").val();
      var Control      = $("#attachment-control").val();


      $.post("dirs/services/actions/save_post.php", {
          Service: Service,
          Type: Type,
          Availability: Availability,
          Start: Start,
          End: End,
          Description: Description,
          Control: Control
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


<!-- Modal update -->
<form id="frm-upd-post">
  <div class="modal fade" id="mdl-upd-service" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Post Service</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label for="upd-service-name">Service Name</label>
            <input type="text" name="upd-service-name" id="upd-service-name" class="form-control border-warning" autocomplete="off" required>
          </div>
          <div class="form-input mb-3">
            <label for="upd-type-of-service">Service Type</label>
            <select class="form-select border-warning" id="upd-type-of-service" required>
              <option selected value="">--Type of Service--</option>
              <option value="Assistance">Assistance</option>
              <option value="Inquiry">Inquiry</option>
              <option value="Request">Request</option>
              <option value="Resolution">Resolution</option>
              <option value="Escalation">Escalation</option>
              <option value="Approval">Approval</option>
              <option value="Coordination">Coordination</option>
              <option value="Verification">Verification</option>
              <option value="Documentation">Documentation</option>
            </select>
          </div>
          <div class="form-input mb-3">
            <label for="upd-service-available">Availabilty</label>
            <select class="form-select border-warning" id="upd-service-available" required>
              <option value="1">Available</option>
              <option value="2">Not-Available</option>
            </select>
          </div>
          <br>
          <div class="row mb-3">
            <h3>Operating Hours:</h3>
            <div class="col-md-6">
              <label for="upd-operate-time-start">Start:</label>
              <input type="time" name="upd-operate-time-start" id="upd-operate-time-start" class="form-control border-warning" required>
            </div>
            <div class="col-md-6">
              <label for="upd-operate-time-end">End:</label>
              <input type="time" name="upd-operate-time-end" id="upd-operate-time-end" class="form-control border-warning" required>
            </div>
          </div>
          <div class="form-input mb-3">
            <label for="upd-service-description">Description</label>
            <textarea class="form-control border-warning" name="upd-service-description" id="upd-service-description" placeholder="Instructions" maxlength="200" required style="height: 20vh;"></textarea>
            <small class="text-muted">200 Max. Characters.</small>
          </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="btn-submit">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel" onclick="resetButtons()">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  /*Function submmit post service created*/
  $("#frm-upd-post").submit(function(event){
      event.preventDefault();

      var Id           = $("#service_id").val();
      var Service      = $("#upd-service-name").val();
      var Type         = $("#upd-type-of-service").val();
      var Availability = $("#upd-service-available").val();
      var Start        = $("#upd-operate-time-start").val();
      var End          = $("#upd-operate-time-end").val();
      var Description  = $("#upd-service-description").val();

      $.post("dirs/services/actions/update_post_service.php", {
          Id              : Id,
          Service         : Service,
          Type            : Type,
          Availability    : Availability,
          Start           : Start,
          End             : End,
          Description     : Description,
      }, function(data) {

          if ($.trim(data) === "success") {
              $("#frm-upd-post")[0].reset();
              $("#mdl-upd-service").modal('hide');
              loadServices();

              Swal.fire({
                  icon: "success",
                  title: "Success",
                  text: "Update Post.",
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
