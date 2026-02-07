<form id="frm-add-department">
  <div class="modal fade" id="mdl-add-department" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-add-department" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Department</h1>
        </div>
        <div class="modal-body">
          <div class="form-input mb-2">
            <label for="department">Department:</label>
            <input type="text" name="department" id="department" class="form-control" required>
          </div>
          <div class="form-input mb-2">
            <label for="team-leader">Team Leader Fullname:</label>
            <input type="text" name="team-leader" id="team-leader" class="form-control" required>
          </div>
          <div class="form-input mb-2">
            <label for="tl-position">Position:</label>
            <input type="text" name="tl-position" id="tl-position" class="form-control" required>
          </div>
          <div class="form-input mb-2">
            <label for="tl-username">Username:</label>
            <input type="text" name="tl-username" id="tl-username" class="form-control" required maxlength="20">
          </div>
          <div class="form-input mb-2">
            <label for="tl-password">Password:</label>
            <input type="password" name="tl-password" id="tl-password" class="form-control" required maxlength="20">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $("#frm-add-department").submit(function(event) {
      event.preventDefault();
      var Department = $("#department").val();
      var Fullname   = $("#team-leader").val();
      var Position   = $("#tl-position").val();
      var Username   = $("#tl-username").val();
      var Password   = $("#tl-password").val();
      $.post("dirs/ho_office/actions/save_account.php", {
          Department: Department,
          Fullname: Fullname,
          Position: Position,
          Username: Username,
          Password: Password
      }, function(data) {
          data = $.trim(data);
          if (data === "OK") {
              loadHeadOffice();
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'New department added successfully.',
                  timer: 2000,
                  showConfirmButton: false
              });
              $("#mdl-add-department").modal('hide');
              $("#frm-add-department")[0].reset();
          } else {
              Swal.fire({
                  icon: 'warning',
                  title: 'Oops',
                  text: data,
                  timer: 3000,
                  showConfirmButton: false
              });
          }
      });
  });


</script>