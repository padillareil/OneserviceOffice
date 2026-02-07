<!-- Modal Apply Booking -->
<form id="frm-submit">
  <div class="modal fade" id="mdl-booking" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Apply Booking</h1>
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
            <textarea class="form-control border-warning" id="description" name="Description" placeholder="Application Description" maxlength="200" required style="height: 20vh;"></textarea>
            <small class="text-muted">200 Max Characters.</small>
          </div>
          <div class="mt-3 d-none" id="attachment-field">
            <label for="attach-file">Attachment :</label>
            <input type="file" name="attach-file" id="attach-file" class="form-control border-warning" accept=".jpeg,.png,.jpg,.xls,.doc,.pdf,.xlsx">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="service-id" name="Serviceid">
  <input type="hidden" id="service-type-chosen" name="SrvType">
  <input type="hidden" id="service-department" name="Department">
</form>




<script>
  // $("#frm-submit").submit(function(event){
  //     event.preventDefault();

  //     var Description   = $("#description").val();
  //     var Serviceid         = $("#service-id").val();
  //     var SrvType       = $("#service-type-chosen").val();
  //     var Department    = $("#service-department").val();
  //     var Attachment    = $("#attach-file").val();


  //     $.post("dirs/services/actions/save_request.php", {
  //         Description: Description,
  //         Serviceid: Serviceid,
  //         SrvType: SrvType,
  //         Department: Department,
  //         Attachment: Attachment,
  //     }, function(data) {
  //         if ($.trim(data) === "OK") {
  //             $("#frm-submit")[0].reset();
  //             $("#mdl-booking").modal('hide');
  //             loadHelpService();
  //             Swal.fire({
  //                 icon: "success",
  //                 title: "Success",
  //                 text: "Request Sent.",
  //                 timer: 2000,
  //                 showConfirmButton: false
  //             });

  //         } else {
  //             Swal.fire({
  //                 icon: "error",
  //                 title: "Error",
  //                 text: data,
  //                 timer: 2000,
  //                 showConfirmButton: false
  //             });
  //         }
  //     });
  // });

  $("#frm-submit").submit(function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
          url: "dirs/services/actions/save_request.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (data) {

              if ($.trim(data) === "OK") {

                  $("#frm-submit")[0].reset();
                  $("#mdl-booking").modal('hide');
                  loadHelpService();

                  Swal.fire({
                      icon: "success",
                      title: "Success",
                      text: "Request Sent.",
                      timer: 2000,
                      showConfirmButton: false
                  });

              } else {
                  Swal.fire({
                      icon: "error",
                      title: "Error",
                      text: data
                  });
              }
          }
      });
  });



</script>

