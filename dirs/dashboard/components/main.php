<div class="card card-shadow border-0 rounded-4 mt-2">
  <div class="card-header bg-primary-subtle border-bottom">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">

      <!-- Left Side: Filters -->
      <div class="d-flex flex-wrap align-items-center gap-2">
        <input type="search" name="search-tickets" id="search-tickets" class="form-control border-primary-subtle form-control-sm" placeholder="Search tickets..." style="width: 200px;">
        <select class="form-select form-select-sm border-primary-subtle" style="width: 160px;" id="iap-branch-dashboard">
          <option selected value="">All</option>
        </select>
        <select class="form-select form-select-sm border-primary-subtle" style="width: 160px;" id="ticket-filter-status">
          <option selected disabled>Status</option>
          <option value="">All</option>
          <option value="O">Open</option>
          <option value="R">Resolved</option>
          <option value="S">Stand By</option>
          <option value="C">Cancelled</option>
          <option value="X">Rejected</option>
        </select>


        <div class="d-flex align-items-center gap-1">
          <input type="date" name="date-from" id="date-from" class="form-control border-primary-subtle form-control-sm">
          <span class="small">to</span>
          <input type="date" name="date-to" id="date-to" class="form-control border-primary-subtle form-control-sm">
        </div>
        <button class="btn btn-success btn-sm" type="button" onclick="loadPostService()">
          <i class="bi bi-check"></i> Generate
        </button>
      </div>

      <!-- Right Side: Actions -->
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-primary btn-sm" type="button" onclick="loadDashboard()">
          <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
        <button class="btn btn-light btn-sm" type="button" id="btn-load-ticket-important">
          <i class="bi bi-exclamation-circle text-warning"></i> Important
        </button>
        <button class="btn btn-light btn-sm" type="button" onclick="loadFindClient()">
          <i class="bi bi-search"></i> Find Client
        </button>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive overscroll-auto" style="height: 55vh;">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-info">
            <th class="sticky-top" style="width:40px;"></th> <!-- checkbox or expand -->
            <th class="sticky-top">Ticket No.</th>
            <th class="sticky-top">Client</th>
            <th class="sticky-top">Service Type</th>
            <th class="sticky-top">Branch</th>
            <th class="sticky-top text-center">Date Created</th>
            <th class="sticky-top">Status</th>
            <th class="sticky-top" style="width:120px;">Action</th>
          </tr>
        </thead>
        <tbody id="service_request">
          <tr>
            <td colspan="8" class="text-center py-5">
              <div class="d-flex flex-column align-items-center text-muted">
                <div class="mb-3" style="font-size: 40px; opacity: .35;">
                  <i class="fa fa-file"></i>
                </div>
                <div class="fw-semibold">No Queue Ticket Available.</div>
                <div class="small opacity-75">
                  Please reload if no available tickets displayed.
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>
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


<script>
  /*Script for Searching ticket*/
  $("#search-tickets").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadPostService();
      }
  });
  /* Pagination + Fetch Blocked Accounts */
  $("#btn-preview").on("click", function(e) {
      e.preventDefault();

      if (currentPage > 1) {
          loadPostService(currentPage - 1);
      }
  });

/*Function load all important tags tickets*/
  $("#btn-next").on("click", function(e) {
      e.preventDefault();

      if (currentPage < totalPages) {
          loadPostService(currentPage + 1);
      }
  });

  /*Function filter ticket status*/
  $("#ticket-filter-status").on("change", function() {
      loadPostService();
  });

  /*Function filter branch assignment*/
  $("#iap-branch-dashboard").on("change", function() {
      loadPostService();
  });

  $("#btn-load-ticket-important").on("click", function () {
      loadPostService(1, 'Y');
  });
  $("#pagination").on("click", ".page-number a", function(e) {
      e.preventDefault();
      var page = parseInt($(this).data("page"));
      loadPostService(page);
  });
</script>



