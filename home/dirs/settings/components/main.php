<div class="row">
    <!-- User Account Settings and Login Logs -->
    <div class="col-md-2">
      <div class="row g-3">
        <!-- Account Settings Card -->
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-4 ">
           <div class="card-header" style="display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 1rem;">
             <!-- Title -->
             <p class="fw-semibold">Account Settings</p>
             <div class="dropdown">
               <button class="btn btn-lg" data-bs-toggle="dropdown">
                 <i class="bi bi-gear"></i>
               </button>
               <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                 <li>
                   <a class="dropdown-item" href="#" onclick="changeSecurity()">
                     <i class="bi bi-key me-2"></i>Change Security
                   </a>
                 </li>
                 <li>
                   <a class="dropdown-item" href="#" onclick="changeLandline()">
                     <i class="bi bi-telephone me-2"></i>Change Contacts
                   </a>
                 </li>
               </ul>
             </div>
           </div>
            <div class="card-body">
              <div class="form-input mb-2">
                <label for="user-fullname" class="form-label">Fullname:</label>
                <input type="text" name="user-fullname" id="user-fullname" class="form-control form-control-plaintext" readonly>
              </div>
              <div class="form-input">
                <label for="user-position" class="form-label">Position:</label>
                <input type="text" name="user-position" id="user-position" class="form-control form-control-plaintext" readonly>
              </div>
              <input type="hidden" id="user-theme"><!-- User theme prefenence -->
              <!-- <hr class="my-4"> -->
              <!-- Theme Preference -->
              <!-- <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold">Theme Preference</div>
                  <small id="text-theme" class="text-muted">Light Mode</small>
                </div>
                <div class="form-check form-switch m-0">
                  <input class="form-check-input" type="checkbox" id="preference-display">
                </div>
              </div> -->
            </div>
            
          </div>
        </div>

        <!-- Login Logs Card -->
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-4 ">
            
            <!-- Header -->
            <div class="card-header fw-semibold">
              Login Logs
                <input type="search" name="search-logs" id="search-logs" class="form-control" placeholder="Search">

            </div>

            <!-- Scroll Body -->
            <div class="card-body p-0" style="height:30vh; overflow:auto;">

              <div class="list-group list-group-flush">
                <div id="user_logs"></div>
                <!-- ITEM -->


                <!-- repeat items here -->

              </div>
            </div>
            <div class="card-footer">
                <nav>
                    <ul class="pagination" id="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" id="btn-preview">Previous</a> <!-- Page list number -->
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" id="btn-next">Next</a>
                        </li>
                    </ul>
                </nav>

                <div id="page-info" class="mt-3 small text-muted">  <!-- Page number counting -->
                </div>

            </div>

          </div>

        </div>

      </div>
    </div>

    <div class="col-md-10">
      <!-- Tickets Logs Resolved and Cancelled -->
      <div class="row g-3">
        <div class="col-md-6 col-sm-6 col-12">
          <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
              <div class="card-body d-flex align-items-center">

                <div class="me-3 rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;">
                  <i class="bi bi-check-lg fs-4"></i>
                </div>

                <div>
                  <div class="text-muted">Resolved Tickets</div>
                  <div class="fs-3 fw-bold" id="resolved-tickets">0</div>
                </div>

              </div>
            </div>
          </a>
        </div>
        <!-- Cancelled -->
        <div class="col-md-6 col-sm-6 col-12">
          <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
              <div class="card-body d-flex align-items-center">

                <div class="me-3 rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;">
                  <i class="bi bi-x-lg fs-4"></i>
                </div>

                <div>
                  <div class="text-muted">Cancelled Tickets</div>
                  <div class="fs-3 fw-bold" id="cancelled-tickets">0</div>
                </div>

              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Resolved Tickets of this Department -->
      <div class="card mt-2 shadow-sm border-0 rounded-3">
        <div class="card-body">
          <ul class="nav nav-underline mt-2" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fs-6" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab">
                Resolved Tickets
              </button>
            </li>

            <li class="nav-item" role="presentation">
              <button class="nav-link fs-6" id="open-tab" data-bs-toggle="tab" data-bs-target="#open" type="button" role="tab">
                Cancelled Tickets
              </button>
            </li>
          </ul>



          <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="new" role="tabpanel">
              <?php include 'resolved_tickets.php';  ?>
            </div>

            <div class="tab-pane fade" id="open" role="tabpanel">
              <?php include 'cancelled_tickets.php';  ?>
            </div>
          </div>

        </div>
      </div>



    </div>
</div>


<script>
  /*Search post*/
  $("#search-logs").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadUserLogs();
      }
  });
</script>