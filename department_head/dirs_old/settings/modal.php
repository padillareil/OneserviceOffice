<!-- Modal Security Change -->
<form id="frm-change-password">
  <div class="modal fade" id="mdl-change-pass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label class="form-label" for="new-password">New Password</label>
            <input type="password" name="new-password" id="new-password" class="form-control" required>
          </div>
          <div class="form-check mb-2">
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


<!-- Modal Change Department Lanline -->
<form id="frm-change-contact">
  <div class="modal fade" id="mdl-change-contact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Contacts</h4>
        </div>
        <div class="modal-body">
          <div class="form-input mb-3">
            <label class="form-label" for="landline">Landline:</label>
            <input type="text" name="landline" id="landline" class="form-control" required>
          </div>
          <div class="form-input mb-3">
            <label class="form-label" for="mobile">Phone number:</label>
            <input type="text" name="mobile" id="mobile" class="form-control" required>
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