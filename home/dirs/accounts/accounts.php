<div class="card card-shadow">
	<div class="card-header">
		<div class="d-flex align-items-center gap-2">
			<button class="btn btn-success" type="button" onclick="mdladdAccount()">Create Account</button>
			<input type="search" name="search-account" id="search-account" class="form-control ms-auto col-2" placeholder="Search">
		</div>
	</div>
	<div class="card-body bg-secondary-subtle overscroll-auto" style="height: 70vh;">
		<div id="loadAccounts"></div>
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

	    <div id="page-info" class="mt-3 small text-muted">	<!-- Page number counting -->
	    </div>

	</div>

</div>

<script src="dirs/accounts/script/accounts.js"></script>

<?php include 'modal.php';  ?>