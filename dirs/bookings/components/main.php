<div class="card card-shadow h-100" style="height:60vh;">

    <!-- Card Header -->
    <div class="card-header bg-transparent">
        <div class="d-flex justify-content-end">
            <input
                type="search"
                name="search-booking"
                id="search-booking"
                class="form-control w-25"
                placeholder="Search bookings..."
            >
        </div>
    </div>

    <!-- Card Body -->
    <div class="card-body p-0 overflow-auto">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center mb-0">
                <thead class="table-secondary sticky-top">
                    <tr>
                        <th>Subject</th>
                        <th>Department</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Time Ago</th>
                    </tr>
                </thead>
                <tbody id="load_my_bookings">
                    <!-- dynamic rows -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card Footer -->
    <div class="card-footer bg-transparent">
        <nav aria-label="Bookings pagination">
            <ul class="pagination mb-0">
                <li class="page-item">
                    <a class="page-link" href="#">Previous</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

</div>



<script>
	$("#search-booking").on("keydown", function(e) {
	    if (e.key === "Enter") {
	        loadRequest();
	    }
	});
</script>


