<div id="gen-spinner" hidden>
  <div class="d-flex justify-content-center" hidden>
    <div class="spinner-border" role="status">
      <span class="visually-hidden"></span>
    </div>
  </div>
</div>
<div id="gen-btn-spinner" class="justify-content-center" hidden>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="visually-hidden"></span>
</div>
<script>
  function gen_spinner(spinnersize, spinnerclass){
    $("#gen-spinner").find("div[name='spinner-holder']")
    .removeClass("text-primary")
    .removeClass("text-secondary")
    .removeClass("text-success")
    .removeClass("text-danger")
    .removeClass("text-warning")
    .removeClass("text-info")
    .removeClass("text-light")
    .removeClass("text-dark")
    .removeClass("spinner-border-xs")
    .removeClass("spinner-border-sm")
    .removeClass("spinner-border-md")
    .removeClass("spinner-border-lg")
    .removeClass("spinner-border-xl")
    $("#gen-spinner").find("div[name='spinner-holder']")
    .addClass(spinnersize)
    .addClass(spinnerclass);
    return $("#gen-spinner").html();
  }
  function gen_btn_spinner(spinnersize, spinnerclass){
    $("#gen-btn-spinner").find("div[name='spinner-holder']")
    .removeClass("text-primary")
    .removeClass("text-secondary")
    .removeClass("text-success")
    .removeClass("text-danger")
    .removeClass("text-warning")
    .removeClass("text-info")
    .removeClass("text-light")
    .removeClass("text-dark")
    .removeClass("spinner-border-xs")
    .removeClass("spinner-border-sm")
    .removeClass("spinner-border-md")
    .removeClass("spinner-border-lg")
    .removeClass("spinner-border-xl")
    $("#gen-btn-spinner").find("div[name='spinner-holder']")
    .addClass(spinnersize)
    .addClass(spinnerclass);
    return $("#gen-btn-spinner").html();
  }


  

/*Setup Account*/
  $(document).ready(function(){
      var Setup = $("#setup-user").val();
      if (Setup == 'NO') {
        $("#modal-setup-account").modal("show");
      }else{
        $("#modal-setup-account").modal("hide");
      }
  });
  
  $(document).ready(function() {
      $("#showpass").on("click", function () {
          const input = $("#user-newpassword");
          const type = input.attr("type") === "password" ? "text" : "password";
          input.attr("type", type);
          $(this).toggleClass("bi-eye bi-eye-slash");
      });
  });




</script>


<!-- Modal Setup Account -->
<form id="frm-acc-setup">
  <div class="modal fade" id="modal-setup-account" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="mt-2 mb-3 text-center">
            <h1 class="display-8 fs-5">Account Setup</h1>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="user-fullname" id="user-fullname" class="form-control" required>
            <label for="user-fullname">Fullname</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="user-position" id="user-position" class="form-control" required>
            <label for="user-position">Position</label>
          </div>
          <div class="form-floating mb-3 position-relative">
            <input type="password" name="user-newpassword" id="user-newpassword" class="form-control"  required>
            <label for="user-newpassword">Password</label>
            <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" 
               id="showpass" style="cursor: pointer;"></i>
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-success py-2">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $("#frm-acc-setup").submit(function(event){
    event.preventDefault();
      var Fullname  = $("#user-fullname").val();
      var Position  = $("#user-position").val();
      var Password  = $("#user-newpassword").val();

      $.post("actions/update_setup.php", {
          Fullname  : Fullname,
          Position  : Position,
          Password  : Password
      }, function(data){
          if($.trim(data) == "success"){
            $("#modal-setup-account").modal('hide');
          }else{
              alert("Error: " + data);
          }
      });
  })
</script>