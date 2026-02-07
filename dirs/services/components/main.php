<!-- Basis Parameter for filtering service base on clicked departments -->
<input type="hidden" id="department-filtered">

<div class="row">
	<div class="col-md-2 overflow-auto" style="height: 70vh;">
		<div class="sidebar">
	 		<nav class="mt-2">
	 		  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
	 		      role="menu" data-accordion="false" id="departmentList">
	 		    <li class="nav-item mb-2">
	 		      <h6 class="text-uppercase text-muted px-3">Departments</h6>
	 		    </li>
	 		    <li class="nav-item">
	 		      <a href="#" class="nav-link active" name="department" menucode="all">
	 		        <i class="bi bi-grid"></i>
	 		        <p>All</p>
	 		      </a>
	 		    </li>
	 		  </ul>
	 		</nav>
		</div>
	</div>



	<div class="col-md-10">
	    <div class="card card-shadow bg-secondary-subtle overflow-auto" style="height: 80vh;">
	        
	        <!-- Card Header -->
	        <div class="card-header d-flex align-items-center justify-content-between">
	            <h4 class="card-title mb-0">Available Services</h4>
	        </div>

	        <!-- Card Body -->
	        <div class="card-body d-flex flex-column overflow-auto">
	            
	            <!-- Search -->
	            <div class="row mb-3">
	                <div class="col-md-4 ms-auto">
	                    <input type="search" name="search-services" id="search-services" class="form-control" placeholder="Search services...">
	                </div>
	            </div>

	            <!-- Services List -->
	            <div class="row g-3" id="posted_service">
	            </div>
	            <!-- <div class="row flex-grow-1 g-3" id="posted_service">
	            </div> -->

	        </div>

	        <!-- Card Footer / Pagination -->
	        <div class="card-footer bg-transparent">
	            <nav aria-label="Service pagination">
	                <ul class="pagination mb-0" id="pagination">
	                    <li class="page-item">
	                        <a class="page-link" href="#">Previous</a>
	                    </li>
	                    <li class="page-item active">
	                        <a class="page-link" href="#">1</a>
	                    </li>
	                    <li class="page-item">
	                        <a class="page-link" href="#">Next</a>
	                    </li>
	                </ul>
	            </nav>
	        </div>

	    </div>
	</div>


</div>



<script>
	/*Script for searching*/
	$(document).ready(function () {
	    $("#search-services").on("keypress", function (e) {
	        if (e.which === 13) { // Enter key
	            e.preventDefault();
	            loadPostService();
	        }
	    });
	});


	/*Navigation script*/
	$("#departmentList")
	  .on("click", "a.nav-link[name='department']", function (e) {
	    e.preventDefault();
	    $("#departmentList a.nav-link[name='department']").removeClass("active");
	    $(this).addClass("active");
	    const menucode = $(this).attr("menucode");
	    switch (menucode) {
	      case "all":
	        loadHelpService(); 
	        break;

	      default:
	        filterDepartment(menucode); 
	        break;
	    }
	});

</script>