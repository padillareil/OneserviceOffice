<div class="mb-2">
	<button class="btn btn-success" type="button" onclick="mldDepartment()">Create Department</button>
</div>

<div class="mt-2">
	<div class="row">
		<div class="col-md-3">
			<div class="card shadow-sm overflow-auto" style="height: 35vh;">
				<div class="card-body">
					<h4>Departments</h4>
					<div class="mt-2 text-center" id="department-list"></div>
				</div>
			</div>

			<div class="card shadow-sm border-0 rounded-4 d-flex flex-column justify-content-center text-center" style="height: 35vh;">
			    <div class="card-body">
			        <h5 class="text-muted mb-2">Total Department Members</h5>
			        <h1 id="count-members" class="fw-bold display-2"></h1>
			    </div>
			</div>



		</div>
		<div class="col-md-9">
			<div class="card shadow-sm overflow-auto" style="height: 72vh;">
				<div class="card-body">
					<div class="form-input justify-content-end d-flex">
						<div class="mb-2 col-md-4">
						  <label for="team-leader-name" class="form-label">Team Leader</label>
						  <input type="text" name="team-leader-name" id="team-leader-name" class="form-control" readonly>
						</div>
					</div>
					<div class="justify-content-end d-flex">
						<input type="search" name="search-teams" id="search-teams" class="form-control col-md-4" placeholder="Search">
					</div>
					<h5>Team Members</h5>
					<table class="table table-sm table-bordered text-center table-hover">
					  <thead class="table-secondary">
					    <tr>
					      <th>ID</th>
					      <th>Fullname</th>
					      <th>Position</th>
					      <th>Status</th>
					      <!-- <th>Action</th> -->
					    </tr>
					  </thead>
					  <tbody id="departentlist-members">
					  </tbody>
					</table>
				</div>
			</div>
		</div>




	</div>



</div>

<script>
	/* Search Filter */
	$("#search-teams").on("keyup", function() {
	    const value = $(this).val().toLowerCase();
	    $("#departentlist-members tr").filter(function() {
	        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
	    });
	});

</script>