<div class="card card-shadow border-0 rounded-4 mt-2">
  <div class="card-header bg-white border-bottom">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">

      <!-- Left Side: Filters -->
      <div class="d-flex flex-wrap align-items-center gap-2">
        <select class="form-select form-select-sm" style="width: 160px;">
          <option selected disabled>Branch</option>
        </select>
        <select class="form-select form-select-sm" style="width: 160px;">
          <option selected disabled>Department</option>
        </select>

        <input type="search" name="search-tickets" id="search-tickets" class="form-control form-control-sm" placeholder="Search tickets..." style="width: 200px;">

        <div class="d-flex align-items-center gap-1">
          <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
          <span class="small text-muted">to</span>
          <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
        </div>

      </div>

      <!-- Right Side: Actions -->
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-success btn-sm" type="button">
          Apply
        </button>
        <button class="btn btn-outline-primary btn-sm" type="button" onclick="loadDashboard()">
          <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive overscroll-auto" style="height: 55vh;">
      <table class="table table-sm table-hovered">
        <thead>
          <tr>
            <th style="width:40px;"></th> <!-- checkbox or expand -->
            <th>Ticket No.</th>
            <th>Client</th>
            <th>Service</th>
            <th>Branch</th>
            <th>Department</th>
            <th>Date Created</th>
            <th>Status</th>
            <th style="width:120px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="9" class="text-center py-5">
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