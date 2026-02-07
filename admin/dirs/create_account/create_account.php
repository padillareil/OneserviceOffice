<div class="card shadow-sm overflow-auto" style="min-height: 80vh;">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<button class="btn btn-primary" type="button" onclick="createAccount()">
				<i class="bi bi-plus-lg"></i> Register
			</button>
			<input type="search" name="search-account" id="search-account" class="form-control col-md-3" placeholder="Search">
		</div>
		<div id="load_createaccount"></div>
	</div>
	<div class="card-footer">
		<div class="row justify-content-between">
		    <div class="col-auto">
		      <button class="btn btn-link" type="button" id="btn-preview-rev">Previous </button>
		    </div>
		    <div class="col-auto">
		      <button class="btn btn-link" type="button" id="btn-next-rev">Next</i></button>
		    </div>
		</div>
	</div>
</div>


<script src="dirs/create_account/script/createaccount.js"></script>


<?php include 'modal.php';  ?>