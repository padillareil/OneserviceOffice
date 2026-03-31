<div class="row" style="height: 80vh;"> 

    <!-- LEFT: Published Ticket List (collapsible) -->
    <div class="col-md-2 d-none" id="published_ticket_list">
        <div class="card rounded-2 shadow-sm h-100">
            <div class="card-header">
                <strong>Service List</strong>
            </div>
            <div class="card-body p-2">
                  <div class="card-body p-2 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                      <div class="text-center">
                          <div class="mb-3">
                              <i class="bi bi-inbox fs-1 text-muted"></i>
                          </div>
                          <h6 class="fw-semibold mb-1">No Services Record</h6>
                          <p class="text-muted small mb-3">
                              You haven’t posted any services yet. Start by creating one.
                          </p>
                      </div>

                  </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div id="main_ticket_container">
        <div class="card rounded-2 shadow-sm h-100">
            <div class="card-header py-2">
                <div class="d-flex align-items-center flex-wrap gap-2">
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

                    <!-- RIGHT: Search -->
                    <div class="ms-auto">
                        <input type="search" id="search-ticket" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                    </div>

                </div>
            </div>

            <!-- BODY -->
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 350px;">
                
                <div class="text-center" onclick="createPost()">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-inbox fs-2 text-secondary"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-1">No Services Yet</h5>
                    <p class="text-muted mb-3" style="max-width: 300px;">
                       Start by adding a new service to make requests available.
                    </p>
                    <a href="#" class="button">Start Post</a>
                </div>

            </div>

            <!-- FOOTER / PAGINATION -->
            <div class="card-footer py-2">
                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Showing 1–10 of 100 Post
                    </small>

                    <!-- jQuery UI style pagination -->
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-light active">1</button>
                        <button class="btn btn-sm btn-light">2</button>
                        <button class="btn btn-sm btn-light">3</button>
                        <button class="btn btn-sm btn-light">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>


