<div class="row">
	<div class="col-md-2">
		<div class="card shadow-sm bg-secondary-subtle" style="height: 90vh;">
			<div class="card-header">
			    <div class="d-flex justify-content-between align-items-center flex-wrap">

			        <!-- Button Group -->
			        <div class="btn-group mb-2">
			            <button class="btn btn-success" type="button" onclick="mdlSetAsssignment()">
			                Set Assignment
			            </button>
			            <button class="btn bg-purple" type="button">
			                <i class="bi bi-list"></i> Work Book List
			            </button>
			        </div>
			        <input type="text" name="search-staff" id="search-staff" class="form-control form-control-sm col-md-12"placeholder="Search...">
			    </div>
			</div>
			<div class="card-body">
			    <div class="list-group">
			        <!-- Staff Item -->
			        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
			            <div>
			                <p class="fw-bold">Reil P. Padilla</p>
			                <small class="text-muted">Software Developer</small>
			                <small class="text-secondary">Branch: Bajada</small>
			            </div>
			        </div>

			        <!-- Staff Item -->
			        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
			            <div>
			                <div class="fw-bold">Maria Santos</div>
			                <div class="small text-muted">IT Support</div>
			                <div class="small text-secondary">Branch: Iloilo</div>
			            </div>
			        </div>

			        <!-- Staff Item -->
			        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
			            <div>
			                <div class="fw-bold">John Cruz</div>
			                <div class="small text-muted">Network Technician</div>
			                <div class="small text-secondary">Branch: Manila</div>
			            </div>
			        </div>

			    </div>

			</div>
			<div class="card-footer">
				<nav>
				    <ul class="pagination" id="pagination-staff">
				        <li class="page-item">
				            <a class="page-link" href="#" id="btn-preview-staff">Previous</a> <!-- Page list number -->
				        </li>
				        <li class="page-item">
				            <a class="page-link" href="#" id="btn-next-staff">Next</a>
				        </li>
				    </ul>
				</nav>

				<div id="page-info-staff" class="mt-3 small text-muted">  <!-- Page number counting -->
				</div>
			</div>
		</div>


	</div>


	<div class="col-md-10">
		<div class="card shadow-sm bg-secondary-subtle">
			<div class="card-header">
			    <div class="row align-items-center">

			        <!-- Staff Profile -->
			        <div class="col-md-6">
			            <div class="d-flex align-items-center gap-3">
			                <img src="../assets/image/uploads/thor.jpg" alt="Staff Profile" class="shadow-sm border" style="width:100px;height:100px;object-fit:cover;border-radius:10px;">

			                <div>
			                    <h4 class="fw-bold mb-1">Reil P. Padilla</h4>
			                    <div class="fw-semibold text-primary">Software Developer</div>
			                    <div class="small text-muted">Branch: Bajada</div>
			                </div>
			            </div>
			        </div>

			        <!-- Stats -->
			        <div class="col-md-6">
			            <div class="row g-3">

			                <!-- Total Open -->
			                <div class="col-md-6 col-sm-6">
			                    <a href="#" class="text-decoration-none">
			                        <div class="card shadow-sm border-0 rounded-4 h-100">
			                            <div class="card-body d-flex align-items-center">
			                                <div class="me-3 bg-info-subtle text-info d-flex align-items-center justify-content-center"
			                                     style="width:56px;height:56px;border-radius:12px;">
			                                    <i class="bi bi-list-nested fs-4"></i>
			                                </div>
			                                <div>
			                                    <div class="text-muted small">Total Open</div>
			                                    <div class="fs-3 fw-bold text-danger" id="queue-open">0</div>
			                                </div>
			                            </div>
			                        </div>
			                    </a>
			                </div>

			                <!-- Total Reject -->
			                <div class="col-md-6 col-sm-6">
			                    <a href="#" class="text-decoration-none">
			                        <div class="card shadow-sm border-0 rounded-4 h-100">
			                            <div class="card-body d-flex align-items-center">
			                                <div class="me-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center"
			                                     style="width:56px;height:56px;border-radius:12px;">
			                                    <i class="bi bi-x-circle fs-4"></i>
			                                </div>
			                                <div>
			                                    <div class="text-muted small">Total Reject</div>
			                                    <div class="fs-3 fw-bold text-danger" id="queue-reject">0</div>
			                                </div>
			                            </div>
			                        </div>
			                    </a>
			                </div>

			            </div>
			        </div>

			    </div>
			</div>
			<div class="card-body">
				<!-- Tickets Tables cater on this Branch Assignment -->
				<div class="card shadow-sm">
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
					    </div>
					  </div>
					<div class="card-body">
						<div class="table-responsive overscroll-auto" style="height: 55vh;">
						  <table class="table table-bordered table-hover">
						    <thead>
						      <tr class="table-info">
						        <th class="sticky-top">Ticket No.</th>
						        <th class="sticky-top">Branch</th>
						        <th class="sticky-top">Client</th>
						        <th class="sticky-top">Service Type</th>
						        <th class="sticky-top text-center">Date Created</th>
						        <th class="sticky-top">Status</th>
						      </tr>
						    </thead>
						    <tbody id="service_request">
						      <tr>
						        <td colspan="6" class="text-center py-5">
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
			</div>
		</div>
	</div>

</div>


