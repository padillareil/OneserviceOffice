<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iScanner</title>
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert2/sweetalert2.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="icon" href="assets/image/logo/favicon.png">
</head>
<body>
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-4">
      <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-4">
          <h3 class="fw-bold mb-1 display-8" style="font-family:sans-serif;">Create Account</h3>
          <p class="text-muted mb-0">Welcome to iServe</p>
        </div>
        <form id="frm_signup" style="max-width: 300px; width: 100%;">
          <div class="form-floating mb-3">
            <select class="form-select" id="create-role" >
              <option selected disabled></option>
              <option value="1">Admin</option>
              <option value="2">Approver</option>
              <option value="3">Client</option>
            </select>
            <label for="create-role">Account Type</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="create-username" id="create-username" class="form-control" required autocomplete="off">
            <label for="create-username">Username</label>
          </div>

          <div class="form-floating mb-3 position-relative">
            <input type="password" name="create-password" id="create-password" class="form-control"  required>
            <label for="create-password">Password</label>
            <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" 
               id="togglePassword" style="cursor: pointer;"></i>
          </div>
          
          <div class="d-grid">
            <button type="submit" class="btn btn-primary py-2">Save</button>
          </div>
          <div class="mt-2 text-center">
            <small>Developed by: Reil P. Padilla</small>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="assets/plugins/bootstrap/scripts/jquery.min.js"></script>
  <script src="assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="assets/js/adminlte.js"></script>
  <script src="assets/js/global-scripts.js"></script>
  <script src="assets/js/signup.js"></script>
</body>
</html>

  
