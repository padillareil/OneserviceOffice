<div class="container-fluid">
	<div class="row">
		<!-- Queue Tickets -->
		<div class="col-md-3 col-sm-6 col-12">
		  <a href="#" class="text-decoration-none">
		    <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
		      <div class="card-body d-flex align-items-center">
		        <div class="me-3 rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
		          <i class="bi bi-list-nested fs-4"></i>
		        </div>
		        <div>
		          <div class="text-muted">Queue Tickets</div>
		          <div class="fs-3 fw-bold" id="resolved-tickets">0</div>
		        </div>
		      </div>
		    </div>
		  </a>
		</div>
		<!-- Resolved Tickets -->
		<div class="col-md-3 col-sm-6 col-12">
		  <a href="#" class="text-decoration-none">
		    <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
		      <div class="card-body d-flex align-items-center">
		        <div class="me-3 rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
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
		<!-- Stand by Tickets -->
		<div class="col-md-3 col-sm-6 col-12">
		  <a href="#" class="text-decoration-none">
		    <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
		      <div class="card-body d-flex align-items-center">
		        <div class="me-3 rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
		          <i class="bi bi-clock-history fs-4"></i>
		        </div>
		        <div>
		          <div class="text-muted">Standby Tickets</div>
		          <div class="fs-3 fw-bold" id="resolved-tickets">0</div>
		        </div>
		      </div>
		    </div>
		  </a>
		</div>
		<!-- Cancelled Tickets -->
		<div class="col-md-3 col-sm-6 col-12">
		  <a href="#" class="text-decoration-none">
		    <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
		      <div class="card-body d-flex align-items-center">
		        <div class="me-3 rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
		          <i class="bi bi-x-circle fs-4"></i>
		        </div>
		        <div>
		          <div class="text-muted">Cancelled Tickets</div>
		          <div class="fs-3 fw-bold" id="resolved-tickets">0</div>
		        </div>
		      </div>
		    </div>
		  </a>
		</div>
	</div>
	<div id="load_Dashboard"></div>
</div>





<script src="dirs/dashboard/script/dashboard.js"></script>

<?php include 'modal.php';  ?>