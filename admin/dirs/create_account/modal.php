<form id="frm-account">
  <div class="modal fade" id="modal-add-account" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="mdl-title">Create Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="fullname" class="form-label">Full name</label>
            <input type="text" name="fullname" id="fullname" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3">
            <select class="form-select" id="user-role" name="user-role" required>
              <option value="">-- Choose Role --</option>
              <option value="1">Admin</option>
              <option value="2">Department Admin</option>
              <option value="3">Client / Requestor</option>
              <option value="4">System Checker</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="branch" class="form-label">Branch</label>
            <select class="form-select" id="branch" required>
              <option selected value="">--</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" id="department" class="form-control" required autocomplete="off">
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required autocomplete="off">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="off">
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="show-password" onclick="showPassword()">
            <label class="form-check-label" for="show-password">
              Show Password
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>




<!-- <div class="from-input mb-3">
  <label form="portal_id">Portal ID</label>
  <input type="text" name="portal_id" id="portal_id" class="form-control" readonly>
</div> -->

<!-- Modal Profile Account -->
<!--  <div class="modal fade" id="mdl-profile" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-body">
          <div class="row">
            <label for="usr-fullname" class="col-sm-4 col-form-label">Fullname:</label>
            <div class="col-sm-8">
             <p id="usr-fullname"></p>
            </div>
          </div>
          <div class="row">
            <label for="usr-position" class="col-sm-4 col-form-label">Position:</label>
            <div class="col-sm-8">
             <p id="usr-position"></p>
            </div>
          </div>
          <div class="row">
            <label for="usr-portalid" class="col-sm-4 col-form-label">Portal ID:</label>
            <div class="col-sm-8">
             <p id="usr-portalid"></p>
            </div>
          </div>
       </div>
     </div>
   </div>
 </div>
 -->