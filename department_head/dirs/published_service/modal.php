<!-- Modal Add Category -->
<form id="frm-post-service">
  <div class="modal fade" id="mdl-published-post" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-category-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="add-category-modal">Post a Service</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label for="service-name">Service name</label>
            <input type="text" name="service-name" id="service-name" class="form-control" autocomplete="off" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Visibility Setup</label>
            <div class="d-flex gap-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visibility" id="service-public" value="1" checked>
                <label class="form-check-label" for="service-public">
                  Public
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visibility" id="service-private" value="0">
                <label class="form-check-label" for="service-private">
                  Private
                </label>
              </div>
            </div>
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
            <textarea class="form-control" name="service-description" id="service-description" autocomplete="off" placeholder="Supporting instruction."maxlength="300" required style="height: 20vh;"></textarea>
            <small class="text-muted">Maximum 300 characters</small>
          </div>
        </div>
        <div class="modal-footer">
          <div class="justify-content-end d-flex gap-2">
           <button id="btn-submit" class="btn btn-success" type="submit">
             <span class="spinner-border spinner-border-sm d-none" id="btn-spinner"></span>
             <span class="btn-text">Post</span>
           </button>
            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" type="reset" id="btn-cancel">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
 $("#frm-post-service").submit(function(event){
     event.preventDefault();
     let $btnSubmit = $("#btn-submit");
     let $btnCancel = $("#btn-cancel");
     let $spinner = $("#btn-spinner");
     let $text = $btnSubmit.find(".btn-text");
     $btnSubmit.prop("disabled", true);
     $btnCancel.prop("disabled", true);
     $spinner.removeClass("d-none");
     $text.text("Posting...");

     var ServiceName  = $("#service-name").val();
     var Visibility   = $("input[name='visibility']:checked").val();
     var ServiceType  = $("#type-of-service").val();
     var Description  = $("#service-description").val();

     $.post("dirs/published_service/actions/save_post.php", {
         ServiceName: ServiceName,
         Visibility: Visibility,
         ServiceType: ServiceType,
         Description: Description
     }, function(data){
         $btnSubmit.prop("disabled", false);
         $btnCancel.prop("disabled", false);
         $spinner.addClass("d-none");
         $text.text("Post");
         if($.trim(data) == "OK"){
             $("#frm-post-service")[0].reset();
             $("#mdl-published-post").modal('hide');
             loadPublishedServices();

             Swal.fire({
                 toast: true,
                 position: "top-end",
                 icon: "success",
                 title: "Posted successfully",
                 showConfirmButton: false,
                 timer: 2000,
                 timerProgressBar: true
             });

         }else{
            Swal.fire({
              icon: "error",
              title: "Oops!",
              text: data,
              confirmButtonText: "OK"
            });
         }
     });
 });
</script>



<form id="frm-edit-post">
  <div class="modal fade" id="mdl-post-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-category-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="add-category-modal">Service Info</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label for="service-name">Service name</label>
            <input type="text" name="service-name" id="service-name" class="form-control" autocomplete="off" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Visibility Setup</label>
            <div class="d-flex gap-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visibility" id="service-public" value="1" checked>
                <label class="form-check-label" for="service-public">
                  Public
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visibility" id="service-private" value="0">
                <label class="form-check-label" for="service-private">
                  Private
                </label>
              </div>
            </div>
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
            <textarea class="form-control" name="service-description" id="service-description" autocomplete="off" placeholder="Supporting instruction."maxlength="300" required style="height: 20vh;"></textarea>
            <small class="text-muted">Maximum 300 characters</small>
          </div>
        </div>
        <div class="modal-footer">
          <div class="justify-content-end d-flex gap-2">
           
            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" type="reset" id="btn-cancel">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>