<!-- Modal Request Queue -->
<div class="modal fade" id="mdl-req-queue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="team-req-mdl-title">Team Applied Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-request" id="search-request" class="form-control form-control-sm" placeholder="Search request..." style="width: 200px;">
              <select class="form-select form-select-sm" style="width: 180px;" title="Requested Department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 180px;" title="Prepared by Staff">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success">Apply</button>
              <button type="button" class="btn btn-sm btn-primary">Refresh</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hovered">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view applied tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
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
               <ul class="pagination" id="pagination-t-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-t-application">Previous</a> <!-- Page list number -->
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-t-application">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-t-application" class="mt-3 small text-muted">  <!-- Page number counting -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Resolved Ticekts Modal -->
<div class="modal fade" id="mdl-req-resolved" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="team-req-mdl-title">Team Resolved Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-resolve" id="search-resolve" class="form-control form-control-sm" placeholder="Search request..." style="width: 150px;">
              <select class="form-select form-select-sm" style="width: 150px;" title="Requested Department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 150px;" title="Prepared by Staff">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success">Apply</button>
              <button type="button" class="btn btn-sm btn-primary">Refresh</button>
              <button type="button" class="btn btn-sm btn-danger">Clear</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hovered">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view resolved tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
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
               <ul class="pagination" id="pagination-r-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-r-application">Previous</a> <!-- Page list number -->
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-r-application">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-r-application" class="mt-3 small text-muted">  <!-- Page number counting -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Resolved Ticekts Modal -->
<div class="modal fade" id="mdl-req-cancelled" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="team-req-mdl-title" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="team-req-mdl-title">Team Cancelled Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <input type="search" name="search-resolve" id="search-resolve" class="form-control form-control-sm" placeholder="Search request..." style="width: 150px;">
              <select class="form-select form-select-sm" style="width: 150px;" title="Requested Department">
                <option selected disabled>Department</option>
              </select>
              <select class="form-select form-select-sm" style="width: 150px;" title="Prepared by Staff">
                <option selected disabled>Filter by Staff</option>
              </select>
              <div class="d-flex align-items-center gap-1">
                <span class="small text-muted">from</span>
                <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
                <span class="small text-muted">to</span>
                <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
              </div>
              <button type="button" class="btn btn-sm btn-success">Apply</button>
              <button type="button" class="btn btn-sm btn-primary">Refresh</button>
              <button type="button" class="btn btn-sm btn-danger">Clear</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive overscroll-auto" style="height: 55vh;">
              <table class="table table-sm table-hovered">
                <thead>
                  <tr>
                    <th>Ticket No.</th>
                    <th>Department</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center text-muted">
                        <div class="mb-3" style="font-size: 40px; opacity: .35;">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="fw-semibold">Filter to view cancelled tickets.</div>
                        <div class="small opacity-75">
                          Please filter and apply if no tickets displayed.
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
               <ul class="pagination" id="pagination-cancel-application">
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-preview-cancel-application">Previous</a> <!-- Page list number -->
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="#" id="btn-next-cancel-application">Next</a>
                  </li>
               </ul>
            </nav>
            <div id="page-info-cancel-application" class="mt-3 small text-muted">  <!-- Page number counting -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>