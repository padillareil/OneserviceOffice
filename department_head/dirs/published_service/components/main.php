<div class="row" style="height: 80vh;"> 
    <div class="col-md-2 d-none" id="published_ticket_list">
        <div class="card rounded-2 shadow h-100">
            <div class="card-header">
                <strong>In Active Services</strong>
            </div>
            <div class="card-body p-2 bg-secondary-subtle">
                <div class="mb-2">
                    <input type="search" name="search-inactive" id="search-inactive" class="form-control" placeholder="Search...">
                </div>



                  <!-- <div class="card-body p-2" style="min-height: 300px;">
                      <div class="text-center">
                          <div class="mb-3">
                              <i class="bi bi-inbox fs-1 text-muted"></i>
                          </div>
                          <h6 class="fw-semibold mb-1">No Services Record</h6>
                          <p class="text-muted small mb-3">
                              You haven’t posted any services yet. Start by creating one.
                          </p>
                      </div>
                  </div> -->
                  <div class="card-body p-2" style="min-height: 300px;">

                    <!-- Service Item -->
                    <ul class="list-group list-group-flush">

                      <!-- Example Service Item -->
                      <li class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded-2 mb-2">
                        <div class="d-flex align-items-center gap-3">
                          <i class="bi bi-briefcase-fill fs-4"></i> <!-- Service Icon -->
                          <div>
                            <div class="fw-semibold">New Software</div>
                            <small class="text-muted">#SRVC100000001</small>
                          </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-danger">Blocked</span>
                        </div>
                      </li>
                      

                    </ul>
                  </div>
            </div>
            <div class="card-footer">
                <div class="justify-content-between d-flex">
                    <button class="btn btn-sm btn-light" id="btn-preview-inactive">
                        <i class="bi bi-chevron-left"></i> Preview
                    </button>
                    <button class="btn btn-sm btn-light" id="btn-next-inactive">
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div id="main_ticket_container">
        <div class="card rounded-2 shadow h-100">
            <div class="card-header py-2">
                <div class="d-flex align-items-center flex-wrap gap-2">

                  <!-- LEFT: Button Group -->
                  <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-light" type="button" onclick="showCategoryList()">
                      <i class="bi bi-list"></i>
                    </button>
                    <button class="btn btn-light" type="button" onclick="createPost()">
                      <i class="bi bi-plus-lg"></i> Create Post
                    </button>
                    <button class="btn btn-light" type="button" onclick="loadPublishedServices()">
                      <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                  </div>

                  <!-- VISIBILITY FILTER -->
                  <div class="d-flex align-items-center gap-2 ms-3">
                    <!-- <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="filter-visibility" id="filter-private" value="0" checked>
                      <label class="form-check-label" for="filter-private">Private</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="filter-visibility" id="filter-public" value="1">
                      <label class="form-check-label" for="filter-public">Public</label>
                    </div> -->
                    <select class="form-select form-select-sm" id="filter-visibility">
                        <option selected value="">Filter</option>
                        <option value="0">Private</option>
                        <option value="1">Public</option>
                    </select>
                  </div>

                  <!-- RIGHT: Search -->
                  <div class="ms-auto">
                    <input type="search" id="search-service" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                  </div>

                </div>
            </div>

            <!-- BODY -->
            <div class="card-body bg-secondary-subtle" style="min-height: 350px;">
                <div class="row" id="posted_services"></div>
            </div>

            <!-- FOOTER / PAGINATION -->
            <div class="card-footer py-2">
                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Showing 1–10 of 100 Post
                    </small>

                    <!-- jQuery UI style pagination -->
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light" id="btn-preview">
                            <i class="bi bi-chevron-left"></i> Preview
                        </button>
                        <button class="btn btn-sm btn-light" id="btn-next">
                            Next <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>



<script>
    /*Function for search*/
    $(document).ready(function () {
        $("#search-service").on("keypress", function (e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                loadAvailableServices();
            }
        });
    });

    /*Function filter ticket status*/
    $("#filter-visibility").on("change", function() {
        loadAvailableServices();
    });

  var currentPage = 1;
  var pageSize = 10;
  var totalPages = 1;
  var display = $("#posted_services");

  // Load Services with Pagination
  function loadAvailableServices(page = 1) {
      var search = $("#search-service").val();
      var Visibility = $("#filter-visibility").val();
      $.post("dirs/published_service/actions/get_services.php", {
          CurrentPage: page,
          PageSize: pageSize,
          Search: search,
          Visibility: Visibility,
      }, function(data) {
          var response;
          try {
              response = JSON.parse(data);
          } catch (e) {
              toastr.error("Server error.", "Error");
              return;
          }

          if ($.trim(response.isSuccess) === "success") {
              displayServices(response.Data);
              currentPage = page;
              if (response.Data && response.Data.length > 0) {
                  totalPages = parseInt(response.Data[0].TotalPages);
                  updateFooterInfo(response.Data[0].TotalRecords);
              } else {
                  totalPages = 1;
                  updateFooterInfo(0);
              }

              updatePaginationButtons();
          } else {
              toastr.error($.trim(response.Data), "Error");
          }
      });
  }

  /* Render Services as Info Box */
  function displayServices(data) {
      display.empty();

      if (!data || data.length === 0) {
          display.html(`
              <div class="text-center py-5">
                  <div class="mb-3">
                      <i class="bi bi-inbox fs-2 text-secondary"></i>
                  </div>
                  <h5 class="fw-semibold mb-1">No Services Yet</h5>
                  <p class="text-muted mb-3" style="max-width: 300px; margin:auto;">
                     Start by adding a new service to make requests available.
                  </p>
              </div>
          `);
          return;
      }

      data.forEach(srv => {
          display.append(`
              <div class="col-md-3 col-sm-6 col-12" ondblclick="openServiceInfo(${srv.ServiceId})">
                <div class="info-box shadow-sm rounded-3 border-0 service-box">
                  <span class="info-box-icon bg-gradient-warning elevation-2">
                    <i class="bi bi-briefcase-fill"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text fw-semibold text-dark">
                      ${srv.ServiceName}
                    </span>
                    <small class="text-muted d-block">
                      #${srv.ServiceCode}
                    </small>
                    <span class="info-box-number mt-1">
                      <i class="bi bi-people-fill me-1 text-secondary"></i>
                      ${srv.UserCount}
                    </span>
                  </div>
                </div>
              </div>
          `);
      });
  }

  /* Update Footer Info (left side) */
  function updateFooterInfo(totalRecords) {
      var startRecord = (currentPage - 1) * pageSize + 1;
      var endRecord = Math.min(currentPage * pageSize, totalRecords);
      $(".card-footer small.text-muted").text(
          totalRecords > 0 
              ? `Showing ${startRecord}–${endRecord} of ${totalRecords} Posts`
              : "No Posts Available"
      );
  }

  /* Pagination Button Events */
  $("#btn-preview").on("click", function(e) {
      e.preventDefault();
      if (currentPage > 1) loadAvailableServices(currentPage - 1);
  });

  $("#btn-next").on("click", function(e) {
      e.preventDefault();
      if (currentPage < totalPages) loadAvailableServices(currentPage + 1);
  });

  /* Update Pagination Buttons Right Side */
  function updatePaginationButtons() {
      // Reset buttons inside btn-group
      var container = $(".card-footer .btn-group");
      container.find("button.page-number").remove();

      for (let i = 1; i <= totalPages; i++) {
          var btnClass = i === currentPage ? "btn btn-sm btn-light active page-number" : "btn btn-sm btn-light page-number";
          var btn = `<button class="${btnClass}" data-page="${i}">${i}</button>`;
          $("#btn-next").before(btn); // Insert before next button
      }

      // Enable / disable prev & next
      currentPage <= 1 ? $("#btn-preview").prop("disabled", true) : $("#btn-preview").prop("disabled", false);
      currentPage >= totalPages ? $("#btn-next").prop("disabled", true) : $("#btn-next").prop("disabled", false);
  }

  /* Page Number Click */
  $(".card-footer .btn-group").on("click", ".page-number", function(e) {
      e.preventDefault();
      var page = parseInt($(this).data("page"));
      if (page && page !== currentPage) loadAvailableServices(page);
  });





</script>

  <!-- <div class="text-center" onclick="createPost()">
      <div class="mb-3">
          <i class="bi bi-inbox fs-2 text-secondary"></i>
      </div>
      <h5 class="fw-semibold mb-1">No Services Yet</h5>
      <p class="text-muted mb-3" style="max-width: 300px;">
         Start by adding a new service to make requests available.
      </p>
      <a href="#" class="button">Start Post</a>
  </div> -->
<!--   <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow-sm rounded-3 border-0 service-box">
      <span class="info-box-icon bg-gradient-warning elevation-2">
        <i class="bi bi-briefcase-fill"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text fw-semibold text-dark">
          New Software
        </span>
        <small class="text-muted d-block">
          #SRVC100000001
        </small>
        <span class="info-box-number mt-1">
          <i class="bi bi-people-fill me-1 text-secondary"></i>
          1,410
        </span>
      </div>
    </div>
  </div> -->